<?php

namespace App\Services;

use App\Models\Citizen;
use Illuminate\Support\Str;

class CitizenService
{
    public function getAll()
    {
        return Citizen::with('creator')->paginate(10);
    }

    public function getById(string $id)
    {
        return Citizen::with('creator')->findOrFail($id);
    }

    public function create(array $data)
    {
        try {
            $data['id'] = Str::uuid();
            $data['photo'] = 'https://api.dicebear.com/7.x/personas/svg?seed=' . rand();
            $data['created_by'] = auth()->id();

            return Citizen::create($data);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function update(string $id, array $data)
    {
        $citizen = Citizen::findOrFail($id);

        $citizen->update($data);

        return $citizen;
    }

    public function delete(string $id)
    {
        $citizen = Citizen::findOrFail($id);

        $citizen->delete();

        return true;
    }
}