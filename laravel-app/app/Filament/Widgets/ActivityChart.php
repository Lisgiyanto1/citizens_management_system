<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityChart extends ChartWidget
{
    // 1. Polling: Memaksa widget me-refresh data setiap 5 detik
    protected ?string $pollingInterval = '5s';

    protected  ?string $heading = 'Activity Chart (10 Menit Terakhir)';

    // Memberikan lebar yang sama dengan widget lainnya
    protected int|array|string $columnSpan = 1;

    public static function canView(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        // 2. Mengambil log 10 menit terakhir saja agar selalu fresh dan bergerak
        $logs = ActivityLog::query()
            ->where('created_at', '>=', now()->subMinutes(10))
            ->orderBy('created_at', 'asc')
            ->get();

        // 3. Jika tidak ada log, tampilkan data kosong agar grafik tidak error
        if ($logs->isEmpty()) {
            return [
                'labels' => ['No activity'],
                'datasets' => [
                    [
                        'label' => 'Total Aktivitas',
                        'data' => [0],
                        'borderColor' => '#3b82f6',
                        'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                        'fill' => true,
                    ],
                ],
            ];
        }

        // 4. Kelompokkan log berdasarkan menit (H:i)
        $groups = $logs->groupBy(fn($log) => $log->created_at->format('H:i'));

        $labels = $groups->keys()->toArray();

        // Hitung total aksi yang terjadi pada setiap menit tersebut
        $data = $groups->map(fn($group) => $group->count())->values()->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Aksi',
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'fill' => true,
                    'tension' => 0.4, // Membuat garis lebih halus/melengkung
                ],
            ],
            'labels' => $labels,
        ];
    }

    /**
     * Opsi tambahan untuk mempercantik tampilan Chart
     */
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1, // Agar angka Y selalu integer
                    ],
                ],
            ],
        ];
    }
}