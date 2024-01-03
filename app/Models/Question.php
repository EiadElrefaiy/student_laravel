<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'survey_questions';
    protected $fillable = [
        'survey_id',
        'question',
    ];
    use HasFactory;
}
