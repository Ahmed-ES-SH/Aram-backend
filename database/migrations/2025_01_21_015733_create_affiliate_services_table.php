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
        Schema::create('affiliate_services', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('features_en')->nullable();
            $table->text('features_ar')->nullable();
            $table->text('image')->nullable();
            $table->text('icon')->nullable();
            $table->boolean('status')->default(0);
            $table->enum('check_status', ['done', 'waiting', 'updated'])->default('waiting');
            $table->boolean('confirmation_status')->default(0);
            $table->decimal('confirmation_price')->nullable();
            $table->integer('number_of_orders')->default(0);
            $table->integer('discount_percent')->default(0);
            $table->foreignId('organization_id')->constrained('organizations', 'id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->constrained('service_categories', 'id')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_services');
    }
};
