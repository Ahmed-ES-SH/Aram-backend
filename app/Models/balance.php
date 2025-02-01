<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class balance extends Model
{
    protected $fillable = [
        "user_id",
        "organization_id",
        "pending_balance",
        "available_balance",
        "total_balance",
    ];
}
