<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'user_type',
        'content',
    ];

    /**
     * العلاقة مع المقال.
     */
    public function article()
    {
        return $this->belongsTo(Blog::class, 'article_id');
    }

    /**
     * العلاقة مع المستخدم (كاتب التعليق).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
