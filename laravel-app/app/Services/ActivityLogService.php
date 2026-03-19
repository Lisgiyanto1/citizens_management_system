<?php

namespace App\Services;

use App\Jobs\ProcessActivityLog;

class ActivityLogService
{
    /**
     * Mencatat Aktivitas Baru
     */
    public function logActivity(string $action, string $description, ?string $subjectType = null, ?string $subjectId = null)
    {
        // Ambil user_id dari sesi saat ini sebelum di-dispatch
        $userId = auth()->id();

        \App\Jobs\ProcessActivityLog::dispatch(
            $userId,
            $action,
            $description,
            $subjectType,
            $subjectId
        );
    }
}