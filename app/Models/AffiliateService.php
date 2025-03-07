<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateService extends Model
{
    protected $fillable = [
        "title_ar",
        "title_en",
        "description_ar",
        "description_en",
        "features_en",
        "features_ar",
        "image",
        "icon",
        "status",
        "confirmation_price",
        'confirmation_status',
        "number_of_orders",
        "organization_id",
        "discount_percent",
        "category_id",
        "check_status"
    ];

    protected $casts = [
        'features_en' => 'array',
        'features_ar' => 'array',
    ];


    // العلاقة مع الجدول organizations
    public function organization()
    {
        return $this->belongsTo(organization::class);
    }

    // العلاقة مع الجدول categories
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
