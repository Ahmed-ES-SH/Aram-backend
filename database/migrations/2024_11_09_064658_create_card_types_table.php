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
        Schema::create('card_types', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->decimal('price_before_discount');
            $table->decimal('price');
            $table->integer('number_of_promotional_purchases')->default(0);
            $table->json('features_ar');
            $table->json('features_en');
            $table->string('duration');
            $table->text('image');
            $table->boolean('active')->default(0);
            $table->foreignId('category_id')->constrained('card_type_categories', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_types');
    }
};
