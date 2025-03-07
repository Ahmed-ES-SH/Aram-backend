<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تعطيل فحص المفاتيح الخارجية مؤقتاً
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        // تفريغ جدول العروض
        DB::table('offers')->truncate();

        // تمكين فحص المفاتيح الخارجية مرة أخرى
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        // إنشاء مثيل Faker لتوليد بيانات وهمية
        $faker = Faker::create();

        // المسار الكامل للصور
        $urlimage = env('BACK_END_URL'); // يمكن تغيير هذا إلى رابطك الفعلي
        $path = 'images/offers';
        $fullpath = public_path($path);

        // الحصول على قائمة الصور من المجلد
        $images = scandir($fullpath);
        $imagesarray = array_filter($images, function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        // الحصول على معرفات الفئات والمنظمات
        $categoryIds = DB::table('service_categories')->pluck('id')->toArray();
        $organizationIds = DB::table('organizations')->pluck('id')->toArray();

        // عدد العروض التي تريد إنشاءها
        $numberOfOffers = 20;

        // إنشاء العروض
        for ($i = 0; $i < $numberOfOffers; $i++) {
            // اختيار صورة عشوائية من المجلد
            // $randomImage = $urlimage . '/' . 'public/' . $path . '/' . $imagesarray[array_rand($imagesarray)];
            $randomImage = $urlimage . '/'   . $path . '/' . $imagesarray[array_rand($imagesarray)];

            // إنشاء عرض جديد
            DB::table('offers')->insert([
                'title_ar' => 'عرض ' . $faker->word, // عنوان العرض بالعربية
                'title_en' => 'Offer ' . $faker->word, // عنوان العرض بالإنجليزية
                'image' => $randomImage, // صورة عشوائية من المجلد
                'description_ar' => $faker->paragraph, // وصف العرض بالعربية
                'description_en' => $faker->paragraph, // وصف العرض بالإنجليزية
                'code' => $faker->unique()->bothify('OFF#####'), // كود الكوبون (فريد)
                'discount_value' => $faker->randomFloat(2, 5, 50), // قيمة الخصم (بين 5 و 50)
                'start_date' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'), // تاريخ البداية (منذ شهر حتى الآن)
                'end_date' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'), // تاريخ النهاية (من الآن حتى شهر)
                'is_active' => $faker->boolean(80), // حالة العرض (80% احتمالية أن يكون نشطاً)
                'organization_id' => $organizationIds[array_rand($organizationIds)], // معرف المنظمة عشوائي
                'category_id' => $categoryIds[array_rand($categoryIds)], // معرف الفئة عشوائي
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // إظهار رسالة نجاح
        $this->command->info('تم إنشاء ' . $numberOfOffers . ' عروض بنجاح.');
    }
}
