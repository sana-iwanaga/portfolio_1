<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booklog extends Model
{
    use HasFactory;

    protected $primaryKey = 'booklog_id';

    protected $fillable = [
        'user_id',
        'isbn',
        'title',
        'status',
    ];

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ステータスのラベル
    public function getStatusLabelAttribute()
    {
        return match ($this->attributes['status']) {
            'unread' => '未読',
            'reading' => '読書中',
            'read' => '読了',
            default => '不明',
        };
    }

    // メモとのリレーション
    public function memos()
    {
        return $this->hasMany(BooklogMemo::class, 'booklog_id', 'booklog_id');
    }
}
