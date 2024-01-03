<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';
    protected $fillable = [
        'subject',
        'year',
        'title',
        'degree',
    ];
    use HasFactory;
    
}