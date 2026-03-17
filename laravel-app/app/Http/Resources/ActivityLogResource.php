<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ActivityLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'action' => $this->action,
            'description' => $this->description,
            'created_at_formatted' => Carbon::parse($this->created_at)->translatedFormat('d M Y, H:i'),
            'created_at' => $this->created_at,
            'actor' => [
                'id' => $this->user->id ?? null,
                'name' => $this->user->name ?? 'Unknown',
                'role' => $this->user->role ?? 'Unknown',
            ],
            'target' => [
                'type' => $this->subject_tytpe ? class_basename($this->subject_tytpe) : null,
                'id' => $this->subject_id,
            ]
        ];
    }
}