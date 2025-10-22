<?php

namespace App\Filament\Admin\Resources\EventParticipants\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class EventParticipantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // Event Information
                TextEntry::make('eventHastana.title')
                    ->label('Event')
                    ->icon('heroicon-o-calendar')
                    ->copyable()
                    ->columnSpan(2),
                
                TextEntry::make('registration_code')
                    ->label('Kode Registrasi')
                    ->icon('heroicon-o-hashtag')
                    ->badge()
                    ->color('primary')
                    ->copyable()
                    ->columnSpan(1),

                // Participant Information
                TextEntry::make('name')
                    ->label('Nama Lengkap')
                    ->icon('heroicon-o-user')
                    ->weight('bold')
                    ->columnSpan(1),
                
                TextEntry::make('email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->columnSpan(1),
                
                TextEntry::make('phone')
                    ->label('No. Telepon')
                    ->icon('heroicon-o-phone')
                    ->copyable()
                    ->columnSpan(1),
                
                TextEntry::make('company')
                    ->label('Perusahaan/Instansi')
                    ->icon('heroicon-o-building-office')
                    ->placeholder('Tidak ada')
                    ->columnSpan(1),
                
                TextEntry::make('position')
                    ->label('Jabatan')
                    ->icon('heroicon-o-briefcase')
                    ->placeholder('Tidak ada')
                    ->columnSpan(1),

                // Status Information
                TextEntry::make('status')
                    ->label('Status Pendaftaran')
                    ->badge()
                    ->color(fn ($record) => match($record->status) {
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
                    })
                    ->columnSpan(1),
                
                TextEntry::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn ($record) => match($record->payment_status) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'refunded' => 'danger',
                        'free' => 'info',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'pending' => 'Menunggu Pembayaran',
                        'paid' => 'Sudah Dibayar',
                        'refunded' => 'Refund',
                        'free' => 'Gratis',
                        default => $state
                    })
                    ->columnSpan(1),
                
                TextEntry::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'bca' => 'Transfer Bank BCA',
                        'mandiri' => 'Transfer Bank Mandiri',
                        'bni' => 'Transfer Bank BNI',
                        'bri' => 'Transfer Bank BRI',
                        default => 'Tidak ada'
                    })
                    ->placeholder('Tidak ada')
                    ->columnSpan(1),
                
                ImageEntry::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->disk('public')
                    ->height(250)
                    ->placeholder('Tidak ada bukti')
                    ->columnSpan(1)
                    ->visible(fn ($record) => $record->payment_proof !== null),

                // Dates
                TextEntry::make('confirmed_at')
                    ->label('Waktu Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Belum dikonfirmasi')
                    ->columnSpan(1),
                
                TextEntry::make('attended_at')
                    ->label('Waktu Kehadiran')
                    ->icon('heroicon-o-user-circle')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Belum hadir')
                    ->columnSpan(1),

                TextEntry::make('notes')
                    ->label('Catatan')
                    ->placeholder('Tidak ada catatan')
                    ->columnSpanFull(),
                
                TextEntry::make('created_at')
                    ->label('Terdaftar Pada')
                    ->icon('heroicon-o-calendar')
                    ->dateTime('d M Y, H:i')
                    ->columnSpan(1),
                
                TextEntry::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->icon('heroicon-o-clock')
                    ->dateTime('d M Y, H:i')
                    ->since()
                    ->columnSpan(2),
            ]);
    }
}
