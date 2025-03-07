<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CardVisit extends Model
{

    use HasFactory;

    protected $fillable = ['user_id', 'ip_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
