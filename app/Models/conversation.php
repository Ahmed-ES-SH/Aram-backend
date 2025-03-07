<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class conversation extends Model
{
    protected $fillable = ['participant_one_id', 'participant_one_type', 'participant_two_id', 'participant_two_type', 'deleted_by', 'blocked_by'];


    protected $casts = [
        'deleted_by' => 'array',
        'blocked_by' => 'array',
    ];


    public function messages()
    {
        return $this->hasMany(message::class);
    }

    public function participants()
    {
        return $this->morphToMany(Participant::class, 'participant');
    }
}
