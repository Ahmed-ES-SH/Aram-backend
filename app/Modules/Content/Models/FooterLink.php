<?php

namespace App\Modules\Content\Models;

use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    protected $fillable = [
        'list_id',
        'link_title_en',
        'link_title_ar',
        'link_url',
    ];


    public function link()
    {
        $this->belongsTo(FooterList::class);
    }
}
