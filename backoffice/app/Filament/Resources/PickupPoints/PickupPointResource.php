<?php

namespace App\Filament\Resources\PickupPoints;

use App\Filament\Resources\PickupPoints\Pages\CreatePickupPoint;
use App\Filament\Resources\PickupPoints\Pages\EditPickupPoint;
use App\Filament\Resources\PickupPoints\Pages\ListPickupPoints;
use App\Filament\Resources\PickupPoints\Pages\ViewPickupPoint;
use App\Filament\Resources\PickupPoints\Schemas\PickupPointForm;
use App\Filament\Resources\PickupPoints\Schemas\PickupPointInfolist;
use App\Filament\Resources\PickupPoints\Tables\PickupPointsTable;
use App\Models\PickupPoint;
use App\Support\Filament\ResourceAccess;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PickupPointResource extends Resource
{
    protected static ?string $model = PickupPoint::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return PickupPointForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PickupPointInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PickupPointsTable::configure($table);
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
            'index' => ListPickupPoints::route('/'),
            'create' => CreatePickupPoint::route('/create'),
            'view' => ViewPickupPoint::route('/{record}'),
            'edit' => EditPickupPoint::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return ResourceAccess::adminOnly();
    }

    public static function canViewAny(): bool
    {
        return ResourceAccess::adminOnly();
    }
}
