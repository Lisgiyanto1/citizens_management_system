<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use App\Http\Resources\ActivityLogResource; 

class ActivityLogController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $user = auth()->user();

        $logs = $this->activityLogService->getLogsForCurrentUser($user);

        return ActivityLogResource::collection($logs)->additional([
            'success' => true,
            'message' => 'Daftar riwayat aktivitas berhasil dimuat.'
        ]);
    }
}