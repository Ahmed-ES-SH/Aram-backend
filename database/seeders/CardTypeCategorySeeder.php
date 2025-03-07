<?php

namespace Database\Seeders;

use App\Models\CardTypeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardTypeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('card_type_categories')->truncate();
        $urlimage = env('BACK_END_URL');
        // $urlimage = 'http://127.0.0.1:8000';
        $path = 'images/cardTypeCategories';
        $fullpath = public_path($path);
        $images = scandir($fullpath);
        $imagesarray = array_filter($images, function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });
        $categories = [
            ['title_en' => 'Gift Cards', 'title_ar' => 'بطاقات الهدايا'],
            ['title_en' => 'Gaming Cards', 'title_ar' => 'بطاقات الألعاب'],
            ['title_en' => 'Payment Cards', 'title_ar' => 'بطاقات الدفع'],
            ['title_en' => 'Shopping Cards', 'title_ar' => 'بطاقات التسوق'],
            ['title_en' => 'Subscription Cards', 'title_ar' => 'بطاقات الاشتراكات'],
            ['title_en' => 'Entertainment Cards', 'title_ar' => 'بطاقات الترفيه'],
            ['title_en' => 'Travel Cards', 'title_ar' => 'بطاقات السفر'],
            ['title_en' => 'Food & Beverage Cards', 'title_ar' => 'بطاقات المطاعم والمشروبات'],
            ['title_en' => 'Education Cards', 'title_ar' => 'بطاقات التعليم'],
            ['title_en' => 'Healthcare Cards', 'title_ar' => 'بطاقات الرعاية الصحية'],
        ];

        foreach ($categories as $category) {
            $imageuser = $imagesarray[array_rand($imagesarray)];
            // $imageurl = $urlimage . '/'  . $path . '/' . $imageuser;
            $imageurl = $urlimage . '/'  . $path . '/' . $imageuser;
            DB::table('card_type_categories')->insert([
                'title_en' => $category['title_en'],
                'title_ar' => $category['title_ar'],
                'image' => $imageurl,
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
