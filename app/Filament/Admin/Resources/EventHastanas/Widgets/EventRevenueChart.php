<?php

namespace App\Filament\Admin\Resources\EventHastanas\Widgets;

use App\Models\EventParticipant;
use App\Models\EventHastana;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EventRevenueChart extends ChartWidget
{
    protected ?string $heading = 'Revenue Trend (Last 12 Months)';
    
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Get data for last 12 months
        $data = [];
        $labels = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');
            
            // Calculate revenue for this month
            $revenue = EventParticipant::where('payment_status', 'paid')
                ->whereYear('event_participants.created_at', $month->year)
                ->whereMonth('event_participants.created_at', $month->month)
                ->join('event_hastanas', 'event_participants.event_hastana_id', '=', 'event_hastanas.id')
                ->sum('event_hastanas.price');
            
            $data[] = $revenue;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (Rp)',
                    'data' => $data,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return "Rp " + context.parsed.y.toLocaleString("id-ID"); }',
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "Rp " + value.toLocaleString("id-ID"); }',
                    ],
                ],
            ],
        ];
    }
}
