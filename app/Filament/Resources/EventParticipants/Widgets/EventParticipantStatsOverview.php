<?php

namespace App\Filament\Resources\EventParticipants\Widgets;

use App\Models\EventParticipant;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EventParticipantStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total      = EventParticipant::count();
        $pending    = EventParticipant::where('status', 'pending')->count();
        $confirmed  = EventParticipant::where('status', 'confirmed')->count();
        $attended   = EventParticipant::where('status', 'attended')->count();
        $cancelled  = EventParticipant::where('status', 'cancelled')->count();

        $paid       = EventParticipant::where('payment_status', 'paid')->count();
        $unpaid     = EventParticipant::where('payment_status', 'pending')->count();
        $free       = EventParticipant::where('payment_status', 'free')->count();

        $totalRevenue = EventParticipant::where('payment_status', 'paid')->sum('total_amount');

        $thisMonth = EventParticipant::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonth = EventParticipant::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $growth = $lastMonth > 0
            ? round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1)
            : ($thisMonth > 0 ? 100 : 0);

        return [
            Stat::make('Total Peserta', number_format($total))
                ->description($growth >= 0
                    ? "+{$growth}% dari bulan lalu"
                    : "{$growth}% dari bulan lalu")
                ->descriptionIcon($growth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($growth >= 0 ? 'success' : 'danger')
                ->chart([$lastMonth, $thisMonth]),

            // Stat::make('Status Peserta', "{$confirmed} Confirmed")
            //     ->description("{$pending} pending · {$attended} hadir · {$cancelled} batal")
            //     ->descriptionIcon('heroicon-m-user-group')
            //     ->color('info'),

            Stat::make('Pembayaran', "{$paid} Lunas")
                ->description("{$unpaid} belum bayar · {$free} gratis")
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('warning'),

            Stat::make('Total Pendapatan', 'Rp '.number_format($totalRevenue, 0, ',', '.'))
                ->description('Dari peserta yang sudah lunas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
