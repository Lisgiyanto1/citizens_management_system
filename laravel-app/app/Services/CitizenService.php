<?php

namespace App\Services;

use App\Repositories\CitizenRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CitizenService
{
    protected $citizenRepository;

    public function __construct(CitizenRepository $citizenRepository)
    {
        $this->citizenRepository = $citizenRepository;
    }

    public function getAll()
    {
        return $this->citizenRepository->getAll();
    }

    public function getById(string $id)
    {
        return Cache::remember("citizen:{$id}", 3000, function () use ($id) {
            $this->citizenRepository->findById($id);
        });
    }

    public function create(array $data)
    {
        $data['id'] = (string) Str::uuid();
        $data['photo'] = 'https://api.dicebear.com/7.x/personas/svg?seed=' . rand();
        $data['created_by'] = auth()->id();

        return $this->citizenRepository->create($data);
    }

    public function update(string $id, array $data)
    {
        $citizen = $this->citizenRepository->findById($id);
        $updatedCitizen = $this->citizenRepository->update($citizen, $data);

        Cache::forget("citizen:{$id}");

        return $updatedCitizen;
    }

    public function delete(string $id)
    {
        $citizen = $this->citizenRepository->findById($id);
        $this->citizenRepository->delete($citizen);

        Cache::forget("citizen:{$id}");

        return true;
    }
}