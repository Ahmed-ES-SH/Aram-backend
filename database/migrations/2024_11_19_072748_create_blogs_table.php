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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id(); // معرف فريد
            $table->string('slug')->nullable()->unique(); // رابط slug فريد للمقالة
            $table->text('image')->nullable();
            $table->string('title_ar'); // عنوان المقالة باللغة العربية
            $table->string('title_en'); // عنوان المقالة باللغة الإنجليزية
            $table->text('content_ar'); // محتوى المقالة باللغة العربية
            $table->text('content_en'); // محتوى المقالة باللغة الإنجليزية
            $table->unsignedBigInteger('author_id'); // معرف كاتب المقالة (علاقة مع جدول المستخدمين)
            $table->boolean('active')->default(0);
            $table->unsignedBigInteger('category_id'); // معرف كاتب المقالة (علاقة مع جدول المستخدمين)
            $table->integer('views')->default(0); // عدد المشاهدات
            $table->timestamp('published_at')->nullable()->default(now()); // تاريخ نشر المقالة
            $table->timestamps(); // تاريخ الإنشاء والتعديل
            // تعريف المفتاح الخارجي (العلاقة مع جدول المستخدمين)
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('artical_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
