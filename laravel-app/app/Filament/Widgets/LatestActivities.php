<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use App\Models\ActivityLog;

class LatestActivities extends TableWidget
{
    protected static ?string $heading = 'Latest Activities';

    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return ActivityLog::query()
            ->select(['id', 'user_id', 'action', 'description', 'created_at'])
            ->latest()
            ->limit(5);
    }


    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            TextColumn::make('user_id')
                ->label('User ID')
                ->sortable(),

            TextColumn::make('action')
                ->label('Action')
                ->sortable(),

            TextColumn::make('description')
                ->label('Description')
                ->limit(50) 
                ->placeholder('Not Found Recent Action'),

            TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime('d M Y H:i')
                ->sortable(),
        ];
    }
}