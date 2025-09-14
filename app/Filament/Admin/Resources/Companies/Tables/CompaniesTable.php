<?php

namespace App\Filament\Admin\Resources\Companies\Tables;

use App\Models\Company;
use App\Models\Region;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;

class CompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Logo & Company Info
                ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->circular()
                    ->defaultImageUrl(asset('images/default-logo.png'))
                    ->disk('public')
                    ->visibility('public')
                    ->extraAttributes(['class' => 'object-cover'])
                    ->toggleable(),

                TextColumn::make('company_name')
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn (Company $record): string => $record->owner_name ? "Ketum: {$record->owner_name}" : '')
                    ->wrap(),

                TextColumn::make('legal_entity_type')
                    ->label('Jenis Usaha')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PT' => 'success',
                        'CV' => 'info',
                        'Firma' => 'warning',
                        'UD' => 'gray',
                        'Koperasi' => 'primary',
                        'Yayasan' => 'purple',
                        'Perkumpulan' => 'pink',
                        default => 'gray',
                    }),

                TextColumn::make('legal_document_status')
                    ->label('Status Verifikasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'verified' => 'success',
                        'pending_review' => 'warning',
                        'rejected' => 'danger',
                        'incomplete' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'verified' => '✅ Terverifikasi',
                        'pending_review' => '⏳ Review',
                        'rejected' => '🚫 Ditolak',
                        'incomplete' => '❌ Belum Lengkap',
                        default => $state,
                    }),

                // Contact Information
                TextColumn::make('contact_info')
                    ->label('Kontak')
                    ->state(function (Company $record): string {
                        $contact = [];
                        if ($record->email) $contact[] = $record->email;
                        if ($record->phone) $contact[] = $record->phone;
                        return implode(' | ', $contact);
                    })
                    ->searchable(['email', 'phone'])
                    ->toggleable(),

                // Location
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->state(function (Company $record): string {
                        return "{$record->city}, {$record->province}";
                    })
                    ->searchable(['city', 'province'])
                    ->description(fn (Company $record): string => $record->postal_code ? "Kode Pos: {$record->postal_code}" : ''),

                // Business Details
                TextColumn::make('established_year')
                    ->label('Didirikan')
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state): string => $state ? "Tahun {$state}" : 'N/A'),

                TextColumn::make('employee_count')
                    ->label('Karyawan')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state): string => $state ? "{$state} orang" : 'N/A'),

                // Legal Documents
                TextColumn::make('business_license')
                    ->label('Izin Usaha')
                    ->searchable()
                    ->toggleable()
                    ->limit(20),

                TextColumn::make('nib_number')
                    ->label('NIB')
                    ->searchable()
                    ->toggleable()
                    ->copyable()
                    ->limit(15),

                TextColumn::make('npwp_number')
                    ->label('NPWP')
                    ->searchable()
                    ->toggleable()
                    ->copyable()
                    ->limit(20),

                // Website
                TextColumn::make('website')
                    ->label('Website')
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->toggleable()
                    ->limit(30),

                // Verification Info
                TextColumn::make('legal_verified_at')
                    ->label('Tanggal Verifikasi')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('legalVerifier.name')
                    ->label('Diverifikasi Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),

                // Timestamps
                TextColumn::make('created_at')
                    ->label('Didaftarkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('legal_entity_type')
                    ->label('Jenis Badan Usaha')
                    ->options(Company::getLegalEntityTypeOptions())
                    ->multiple(),

                SelectFilter::make('legal_document_status')
                    ->label('Status Verifikasi')
                    ->options([
                        'incomplete' => '❌ Tidak Lengkap',
                        'pending_review' => '⏳ Menunggu Review',
                        'verified' => '✅ Terverifikasi',
                        'rejected' => '🚫 Ditolak',
                    ])
                    ->multiple(),

                SelectFilter::make('province')
                    ->label('Provinsi')
                    ->relationship('region', 'province')
                    ->searchable()
                    ->preload(),

                Filter::make('established_year')
                    ->form([
                        DatePicker::make('established_from')
                            ->label('Didirikan Dari')
                            ->maxDate(now()),
                        DatePicker::make('established_until')
                            ->label('Didirikan Sampai')
                            ->maxDate(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['established_from'],
                                fn (Builder $query, $date): Builder => $query->whereYear('established_year', '>=', $date->year),
                            )
                            ->when(
                                $data['established_until'],
                                fn (Builder $query, $date): Builder => $query->whereYear('established_year', '<=', $date->year),
                            );
                    }),

                Filter::make('employee_count')
                    ->label('Jumlah Karyawan')
                    ->form([
                        TextInput::make('min_employees')
                            ->label('Minimal')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('max_employees')
                            ->label('Maksimal')
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_employees'],
                                fn (Builder $query, $value): Builder => $query->where('employee_count', '>=', $value),
                            )
                            ->when(
                                $data['max_employees'],
                                fn (Builder $query, $value): Builder => $query->where('employee_count', '<=', $value),
                            );
                    }),

                Filter::make('verified_companies')
                    ->label('Hanya Perusahaan Terverifikasi')
                    ->query(fn (Builder $query): Builder => $query->where('legal_document_status', 'verified'))
                    ->toggle(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat'),
                EditAction::make()
                    ->label('Edit'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus yang Dipilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}
