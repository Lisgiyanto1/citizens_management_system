<?php

namespace App\Filament\Resources\Citizens\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CitizenInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Informasi Penduduk')
                ->schema([
                    ImageEntry::make('photo')
                        ->label('Foto Penduduk')
                        ->size(200)
                        ->circular()
                        ->placeholder('Tidak ada foto'),

                    TextEntry::make('nik')->label('NIK'),
                    TextEntry::make('name')->label('Nama Lengkap'),
                    TextEntry::make('address')->label('Alamat'),
                ])
                ->columns(2),
        ]);
    }
}