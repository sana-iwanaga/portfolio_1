<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooklogMemo extends Model
{
    use HasFactory;
    protected $fillable = ['booklog_id', 'content'];

    public function booklog()
    {
        return $this->belongsTo(Booklog::class, 'booklog_id', 'booklog_id');
    }

}
