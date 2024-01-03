<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    protected $table = 'specalists';
    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    use HasFactory;
}
