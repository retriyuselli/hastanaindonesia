<?php

namespace App\Filament\Resources\Companies;

use App\Filament\Resources\Companies\Pages\CreateCompany;
use App\Filament\Resources\Companies\Pages\EditCompany;
use App\Filament\Resources\Companies\Pages\ListCompanies;
use App\Filament\Resources\Companies\Schemas\CompanyForm;
use App\Filament\Resources\Companies\Tables\CompaniesTable;
use App\Models\Company;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static string|UnitEnum|null $navigationGroup = 'Organization';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingLibrary;

    protected static ?string $recordTitleAttribute = 'company_name';

    protected static ?string $navigationLabel = 'Perusahaan';

    protected static ?string $modelLabel = 'Perusahaan';

    protected static ?string $pluralModelLabel = 'Perusahaan';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return CompanyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompaniesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompanies::route('/'),
            'create' => CreateCompany::route('/create'),
            'edit' => EditCompany::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        $count = static::getModel()::count();

        if ($count > 50) {
            return 'success';
        } elseif ($count > 20) {
            return 'warning';
        }

        return 'primary';
    }
}
