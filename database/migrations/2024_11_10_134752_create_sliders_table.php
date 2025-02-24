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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('bg_color')->nullable();
            $table->string('text_1_ar')->nullable();
            $table->string('text_2_ar')->nullable();
            $table->string('text_3_ar')->nullable();
            $table->string('text_1_en')->nullable();
            $table->string('text_2_en')->nullable();
            $table->string('text_3_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
