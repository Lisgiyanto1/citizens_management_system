<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ActiveUsers extends ChartWidget
{
    protected ?string $heading = 'Active Users: Admin vs User';

    // columnSpan = 1 akan membuat lebarnya sama dengan ActivityChart
    protected int|string|array $columnSpan = 1;

    // Menentukan jenis chart
    protected function getType(): string
    {
        return 'doughnut';
    }

    public static function canView(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    protected function getData(): array
    {
        $today = now()->startOfDay();

        // Ambil ID user unik yang aktif hari ini
        $activeUserIds = ActivityLog::where('created_at', '>=', $today)
            ->distinct('user_id')
            ->pluck('user_id');

        // Hitung proporsi
        $adminCount = User::whereIn('id', $activeUserIds)->where('role', 'admin')->count();
        $userCount = User::whereIn('id', $activeUserIds)->where('role', 'user')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Active Users',
                    'data' => [$adminCount, $userCount],
                    'backgroundColor' => [
                        '#f59e0b', // Amber (Admin)
                        '#3b82f6', // Blue (User)
                    ],
                ],
            ],
            'labels' => ['Admin', 'User'],
        ];
    }

    // Opsi tambahan agar chart tidak terlalu besar/tinggi
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}