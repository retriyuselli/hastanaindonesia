<?php

namespace App\Filament\Admin\Resources\WeddingOrganizers\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Filament\Support\Colors\Color;
use App\Models\Region;
use Illuminate\Database\Eloquent\Collection;

class WeddingOrganizersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Avatar/Logo (if available)
                ImageColumn::make('logo')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl('/images/default-avatar.png')
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                // Core Information
                TextColumn::make('organizer_name')
                    ->label('🎭 Nama Organizer')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->copyMessage('Nama organizer berhasil disalin')
                    ->description(fn ($record) => $record->brand_name),

                TextColumn::make('user.name')
                    ->label('👤 User')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('region.region_name')
                    ->label('🌏 Wilayah')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(Color::Blue),

                // Contact Information
                TextColumn::make('phone')
                    ->label('📞 Telepon')
                    ->searchable()
                    ->copyable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => $state ? $state : '-'),

                TextColumn::make('email')
                    ->label('📧 Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => $state ? $state : '-'),

                // Location
                TextColumn::make('city')
                    ->label('🏙️ Kota')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->province),

                // Business Information
                TextColumn::make('business_type')
                    ->label('🏢 Jenis Usaha')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Perorangan' => 'gray',
                        'CV' => 'blue',
                        'PT' => 'green',
                        'Koperasi' => 'orange',
                        default => 'gray',
                    })
                    ->toggleable(),

                TextColumn::make('certification_level')
                    ->label('🏆 Sertifikasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Platinum' => 'warning',
                        'Gold' => 'yellow',
                        'Silver' => 'gray',
                        'Bronze' => 'orange',
                        default => 'secondary',
                    })
                    ->toggleable(),

                TextColumn::make('established_year')
                    ->label('📅 Berdiri')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? $state . ' (' . (now()->year - $state) . ' tahun)' : '-')
                    ->toggleable(),

                // Performance Metrics
                TextColumn::make('completed_events')
                    ->label('✅ Event Selesai')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($state) => $state >= 50 ? Color::Green : ($state >= 20 ? Color::Orange : Color::Gray))
                    ->formatStateUsing(fn ($state) => $state ?? 0),

                TextColumn::make('rating')
                    ->label('⭐ Rating')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1) . '/5.0' : 'Belum ada')
                    ->color(fn ($state) => $state >= 4.5 ? Color::Green : ($state >= 4.0 ? Color::Orange : Color::Gray)),

                // Price Range
                TextColumn::make('price_range_min')
                    ->label('💰 Harga Min')
                    ->numeric()
                    ->sortable()
                    ->money('IDR')
                    ->toggleable(),

                TextColumn::make('price_range_max')
                    ->label('💰 Harga Max')
                    ->numeric()
                    ->sortable()
                    ->money('IDR')
                    ->toggleable(),

                // Status Columns
                TextColumn::make('verification_status')
                    ->label('✓ Status Verifikasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'danger',
                        'under_review' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'gray',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-m-clock',
                        'under_review' => 'heroicon-m-eye',
                        'verified' => 'heroicon-m-check-circle',
                        'rejected' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    }),

                TextColumn::make('legal_document_status')
                    ->label('📋 Dokumen Legal')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'incomplete' => 'danger',
                        'pending_review' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'gray',
                        default => 'gray',
                    })
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label('⭐ Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('📊 Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'suspended' => 'danger',
                        'pending' => 'gray',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'active' => 'heroicon-m-check-circle',
                        'inactive' => 'heroicon-m-pause-circle',
                        'suspended' => 'heroicon-m-x-circle',
                        'pending' => 'heroicon-m-clock',
                        default => 'heroicon-m-question-mark-circle',
                    }),

                // Social Media
                TextColumn::make('website')
                    ->label('🌐 Website')
                    ->url(fn ($record) => $record->website)
                    ->openUrlInNewTab()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->formatStateUsing(fn ($state) => $state ? 'Lihat Website' : '-'),

                TextColumn::make('instagram')
                    ->label('📷 Instagram')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->formatStateUsing(fn ($state) => $state ? $state : '-'),

                // Verification Information
                TextColumn::make('verified_at')
                    ->label('📅 Terverifikasi')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make('verifier.name')
                    ->label('👤 Diverifikasi Oleh')
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                // Legal Document Information
                TextColumn::make('legal_entity_type')
                    ->label('🏛️ Jenis Badan Hukum')
                    ->badge()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make('nib_number')
                    ->label('📃 NIB')
                    ->searchable()
                    ->copyable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make('npwp_number')
                    ->label('🏛️ NPWP')
                    ->searchable()
                    ->copyable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                // Timestamps
                TextColumn::make('created_at')
                    ->label('📅 Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('📅 Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('region_id')
                    ->label('Wilayah')
                    ->options(Region::pluck('region_name', 'id'))
                    ->placeholder('Semua Wilayah')
                    ->multiple(),

                SelectFilter::make('verification_status')
                    ->label('Status Verifikasi')
                    ->options([
                        'pending' => 'Pending',
                        'under_review' => 'Sedang Ditinjau',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                    ])
                    ->placeholder('Semua Status'),

                SelectFilter::make('legal_document_status')
                    ->label('Status Dokumen Legal')
                    ->options([
                        'pending' => 'Pending',
                        'under_review' => 'Sedang Ditinjau',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                    ])
                    ->placeholder('Semua Status'),

                TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->placeholder('Semua')
                    ->trueLabel('Hanya Featured')
                    ->falseLabel('Bukan Featured'),

                SelectFilter::make('status')
                    ->label('Status Aktif')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                        'suspended' => 'Disuspend',
                        'pending' => 'Pending',
                    ])
                    ->placeholder('Semua Status'),

                SelectFilter::make('certification_level')
                    ->label('Level Sertifikasi')
                    ->options([
                        'Bronze' => 'Bronze',
                        'Silver' => 'Silver',
                        'Gold' => 'Gold',
                        'Platinum' => 'Platinum',
                    ])
                    ->placeholder('Semua Level'),

                SelectFilter::make('business_type')
                    ->label('Jenis Usaha')
                    ->options([
                        'Perorangan' => 'Perorangan',
                        'CV' => 'CV',
                        'PT' => 'PT',
                        'Koperasi' => 'Koperasi',
                    ])
                    ->placeholder('Semua Jenis'),

                SelectFilter::make('province')
                    ->label('Provinsi')
                    ->options(function () {
                        return \App\Models\WeddingOrganizer::distinct()
                            ->whereNotNull('province')
                            ->pluck('province', 'province')
                            ->sort();
                    })
                    ->placeholder('Semua Provinsi')
                    ->searchable(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    // Delete Bulk Action
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Wedding Organizer')
                        ->modalDescription('Apakah Anda yakin ingin menghapus wedding organizer yang dipilih? Tindakan ini tidak dapat dibatalkan.')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal'),

                    // Activate Bulk Action
                    BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Aktifkan Wedding Organizer')
                        ->modalDescription('Apakah Anda yakin ingin mengaktifkan wedding organizer yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Aktifkan')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'active']);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),

                    // Deactivate Bulk Action
                    BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Nonaktifkan Wedding Organizer')
                        ->modalDescription('Apakah Anda yakin ingin menonaktifkan wedding organizer yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Nonaktifkan')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'inactive']);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),

                    // Verify Bulk Action
                    BulkAction::make('verify')
                        ->label('Verifikasi')
                        ->icon('heroicon-o-shield-check')
                        ->color('info')
                        ->requiresConfirmation()
                        ->modalHeading('Verifikasi Wedding Organizer')
                        ->modalDescription('Apakah Anda yakin ingin memverifikasi wedding organizer yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Verifikasi')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'verification_status' => 'verified',
                                    'verified_at' => now(),
                                ]);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),

                    // Set as Featured Bulk Action
                    BulkAction::make('set_featured')
                        ->label('Jadikan Unggulan')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Jadikan Wedding Organizer Unggulan')
                        ->modalDescription('Apakah Anda yakin ingin menjadikan wedding organizer yang dipilih sebagai unggulan?')
                        ->modalSubmitActionLabel('Ya, Jadikan Unggulan')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['is_featured' => true]);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),

                    // Remove from Featured Bulk Action
                    BulkAction::make('remove_featured')
                        ->label('Hapus dari Unggulan')
                        ->icon('heroicon-o-star')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->modalHeading('Hapus dari Wedding Organizer Unggulan')
                        ->modalDescription('Apakah Anda yakin ingin menghapus wedding organizer yang dipilih dari daftar unggulan?')
                        ->modalSubmitActionLabel('Ya, Hapus dari Unggulan')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['is_featured' => false]);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),

                    // Export to CSV Bulk Action
                    BulkAction::make('export')
                        ->label('Export CSV (coming soon)')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $csv = "Nama Organizer,Brand Name,Email,Telepon,Kota,Provinsi,Status,Level Sertifikasi,Rating\n";
                            $records->each(function ($record) use (&$csv) {
                                $csv .= sprintf(
                                    "%s,%s,%s,%s,%s,%s,%s,%s,%.1f\n",
                                    $record->organizer_name,
                                    $record->brand_name ?? '',
                                    $record->email ?? '',
                                    $record->phone ?? '',
                                    $record->city ?? '',
                                    $record->province ?? '',
                                    $record->status ?? '',
                                    $record->certification_level ?? '',
                                    $record->rating ?? 0
                                );
                            });
                            
                            $filename = 'wedding_organizers_' . now()->format('Y-m-d_H-i-s') . '.csv';
                            
                            return response($csv)
                                ->header('Content-Type', 'text/csv')
                                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}
