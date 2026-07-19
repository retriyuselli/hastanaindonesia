<?php

namespace App\Filament\Resources\IuranSettings;

use App\Filament\Resources\IuranSettings\Pages\CreateIuranSetting;
use App\Filament\Resources\IuranSettings\Pages\EditIuranSetting;
use App\Filament\Resources\IuranSettings\Pages\ListIuranSettings;
use App\Filament\Resources\IuranSettings\Schemas\IuranSettingForm;
use App\Filament\Resources\IuranSettings\Tables\IuranSettingsTable;
use App\Models\IuranSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class IuranSettingResource extends Resource
{
    protected static ?string $model = IuranSetting::class;

    protected static string|UnitEnum|null $navigationGroup = 'Organization';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    public static function form(Schema $schema): Schema
    {
        return IuranSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IuranSettingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIuranSettings::route('/'),
            'create' => CreateIuranSetting::route('/create'),
            'edit' => EditIuranSetting::route('/{record}/edit'),
        ];
    }
}
