<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminOverviewWidget;
use App\Filament\Widgets\FinanceOverviewWidget;
use App\Filament\Widgets\OwnerOverviewWidget;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    public function getTitle(): string
    {
        return 'Deny Trans Office Dashboard';
    }

    public function getSubheading(): ?string
    {
        return 'Landing page internal untuk admin, finance, dan owner.';
    }

    public function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,
            AdminOverviewWidget::class,
            FinanceOverviewWidget::class,
            OwnerOverviewWidget::class,
        ];
    }
}
