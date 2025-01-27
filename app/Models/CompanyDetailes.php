<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDetailes extends Model
{
    protected $fillable = [
        'whatsapp_number',
        'gmail_account',
        'facebook_account',
        'x_account',
        'youtube_account',
        'instgram_account',
        'snapchat_account',
        'about_ar',
        'about_en',
        'vision_ar',
        'vision_en',
        'goals_ar',
        'goals_en',
        'values_ar',
        'values_en',
        'show_map',
        'address',
        'about_image',
        'vision_image',
        'goals_image',
        'values_image',
        'main_video',
    ];

    protected $table = 'company_detailes';
}
