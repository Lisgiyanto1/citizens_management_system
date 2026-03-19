<?php

namespace App\Jobs;

use App\Repositories\ActivityLogRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessActivityLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $action;
    protected $description;
    protected $subjectType;
    protected $subjectId;

    public function __construct($userId, $action, $description, $subjectType, $subjectId)
    {
        $this->userId = $userId;
        $this->action = $action;
        $this->description = $description;
        $this->subjectType = $subjectType;
        $this->subjectId = $subjectId;
    }

    public function handle(): void
    {
        \App\Models\ActivityLog::create([
            'user_id' => $this->userId,
            'action' => $this->action,
            'description' => $this->description,
            'subject_type' => $this->subjectType,
            'subject_id' => $this->subjectId,
            'created_at' => now(),
        ]);
    }
}