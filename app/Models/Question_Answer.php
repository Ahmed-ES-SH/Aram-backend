<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question_Answer extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'user_id',
        'is_visible',
    ];

    protected $table = 'question_answers';


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
