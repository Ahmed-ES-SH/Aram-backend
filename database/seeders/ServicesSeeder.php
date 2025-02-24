<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('services')->truncate();
        $services = [
            [
                'title_en' => 'Eye Care',
                'title_ar' => 'العناية بالعيون',
                'description_en' => 'Comprehensive eye exams and treatments for all ages.',
                'description_ar' => 'فحوصات شاملة للعيون وعلاجات لجميع الأعمار.',
            ],
            [
                'title_en' => 'Dental Services',
                'title_ar' => 'خدمات طب الأسنان',
                'description_en' => 'High-quality dental care for your family.',
                'description_ar' => 'رعاية أسنان عالية الجودة لعائلتك.',
            ],
            [
                'title_en' => 'Cardiology',
                'title_ar' => 'أمراض القلب',
                'description_en' => 'Expert care for heart health and cardiovascular conditions.',
                'description_ar' => 'رعاية متخصصة لصحة القلب والحالات القلبية.',
            ],
            [
                'title_en' => 'Pediatrics',
                'title_ar' => 'طب الأطفال',
                'description_en' => 'Dedicated healthcare for your children.',
                'description_ar' => 'رعاية صحية مخصصة لأطفالك.',
            ],
            [
                'title_en' => 'Orthopedics',
                'title_ar' => 'جراحة العظام',
                'description_en' => 'Specialized care for bones and joints.',
                'description_ar' => 'رعاية متخصصة للعظام والمفاصل.',
            ],
            [
                'title_en' => 'Dermatology',
                'title_ar' => 'الأمراض الجلدية',
                'description_en' => 'Comprehensive skin care and treatment.',
                'description_ar' => 'رعاية وعلاج شامل للبشرة.',
            ],
            [
                'title_en' => 'Nutrition Counseling',
                'title_ar' => 'الإرشاد الغذائي',
                'description_en' => 'Personalized diet plans for a healthier you.',
                'description_ar' => 'خطط غذائية شخصية لصحة أفضل.',
            ],
            [
                'title_en' => 'Physical Therapy',
                'title_ar' => 'العلاج الطبيعي',
                'description_en' => 'Therapeutic exercises to restore mobility.',
                'description_ar' => 'تمارين علاجية لاستعادة الحركة.',
            ],
            [
                'title_en' => 'Radiology',
                'title_ar' => 'الأشعة',
                'description_en' => 'Advanced imaging for accurate diagnoses.',
                'description_ar' => 'تصوير متقدم لتشخيص دقيق.',
            ],
            [
                'title_en' => 'Mental Health',
                'title_ar' => 'الصحة النفسية',
                'description_en' => 'Supportive care for emotional well-being.',
                'description_ar' => 'رعاية داعمة للرفاهية النفسية.',
            ],
        ];
        $ids = DB::table('service_categories')->pluck('id')->toArray();
        $usersids = DB::table('users')->pluck('id')->toArray();


        $urlimage = env('BACK_END_URL');
        // $urlimage = 'http://127.0.0.1:8000';
        $imagepath = 'images/services/images';
        $iconpath = 'images/services/icons';
        $fullimagepath = public_path($imagepath);
        $fulliconpath = public_path($iconpath);

        $images = array_filter(scandir($fullimagepath), function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });
        $icons = array_filter(scandir($fulliconpath), function ($icon) {
            return in_array(pathinfo($icon, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        $imagesarray = array_values(array_filter($images, function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        }));

        $iconsarray = array_values(array_filter($icons, function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        }));

        foreach ($services as $service) {
            if (empty($imagesarray) || empty($iconsarray)) {
                throw new Exception("The images or icons array is empty. Please check the directories.");
            }

            $image = $imagesarray[array_rand($imagesarray)];
            $icon = $iconsarray[array_rand($iconsarray)];

            $imageurl = $urlimage . '/'  . $imagepath . '/' . $image;
            $iconurl = $urlimage . '/'  . $iconpath . '/' . $icon;

            DB::table('services')->insert([
                'title_en' => $service['title_en'],
                'title_ar' => $service['title_ar'],
                'description_en' => $service['description_en'],
                'description_ar' => $service['description_ar'],
                'category_id' => $ids[array_rand($ids)],
                'features' => json_encode(["Access to basic features", "Email support", "Simple analytics", "Custom dashboard"]),
                'organization_ids' => $usersids[array_rand($usersids)],
                'image' => $imageurl,
                'icon' => $iconurl,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
