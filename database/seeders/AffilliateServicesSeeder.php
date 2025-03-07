<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AffilliateServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تعطيل فحص المفاتيح الخارجية مؤقتاً
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        // تفريغ جدول الخدمات
        DB::table('affiliate_services')->truncate();

        // تمكين فحص المفاتيح الخارجية مرة أخرى
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        // إنشاء مثيل Faker لتوليد بيانات وهمية
        $faker = Faker::create();

        // المسار الكامل للصور
        $urlimage = env('BACK_END_URL'); // يمكن تغيير هذا إلى رابطك الفعلي
        $path = 'images/affiliateServices';
        $fullpath = public_path($path);

        // الحصول على قائمة الصور من المجلد
        $images = scandir($fullpath);
        $imagesarray = array_filter($images, function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        // الحصول على معرفات الفئات والمنظمات
        $categoryIds = DB::table('service_categories')->pluck('id')->toArray();
        $organizationIds = DB::table('organizations')->pluck('id')->toArray();

        // عدد الخدمات التي تريد إنشاءها
        $numberOfServices = 20;

        // إنشاء الخدمات
        for ($i = 0; $i < $numberOfServices; $i++) {
            // اختيار صورة عشوائية من المجلد
            $randomImage = $urlimage . '/'  . $path . '/' . $imagesarray[array_rand($imagesarray)];

            // إنشاء خدمة جديدة
            DB::table('affiliate_services')->insert([
                'title_ar' => 'خدمة ' . $faker->word, // عنوان الخدمة بالعربية
                'title_en' => 'Service ' . $faker->word, // عنوان الخدمة بالإنجليزية
                'description_ar' => $faker->paragraph, // وصف الخدمة بالعربية
                'description_en' => $faker->paragraph, // وصف الخدمة بالإنجليزية
                'features_ar' => json_encode([$faker->word, $faker->word, $faker->word]), // ميزات الخدمة بالعربية (كمصفوفة JSON)
                'features_en' => json_encode([$faker->word, $faker->word, $faker->word]), // ميزات الخدمة بالإنجليزية (كمصفوفة JSON)
                'image' => $randomImage, // صورة الخدمة
                'icon' => $faker->imageUrl(64, 64, 'icons', true), // أيقونة الخدمة (صورة وهمية)
                'status' => $faker->randomElement(['1', '0']), // حالة الخدمة
                'confirmation_price' => $faker->randomFloat(2, 10, 100), // سعر التأكيد (بين 10 و 100)
                'confirmation_status' => $faker->randomElement(['1', '0']), // حالة التأكيد
                'number_of_orders' => $faker->numberBetween(0, 100), // عدد الطلبات (بين 0 و 100)
                'organization_id' => $organizationIds[array_rand($organizationIds)], // معرف المنظمة عشوائي
                'category_id' => $categoryIds[array_rand($categoryIds)], // معرف الفئة عشوائي
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // إظهار رسالة نجاح
    }
}
