<?php

namespace App\Services;

use App\Jobs\ProcessActivityLog;
use App\Repositories\ActivityLogRepository;

class ActivityLogService
{
    protected $activityLogRepository;

    public function __construct(ActivityLogRepository $activityLogRepository)
    {
        $this->activityLogRepository = $activityLogRepository;
    }

    /**
     * Mencatat Aktivitas Baru
     */
    public function logActivity(string $action, string $description, ?string $subjectType = null, ?string $subjectId = null)
    {
        $userId = auth()->id();

        if (!$userId)
            return null;

        $finalSubjectId = is_numeric($subjectId) ? (int) $subjectId : null;

        if ($subjectId && !is_numeric($subjectId)) {
            $description .= " [Ref ID: {$subjectId}]";
        }

        ProcessActivityLog::dispatch(
            $userId,
            $action,
            $description,
            $subjectType,
            $finalSubjectId
        );

        return true;
    }

    public function getLogsForCurrentUser($user)
    {
        if ($user->role === 'admin') {
            return $this->activityLogRepository->getAllPaginated();
        }

        return $this->activityLogRepository->getByUserIdPaginated($user->id);
    }
}