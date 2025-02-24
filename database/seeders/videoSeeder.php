<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class videoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('mainpages')->truncate();
        $videoSectionTexts = [

            'main_text_en' => 'Access Trusted Medical Information',
            'main_text_ar' => 'احصل على معلومات طبية موثوقة',
            'second_text_en' => 'Explore expert advice from top healthcare professionals.',
            'second_text_ar' => 'استكشف نصائح الخبراء من أفضل المتخصصين في الرعاية الصحية.',
            'third_text_en' => 'Learn about treatments, wellness tips, and more!',
            'third_text_ar' => 'تعرف على العلاجات، نصائح العناية الصحية، والمزيد!',
            'forth_text_en' => 'Empower yourself with knowledge to make informed decisions.',
            'forth_text_ar' => 'قم بتمكين نفسك بالمعلومات لاتخاذ قرارات مستنيرة.',
        ];

        $aboutTexts = [
            "main_text_en" => "Committed to Your Health and Well-being",
            "main_text_ar" => "ملتزمون بصحتك ورفاهيتك",
            "second_text_en" => "Our platform connects you with top medical professionals and trusted healthcare resources, empowering you to make informed decisions about your health.",
            "second_text_ar" => "منصتنا تربطك بأفضل المتخصصين الطبيين ومصادر الرعاية الصحية الموثوقة، لنمكنك من اتخاذ قرارات مستنيرة بشأن صحتك."
        ];

        $urlimage = env('BACK_END_URL');
        // $urlimage = 'http://127.0.0.1:8000';
        $path = 'images/about';
        $fullpath = public_path($path);
        $images = scandir($fullpath);
        $imagesarray = array_filter($images, function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        $image = $imagesarray[array_rand($imagesarray)];
        $image_2 = $imagesarray[array_rand($imagesarray)];
        $imageurl = $urlimage . '/'   . $path . '/' . $image;
        $image_2url = $urlimage . '/'   . $path . '/' . $image_2;


        DB::table('mainpages')->where('id', 2)->updateOrInsert([
            'main_screen' => 0,
            'main_text_en' => $videoSectionTexts['main_text_en'],
            'main_text_ar' => $videoSectionTexts['main_text_ar'],
            'second_text_en' => $videoSectionTexts['second_text_en'],
            'second_text_ar' => $videoSectionTexts['second_text_ar'],
            'third_text_en' => $videoSectionTexts['third_text_en'],
            'third_text_ar' => $videoSectionTexts['third_text_ar'],
            'forth_text_en' => $videoSectionTexts['forth_text_en'],
            'forth_text_ar' => $videoSectionTexts['forth_text_ar'],
        ]);
        DB::table('mainpages')->where('id', 1)->updateOrInsert([
            'main_text_en' => $aboutTexts['main_text_en'],
            'main_text_ar' => $aboutTexts['main_text_ar'],
            'second_text_en' => $aboutTexts['second_text_en'],
            'second_text_ar' => $aboutTexts['second_text_ar'],
            'image' => $imageurl,
            'image_2' => $image_2url,
        ]);
        DB::table('mainpages')->where('id', 3)->updateOrInsert([
            'main_screen' => 1,
            'main_text_en' => null,
            'main_text_ar' => null,
            'second_text_en' => null,
            'second_text_ar' => null,
            'image' => null,
            'image_2' => null,
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
