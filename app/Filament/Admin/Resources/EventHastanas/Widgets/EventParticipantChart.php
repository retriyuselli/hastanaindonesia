<?php

namespace App\Filament\Admin\Resources\EventHastanas\Widgets;

use App\Models\EventParticipant;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class EventParticipantChart extends ChartWidget
{
    protected ?string $heading = 'Participant Registration Trend (Last 12 Months)';
    
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Get data for last 12 months
        $data = [];
        $labels = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');
            
            $count = EventParticipant::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Participants',
                    'data' => $data,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
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
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
