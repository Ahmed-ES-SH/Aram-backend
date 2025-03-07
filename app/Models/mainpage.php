<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mainpage extends Model
{
    protected $fillable = [
        "main_text_en",
        "main_text_ar",
        "second_text_en",
        "second_text_ar",
        "third_text_en",
        "third_text_ar",
        "forth_text_en",
        "forth_text_ar",
        "bg_color",
        'image',
        'image_2',
        'video',
        'link_video',
        'main_screen'
    ];
}
