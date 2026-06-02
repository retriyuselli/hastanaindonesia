<?php

namespace App\Filament\Resources\Iurans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IuranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Data Tagihan')
                ->columns(2)
                ->schema([
                    Select::make('user_id')
                        ->label('Member')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->columnSpan(1),

                    Select::make('iuran_setting_id')
                        ->label('Pengaturan Iuran')
                        ->relationship('iuranSetting', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                $setting = \App\Models\IuranSetting::find($state);
                                if ($setting) {
                                    $set('amount', $setting->amount);
                                    $set('period_label', $setting->period_label);
                                    $set('due_date', $setting->due_date);
                                }
                            }
                        })
                        ->columnSpan(1),

                    TextInput::make('amount')
                        ->label('Nominal (Rp)')
                        ->numeric()
                        ->required()
                        ->prefix('Rp')
                        ->columnSpan(1),

                    TextInput::make('period_label')
                        ->label('Periode')
                        ->required()
                        ->placeholder('Contoh: Januari 2025 / 2025')
                        ->columnSpan(1),

                    DatePicker::make('due_date')
                        ->label('Jatuh Tempo')
                        ->required()
                        ->displayFormat('d M Y')
                        ->columnSpan(1),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'unpaid'  => '⬜ Belum Bayar',
                            'pending' => '⏳ Menunggu Konfirmasi',
                            'paid'    => '✅ Lunas',
                            'overdue' => '🔴 Terlambat',
                        ])
                        ->default('unpaid')
                        ->required()
                        ->live()
                        ->columnSpan(1),
                ]),

            Section::make('Pembayaran')
                ->columns(2)
                ->visible(fn ($get) => in_array($get('status'), ['pending', 'paid']))
                ->schema([
                    Select::make('payment_method')
                        ->label('Metode Pembayaran')
                        ->options([
                            'bca'     => '🏦 Transfer BCA',
                            'mandiri' => '🏦 Transfer Mandiri',
                            'bni'     => '🏦 Transfer BNI',
                            'bri'     => '🏦 Transfer BRI',
                            'gopay'   => '💳 GoPay',
                            'ovo'     => '💳 OVO',
                            'dana'    => '💳 DANA',
                            'cash'    => '💵 Tunai',
                        ])
                        ->nullable()
                        ->columnSpan(1),

                    DateTimePicker::make('paid_at')
                        ->label('Waktu Bayar')
                        ->displayFormat('d M Y, H:i')
                        ->seconds(false)
                        ->nullable()
                        ->columnSpan(1),

                    FileUpload::make('payment_proof')
                        ->label('Bukti Pembayaran')
                        ->disk('private')
                        ->directory('iuran_proofs')
                        ->nullable()
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'])
                        ->columnSpanFull(),
                ]),

            Section::make('Konfirmasi Admin')
                ->columns(2)
                ->visible(fn ($get) => $get('status') === 'paid')
                ->schema([
                    Select::make('confirmed_by')
                        ->label('Dikonfirmasi Oleh')
                        ->relationship('confirmedBy', 'name')
                        ->searchable()
                        ->nullable()
                        ->columnSpan(1),

                    DateTimePicker::make('confirmed_at')
                        ->label('Waktu Konfirmasi')
                        ->displayFormat('d M Y, H:i')
                        ->seconds(false)
                        ->nullable()
                        ->columnSpan(1),
                ]),

            Section::make('Catatan')
                ->schema([
                    Textarea::make('notes')
                        ->label('Catatan')
                        ->rows(3)
                        ->nullable()
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
