<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Region;
use App\Models\WeddingOrganizer;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('import_users')
                ->label('Import Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Import Pengguna dari Excel/CSV')
                ->modalDescription('Unggah file dengan kolom: no_anggota, organizer_name, email, name, region_name, dpc_name, instagram, no_ktp, gender, status, status_menikah, alamat, agama')
                ->schema([
                    FileUpload::make('file')
                        ->label('File Excel/CSV')
                        ->disk('public')
                        ->directory('imports')
                        ->preserveFilenames()
                        ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                        ->maxSize(10240)
                        ->required(),
                ])
                ->action(function (array $data) {
                    $path = $data['file'] ?? null;
                    if (!$path) {
                        Notification::make()->title('File tidak ditemukan')->danger()->send();
                        return;
                    }

                    $fullPath = storage_path('app/public/' . $path);
                    $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

                    $rows = [];
                    try {
                        if (in_array($ext, ['xlsx', 'xls'])) {
                            $spreadsheet = IOFactory::load($fullPath);
                            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                            if (!empty($sheet)) {
                                $headers = [];
                                foreach ($sheet[1] as $col => $val) {
                                    $norm = strtolower(trim((string) $val));
                                    $norm = preg_replace('/[\s\.-]+/', '_', $norm);
                                    $headers[$col] = $norm;
                                }
                                foreach (array_slice($sheet, 1) as $row) {
                                    $assoc = [];
                                    foreach ($row as $col => $val) {
                                        $key = $headers[$col] ?? $col;
                                        $assoc[$key] = is_string($val) ? trim($val) : $val;
                                    }
                                    if (isset($assoc['nik']) && !isset($assoc['no_ktp'])) {
                                        $assoc['no_ktp'] = $assoc['nik'];
                                    }
                                    if (array_filter($assoc)) {
                                        $rows[] = $assoc;
                                    }
                                }
                            }
                        } else {
                            $fh = fopen($fullPath, 'r');
                            if ($fh) {
                                $headers = [];
                                if (($headerRow = fgetcsv($fh)) !== false) {
                                    foreach ($headerRow as $val) {
                                        $norm = strtolower(trim((string) $val));
                                        $norm = preg_replace('/[\s\.-]+/', '_', $norm);
                                        $headers[] = $norm;
                                    }
                                }
                                while (($row = fgetcsv($fh)) !== false) {
                                    $assoc = [];
                                    foreach ($row as $i => $val) {
                                        $assoc[$headers[$i] ?? ('col_' . $i)] = trim((string) $val);
                                    }
                                    if (isset($assoc['nik']) && !isset($assoc['no_ktp'])) {
                                        $assoc['no_ktp'] = $assoc['nik'];
                                    }
                                    if (array_filter($assoc)) {
                                        $rows[] = $assoc;
                                    }
                                }
                                fclose($fh);
                            }
                        }
                    } catch (\Throwable $e) {
                        Notification::make()->title('Gagal membaca file: ' . $e->getMessage())->danger()->send();
                        return;
                    }

                    if (empty($rows)) {
                        Notification::make()->title('Tidak ada data untuk diimpor')->warning()->send();
                        return;
                    }

                    $regionAliasMap = [
                        'sumsel' => 'Sumatera Selatan',
                        'lampung' => 'Lampung',
                    ];

                    // Precompute hashed password once to avoid repeated expensive bcrypt operations
                    $hashedPassword = Hash::make('password123');

                    $created = 0; $updated = 0; $woLinked = 0;
                    foreach ($rows as $row) {
                        $noAnggota = $row['no_anggota'] ?? null;
                        $email = $row['email'] ?? null;
                        $name = $row['name'] ?? ($row['organizer_name'] ?? 'Member HASTANA');
                        $regionName = $row['region_name'] ?? null;
                        $dpcName = $row['dpc_name'] ?? null;
                        $organizerName = $row['organizer_name'] ?? null;
                        $instagram = $row['instagram'] ?? null;
                        $genderRaw = $row['gender'] ?? null;
                        $statusRaw = $row['status'] ?? null;
                        $statusNikahRaw = $row['status_menikah'] ?? null;
                        $alamat = $row['alamat'] ?? null;
                        $agama = $row['agama'] ?? null;
                        $noKtp = $row['no_ktp'] ?? null;

                        $emailKey = strtolower($email ?: ('member+' . Str::slug($noAnggota ?: Str::random(6)) . '@hastana.local'));

                        $user = User::where('email', $emailKey)->first();
                        // Normalize gender and status
                        $gender = match (strtolower((string)$genderRaw)) {
                            'male', 'laki-laki', 'laki laki', 'l' => 'male',
                            'female', 'perempuan', 'p' => 'female',
                            default => null,
                        };
                        $status = match (strtolower((string)$statusRaw)) {
                            'active', 'aktif' => 'active',
                            'inactive', 'tidak aktif', 'nonaktif' => 'inactive',
                            default => null,
                        };

                        $statusMenikah = match (strtolower((string)$statusNikahRaw)) {
                            'single', 'belum menikah', 'tidak kawin', 'lajang' => 'single',
                            'married', 'menikah', 'kawin' => 'married',
                            'divorced', 'cerai' => 'divorced',
                            'widowed', 'duda', 'janda' => 'widowed',
                            default => null,
                        };

                        $payload = [
                            'name' => $name,
                            'password' => $hashedPassword,
                            'role' => 'member',
                            'status' => $status,
                            'email_verified_at' => now(),
                            'no_anggota' => $noAnggota,
                            'gender' => $gender,
                            'agama' => $agama,
                            'no_ktp' => $noKtp,
                            'address' => $alamat,
                            'status_menikah' => $statusMenikah,
                        ];
                        if (!$user && is_null($payload['status'])) {
                            $payload['status'] = 'active';
                        }
                        $payload = array_filter($payload, function ($v) {
                            return !is_null($v) && $v !== '';
                        });
                        if ($user) {
                            $user->update($payload);
                            $updated++;
                        } else {
                            $user = User::create(array_merge(['email' => $emailKey], $payload));
                            $created++;
                        }

                        $regionId = null;
                        $provinceForWo = null;
                        if ($regionName) {
                            $mapped = $regionAliasMap[strtolower($regionName)] ?? $regionName;
                            $region = Region::where('region_name', $mapped)->first();
                            $regionId = $region?->id;
                            $provinceForWo = $region?->province;
                        }

                        if ($organizerName) {
                            $slugBase = Str::slug($organizerName);
                            $slug = $slugBase;
                            if (WeddingOrganizer::where('slug', $slug)->exists()) {
                                $slug .= '-' . Str::slug((string)($noAnggota ?? Str::random(4)));
                            }

                            $instagramUrl = null;
                            if ($instagram) {
                                $inst = trim((string)$instagram);
                                if (str_starts_with($inst, '@')) {
                                    $inst = substr($inst, 1);
                                }
                                if (str_starts_with(strtolower($inst), 'http')) {
                                    $instagramUrl = $inst;
                                } else {
                                    $instagramUrl = 'https://instagram.com/' . $inst;
                                }
                            }

                            $woData = [
                                'user_id' => $user->id,
                                'region_id' => $regionId,
                                'slug' => $slug,
                                'brand_name' => $organizerName,
                                'email' => $email,
                                'instagram' => $instagramUrl,
                                'city' => $dpcName,
                                'province' => $provinceForWo,
                                'status' => 'active',
                                'verification_status' => 'verified',
                            ];
                            $woData = array_filter($woData, function ($v) {
                                return !is_null($v) && $v !== '';
                            });
                            $wo = WeddingOrganizer::updateOrCreate(
                                ['organizer_name' => $organizerName],
                                $woData
                            );
                            $woLinked++;
                        }
                    }

                    Notification::make()
                        ->title('Import selesai')
                        ->body("Created: {$created}, Updated: {$updated}, WO linked: {$woLinked}")
                        ->success()
                        ->send();
                }),

            Action::make('download_template_xlsx')
                ->label('Download Template XLSX')
                ->icon('heroicon-o-document-text')
                ->action(function () {
                    $spreadsheet = new Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setTitle('Template Import Users');

                    $headers = ['no_anggota', 'organizer_name', 'email', 'name', 'region_name', 'dpc_name', 'instagram', 'no_ktp', 'gender', 'status', 'status_menikah', 'alamat', 'agama'];
                    foreach ($headers as $i => $header) {
                        $col = Coordinate::stringFromColumnIndex($i + 1);
                        $sheet->setCellValue($col . '1', $header);
                    }

                    $samples = [
                        ['HI.07.002', 'Dhiary Wedding Organizer', 'dhiary.wo@gmail.com', 'M Fritran Garida', 'Sumsel', 'Jakarta Selatan', 'https://instagram.com/dhiary.wo', '3276012345678901', 'Laki-laki', 'Aktif', 'Menikah', 'JL. Mawar No.1', 'Islam'],
                        ['HI.06.001', 'Muli Mekhnai Production', 'mulimekhnaiproduction@gmail.com', 'Ruland Rachmat Mantiri', 'Lampung', 'Bandar Lampung', 'https://instagram.com/mulimekhnai', '1801012345678901', 'Perempuan', 'Tidak Aktif', 'Belum Menikah', 'Jl. Melati No.2', 'Kristen'],
                    ];
                    foreach ($samples as $rIndex => $row) {
                        foreach ($row as $cIndex => $value) {
                            $col = Coordinate::stringFromColumnIndex($cIndex + 1);
                            $sheet->setCellValue($col . (string)($rIndex + 2), $value);
                        }
                    }

                    foreach (range('A', 'M') as $col) {
                        $sheet->getColumnDimension($col)->setAutoSize(true);
                    }

                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $filename = 'template_import_users_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

                    return response()->streamDownload(function () use ($writer) {
                        $writer->save('php://output');
                    }, $filename, [
                        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ]);
                }),

        ];
    }
}
