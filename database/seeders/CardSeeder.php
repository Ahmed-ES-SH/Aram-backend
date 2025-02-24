<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // تعطيل فحص المفاتيح الخارجية لإزالة البيانات القديمة
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('card_types')->truncate(); // حذف البيانات القديمة

        // مسار الصور
        $urlimage = env('BACK_END_URL'); // عنوان URL الأساسي
        $path = 'images/cardtypes'; // المسار النسبي لمجلد الصور
        $fullpath = public_path($path); // المسار الكامل للمجلد

        // قراءة الصور من المجلد
        $images = scandir($fullpath);
        $imagesarray = array_filter($images, function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        // بيانات البطاقات
        $cards = [
            [
                'title_en' => 'Basic Subscription',
                'title_ar' => 'الاشتراك الأساسي',
                'description_en' => 'A starter plan for individuals.',
                'description_ar' => 'خطة بداية مناسبة للأفراد.',
                'price_before_discount' => 12.99,
                'price' => 9.99,
                'features_en' => json_encode(['Access to basic features', 'Email support', 'Simple analytics', 'Custom dashboard']),
                'features_ar' => json_encode(['الوصول إلى الميزات الأساسية', 'دعم البريد الإلكتروني', 'تحليلات بسيطة', 'لوحة تحكم مخصصة']),
                'duration' => '1 month',
                'image' => $this->getRandomImageUrl($urlimage, $path, $imagesarray), // رابط صورة عشوائي
                'active' => 1,
                'category_id' => 7
            ],
            [
                'title_en' => 'Pro Subscription',
                'title_ar' => 'الاشتراك الاحترافي',
                'description_en' => 'An advanced plan for professionals.',
                'description_ar' => 'خطة متقدمة للمحترفين.',
                'price_before_discount' => 25.99,
                'price' => 19.99,
                'features_en' => json_encode(['Advanced analytics', 'Priority support', 'Team management', 'Unlimited projects']),
                'features_ar' => json_encode(['تحليلات متقدمة', 'دعم أولوية', 'إدارة الفرق', 'مشاريع غير محدودة']),
                'duration' => '1 month',
                'image' => $this->getRandomImageUrl($urlimage, $path, $imagesarray), // رابط صورة عشوائي
                'active' => 1,
                'category_id' => 6
            ],
            [
                'title_en' => 'Enterprise Subscription',
                'title_ar' => 'اشتراك الشركات',
                'description_en' => 'A premium plan for businesses.',
                'description_ar' => 'خطة متميزة للشركات.',
                'price_before_discount' => 55.99,
                'price' => 49.99,
                'features_en' => json_encode(['Dedicated account manager', 'Custom integrations', 'Enhanced security', '24/7 support']),
                'features_ar' => json_encode(['مدير حساب مخصص', 'تكامل مخصص', 'أمان محسّن', 'دعم على مدار الساعة']),
                'duration' => '1 year',
                'image' => $this->getRandomImageUrl($urlimage, $path, $imagesarray), // رابط صورة عشوائي
                'active' => 1,
                'category_id' => 2
            ],
            [
                'title_en' => 'Basic Subscription',
                'title_ar' => 'الاشتراك الأساسي',
                'description_en' => 'A starter plan for individuals.',
                'description_ar' => 'خطة بداية مناسبة للأفراد.',
                'price_before_discount' => 12.99,
                'price' => 9.99,
                'features_en' => json_encode(['Access to basic features', 'Email support', 'Simple analytics', 'Custom dashboard']),
                'features_ar' => json_encode(['الوصول إلى الميزات الأساسية', 'دعم البريد الإلكتروني', 'تحليلات بسيطة', 'لوحة تحكم مخصصة']),
                'duration' => '1 month',
                'image' => $this->getRandomImageUrl($urlimage, $path, $imagesarray), // رابط صورة عشوائي
                'active' => 1,
                'category_id' => 7
            ],
            [
                'title_en' => 'Pro Subscription',
                'title_ar' => 'الاشتراك الاحترافي',
                'description_en' => 'An advanced plan for professionals.',
                'description_ar' => 'خطة متقدمة للمحترفين.',
                'price_before_discount' => 25.99,
                'price' => 19.99,
                'features_en' => json_encode(['Advanced analytics', 'Priority support', 'Team management', 'Unlimited projects']),
                'features_ar' => json_encode(['تحليلات متقدمة', 'دعم أولوية', 'إدارة الفرق', 'مشاريع غير محدودة']),
                'duration' => '1 month',
                'image' => $this->getRandomImageUrl($urlimage, $path, $imagesarray), // رابط صورة عشوائي
                'active' => 1,
                'category_id' => 5
            ],
            [
                'title_en' => 'Enterprise Subscription',
                'title_ar' => 'اشتراك الشركات',
                'description_en' => 'A premium plan for businesses.',
                'description_ar' => 'خطة متميزة للشركات.',
                'price_before_discount' => 55.99,
                'price' => 49.99,
                'features_en' => json_encode(['Dedicated account manager', 'Custom integrations', 'Enhanced security', '24/7 support']),
                'features_ar' => json_encode(['مدير حساب مخصص', 'تكامل مخصص', 'أمان محسّن', 'دعم على مدار الساعة']),
                'duration' => '1 year',
                'image' => $this->getRandomImageUrl($urlimage, $path, $imagesarray), // رابط صورة عشوائي
                'active' => 1,
                'category_id' => 5
            ],
            [
                'title_en' => 'Basic Subscription',
                'title_ar' => 'الاشتراك الأساسي',
                'description_en' => 'A starter plan for individuals.',
                'description_ar' => 'خطة بداية مناسبة للأفراد.',
                'price_before_discount' => 12.99,
                'price' => 9.99,
                'features_en' => json_encode(['Access to basic features', 'Email support', 'Simple analytics', 'Custom dashboard']),
                'features_ar' => json_encode(['الوصول إلى الميزات الأساسية', 'دعم البريد الإلكتروني', 'تحليلات بسيطة', 'لوحة تحكم مخصصة']),
                'duration' => '1 month',
                'image' => $this->getRandomImageUrl($urlimage, $path, $imagesarray), // رابط صورة عشوائي
                'active' => 1,
                'category_id' => 4
            ],
            [
                'title_en' => 'Pro Subscription',
                'title_ar' => 'الاشتراك الاحترافي',
                'description_en' => 'An advanced plan for professionals.',
                'description_ar' => 'خطة متقدمة للمحترفين.',
                'price_before_discount' => 25.99,
                'price' => 19.99,
                'features_en' => json_encode(['Advanced analytics', 'Priority support', 'Team management', 'Unlimited projects']),
                'features_ar' => json_encode(['تحليلات متقدمة', 'دعم أولوية', 'إدارة الفرق', 'مشاريع غير محدودة']),
                'duration' => '1 month',
                'image' => $this->getRandomImageUrl($urlimage, $path, $imagesarray), // رابط صورة عشوائي
                'active' => 1,
                'category_id' => 2
            ],
            [
                'title_en' => 'Enterprise Subscription',
                'title_ar' => 'اشتراك الشركات',
                'description_en' => 'A premium plan for businesses.',
                'description_ar' => 'خطة متميزة للشركات.',
                'price_before_discount' => 55.99,
                'price' => 49.99,
                'features_en' => json_encode(['Dedicated account manager', 'Custom integrations', 'Enhanced security', '24/7 support']),
                'features_ar' => json_encode(['مدير حساب مخصص', 'تكامل مخصص', 'أمان محسّن', 'دعم على مدار الساعة']),
                'duration' => '1 year',
                'image' => $this->getRandomImageUrl($urlimage, $path, $imagesarray), // رابط صورة عشوائي
                'active' => 1,
                'category_id' => 2
            ],
            // يمكنك إضافة المزيد من البطاقات هنا
        ];

        // إدخال البيانات في الجدول
        foreach ($cards as $card) {
            DB::table('card_types')->insert($card);
        }

        // إعادة تفعيل فحص المفاتيح الخارجية
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }

    /**
     * الحصول على رابط صورة عشوائية من المجلد.
     *
     * @param string $urlimage
     * @param string $path
     * @param array $imagesarray
     * @return string
     */
    private function getRandomImageUrl($urlimage, $path, $imagesarray)
    {
        if (empty($imagesarray)) {
            return 'https://via.placeholder.com/150'; // صورة افتراضية إذا لم توجد صور
        }

        $imagecard = $imagesarray[array_rand($imagesarray)]; // اختيار صورة عشوائية
        return $urlimage . '/'  . $path . '/' . $imagecard; // إنشاء الرابط الكامل
    }
}
