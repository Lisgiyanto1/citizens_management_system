<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = 'activity_log';
    public const UPDATE_AT = null;
    public $timestamps = false;
    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'created_at' => 'datetime', 
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'subject_tytpe',
        'subject_id'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
