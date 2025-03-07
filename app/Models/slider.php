<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class slider extends Model
{
    protected $fillable = [
        "image",
        "bg_color",
        "text_1_ar",
        "text_2_ar",
        "text_3_ar",
        "text_1_en",
        "text_2_en",
        "text_3_en",
    ];
}
