<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_article_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // معرف المستخدم
            $table->foreignId('article_id')->constrained('blogs')->onDelete('cascade'); // معرف المقال
            $table->string('reaction_type'); // نوع التفاعل: like, dislike, love, laugh
            $table->timestamps();
            $table->unique(['user_id', 'article_id']); // لضمان أن كل مستخدم يتفاعل مرة واحدة فقط مع المقال
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
