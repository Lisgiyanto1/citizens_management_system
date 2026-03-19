<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Illuminate\Support\Str;

class Register
{
    public function form(Form $form): Form
    {
        return $form->schema([
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
        ]);
    }

    // Fungsi ini dipanggil sebelum data disimpan ke database
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id'] = (string) Str::uuid(); // Generate UUID otomatis
        $data['role'] = 'user';            // Set role default otomatis

        return $data;
    }
}