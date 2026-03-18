<?php

namespace App\Policies;

use App\Models\Citizen;
use App\Models\User;

class CitizenPolicy
{
    /**
     * Semua user bisa lihat list
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Semua user bisa lihat detail
     */
    public function view(User $user, Citizen $citizen): bool
    {
        return true;
    }

    /**
     * Hanya admin
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Optional (kalau pakai soft delete)
     */
    public function restore(User $user): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user): bool
    {
        return $user->isAdmin();
    }
}