<?php

namespace App\Models;

use App\Observers\CitizenObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([CitizenObserver::class])]
class Citizen extends Model
{
    use HasFactory;
    protected $table = 'citizens';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'name',
        'birth_date',
        'gender',
        'address',
        'photo',
        'created_by'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function getRecordTitle($record): string
    {
        return "{$record->name} - {$record->nik}";
    }


    public $timestamps = true;

    protected static function booted(): void
    {
        static::creating(function ($citizen) {
            if (auth()->check()) {
                $citizen->created_by = auth()->id();
            }
        });
    }
}


