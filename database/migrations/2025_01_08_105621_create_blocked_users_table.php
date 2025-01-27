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
        Schema::create('blocked_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blocker_id'); // الشخص الذي قام بالحظر
            $table->string('blocker_type'); // نوع الشخص (User أو Vendor)
            $table->unsignedBigInteger('blocked_id'); // الشخص الذي تم حظره
            $table->string('blocked_type'); // نوع الشخص الذي تم حظره
            $table->timestamps();
            $table->unique(['blocker_id', 'blocker_type', 'blocked_id', 'blocked_type'], 'unique_block_relation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked_users');
    }
};
