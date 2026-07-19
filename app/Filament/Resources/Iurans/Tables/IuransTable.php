<?php

namespace App\Filament\Resources\Iurans\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class IuransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Member')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('iuranSetting.name')
                    ->label('Iuran')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('period_label')
                    ->label('Periode')
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->sortable()
                    ->color(fn ($record) => $record->is_overdue ? 'danger' : null),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'unpaid' => 'Belum Bayar',
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'overdue' => 'Terlambat',
                        default => ucfirst($state),
                    })
                    ->color(fn ($state) => match ($state) {
                        'unpaid' => 'gray',
                        'pending' => 'warning',
                        'paid' => 'success',
                        'overdue' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('paid_at')
                    ->label('Tgl Bayar')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'unpaid' => 'Belum Bayar',
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'overdue' => 'Terlambat',
                    ]),

                SelectFilter::make('iuran_setting_id')
                    ->label('Periode Iuran')
                    ->relationship('iuranSetting', 'name'),
            ])
            ->actions([
                Action::make('konfirmasi')
                    ->label('Konfirmasi Lunas')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(function ($record) {
                        $record->markAsPaid(auth()->id());
                        Notification::make()
                            ->title('Iuran dikonfirmasi lunas')
                            ->success()
                            ->send();
                    }),

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
