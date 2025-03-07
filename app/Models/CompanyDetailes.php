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
        'show_map',
        'address',
        'first_section_image',
        'second_section_image',
        'thired_section_image',
        'fourth_section_image',
        'cooperation_pdf',
        'main_video',
        'link_video',
        'first_section_title_en',
        'first_section_title_ar',
        'first_section_contnet_ar',
        'first_section_contnet_en',
        'second_section_title_en',
        'second_section_title_ar',
        'second_section_contnet_ar',
        'second_section_contnet_en',
        'thired_section_title_en',
        'thired_section_title_ar',
        'thired_section_contnet_ar',
        'thired_section_contnet_en',
        'fourth_section_title_en',
        'fourth_section_title_ar',
        'fourth_seaction_contnet_ar',
        'fourth_seaction_contnet_en',
    ];

    protected $table = 'company_detailes';
}
