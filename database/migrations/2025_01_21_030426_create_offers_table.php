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
        Schema::create('offers', function (Blueprint $table) {
            // الأعمدة الأساسية
            $table->id(); // معرف فريد للعرض/الكوبون
            $table->string('title_ar'); // عنوان العرض باللغة العربية
            $table->string('title_en'); // عنوان العرض باللغة الإنجليزية
            $table->string('image')->nullable(); // صورة العرض أو الكوبون
            $table->text('description_ar')->nullable(); // وصف العرض باللغة العربية
            $table->text('description_en')->nullable(); // وصف العرض باللغة الإنجليزية
            $table->integer('number_of_uses')->default(0); // وصف العرض باللغة الإنجليزية
            $table->string('code')->unique()->nullable(); // كود الكوبون (فريد إذا كان موجوداً)
            $table->integer('usage_limit')->nullable();
            $table->decimal('discount_value', 10, 2); // قيمة الخصم
            $table->date('start_date'); // تاريخ بداية العرض
            $table->enum('status', ['waiting', 'active', 'expired'], 'waiting'); // تاريخ بداية العرض
            $table->date('end_date'); // تاريخ نهاية العرض
            $table->boolean('is_active')->default(false); // حالة العرض (نشط أو غير نشط)
            // العلاقة مع المركز الطبي
            $table->foreignId('organization_id')->nullable()->constrained('organizations', 'id')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('service_categories', 'id')->onDelete('cascade'); // العلاقة مع الفئة
            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
