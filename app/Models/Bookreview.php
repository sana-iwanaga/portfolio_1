<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookreview extends Model
{
    protected $fillable = [
        'book',
        'emotion_category',
        'title',
        'body',
    ];
    use HasFactory;
}
