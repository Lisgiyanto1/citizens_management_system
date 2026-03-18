<?php

namespace App\Filament\ActivityLog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ActivityLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user->id ?? null,
            'user_name' => $this->user->name ?? 'Unknown',
            'action' => $this->action,
            'description' => $this->description,
            'created_at_formatted' => Carbon::parse($this->created_at)->translatedFormat('d M Y, H:i'),
            'created_at' => $this->created_at,
            'target' => [
                'type' => $this->subject_type ? class_basename($this->subject_type) : null,
                'id' => $this->subject_id,
            ]
        ];
    }
}