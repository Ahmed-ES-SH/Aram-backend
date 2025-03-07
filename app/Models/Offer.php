<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        "title_ar",
        "title_en",
        "image",
        "description_ar",
        "description_en",
        "code",
        "discount_value",
        "start_date",
        "end_date",
        'usage_limit',
        "status",
        "is_active",
        "organization_id",
        "category_id",
        "number_of_uses",
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
