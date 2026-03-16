<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Table associated with the model.
     */
    protected $table = 'users';

    /**
     * Primary key is not auto-incrementing (UUID).
     */
    public $incrementing = false;

    /**
     * Primary key type.
     */
    protected $keyType = 'string';

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',      // wajib disertakan karena kita pakai UUID
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * Attributes hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // otomatis hash password saat create/update
    ];

    /**
     * Relation: User has many Citizens.
     */
    public function citizens(): HasMany
    {
        return $this->hasMany(Citizen::class, 'created_by');
    }

    /**
     * Relation: User has many Activity Logs.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }
}