<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // レビューとのリレーション
    public function bookreviews()
    {
        return $this->hasMany(Bookreview::class);
    }

    // ログインユーザー自身のレビュー取得
    public function getOwnPaginateByLimit(int $limit_count = 5)
    {
        return $this->bookreviews()
            ->with('user')
            ->orderBy('updated_at', 'DESC')
            ->paginate($limit_count);
    }

    // フォローしているユーザー
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    // フォローされているユーザー
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }
}
