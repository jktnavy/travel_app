<?php

namespace App\Filament\Pages;

use App\Support\Filament\ResourceAccess;
use BackedEnum;
use Filament\Pages\Page;

class Reports extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static string|\UnitEnum|null $navigationGroup = 'Finance';

    protected static ?string $title = 'Reports';

    protected string $view = 'filament.pages.reports';

    public static function shouldRegisterNavigation(): bool
    {
        return ResourceAccess::adminOrOwner();
    }

    public static function canAccess(): bool
    {
        return ResourceAccess::adminOrOwner();
    }
}
