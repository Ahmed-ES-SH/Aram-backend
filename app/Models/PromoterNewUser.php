<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoterNewUser extends Model
{
    protected $fillable = [
        'promoter_id',
        'promoter_code',
        'new_account_id',
        'new_account_type',
    ];


    public function promoter()
    {
        return $this->belongsTo(User::class, 'promoter_id');
    }


    public function newAccount()
    {
        return $this->belongsTo(User::class, 'new_account_id');
    }
}
