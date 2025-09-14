<?php

namespace App\Filament\Admin\Resources\WeddingOrganizers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use App\Models\Region;

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
                    ->size(40)
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
                BadgeColumn::make('verification_status')
                    ->label('✓ Status Verifikasi')
                    ->colors([
                        'danger' => 'pending',
                        'warning' => 'under_review',
                        'success' => 'verified',
                        'secondary' => 'rejected',
                    ])
                    ->icons([
                        'heroicon-m-clock' => 'pending',
                        'heroicon-m-eye' => 'under_review',
                        'heroicon-m-check-circle' => 'verified',
                        'heroicon-m-x-circle' => 'rejected',
                    ]),

                BadgeColumn::make('legal_document_status')
                    ->label('📋 Dokumen Legal')
                    ->colors([
                        'danger' => 'pending',
                        'warning' => 'under_review',
                        'success' => 'verified',
                        'secondary' => 'rejected',
                    ])
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label('⭐ Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->toggleable(),

                BadgeColumn::make('status')
                    ->label('📊 Status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'inactive',
                        'danger' => 'suspended',
                        'secondary' => 'pending',
                    ])
                    ->icons([
                        'heroicon-m-check-circle' => 'active',
                        'heroicon-m-pause-circle' => 'inactive',
                        'heroicon-m-x-circle' => 'suspended',
                        'heroicon-m-clock' => 'pending',
                    ]),

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
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-m-eye'),
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}
