<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = 'activity_log';
    public $timestamps = false;
    public $incrementing = false;

    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'subject_type',
        'subject_id'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
