<?php

namespace App\Filament\Resources\Citizens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CitizenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nik')
                ->label('NIK')
                ->required()
                ->length(16)
                ->numeric()
                ->unique(ignoreRecord: true),

            TextInput::make('name')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),

            TextInput::make('address')
                ->label('Alamat')
                ->required(),

            TextInput::make('phone')
                ->label('No HP')
                ->tel(),
        ]);
    }
}
