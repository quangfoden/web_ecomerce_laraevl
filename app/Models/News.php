<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = ['title', 'slug', 'content', 'image','url', 'category_id'];

    public function category()
    {
        return $this->belongsTo(CategoryNews::class, 'category_id');
    }
}
