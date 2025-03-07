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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id'); // يمكن أن يكون المستخدم أو المنظمة
            $table->string('sender_type'); // يمكن أن يكون المستخدم أو المنظمة
            $table->string('content')->nullable(); // النص إذا كانت الرسالة نصية
            $table->string('file_path')->nullable(); // مسار الملف إذا كانت صورة أو صوت
            $table->boolean('is_read')->default(0); // مسار الملف إذا كانت صورة أو صوت
            $table->enum('message_type', ['text', 'image', 'audio'])->default('text'); // نوع الرسالة
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
