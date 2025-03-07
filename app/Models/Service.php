<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title_en',
        'title_ar',
        'description_ar',
        'description_en',
        'icon',
        'image',
        'features',
        'popularity',
        'tags',
        'video_url',
        'status',
        'category_id',
        'organization_ids',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }


    protected $casts = ['features' => 'array'];
}
