<?php

namespace App\Filament\Resources\WeddingOrganizers\Pages;

use App\Filament\Resources\WeddingOrganizers\WeddingOrganizerResource;
use App\Filament\Resources\WeddingOrganizers\Widgets\WeddingOrganizerOverviewWidget;
use App\Models\WeddingOrganizer;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ListWeddingOrganizers extends ListRecords
{
    protected static string $resource = WeddingOrganizerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
            Action::make('download_excel')
                ->label('Download Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $records = WeddingOrganizer::with(['user', 'region'])
                        ->orderBy('organizer_name')
                        ->get();

                    $spreadsheet = new Spreadsheet;
                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setTitle('Data Wedding Organizer');

                    $headers = [
                        'No', 'No Anggota', 'Nama Organizer', 'Brand Name',
                        'Email', 'Telepon', 'Kota', 'Provinsi',
                        'Instagram', 'Website', 'Tahun Berdiri',
                        'Level Sertifikasi', 'Tipe Bisnis',
                        'NIB', 'NPWP', 'Status Verifikasi', 'Status Aktif',
                        'Tanggal Daftar',
                    ];

                    foreach ($headers as $i => $header) {
                        $col = Coordinate::stringFromColumnIndex($i + 1);
                        $sheet->setCellValue($col.'1', $header);
                    }

                    // Style header
                    $lastCol = Coordinate::stringFromColumnIndex(count($headers));
                    $sheet->getStyle('A1:'.$lastCol.'1')->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DC2626']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);

                    foreach ($records as $i => $wo) {
                        $row = $i + 2;
                        $data = [
                            $i + 1,
                            $wo->user->no_anggota ?? '-',
                            $wo->organizer_name,
                            $wo->brand_name ?? '-',
                            $wo->email ?? '-',
                            $wo->phone ?? '-',
                            $wo->city ?? '-',
                            $wo->province ?? '-',
                            $wo->instagram ?? '-',
                            $wo->website ?? '-',
                            $wo->established_year ?? '-',
                            $wo->certification_level ?? '-',
                            $wo->business_type ?? '-',
                            $wo->nib_number ?? '-',
                            $wo->npwp_number ?? '-',
                            match($wo->verification_status) {
                                'verified' => 'Terverifikasi',
                                'pending'  => 'Menunggu',
                                'rejected' => 'Ditolak',
                                default    => $wo->verification_status ?? '-',
                            },
                            $wo->is_active ? 'Aktif' : 'Tidak Aktif',
                            $wo->created_at?->format('d/m/Y') ?? '-',
                        ];

                        foreach ($data as $j => $value) {
                            $col = Coordinate::stringFromColumnIndex($j + 1);
                            $sheet->setCellValue($col.$row, $value);
                        }

                        // Zebra striping
                        if ($i % 2 === 1) {
                            $sheet->getStyle('A'.$row.':'.$lastCol.$row)->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEF2F2']],
                            ]);
                        }
                    }

                    foreach (range(1, count($headers)) as $i) {
                        $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);
                    }

                    $sheet->freezePane('A2');

                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                    $filename = 'data_wedding_organizer_'.now()->format('Y-m-d_H-i-s').'.xlsx';

                    return response()->streamDownload(function () use ($writer) {
                        $writer->save('php://output');
                    }, $filename, [
                        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ]);
                }),

            Action::make('download_pdf')
                ->label('Download PDF')
                ->icon('heroicon-o-document-text')
                ->color('danger')
                ->action(function () {
                    $records = WeddingOrganizer::with(['user', 'region'])
                        ->orderBy('organizer_name')
                        ->get();

                    $html = view('filament.exports.wedding-organizers-pdf', [
                        'records'     => $records,
                        'generatedAt' => now()->format('d/m/Y H:i'),
                        'total'       => $records->count(),
                    ])->render();

                    $pdf = Pdf::loadHTML($html)
                        ->setPaper('a4', 'landscape')
                        ->setOption('defaultFont', 'sans-serif')
                        ->setOption('isHtml5ParserEnabled', true)
                        ->setOption('isRemoteEnabled', false);

                    $filename = 'data_wedding_organizer_'.now()->format('Y-m-d_H-i-s').'.pdf';

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, $filename, [
                        'Content-Type' => 'application/pdf',
                    ]);
                }),
            ])
                ->label('Download Data')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->button(),

            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WeddingOrganizerOverviewWidget::class,
        ];
    }
}
