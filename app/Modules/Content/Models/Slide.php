<?php

namespace App\Modules\Content\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $fillable = [
        'image',
        'title',
        'description',
        'circle_1_color',
        'circle_2_color',
        'status',
    ];


    protected  $casts = ['title' => 'array', 'description' => 'array'];
}
