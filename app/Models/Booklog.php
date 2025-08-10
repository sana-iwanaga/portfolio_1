<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooklogController extends Model
{
    protected $fillable = [
        'title',
        'author',
        'published_at',
        'emotioncategory_id',
    ];
    use HasFactory;
}
