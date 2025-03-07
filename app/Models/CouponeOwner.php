<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponeOwner extends Model
{
      protected $fillable = [
        "coupon_id",
        "owner_id",
        "owner_type",
    ];

    public function coupon()
    {
        return $this->belongsTo(Copone::class, 'coupon_id');
    }
}
