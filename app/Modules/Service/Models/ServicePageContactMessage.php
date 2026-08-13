<?php

namespace App\Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePageContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'service_page_id',
        'status',
    ];





    public function servicePage()
    {
        return $this->belongsTo(ServicePage::class);
    }
}
