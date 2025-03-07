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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('bell_type');
            $table->enum('type_operation', ['deposit', 'withdraw'])->nullable();
            $table->string('account_type');
            $table->json('bell_items');
            $table->integer('amount');
            $table->string('balance_type');
            $table->enum('status', ['waiting', 'done', 'refused'])->default('waiting')->nullable();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->foreignId('bell_id')->constrained('bells', 'id')->onUpdate('cascade');
            $table->foreignId('organization_id')->constrained('organizations', 'id')->onUpdate('cascade');
            $table->timestamps();
        });
    }







    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
