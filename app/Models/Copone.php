<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Copone extends Model
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
        "status",
        "is_active",
        "organization_id",
        "category_id",
        "usage_limit",
        'card_type_id'
    ];

    // العلاقة مع الجدول organizations
    public function organization()
    {
        return $this->belongsTo(organization::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user');
    }

    // العلاقة مع الجدول categories
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
