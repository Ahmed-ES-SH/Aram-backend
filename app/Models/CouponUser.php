<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected  $fillable = [
        'user_id',
        'coupon_id',
        'account_type',
    ];

    protected $table = 'coupon_user';

    public function coupon()
    {
        return $this->belongsTo(Copone::class, 'coupon_id');
    }
}
