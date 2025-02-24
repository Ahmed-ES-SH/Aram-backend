<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleReactionCount extends Model
{
    use HasFactory;


    protected $table = 'article_reactions_count';


    protected $fillable = ['likes', 'dislikes', 'loves', 'laughs', 'first_reaction_at', 'last_reaction_at', 'article_id', 'totalReactions'];

    public function article()
    {
        return $this->belongsTo(Blog::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
