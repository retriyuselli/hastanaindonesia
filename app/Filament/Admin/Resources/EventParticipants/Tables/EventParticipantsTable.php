<?php

namespace App\Filament\Admin\Resources\EventParticipants\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventParticipantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('eventHastana.title')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function ($record) {
                        return $record->eventHastana?->title;
                    }),
                
                TextColumn::make('registration_code')
                    ->label('Kode')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Kode dicopy!')
                    ->copyMessageDuration(1500),
                
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->weight('bold'),
                
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable()
                    ->copyable(),
                
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->toggleable()
                    ->copyable(),
                
                TextColumn::make('company')
                    ->label('Perusahaan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'attended' => 'info',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'attended' => 'Attended',
                        default => $state
                    }),
                
                TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'refunded' => 'danger',
                        'free' => 'info',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'refunded' => 'Refund',
                        'free' => 'Free',
                        default => $state
                    }),
                
                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => $state ? strtoupper($state) : '-')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->tooltip(fn ($state) => match($state) {
                        'bca' => 'Transfer Bank BCA',
                        'mandiri' => 'Transfer Bank Mandiri',
                        'bni' => 'Transfer Bank BNI',
                        'bri' => 'Transfer Bank BRI',
                        default => 'Tidak ada'
                    }),
                
                TextColumn::make('confirmed_at')
                    ->label('Konfirmasi')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('attended_at')
                    ->label('Kehadiran')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('event_hastana_id')
                    ->label('Event')
                    ->relationship('eventHastana', 'title')
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'attended' => 'Attended',
                    ]),
                
                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'free' => 'Gratis',
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'refunded' => 'Refund',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('viewPaymentProof')
                    ->label('Bukti Bayar')
                    ->icon('heroicon-o-photo')
                    ->color('info')
                    ->visible(fn ($record) => $record->payment_proof !== null)
                    ->modalHeading(fn ($record) => 'Bukti Pembayaran - ' . $record->name)
                    ->modalContent(fn ($record) => view('filament.modals.payment-proof', [
                        'record' => $record,
                        'imageUrl' => asset('storage/' . $record->payment_proof)
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
