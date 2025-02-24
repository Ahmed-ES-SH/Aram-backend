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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // صاحب الكود
            $table->foreignId('bell_id')->constrained('bells', 'id')->onDelete('cascade'); // صاحب الكود
            $table->foreignId('buyer_id')->nullable(); // المشتري (إذا كان مسجلاً)
            $table->enum('buyer_type', ['User', 'Organization']); // الكود الترويجي المستخدم
            $table->string('promo_code'); // الكود الترويجي المستخدم
            $table->string('uniqId'); // الكود الترويجي المستخدم
            $table->decimal('amount', 10, 2); // المبلغ المدفوع
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending'); // حالة الشراء (قيد الانتظار، مكتمل، ملغي)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
