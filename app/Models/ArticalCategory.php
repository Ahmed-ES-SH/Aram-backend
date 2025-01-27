<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticalCategory extends Model
{
    protected $fillable = [
        "title_ar",
        "title_en",
        "image",
    ];


    public function category()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }
}
