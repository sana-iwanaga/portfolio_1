<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booklog extends Model
{
    protected $primaryKey = 'booklog_id';
    protected $fillable = [
        'user_id',
        'isbn',
        'title',
        'status',
        'memo',
    ];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->attributes['status']) {
            'unread' => '未読',
            'reading' => '読書中',
            'read' => '読了',
            default => '不明',
        };
    }
}
