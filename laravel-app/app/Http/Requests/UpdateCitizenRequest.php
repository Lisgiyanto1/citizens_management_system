<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCitizenRequest extends FormRequest
{
    public function authorize(): bool
    {

        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {

        $citizenId = $this->route('citizen');

        return [
            'nik' => 'sometimes|string|size:16|unique:pgsql.citizens,nik,' . $citizenId,
            'name' => 'sometimes|string|max:255',
            'birth_date' => 'sometimes|date',
            'gender' => 'sometimes|in:L,P',
            'address' => 'sometimes|string'
        ];
    }
}