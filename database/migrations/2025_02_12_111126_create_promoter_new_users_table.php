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
        Schema::create('promoter_new_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promoter_id')->constrained('users', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('new_account_id');
            $table->string('new_account_type');
            $table->string('promoter_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promoter_new_users');
    }
};
