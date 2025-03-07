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
        Schema::create('provisional_data', function (Blueprint $table) {
            $table->id();
            $table->string('uniqueId');
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->json('cardsDetailes');
            $table->string('expire_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provisional_data');
    }
};
