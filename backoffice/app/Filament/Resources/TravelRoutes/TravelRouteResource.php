<?php

namespace App\Filament\Resources\TravelRoutes;

use App\Filament\Resources\TravelRoutes\Pages\CreateTravelRoute;
use App\Filament\Resources\TravelRoutes\Pages\EditTravelRoute;
use App\Filament\Resources\TravelRoutes\Pages\ListTravelRoutes;
use App\Filament\Resources\TravelRoutes\Pages\ViewTravelRoute;
use App\Filament\Resources\TravelRoutes\Schemas\TravelRouteForm;
use App\Filament\Resources\TravelRoutes\Schemas\TravelRouteInfolist;
use App\Filament\Resources\TravelRoutes\Tables\TravelRoutesTable;
use App\Models\TravelRoute;
use App\Support\Filament\ResourceAccess;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TravelRouteResource extends Resource
{
    protected static ?string $model = TravelRoute::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    public static function form(Schema $schema): Schema
    {
        return TravelRouteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TravelRouteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TravelRoutesTable::configure($table);
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
            'index' => ListTravelRoutes::route('/'),
            'create' => CreateTravelRoute::route('/create'),
            'view' => ViewTravelRoute::route('/{record}'),
            'edit' => EditTravelRoute::route('/{record}/edit'),
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
