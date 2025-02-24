<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arma_Card extends Model
{
    protected $fillable  = [
        "user_id",
        "card_number",
        "cardtype_id",
        "price",
        "issue_date",
        "expiry_date",
        "status",
        'cvv',
        "usage_limit",
        "current_usage",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function card_type()
    {
        return $this->belongsTo(CardType::class, 'cardtype_id');
    }
    public function affiliate_card_type()
    {
        return $this->belongsTo(Affiliate_cardType::class, 'affiliate_cardtype_id');
    }
}
