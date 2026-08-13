<?php

namespace App\Modules\Coupon\Models;

use Illuminate\Database\Eloquent\Model;

class CouponOrganization extends Model
{
    protected $fillable = [
        'coupon_id',
        'organization_id',
        'usage_limit',
        'current_usage'
    ];
}
