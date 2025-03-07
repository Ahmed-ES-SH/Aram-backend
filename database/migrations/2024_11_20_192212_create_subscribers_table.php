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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable(); // الاسم الأول
            $table->string('last_name')->nullable(); // الاسم الأخير
            $table->string('email')->unique(); // البريد الإلكتروني
            $table->boolean('is_active')->default(1); // حالة الاشتراك (نشط/غير نشط)
            $table->timestamp('subscribed_at')->useCurrent(); // تاريخ الاشتراك
            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
