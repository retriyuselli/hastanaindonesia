<?php

namespace App\Filament\Resources\IuranSettings\Tables;

use App\Models\Iuran;
use App\Models\IuranSetting;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class IuranSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Iuran')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('period_type')
                    ->label('Periode')
                    ->formatStateUsing(fn ($state) => $state === 'monthly' ? 'Bulanan' : 'Tahunan')
                    ->badge()
                    ->color(fn ($state) => $state === 'monthly' ? 'info' : 'success'),

                TextColumn::make('period_label')
                    ->label('Periode')
                    ->getStateUsing(fn ($record) => $record->period_label),

                TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('iurans_count')
                    ->label('Tagihan')
                    ->counts('iurans')
                    ->badge()
                    ->color('gray'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('period_type')
                    ->label('Jenis Periode')
                    ->options(['monthly' => 'Bulanan', 'yearly' => 'Tahunan']),

                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([1 => 'Aktif', 0 => 'Nonaktif']),
            ])
            ->headerActions([
                Action::make('generate_tagihan')
                    ->label('Generate Tagihan ke Semua Member')
                    ->icon('heroicon-o-bolt')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Generate Tagihan')
                    ->modalDescription('Ini akan membuat tagihan iuran ke semua member yang belum memiliki tagihan untuk periode ini.')
                    ->action(function () {
                        $settings = IuranSetting::active()->get();
                        $users = User::whereHas('roles', fn ($q) => $q->whereIn('name', ['member', 'panel_user']))->get();
                        $created = 0;

                        foreach ($settings as $setting) {
                            foreach ($users as $user) {
                                $exists = Iuran::where('user_id', $user->id)
                                    ->where('iuran_setting_id', $setting->id)
                                    ->exists();

                                if (! $exists) {
                                    Iuran::create([
                                        'user_id' => $user->id,
                                        'iuran_setting_id' => $setting->id,
                                        'amount' => $setting->amount,
                                        'period_label' => $setting->period_label,
                                        'due_date' => $setting->due_date,
                                        'status' => 'unpaid',
                                    ]);
                                    $created++;
                                }
                            }
                        }

                        Notification::make()
                            ->title("{$created} tagihan berhasil dibuat")
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->label('Aksi'),
            ])
            ->defaultSort('due_date', 'desc');
    }
}
