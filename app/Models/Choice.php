<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $table = 'choices';
    protected $fillable = [
        'qustion_id',
        'choice',
        'correct',
    ];

    use HasFactory;
}
