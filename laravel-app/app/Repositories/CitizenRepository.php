<?php

namespace App\Repositories;

use App\Models\Citizen;

class CitizenRepository
{
    public function getAll()
    {
        return Citizen::with('creator')->paginate(10);
    }

    public function findById(string $id)
    {
        return Citizen::with('creator')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Citizen::create($data);
    }

    public function update(Citizen $citizen, array $data)
    {
        $citizen->update($data);

        return $citizen;
    }

    public function delete(Citizen $citizen)
    {
        return $citizen->delete();
    }
}