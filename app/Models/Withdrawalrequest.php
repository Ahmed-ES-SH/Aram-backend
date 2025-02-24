<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawalrequest extends Model
{
    protected $fillable = [
        'account_type',
        'account_id',
        'paypal_email',
        'amount',
        'status',
        'transaction_id',
        'rejection_reason',
    ];
}
