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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id'); // الإشارة إلى المقالة
            $table->unsignedBigInteger('user_id'); // الإشارة إلى المستخدم المعلق
            $table->string('user_type'); // الإشارة إلى المستخدم المعلق
            $table->text('content'); // نص التعليق
            $table->timestamps();
            $table->foreign('article_id')->references('id')->on('blogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
