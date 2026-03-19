<?php

namespace App\Filament\Resources\Citizens\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
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
                    Select::make('gender')
                        ->options([
                            'L' => 'Laki - Laki',
                            'P' => 'Perempuan'
                        ])->label("Jenis Kelamin")->placeholder("Pilih Jenis Kelamin")->required(),
                    DatePicker::make('birth_date')->label('Tanggal Lahir')->required()
                ]),

            Section::make('Foto')
                ->schema([
                    TextInput::make('photo')
                        ->label('Link Foto (URL)')
                        ->url() // Validasi bahwa ini harus link URL
                        ->helperText('Masukkan link foto lengkap (contoh: https://domain.com/foto.jpg)'),
                ]),
        ]);
    }
}
