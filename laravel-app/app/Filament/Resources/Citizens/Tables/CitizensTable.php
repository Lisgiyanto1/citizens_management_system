<?php

namespace App\Filament\Resources\Citizens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;


use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


use App\Filament\Exports\CitizenExporter;
use App\Filament\Imports\CitizenImporter;

class CitizensTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->headerActions([
                ImportAction::make()
                    ->importer(CitizenImporter::class),
                ExportAction::make()
                    ->exporter(CitizenExporter::class),
            ])
            ->columns([
                TextColumn::make('nik')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('address'),

                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->actions([
                ViewAction::make(),

                EditAction::make()
                    ->visible(fn() => auth()->user()?->isAdmin()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()?->isAdmin()),
                    ExportBulkAction::make()
                        ->exporter(CitizenExporter::class),
                ]),
            ]);
    }
}