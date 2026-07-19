<?php

namespace App\Filament\Resources\EventParticipants\Tables;

use App\Models\EventHastana;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
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
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

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
                    ->limit(28)
                    ->tooltip(fn ($record) => $record->eventHastana?->title)
                    ->description(fn ($record) => $record->eventHastana?->start_date?->format('d M Y')),

                TextColumn::make('registration_code')
                    ->label('Kode')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Kode dicopy!')
                    ->fontFamily('mono'),

                TextColumn::make('name')
                    ->label('Peserta')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->email.' · '.$record->phone),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn ($state) => match ($state) {
                        'pending' => 'heroicon-m-clock',
                        'confirmed' => 'heroicon-m-check-circle',
                        'cancelled' => 'heroicon-m-x-circle',
                        'attended' => 'heroicon-m-check-badge',
                        default => null,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'attended' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'attended' => 'Attended',
                        default => $state,
                    }),

                TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->icon(fn ($state) => match ($state) {
                        'paid' => 'heroicon-m-banknotes',
                        'free' => 'heroicon-m-gift',
                        'refunded' => 'heroicon-m-arrow-uturn-left',
                        'pending' => 'heroicon-m-clock',
                        default => null,
                    })
                    ->color(fn ($state) => match ($state) {
                        'paid' => 'success',
                        'free' => 'info',
                        'refunded' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'paid' => 'Lunas',
                        'free' => 'Gratis',
                        'refunded' => 'Refund',
                        'pending' => 'Belum Bayar',
                        default => $state,
                    }),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state > 0
                        ? 'Rp '.number_format($state, 0, ',', '.')
                        : 'GRATIS')
                    ->color(fn ($state) => $state > 0 ? 'warning' : 'success')
                    ->weight('semibold')
                    ->toggleable(),

                TextColumn::make('company')
                    ->label('Perusahaan')
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('payment_method')
                    ->label('Metode Bayar')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'bca' => 'BCA',
                        'mandiri' => 'Mandiri',
                        'bni' => 'BNI',
                        'bri' => 'BRI',
                        'gopay' => 'GoPay',
                        'ovo' => 'OVO',
                        'dana' => 'DANA',
                        'bank_transfer' => 'Bank Transfer',
                        'credit_card' => 'Kartu Kredit',
                        'e_wallet' => 'E-Wallet',
                        'cash' => 'Tunai',
                        default => $state ? strtoupper($state) : '—',
                    })
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('payment_proof')
                    ->label('Bukti')
                    ->boolean()
                    ->getStateUsing(fn ($record): bool => (bool) $record->payment_proof)
                    ->trueIcon('heroicon-o-paper-clip')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('info')
                    ->falseColor('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('participantAddons_count')
                    ->label('Addon')
                    ->counts('participantAddons')
                    ->badge()
                    ->icon(fn ($state) => $state > 0 ? 'heroicon-m-shopping-bag' : null)
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray')
                    ->formatStateUsing(fn ($state) => $state > 0 ? "{$state} item" : '—')
                    ->description(fn ($record) => $record->participantAddons_count > 0
                        ? 'Rp '.number_format(
                            $record->participantAddons->sum(fn ($a) => $a->quantity * $a->price_at_time),
                            0, ',', '.'
                        )
                        : null)
                    ->tooltip(fn ($record) => $record->participantAddons_count > 0
                        ? $record->participantAddons
                            ->map(fn ($a) => ($a->eventAddon?->name ?? '?').' ×'.$a->quantity.'  →  Rp '.number_format($a->quantity * $a->price_at_time, 0, ',', '.'))
                            ->join("\n")
                        : null)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('confirmed_at')
                    ->label('Dikonfirmasi')
                    ->since()
                    ->sortable()
                    ->placeholder('Belum dikonfirmasi')
                    ->tooltip(fn ($record) => $record->confirmed_at?->format('d M Y, H:i'))
                    ->color('success')
                    ->toggleable(),

                TextColumn::make('attended_at')
                    ->label('Kehadiran')
                    ->since()
                    ->sortable()
                    ->placeholder('Belum hadir')
                    ->tooltip(fn ($record) => $record->attended_at?->format('d M Y, H:i'))
                    ->color('info')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->since()
                    ->sortable()
                    ->tooltip(fn ($record) => $record->created_at->format('d M Y, H:i'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('event_hastana_id')
                    ->label('Event')
                    ->relationship('eventHastana', 'title')
                    ->searchable()
                    ->preload()
                    ->indicateUsing(fn (array $data) => $data['value']
                        ? 'Event: '.EventHastana::find($data['value'])?->title
                        : null),

                SelectFilter::make('status')
                    ->label('Status Pendaftaran')
                    ->options([
                        'pending' => '⏳ Pending',
                        'confirmed' => '✅ Confirmed',
                        'attended' => '🎉 Attended',
                        'cancelled' => '❌ Cancelled',
                    ])
                    ->indicateUsing(fn (array $data) => $data['value']
                        ? 'Status: '.ucfirst($data['value'])
                        : null),

                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'free' => '🎁 Gratis',
                        'pending' => '⏳ Belum Bayar',
                        'paid' => '✅ Lunas',
                        'refunded' => '↩️ Refund',
                    ])
                    ->indicateUsing(fn (array $data) => $data['value']
                        ? 'Bayar: '.ucfirst($data['value'])
                        : null),

                SelectFilter::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'bca' => 'BCA',
                        'mandiri' => 'Mandiri',
                        'bni' => 'BNI',
                        'bri' => 'BRI',
                        'bank_transfer' => 'Bank Transfer',
                        'gopay' => 'GoPay',
                        'ovo' => 'OVO',
                        'dana' => 'DANA',
                        'e_wallet' => 'E-Wallet',
                        'cash' => 'Tunai',
                    ])
                    ->multiple(),

                TernaryFilter::make('has_payment_proof')
                    ->label('Bukti Bayar')
                    ->placeholder('Semua')
                    ->trueLabel('Ada bukti')
                    ->falseLabel('Tidak ada bukti')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereNotNull('payment_proof')->where('payment_proof', '!=', ''),
                        false: fn (Builder $query): Builder => $query->where(fn ($q) => $q->whereNull('payment_proof')->orWhere('payment_proof', '')),
                        blank: fn (Builder $query): Builder => $query,
                    ),

                Filter::make('registered_at')
                    ->label('Tanggal Daftar')
                    ->schema([
                        DatePicker::make('from')->label('Dari')->native(false),
                        DatePicker::make('until')->label('Sampai')->native(false),
                    ])
                    ->columns(2)
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['from'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                        ->when($data['until'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '<=', $date)))
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators[] = 'Dari: '.$data['from'];
                        }
                        if ($data['until'] ?? null) {
                            $indicators[] = 'Sampai: '.$data['until'];
                        }

                        return $indicators;
                    }),
            ])
            ->filtersFormColumns(2)
            ->groups([
                Group::make('status')
                    ->label('Status Pendaftaran')
                    ->getTitleFromRecordUsing(fn ($record) => match ($record->status) {
                        'pending' => '⏳ Pending',
                        'confirmed' => '✅ Confirmed',
                        'attended' => '🎉 Attended',
                        'cancelled' => '❌ Cancelled',
                        default => ucfirst($record->status),
                    }),
                Group::make('payment_status')
                    ->label('Status Pembayaran')
                    ->getTitleFromRecordUsing(fn ($record) => match ($record->payment_status) {
                        'paid' => '💳 Lunas',
                        'free' => '🎁 Gratis',
                        'refunded' => '↩️ Refund',
                        'pending' => '⏳ Belum Bayar',
                        default => ucfirst($record->payment_status),
                    }),
                Group::make('eventHastana.title')
                    ->label('Event'),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    // Action::make('previewInvoice')
                    //     ->label('Preview Invoice')
                    //     ->icon('heroicon-o-document-text')
                    //     ->color('gray')
                    //     ->url(fn ($record) => route('admin.files.event-participants.invoice', $record))
                    //     ->openUrlInNewTab(),
                    Action::make('downloadInvoice')
                        ->label('Download Invoice')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->url(fn ($record) => route('admin.files.event-participants.invoice', $record).'?download=1')
                        ->openUrlInNewTab(),
                    Action::make('viewPaymentProof')
                        ->label('Bukti Bayar')
                        ->icon('heroicon-o-photo')
                        ->color('info')
                        ->visible(fn ($record) => $record->payment_proof !== null)
                        ->modalHeading(false)
                        ->modalContent(fn ($record) => view('filament.modals.payment-proof', [
                            'record' => $record,
                            'imageUrl' => route('files.event-participants.payment-proof', $record),
                        ]))
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->modalWidth('fit'),
                    Action::make('markConfirmed')
                        ->label('Konfirmasi')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === 'pending')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Peserta?')
                        ->modalDescription(fn ($record) => "Peserta \"{$record->name}\" akan dikonfirmasi dan waktu konfirmasi akan dicatat.")
                        ->action(fn ($record) => $record->markAsConfirmed())
                        ->successNotificationTitle('Peserta berhasil dikonfirmasi'),
                    Action::make('markAttended')
                        ->label('Tandai Hadir')
                        ->icon('heroicon-o-user-group')
                        ->color('info')
                        ->visible(fn ($record) => $record->status === 'confirmed')
                        ->requiresConfirmation()
                        ->modalHeading('Tandai Peserta Hadir?')
                        ->modalDescription(fn ($record) => "Peserta \"{$record->name}\" akan ditandai hadir dan waktu kehadiran akan dicatat.")
                        ->action(fn ($record) => $record->markAsAttended())
                        ->successNotificationTitle('Peserta ditandai hadir'),
                    Action::make('markCancelled')
                        ->label('Batalkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn ($record) => in_array($record->status, ['pending', 'confirmed']))
                        ->requiresConfirmation()
                        ->modalHeading('Batalkan Pendaftaran?')
                        ->modalDescription(fn ($record) => "Pendaftaran \"{$record->name}\" akan dibatalkan. Tindakan ini tidak bisa diundur.")
                        ->modalIcon('heroicon-o-exclamation-triangle')
                        ->action(fn ($record) => $record->cancel())
                        ->successNotificationTitle('Pendaftaran dibatalkan'),
                    DeleteAction::make(),
                ])->label('Aksi')->icon('heroicon-m-ellipsis-vertical'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkConfirm')
                        ->label('Konfirmasi Dipilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Peserta Terpilih?')
                        ->modalDescription('Semua peserta dengan status pending akan dikonfirmasi.')
                        ->action(fn (Collection $records) => $records
                            ->filter(fn ($r) => $r->status === 'pending')
                            ->each->markAsConfirmed())
                        ->successNotificationTitle('Peserta berhasil dikonfirmasi')
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('bulkCancel')
                        ->label('Batalkan Dipilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Batalkan Peserta Terpilih?')
                        ->modalDescription('Semua peserta terpilih yang masih pending/confirmed akan dibatalkan.')
                        ->action(fn (Collection $records) => $records
                            ->filter(fn ($r) => in_array($r->status, ['pending', 'confirmed']))
                            ->each->cancel())
                        ->successNotificationTitle('Pendaftaran dibatalkan')
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ])->label('Aksi'),
            ])
            ->emptyStateIcon('heroicon-o-ticket')
            ->emptyStateHeading('Belum ada peserta')
            ->emptyStateDescription('Peserta event akan muncul di sini setelah mendaftar.')
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('60s')
            ->modifyQueryUsing(fn ($query) => $query->with(['participantAddons.eventAddon']));
    }
}
