<?php

namespace App\Filament\Resources\EventParticipants\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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

                IconColumn::make('payment_proof')
                    ->label('Bukti')
                    ->boolean()
                    ->getStateUsing(fn ($record): bool => (bool) ($record->payment_proof))
                    ->trueIcon('heroicon-o-paper-clip')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('info')
                    ->falseColor('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'attended' => 'info',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'attended' => 'Attended',
                        default => $state
                    }),

                TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'refunded' => 'danger',
                        'free' => 'info',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
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
                    ->tooltip(fn ($state) => match ($state) {
                        'bank_transfer' => 'Transfer Bank',
                        'credit_card' => 'Kartu Kredit',
                        'e_wallet' => 'E-Wallet',
                        'cash' => 'Tunai',
                        'bca' => 'Transfer Bank BCA',
                        'mandiri' => 'Transfer Bank Mandiri',
                        'bni' => 'Transfer Bank BNI',
                        'bri' => 'Transfer Bank BRI',
                        default => 'Tidak ada'
                    }),

                TextColumn::make('eventHastana.start_date')
                    ->label('Tanggal Event')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                SelectFilter::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'bca' => 'BCA',
                        'mandiri' => 'Mandiri',
                        'bni' => 'BNI',
                        'bri' => 'BRI',
                        'bank_transfer' => 'Bank Transfer',
                        'credit_card' => 'Credit Card',
                        'e_wallet' => 'E-Wallet',
                        'cash' => 'Cash',
                    ])
                    ->multiple(),

                TernaryFilter::make('has_payment_proof')
                    ->label('Ada Bukti Bayar')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereNotNull('payment_proof')->where('payment_proof', '!=', ''),
                        false: fn (Builder $query): Builder => $query->whereNull('payment_proof')->orWhere('payment_proof', ''),
                        blank: fn (Builder $query): Builder => $query,
                    ),

                Filter::make('registered_at')
                    ->label('Tanggal Daftar')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('viewPaymentProof')
                        ->label('Bukti Bayar')
                        ->icon('heroicon-o-photo')
                        ->color('info')
                        ->visible(fn ($record) => $record->payment_proof !== null)
                        ->modalHeading(fn ($record) => 'Bukti Pembayaran - '.$record->name)
                        ->modalContent(fn ($record) => view('filament.modals.payment-proof', [
                            'record' => $record,
                            'imageUrl' => route('files.event-participants.payment-proof', $record),
                        ]))
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Tutup')
                        ->slideOver(),
                    Action::make('markConfirmed')
                        ->label('Konfirmasi')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === 'pending')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->update([
                            'status' => 'confirmed',
                            'confirmed_at' => now(),
                        ])),
                    Action::make('markAttended')
                        ->label('Tandai Hadir')
                        ->icon('heroicon-o-user-group')
                        ->color('info')
                        ->visible(fn ($record) => $record->status === 'confirmed')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->update([
                            'status' => 'attended',
                            'attended_at' => now(),
                        ])),
                    DeleteAction::make(),
                ])->label('Aksi'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->label('Aksi'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}
