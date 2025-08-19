<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bookreview_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookReview()
    {
        return $this->belongsTo(BookReview::class, 'bookreview_id');
    }

}
