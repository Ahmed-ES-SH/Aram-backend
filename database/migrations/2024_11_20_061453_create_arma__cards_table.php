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
        Schema::create('arma__cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_number')->unique()->nullable();
            $table->decimal('price', 10, 2);
            $table->dateTime('issue_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired'])->default('inactive');
            $table->integer('usage_limit')->nullable();
            $table->integer('cvv')->nullable();
            $table->integer('current_usage')->default(0);
            $table->foreignId('cardtype_id')->nullable()->constrained('card_types')->onDelete('cascade');
            // $table->foreignId('affiliate_cardtype_id')->nullable()->constrained('affiliate_card_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arma__cards');
    }
};
