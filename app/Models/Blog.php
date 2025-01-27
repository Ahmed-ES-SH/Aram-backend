<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
        'author_id',
        'active',
        'category_id',
        'views',
        'likes',
        'dislikes',
        'hearts',
        'laughs',
        'published_at',
        'image',
    ];

    /**
     * العلاقة مع التعليقات.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');
    }
    public function category()
    {
        return $this->belongsTo(ArticalCategory::class, 'category_id');
    }

    /**
     * العلاقة مع المستخدم (الكاتب).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function reactionCount()
    {
        return $this->hasOne(ArticleReactionCount::class);
    }
}
