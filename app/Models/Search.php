<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publisherName',
    ];
    use HasFactory;
}
