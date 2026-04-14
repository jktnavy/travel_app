<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinanceOverviewWidget extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return auth()->user() instanceof User
            && auth()->user()->hasRole('finance');
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Pembayaran Masuk', 'Placeholder')
                ->description('Akan menampilkan transaksi sukses dan menunggu verifikasi.')
                ->descriptionIcon('heroicon-m-banknotes'),
            Stat::make('Rekonsiliasi', 'Placeholder')
                ->description('Akan dipakai untuk pengecekan sinkronisasi payment dan booking.')
                ->descriptionIcon('heroicon-m-arrow-path-rounded-square'),
            Stat::make('Refund / Koreksi', 'Placeholder')
                ->description('Disiapkan untuk kebutuhan koreksi transaksi internal.')
                ->descriptionIcon('heroicon-m-receipt-refund'),
        ];
    }
}
