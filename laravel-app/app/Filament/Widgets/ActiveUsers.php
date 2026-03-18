<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\ActivityLog;
use Illuminate\Support\HtmlString; // Tambahkan ini

class ActiveUsers extends BaseWidget
{
    public function getColumnSpan(): int|string|array
    {
        return 1;
    }

    protected function getStats(): array
    {
        $today = now()->startOfDay();
        $activeUsersCount = ActivityLog::where('created_at', '>=', $today)
            ->distinct('user_id')
            ->count('user_id');

        return [
            Stat::make('Active Users Today', $activeUsersCount)
                ->description(new HtmlString('
                    <div style="border-top: 1px solid #e5e7eb; margin-top: 8px; padding-top: 8px;">
                        Jumlah user yang melakukan aktivitas hari ini
                    </div>
                '))
                ->descriptionIcon('heroicon-o-user-group')
                ->extraAttributes([
                    'class' => 'h-full',
                ]),
        ];
    }
}