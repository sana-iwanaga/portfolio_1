<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = 'book_id'; 

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publisherName',
        'mediumImageUrl',
        'SalesDate', // Assuming this is the date when the book was published
    ];
    use HasFactory;
}
