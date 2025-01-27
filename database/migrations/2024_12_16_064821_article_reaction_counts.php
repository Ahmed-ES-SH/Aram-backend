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
        Schema::create('article_reactions_count', function (Blueprint $table) {
            $table->id();
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
            $table->integer('loves')->default(0);
            $table->integer('laughs')->default(0);
            $table->integer('totalReactions')->default(0);
            $table->timestamp('first_reaction_at')->nullable()->comment('تاريخ أول تفاعل');
            $table->timestamp('last_reaction_at')->nullable()->comment('تاريخ آخر تفاعل');
            $table->foreignId('article_id')->constrained('blogs')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_reactions_count');
    }
};
