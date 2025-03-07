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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('email', 255);
            $table->string('password');
            $table->string('title_ar');
            $table->string('title_en');
            $table->longText('description_ar');
            $table->longText('description_en');
            $table->longText('features')->nullable();
            $table->text('accaptable_message')->nullable();
            $table->text('unaccaptable_message')->nullable();
            $table->text('location');
            $table->string('phone_number');
            $table->decimal('confirmation_price')->nullable();
            $table->boolean('confirmation_status')->nullable();
            $table->string('open_at')->nullable();
            $table->string('close_at')->nullable();
            $table->longText('url')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
          	$table->string('verification_code')->nullable();
            $table->boolean('email_verified')->default(0);
            $table->text('email_verification_token ')->nullable();
            $table->boolean('active')->default(0);
            $table->enum('status', ['published', 'not_published', 'under_review'])->default('not_published');
            $table->decimal('rateing', 3, 2)->default(0);
            $table->integer('number_of_reservations')->default(0);
            $table->boolean('is_signed')->default(0);
          	$table->boolean('booking_status')->default(0);
            $table->text('cooperation_file')->nullable();
            $table->string('account_type')->default("Organization");
            $table->json('categories_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
