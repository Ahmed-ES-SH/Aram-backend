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
        Schema::create('mainpages', function (Blueprint $table) {
            $table->id();
            $table->boolean('main_screen')->default(0)->nullable();
            $table->longText('video')->nullable();
            $table->longText('link_video')->nullable();
            $table->string('main_text_en')->nullable();
            $table->string('main_text_ar')->nullable();
            $table->text('second_text_en')->nullable();
            $table->text('second_text_ar')->nullable();
            $table->text('third_text_en')->nullable();
            $table->text('third_text_ar')->nullable();
            $table->text('forth_text_en')->nullable();
            $table->text('forth_text_ar')->nullable();
            $table->longText('image')->nullable();
            $table->longText('image_2')->nullable();
            $table->string('bg_color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mainpages');
    }
};
