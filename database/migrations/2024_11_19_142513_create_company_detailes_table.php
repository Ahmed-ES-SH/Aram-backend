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
        Schema::create('company_detailes', function (Blueprint $table) {
            $table->id();  // تعريف العمود الرئيسي
            $table->text('whatsapp_number');  // رقم واتساب الشركة
            $table->string('gmail_account');  // حساب البريد الإلكتروني للشركة
            $table->string('facebook_account');  // حساب البريد الإلكتروني للشركة
            $table->string('x_account');  // حساب البريد الإلكتروني للشركة
            $table->string('youtube_account');  // حساب البريد الإلكتروني للشركة
            $table->string('instgram_account');  // حساب البريد الإلكتروني للشركة
            $table->string('snapchat_account');  // حساب البريد الإلكتروني للشركة
            $table->text('about_ar');  // محتوى عن الشركة بالعربية
            $table->text('about_en');  // محتوى عن الشركة بالإنجليزية
            $table->text('vision_ar');  // رؤية الشركة بالعربية
            $table->text('vision_en');  // رؤية الشركة بالإنجليزية
            $table->text('goals_ar');  // أهداف الشركة بالعربية
            $table->text('goals_en');  // أهداف الشركة بالإنجليزية
            $table->text('values_en');  // قيم الشركة بالإنجليزية
            $table->text('values_ar');  // قيم الشركة بالعربية
            $table->text('cooperation_pdf');  // قيم الشركة بالعربية
            $table->boolean('show_map');  // إظهار الخريطة
            $table->string('address')->nullable();  // عنوان الشركة (اختياري)
            $table->string('about_image')->nullable();  // مسار صورة "عن الشركة" (اختياري)
            $table->string('vision_image')->nullable();  // مسار صورة الرؤية
            $table->string('goals_image')->nullable();  // مسار صورة الأهداف
            $table->string('values_image')->nullable();  // مسار صورة القيم
            $table->string('main_video')->nullable();  // مسار الفيديو الرئيسي (اختياري)
            $table->timestamps();  // تسجيل تاريخ الإنشاء والتحديث
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_detailes');
    }
};
