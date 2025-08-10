<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookreview extends Model
{
    protected $fillable = [
        'isbn', // Added to match the migration
        'emotion_category',
        'title',
        'body',
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
}
