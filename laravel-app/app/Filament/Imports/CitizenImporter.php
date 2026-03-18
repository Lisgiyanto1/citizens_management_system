<?php

namespace App\Filament\Imports;

use App\Models\Citizen;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class CitizenImporter extends Importer
{
    protected static ?string $model = Citizen::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nik')
                ->requiredMapping()
                ->rules(['required', 'max:16']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:120']),
            ImportColumn::make('birth_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('gender')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('address')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('photo')
                ->rules(['max:255']),
            ImportColumn::make('created_by')
                ->requiredMapping()
                ->rules(['required']),
        ];
    }

    public function resolveRecord(): Citizen
    {
        return Citizen::firstOrNew([
            'nik' => $this->data['nik'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your citizen import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
