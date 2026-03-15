<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
