<?php

namespace App\Filament\Admin\Resources\EventHastanas\Widgets;

use App\Models\EventHastana;
use App\Models\EventParticipant;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class EventStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Total Events
        $totalEvents = EventHastana::count();
        $publishedEvents = EventHastana::where('status', 'published')->count();
        $upcomingEvents = EventHastana::where('status', 'published')
            ->where('start_date', '>', now())
            ->count();
        
        // Total Participants
        $totalParticipants = EventParticipant::count();
        $confirmedParticipants = EventParticipant::where('status', 'confirmed')->count();
        $attendedParticipants = EventParticipant::where('status', 'attended')->count();
        
        // Revenue Calculation
        $totalRevenue = EventParticipant::where('payment_status', 'paid')
            ->join('event_hastanas', 'event_participants.event_hastana_id', '=', 'event_hastanas.id')
            ->sum('event_hastanas.price');
        
        // This Month Stats
        $thisMonthParticipants = EventParticipant::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $lastMonthParticipants = EventParticipant::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $participantGrowth = $lastMonthParticipants > 0 
            ? round((($thisMonthParticipants - $lastMonthParticipants) / $lastMonthParticipants) * 100, 1)
            : 0;
        
        // Capacity Utilization
        $totalCapacity = EventHastana::where('status', 'published')->sum('max_participants');
        $capacityUtilization = $totalCapacity > 0 
            ? round(($totalParticipants / $totalCapacity) * 100, 1)
            : 0;
        
        // Average Rating
        $averageRating = EventHastana::where('rating', '>', 0)->avg('rating');
        
        return [
            Stat::make('Total Events', $totalEvents)
                ->description("{$publishedEvents} published, {$upcomingEvents} upcoming")
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 25, $totalEvents]),
            
            Stat::make('Total Participants', number_format($totalParticipants))
                ->description($participantGrowth >= 0 
                    ? "{$participantGrowth}% increase from last month" 
                    : "{$participantGrowth}% decrease from last month")
                ->descriptionIcon($participantGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($participantGrowth >= 0 ? 'success' : 'danger')
                ->chart([
                    $lastMonthParticipants - 20,
                    $lastMonthParticipants - 10,
                    $lastMonthParticipants,
                    $thisMonthParticipants - 5,
                    $thisMonthParticipants
                ]),
            
            Stat::make('Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('From paid events')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning')
                ->chart([
                    $totalRevenue * 0.5,
                    $totalRevenue * 0.6,
                    $totalRevenue * 0.75,
                    $totalRevenue * 0.85,
                    $totalRevenue
                ]),
            
            Stat::make('Confirmed Participants', number_format($confirmedParticipants))
                ->description("{$attendedParticipants} already attended")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info')
                ->chart([
                    $confirmedParticipants * 0.3,
                    $confirmedParticipants * 0.5,
                    $confirmedParticipants * 0.7,
                    $confirmedParticipants * 0.85,
                    $confirmedParticipants
                ]),
            
            Stat::make('Capacity Utilization', "{$capacityUtilization}%")
                ->description("Total capacity: " . number_format($totalCapacity))
                ->descriptionIcon('heroicon-m-user-group')
                ->color($capacityUtilization > 80 ? 'danger' : ($capacityUtilization > 60 ? 'warning' : 'success'))
                ->chart([20, 35, 50, 65, $capacityUtilization]),
            
            Stat::make('Average Rating', $averageRating ? number_format($averageRating, 1) . ' / 5.0' : 'No ratings yet')
                ->description('From ' . EventHastana::where('rating', '>', 0)->count() . ' rated events')
                ->descriptionIcon('heroicon-m-star')
                ->color('success')
                ->chart([3.5, 3.8, 4.0, 4.2, $averageRating ?? 0]),
        ];
    }
}
