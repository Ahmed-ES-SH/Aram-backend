<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('service_categories')->truncate();
        $servicesCategories = [
            [
                "title_en" => "General Medicine",
                "title_ar" => "الطب العام",
            ],
            [
                "title_en" => "Pediatrics",
                "title_ar" => "طب الأطفال",
            ],
            [
                "title_en" => "Dentistry",
                "title_ar" => "طب الأسنان",
            ],
            [
                "title_en" => "Dermatology",
                "title_ar" => "الأمراض الجلدية",
            ],
            [
                "title_en" => "Cardiology",
                "title_ar" => "طب القلب",
            ],
            [
                "title_en" => "Neurology",
                "title_ar" => "طب الأعصاب",
            ],
            [
                "title_en" => "Orthopedics",
                "title_ar" => "طب العظام",
            ],
            [
                "title_en" => "Gynecology",
                "title_ar" => "طب النساء",
            ],
            [
                "title_en" => "Ophthalmology",
                "title_ar" => "طب العيون",
            ],
            [
                "title_en" => "Psychiatry",
                "title_ar" => "الطب النفسي",
            ],
            [
                "title_en" => "Physiotherapy",
                "title_ar" => "العلاج الطبيعي",
            ],
            [
                "title_en" => "Oncology",
                "title_ar" => "طب الأورام",
            ],
            [
                "title_en" => "ENT (Ear, Nose, and Throat)",
                "title_ar" => "الأنف والأذن والحنجرة",
            ],
            [
                "title_en" => "Nutrition",
                "title_ar" => "التغذية",
            ],
            [
                "title_en" => "Radiology",
                "title_ar" => "الأشعة",
            ],
            [
                "title_en" => "Surgery",
                "title_ar" => "الجراحة",
            ],
            [
                "title_en" => "Pharmacy",
                "title_ar" => "الصيدلة",
            ],
            [
                "title_en" => "Rehabilitation",
                "title_ar" => "إعادة التأهيل",
            ],
            [
                "title_en" => "Emergency Medicine",
                "title_ar" => "طب الطوارئ",
            ],
            [
                "title_en" => "Family Medicine",
                "title_ar" => "طب الأسرة",
            ],
        ];
        $urlimage = env('BACK_END_URL');
        // $urlimage = 'http://127.0.0.1:8000';
        $path = 'images/services_categories';
        $fullpath = public_path($path);
        $images = scandir($fullpath);
        $imagesarray = array_filter($images, function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });


        foreach ($servicesCategories as $cat) {
            $imageuser = $imagesarray[array_rand($imagesarray)];
            // $imageurl = $urlimage . '/'  . $path . '/' . $imageuser;
            $imageurl = $urlimage . '/'  . $path . '/' . $imageuser;
            DB::table('service_categories')->insert([
                'title_ar' => $cat['title_ar'], // توليد عنوان عشوائي
                'title_en' => $cat['title_en'], // توليد عنوان عشوائي
                'image' => $imageurl, // الصورة المولدة
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
