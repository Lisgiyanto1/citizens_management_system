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

    // Fungsi ini akan dieksekusi oleh Redis di latar belakang
    public function handle(ActivityLogRepository $repository): void
    {
        $repository->create([
            'user_id' => $this->userId,
            'action' => $this->action,
            'description' => $this->description,
            'subject_tytpe' => $this->subjectType, // Mengikuti ejaan DB Anda
            'subject_id' => $this->subjectId,
        ]);
    }
}