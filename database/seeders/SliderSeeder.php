<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('sliders')->truncate();
        $urlimage = env('BACK_END_URL');
        // $urlimage = 'http://127.0.0.1:8000';
        $path = 'images/slider';
        $fullpath = public_path($path);
        $images = scandir($fullpath);
        $imagesarray = array_filter($images, function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });


        // بيانات الشرائح
        $sliders = [
            [
                'text_1_en' => 'Personal care and beauty',
                'text_1_ar' => 'العناية الشخصية والجمال',
                'text_2_en' => 'enhancement',
                'text_2_ar' => 'تهمنا',
                'text_3_en' => 'Discover the best treatments for personal care, medical attention, and cosmetic surgeries with our professional team.',
                'text_3_ar' => 'اكتشف أفضل العلاجات للعناية الشخصية، الاهتمام الطبي، وعمليات التجميل مع فريقنا المحترف.',
            ],
            [
                'text_1_en' => 'Medical treatments',
                'text_1_ar' => 'العلاجات الطبية',
                'text_2_en' => 'healing',
                'text_2_ar' => 'الشفاء',
                'text_3_en' => 'Our clinic offers advanced medical treatments for all health concerns.',
                'text_3_ar' => 'عيادتنا تقدم علاجات طبية متقدمة لجميع المشاكل الصحية.',
            ],
            [
                'text_1_en' => 'Cosmetic Surgery',
                'text_1_ar' => 'جراحة التجميل',
                'text_2_en' => 'beauty',
                'text_2_ar' => 'الجمال',
                'text_3_en' => 'Enhance your appearance with our experienced cosmetic surgeons.',
                'text_3_ar' => 'عزز مظهرك مع جراحينا التجميل المحترفين.',
            ],
            [
                'text_1_en' => 'Hair Care Treatments',
                'text_1_ar' => 'علاجات العناية بالشعر',
                'text_2_en' => 'growth',
                'text_2_ar' => 'النمو',
                'text_3_en' => 'Regrow and rejuvenate your hair with our specialized treatments.',
                'text_3_ar' => 'نمو وتجديد شعرك مع علاجاتنا المتخصصة.',
            ],
            [
                'text_1_en' => 'Weight Loss Programs',
                'text_1_ar' => 'برامج خسارة الوزن',
                'text_2_en' => 'fitness',
                'text_2_ar' => 'اللياقة',
                'text_3_en' => 'Get fit and lose weight with our personalized programs.',
                'text_3_ar' => 'كن لائقاً وتخلص من الوزن مع برامجنا المخصصة.',
            ],
            [
                'text_1_en' => 'Skin Care Solutions',
                'text_1_ar' => 'حلول العناية بالبشرة',
                'text_2_en' => 'glowing',
                'text_2_ar' => 'التوهج',
                'text_3_en' => 'Achieve clear and glowing skin with our skin care solutions.',
                'text_3_ar' => 'تحقيق بشرة نقية ومتوهجة مع حلول العناية بالبشرة لدينا.',
            ],
        ];

        // إدخال البيانات إلى قاعدة البيانات
        foreach ($sliders as $slider) {
            $imageuser = $imagesarray[array_rand($imagesarray)];
            $imageurl = $urlimage . '/'  . $path . '/' . $imageuser;
            $imageurl = $urlimage . '/'  . $path . '/' . $imageuser;
            DB::table('sliders')->insert([
                'text_1_en' => $slider['text_1_en'],
                'text_1_ar' => $slider['text_1_ar'],
                'text_2_en' => $slider['text_2_en'],
                'text_2_ar' => $slider['text_2_ar'],
                'text_3_en' => $slider['text_3_en'],
                'text_3_ar' => $slider['text_3_ar'],
                'image' => $imageurl,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
