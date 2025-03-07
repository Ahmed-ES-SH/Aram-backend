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
        Schema::create('promotional_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->constrained('card_types', 'id')->onDelete('cascade');
            $table->foreignId('bell_id')->constrained('bells', 'id')->onDelete('cascade');
            $table->string('promoter_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotional_cards');
    }
};
