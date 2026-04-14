<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverviewWidget extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return auth()->user() instanceof User
            && auth()->user()->hasRole('admin');
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Jadwal Operasional', 'Placeholder')
                ->description('Akan dipakai untuk ringkasan jadwal aktif dan conflict alert.')
                ->descriptionIcon('heroicon-m-calendar-days'),
            Stat::make('Booking Harian', 'Placeholder')
                ->description('Akan menampilkan booking baru, diproses, dan selesai.')
                ->descriptionIcon('heroicon-m-ticket'),
            Stat::make('Kesiapan Armada', 'Placeholder')
                ->description('Akan merangkum status kendaraan dan driver yang siap jalan.')
                ->descriptionIcon('heroicon-m-truck'),
        ];
    }
}
