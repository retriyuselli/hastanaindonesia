<?php

namespace App\Filament\Resources\EventHastanas\RelationManagers;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class EventParticipantsRelationManager extends RelationManager
{
    protected static string $relationship = 'participants';

    public function form(Schema $schema): Schema
    {
        $owner = $this->getOwnerRecord();

        return $schema
            ->schema([
                Hidden::make('event_hastana_id')
                    ->default($owner->id)
                    ->dehydrated(),

                Section::make('Peserta')
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label('User (opsional)')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set): void {
                                if (! $state) {
                                    return;
                                }

                                $user = User::find($state);
                                if (! $user) {
                                    return;
                                }

                                $set('name', $user->name);
                                $set('email', $user->email);
                            })
                            ->columnSpan(2),

                        TextInput::make('registration_code')
                            ->label('Kode Registrasi')
                            ->disabled()
                            ->dehydrated()
                            ->default(fn (): string => 'REG-'.strtoupper(Str::random(10)))
                            ->unique(ignoreRecord: true)
                            ->columnSpan(1),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'cancelled' => 'Cancelled',
                                'attended' => 'Attended',
                            ])
                            ->default('pending')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get): void {
                                if ($state === 'confirmed' && ! $get('confirmed_at')) {
                                    $set('confirmed_at', now());
                                }

                                if ($state === 'attended') {
                                    if (! $get('confirmed_at')) {
                                        $set('confirmed_at', now());
                                    }
                                    if (! $get('attended_at')) {
                                        $set('attended_at', now());
                                    }
                                }

                                if ($state === 'pending') {
                                    $set('confirmed_at', null);
                                    $set('attended_at', null);
                                }

                                if ($state === 'confirmed' && $get('attended_at')) {
                                    $set('attended_at', null);
                                }
                            })
                            ->columnSpan(1),

                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('phone')
                            ->label('Telepon')
                            ->required()
                            ->maxLength(20)
                            ->columnSpan(1),

                        TextInput::make('company')
                            ->label('Perusahaan')
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('position')
                            ->label('Posisi')
                            ->maxLength(255)
                            ->columnSpan(1),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpan(2),
                    ]),

                Section::make('Pembayaran')
                    ->columns(2)
                    ->schema([
                        Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'free' => 'Gratis',
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'refunded' => 'Refund',
                            ])
                            ->default($owner->is_free ? 'free' : 'pending')
                            ->required()
                            ->live()
                            ->columnSpan(1),

                        Select::make('payment_method')
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
                            ->visible(fn (callable $get): bool => $get('payment_status') !== 'free')
                            ->columnSpan(1),

                        FileUpload::make('payment_proof')
                            ->label('Bukti Pembayaran')
                            ->disk('private')
                            ->directory('payment_proofs')
                            ->image()
                            ->maxSize(2048)
                            ->visible(fn (callable $get): bool => $get('payment_status') !== 'free')
                            ->columnSpan(2),
                    ]),

                Section::make('Waktu')
                    ->columns(2)
                    ->collapsed()
                    ->collapsible()
                    ->schema([
                        DateTimePicker::make('confirmed_at')
                            ->label('Konfirmasi')
                            ->seconds(false)
                            ->columnSpan(1),

                        DateTimePicker::make('attended_at')
                            ->label('Kehadiran')
                            ->seconds(false)
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Peserta')
                    ->icon('heroicon-o-plus')
                    ->mutateFormDataUsing(fn (array $data): array => $data + ['event_hastana_id' => $this->getOwnerRecord()->id])
                    ->after(function (): void {
                        $owner = $this->getOwnerRecord();
                        if (($owner->current_participants ?? 0) >= 0) {
                            $owner->increment('current_participants');
                        }
                    }),
            ])
            ->columns([
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
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->copyable()
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
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'refunded' => 'danger',
                        'free' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'refunded' => 'Refund',
                        'free' => 'Free',
                        default => $state,
                    }),

                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'attended' => 'Attended',
                    ])
                    ->multiple(),

                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'free' => 'Gratis',
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'refunded' => 'Refund',
                    ])
                    ->multiple(),

                TernaryFilter::make('has_payment_proof')
                    ->label('Ada Bukti Bayar')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereNotNull('payment_proof')->where('payment_proof', '!=', ''),
                        false: fn (Builder $query): Builder => $query->whereNull('payment_proof')->orWhere('payment_proof', ''),
                        blank: fn (Builder $query): Builder => $query,
                    ),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('Lihat'),
                    EditAction::make()
                        ->label('Edit'),
                    Action::make('viewPaymentProof')
                        ->label('Bukti Bayar')
                        ->icon('heroicon-o-photo')
                        ->color('info')
                        ->visible(fn ($record) => (bool) $record->payment_proof)
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
                    DeleteAction::make()
                        ->label('Hapus')
                        ->after(function (): void {
                            $owner = $this->getOwnerRecord();
                            if (($owner->current_participants ?? 0) > 0) {
                                $owner->decrement('current_participants');
                            }
                        }),
                ])->label('Aksi'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkConfirm')
                        ->label('Konfirmasi')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(fn ($record) => $record->update([
                                'status' => 'confirmed',
                                'confirmed_at' => $record->confirmed_at ?? now(),
                            ]));
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('bulkAttended')
                        ->label('Tandai Hadir')
                        ->icon('heroicon-o-user-group')
                        ->color('info')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(fn ($record) => $record->update([
                                'status' => 'attended',
                                'confirmed_at' => $record->confirmed_at ?? now(),
                                'attended_at' => $record->attended_at ?? now(),
                            ]));
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make()
                        ->after(function (Collection $records): void {
                            $owner = $this->getOwnerRecord();
                            $count = $records->count();
                            $current = (int) ($owner->current_participants ?? 0);
                            $owner->update(['current_participants' => max(0, $current - $count)]);
                        }),
                ])->label('Aksi'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->searchable();
    }
}
