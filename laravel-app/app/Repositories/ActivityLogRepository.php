<?php

namespace App\Repositories;

use App\Models\ActivityLog;

class ActivityLogRepository
{
    public function create(array $data)
    {
        return ActivityLog::create($data);
    }

    public function getAllPaginated()
    {
        return ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getByUserIdPaginated(string $userId)
    {
        return ActivityLog::with('user')->where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(10);
    }
}