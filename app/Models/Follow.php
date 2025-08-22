<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Follow extends Model
{
    use HasFactory;

        protected $fillable = [
            'follower_id',
            'following_id',
        ];
    
}


