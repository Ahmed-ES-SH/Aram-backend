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
        Schema::create('affiliate_card_types', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->decimal('price_before_discount');
            $table->decimal('price');
            $table->json('features_ar');
            $table->json('features_en');
            $table->string('duration');
            $table->text('image');
            $table->boolean('active')->default(0);
            $table->enum('status', ['allow', 'not_allow', 'under_review'])->default('not_allow');
            $table->foreignId('organization_id')->constrained('organizations', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_card_types');
    }
};
