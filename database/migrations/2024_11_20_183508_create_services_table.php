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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->longText('description_ar');
            $table->longText('description_en');
            $table->text('icon')->nullable();
            $table->text('image')->nullable();
            $table->longText('features')->nullable();
            $table->integer('popularity')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('active')->default(0);
            $table->json('tags')->nullable();
            $table->string('video_url')->nullable();
            $table->foreignId('category_id')->constrained('service_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->json('organization_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
