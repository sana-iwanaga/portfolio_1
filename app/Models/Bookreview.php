<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookreview extends Model
{
    protected $primaryKey = 'bookreview_id';
    protected $fillable = [
        'book_title', // Changed from 'review_title' to 'book_title' to match the migration
        'isbn', // Added to match the migration
        'emotioncategory_id',
        'title',
        'body',
        'rating', // Added to match the migration
        'user_id', // Assuming user_id is used to track the user who created the review
    ];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPaginateByLimit(int $limit_count = 5)
    {
        return $this::with('user')->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }

    public function emotionCategory()
    {
        return $this->belongsTo(EmotionCategory::class, 'emotioncategory_id');
    }

    public function likes() 
    {
        return $this->hasMany(ReviewLike::class);
    }
}
