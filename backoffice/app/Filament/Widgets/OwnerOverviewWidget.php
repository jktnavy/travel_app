<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OwnerOverviewWidget extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return auth()->user() instanceof User
            && auth()->user()->hasRole('owner');
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Ringkasan Pendapatan', 'Placeholder')
                ->description('Akan menampilkan revenue periodik dan tren pemasukan.')
                ->descriptionIcon('heroicon-m-chart-bar'),
            Stat::make('Kinerja Operasional', 'Placeholder')
                ->description('Disiapkan untuk memantau utilisasi armada dan jadwal.')
                ->descriptionIcon('heroicon-m-presentation-chart-line'),
            Stat::make('Insight Bisnis', 'Placeholder')
                ->description('Akan diisi KPI penting untuk pengambilan keputusan owner.')
                ->descriptionIcon('heroicon-m-light-bulb'),
        ];
    }
}
