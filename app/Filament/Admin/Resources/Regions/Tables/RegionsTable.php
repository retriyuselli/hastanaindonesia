<?php

namespace App\Filament\Admin\Resources\Regions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RegionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->disk('public')
                    ->defaultImageUrl(url('/images/default-region.png'))
                    ->width(40)
                    ->height(40),

                TextColumn::make('region_name')
                    ->label('Nama Wilayah')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): string => $record->province ?? 'Provinsi tidak diset'),

                TextColumn::make('province')
                    ->label('Provinsi')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-map-pin'),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->tooltip(fn ($state): string => $state ? 'Aktif' : 'Tidak Aktif'),

                TextColumn::make('ketuaDpw.name')
                    ->label('Ketua DPW')
                    ->searchable()
                    ->placeholder('Belum diisi')
                    ->icon('heroicon-m-user-circle')
                    ->color('primary'),

                TextColumn::make('dpw_completion')
                    ->label('Kelengkapan DPW')
                    ->getStateUsing(function ($record) {
                        $positions = ['ketua_dpw', 'wk_ketua_dpw', 'sekretaris_dpw', 'bendahara_dpw'];
                        $filled = 0;
                        foreach ($positions as $position) {
                            if (!is_null($record->$position)) {
                                $filled++;
                            }
                        }
                        return round(($filled / count($positions)) * 100);
                    })
                    ->formatStateUsing(fn ($state): string => $state . '%')
                    ->badge()
                    ->color(fn ($state): string => match (true) {
                        $state == 100 => 'success',
                        $state >= 75 => 'warning',
                        $state >= 50 => 'info',
                        default => 'danger',
                    })
                    ->icon(fn ($state): string => match (true) {
                        $state == 100 => 'heroicon-m-check-circle',
                        $state >= 50 => 'heroicon-m-clock',
                        default => 'heroicon-m-exclamation-triangle',
                    })
                    ->sortable(),

                TextColumn::make('contact_email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email berhasil disalin!')
                    ->icon('heroicon-m-envelope')
                    ->placeholder('Tidak ada')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('contact_phone')
                    ->label('Telepon')
                    ->searchable()
                    ->icon('heroicon-m-phone')
                    ->placeholder('Tidak ada')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('website')
                    ->label('Website')
                    ->url(fn ($record): ?string => $record->website)
                    ->openUrlInNewTab()
                    ->icon('heroicon-m-globe-alt')
                    ->placeholder('Tidak ada')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('establishment_date')
                    ->label('Tanggal Pendirian')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('Tidak diset')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('province')
                    ->label('Provinsi')
                    ->options([
                        'Aceh' => 'Aceh',
                        'Sumatera Utara' => 'Sumatera Utara',
                        'Sumatera Barat' => 'Sumatera Barat',
                        'Riau' => 'Riau',
                        'Kepulauan Riau' => 'Kepulauan Riau',
                        'Jambi' => 'Jambi',
                        'Sumatera Selatan' => 'Sumatera Selatan',
                        'Bangka Belitung' => 'Bangka Belitung',
                        'Bengkulu' => 'Bengkulu',
                        'Lampung' => 'Lampung',
                        'DKI Jakarta' => 'DKI Jakarta',
                        'Jawa Barat' => 'Jawa Barat',
                        'Jawa Tengah' => 'Jawa Tengah',
                        'DI Yogyakarta' => 'DI Yogyakarta',
                        'Jawa Timur' => 'Jawa Timur',
                        'Banten' => 'Banten',
                        'Bali' => 'Bali',
                        'Nusa Tenggara Barat' => 'Nusa Tenggara Barat',
                        'Nusa Tenggara Timur' => 'Nusa Tenggara Timur',
                        'Kalimantan Barat' => 'Kalimantan Barat',
                        'Kalimantan Tengah' => 'Kalimantan Tengah',
                        'Kalimantan Selatan' => 'Kalimantan Selatan',
                        'Kalimantan Timur' => 'Kalimantan Timur',
                        'Kalimantan Utara' => 'Kalimantan Utara',
                        'Sulawesi Utara' => 'Sulawesi Utara',
                        'Sulawesi Tengah' => 'Sulawesi Tengah',
                        'Sulawesi Selatan' => 'Sulawesi Selatan',
                        'Sulawesi Tenggara' => 'Sulawesi Tenggara',
                        'Gorontalo' => 'Gorontalo',
                        'Sulawesi Barat' => 'Sulawesi Barat',
                        'Maluku' => 'Maluku',
                        'Maluku Utara' => 'Maluku Utara',
                        'Papua' => 'Papua',
                        'Papua Barat' => 'Papua Barat',
                    ])
                    ->placeholder('Semua Provinsi'),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),

                SelectFilter::make('dpw_complete')
                    ->label('Kelengkapan DPW')
                    ->options([
                        'complete' => 'Lengkap (100%)',
                        'incomplete' => 'Tidak Lengkap',
                        'partial' => 'Sebagian (50-99%)',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['value'], function (Builder $query, string $value): Builder {
                            return match ($value) {
                                'complete' => $query->whereNotNull(['ketua_dpw', 'wk_ketua_dpw', 'sekretaris_dpw', 'bendahara_dpw']),
                                'incomplete' => $query->where(function ($query) {
                                    $query->whereNull('ketua_dpw')
                                        ->orWhereNull('wk_ketua_dpw')
                                        ->orWhereNull('sekretaris_dpw')
                                        ->orWhereNull('bendahara_dpw');
                                }),
                                'partial' => $query->where(function ($query) {
                                    $filled = 0;
                                    $positions = ['ketua_dpw', 'wk_ketua_dpw', 'sekretaris_dpw', 'bendahara_dpw'];
                                    foreach ($positions as $position) {
                                        $query->orWhereNotNull($position);
                                    }
                                })->whereNot(function ($query) {
                                    $query->whereNotNull(['ketua_dpw', 'wk_ketua_dpw', 'sekretaris_dpw', 'bendahara_dpw']);
                                }),
                                default => $query,
                            };
                        });
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat'),
                EditAction::make()
                    ->label('Edit'),
                Action::make('toggle_status')
                    ->label('Toggle Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color(fn ($record) => $record->is_active ? 'warning' : 'success')
                    ->action(function ($record) {
                        $record->update(['is_active' => !$record->is_active]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Ubah Status Wilayah')
                    ->modalDescription(fn ($record) => 'Apakah Anda yakin ingin ' . ($record->is_active ? 'menonaktifkan' : 'mengaktifkan') . ' wilayah ini?'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('region_name')
            ->striped()
            ->paginated([10, 25, 50]);
    }
}
