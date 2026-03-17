<?php

namespace App\Observers;

use App\Models\Citizen;
use App\Services\ActivityLogService;

class CitizenObserver
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function created(Citizen $citizen): void
    {
        $this->activityLogService->logActivity(
            'CREATE',
            "Menambahkan warga baru: {$citizen->name} (NIK: {$citizen->nik})",
            Citizen::class,
            $citizen->id
        );
    }

    public function updated(Citizen $citizen): void
    {
        $this->activityLogService->logActivity(
            'UPDATE',
            "Memperbarui data warga: {$citizen->name}",
            Citizen::class,
            $citizen->id
        );
    }

    public function deleted(Citizen $citizen): void
    {
        $this->activityLogService->logActivity(
            'DELETE',
            "Menghapus data warga: {$citizen->name}",
            Citizen::class,
            $citizen->id
        );
    }
}