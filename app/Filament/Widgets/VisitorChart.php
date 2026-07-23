<?php

namespace App\Filament\Widgets;

use App\Models\VisitorLog;
use Filament\Widgets\ChartWidget;

class VisitorChart extends ChartWidget
{
    protected ?string $heading = '📈 Tren Pengunjung (7 Hari Terakhir)';

    protected ?string $maxHeight = '280px';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->translatedFormat('d M');

            // Unique visitor counts based on IP for this day
            $uniqueCount = VisitorLog::whereDate('created_at', $date->toDateString())
                ->distinct('ip_address')
                ->count('ip_address');

            $data['unique'][] = $uniqueCount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengunjung (IP Address)',
                    'data' => $data['unique'],
                    'borderColor' => '#3b82f6', // Blue color
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
