<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TClass extends Model
{
    protected $table = 'classes';
    protected $fillable = [
        'id',
        'teacher_id',
        'year',
        'created_at',
        'updated_at',
    ];

    use HasFactory;
}
