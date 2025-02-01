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
        Schema::create('withdrawalrequests', function (Blueprint $table) {
            $table->id();
            $table->string('account_type'); // نوع الحساب: "user" أو "organization"
            $table->unsignedBigInteger('account_id'); // معرف المستخدم أو المنظمة
            $table->string('paypal_email'); // بريد PayPal
            $table->decimal('amount', 10, 2); // المبلغ المطلوب سحبه
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // حالة الطلب
            $table->string('transaction_id')->nullable(); // رقم المعاملة عند الموافقة
            $table->text('rejection_reason')->nullable(); // سبب الرفض إذا تم رفض الطلب
            $table->timestamps();

            // فهرس لتحسين الأداء عند البحث بناءً على الحساب
            $table->index(['account_type', 'account_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawalrequests');
    }
};
