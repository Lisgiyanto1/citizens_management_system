<?php

namespace App\Filament\Resources\Citizens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CitizenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Dasar')
                ->schema([
                    TextInput::make('nik')->label('NIK')->required()->length(16),
                    TextInput::make('name')->label('Nama Lengkap')->required(),
                    TextInput::make('address')->label('Alamat')->required(),
                ]),

            Section::make('Foto')
                ->schema([
                    TextInput::make('photo')
                        ->label('Link Foto (URL)')
                        ->url()
                        ->helperText('Masukkan link foto lengkap (contoh: https://domain.com/foto.jpg)'),
                ]),
        ]);
    }
}
