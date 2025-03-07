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
        Schema::create('copones_useds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('copone_id');
            $table->unsignedBigInteger('user_id');
          	$table->unsignedBigInteger('card_type_id')->nullable();
            $table->string('user_type')->nullable();
            $table->integer('current_usage')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->foreign('copone_id')->references('id')->on('copones')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copones_useds');
    }
};
