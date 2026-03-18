<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\ActivityLog;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ActivityChart extends ChartWidget
{
    protected ?string $heading = 'Activity Chart';


    protected int|array|string $columnSpan = 1;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $types = ['POST', 'GET', 'PUT', 'DELETE', 'PATCH'];

        $logs = ActivityLog::query()
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(); 

        if ($logs->isEmpty()) {
            return [
                'labels' => ['No recent actions'],
                'datasets' => [
                    [
                        'label' => 'Actions',
                        'data' => [0],
                    ],
                ],
            ];
        }

        $labels = [];
        $data = [];
        foreach ($types as $type) {
            $data[$type] = [];
        }

        foreach ($logs as $log) {
            $timestamp = $log->created_at->format('H:i:s'); 
            $labels[] = $timestamp;

            foreach ($types as $type) {
                $data[$type][] = $log->action === $type ? 1 : 0;
            }
        }

        $datasets = [];
        foreach ($types as $type) {
            $datasets[] = [
                'label' => $type,
                'data' => $data[$type],
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }
}