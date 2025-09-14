<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan nama lengkap')
                    ->columnSpan(2),

                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email', ignoreRecord: true)
                    ->maxLength(255)
                    ->placeholder('user@example.com')
                    ->suffixIcon('heroicon-m-envelope')
                    ->columnSpan(2),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->minLength(8)
                    ->maxLength(255)
                    ->placeholder('Minimal 8 karakter')
                    ->helperText(fn (string $context): string => 
                        $context === 'edit' 
                            ? 'Kosongkan jika tidak ingin mengubah password' 
                            : 'Password minimal 8 karakter'
                    )
                    ->suffixIcon('heroicon-m-key')
                    ->columnSpan(2),

                TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->maxLength(20)
                    ->placeholder('081234567890')
                    ->suffixIcon('heroicon-m-phone'),

                DatePicker::make('date_of_birth')
                    ->label('Tanggal Lahir')
                    ->nullable()
                    ->maxDate(now()->subYears(13))
                    ->displayFormat('d/m/Y')
                    ->placeholder('dd/mm/yyyy'),

                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',
                    ])
                    ->nullable()
                    ->placeholder('Pilih jenis kelamin'),

                Select::make('role')
                    ->label('Role Pengguna')
                    ->options([
                        'admin' => 'Administrator',
                        'member' => 'Member',
                        'customer' => 'Customer',
                    ])
                    ->default('customer')
                    ->required()
                    ->helperText('Role menentukan hak akses pengguna')
                    ->suffixIcon('heroicon-m-user-group'),

                Select::make('status')
                    ->label('Status Akun')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                    ])
                    ->default('active')
                    ->required()
                    ->helperText('Status akun pengguna')
                    ->suffixIcon('heroicon-m-shield-check'),

                DateTimePicker::make('email_verified_at')
                    ->label('Email Diverifikasi')
                    ->nullable()
                    ->displayFormat('d/m/Y H:i')
                    ->helperText('Tanggal dan waktu verifikasi email')
                    ->suffixIcon('heroicon-m-check-badge'),

                FileUpload::make('avatar')
                    ->label('Foto Profil')
                    ->image()
                    ->directory('avatars')
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(2048)
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('200')
                    ->imageResizeTargetHeight('200')
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }
}
