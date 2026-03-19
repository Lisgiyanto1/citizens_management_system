<?php

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestActivities extends BaseWidget
{
    // Heading untuk widget
    protected static ?string $heading = 'Latest Activities';

    // Widget span full width
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            // 1. Query selalu mengambil data terbaru (limit 5)
            ->query(
                ActivityLog::query()->latest()->limit(5)
            )
            // 2. Mengaktifkan polling langsung di sini agar re-render setiap 5 detik
            ->poll('5s')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('H:i:s')
                    ->sortable(),

                TextColumn::make('user_id')
                    ->label('User ID')
                    ->limit(10),

                TextColumn::make('action')
                    ->label('Action')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'CREATE', 'INSERT' => 'success',
                        'UPDATE' => 'warning',
                        'DELETE' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),
            ])
            // 3. Matikan paginasi agar tidak ada state page yang nyangkut di cache
            ->paginated(false);
    }

    /**
     * Memaksa Livewire untuk selalu menganggap komponen ini segar
     * dengan memberikan timestamp unik setiap kali komponen dimuat ulang.
     */
    public function getKey(): string
    {
        return 'latest-activities-' . now()->timestamp;
    }
}