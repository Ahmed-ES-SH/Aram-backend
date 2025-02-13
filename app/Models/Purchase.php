<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bell_id',
        'buyer_id',
        'buyer_type',
        'promo_code',
        'uniqId',
        'amount',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buyerUser()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function buyerOrganization()
    {
        return $this->belongsTo(organization::class, 'buyer_id');
    }
    public function bell()
    {
        return $this->belongsTo(Bell::class, 'bell_id');
    }
}
