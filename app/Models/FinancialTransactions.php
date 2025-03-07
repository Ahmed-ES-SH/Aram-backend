<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialTransactions extends Model
{
    protected $fillable = [
        'bell_id',
        'bell_type',
        'type_operation',
        'bell_items',
        'account_type',
        'amount',
        'balance_type',
        'user_id',
        'status',
        'organization_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function organization()
    {
        return $this->belongsTo(organization::class, 'organization_id');
    }
}
