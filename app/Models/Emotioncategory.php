<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emotioncategory extends Model
{
    protected $fillable = [
      'emotioncategory_name',
    ];
    use HasFactory;
}
