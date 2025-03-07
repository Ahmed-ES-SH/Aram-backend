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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->json('location')->nullable();
            $table->string('image')->nullable();
            $table->string('role')->default('user');
            $table->text('social_id')->nullable();
            $table->string('social_type')->nullable();
            $table->boolean('is_signed')->default(0);
            $table->boolean('is_promoter')->default(0);
            $table->enum('user_gender', ['male', 'female'])->nullable();
            $table->date('user_birthdate')->nullable();
            $table->integer('number_of_reservations')->default(0);
            $table->boolean('email_verified')->default(0);
            $table->text('email_verification_token ')->nullable();
            $table->string('account_type')->default("User");
            $table->string('user_code')->nullable()->unique();
            $table->string('verification_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
