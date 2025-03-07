<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserArticleReaction extends Model
{
    protected $fillable = [
        'user_id',
        'article_id',
        'reaction_type',
    ];

    protected $table = 'user_article_reactions';
}
