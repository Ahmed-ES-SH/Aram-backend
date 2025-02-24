<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blocked_user extends Model
{
    protected $fillable = [
        "blocker_id",
        "blocker_type",
        "blocked_id",
        "blocked_type",
        "unique_block_relation",
    ];
}
