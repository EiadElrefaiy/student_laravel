<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';
    protected $fillable = [
        'survey_id',
        'student_id',
        'degree',
        'full_degree'
    ];
    use HasFactory;
}
