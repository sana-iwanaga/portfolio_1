<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emotioncategory extends Model
{
    use HasFactory;
    protected $table = 'emotioncategories'; // Specify the table name if it differs from the pluralized model name
    protected $fillable = [
        'emotioncategory_name',// Assuming this is the primary key
    ];
    protected $primaryKey = 'emotioncategory_id'; // Specify the primary key if it's not 'id'

    public function bookreviews()
    {
        return $this->hasMany(Bookreview::class, 'emotioncategory_id');
    }

}
