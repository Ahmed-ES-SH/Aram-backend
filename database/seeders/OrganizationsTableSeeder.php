<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class OrganizationsTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('organizations')->truncate();
        $faker = Faker::create('ar_SA'); // Arabic locale for Arabic data

        $centers = [
            [
                'title_ar' => 'مركز الطب العام',
                'title_en' => 'General Medicine Center',
                'description_ar' => 'مركز يقدم خدمات الطب العام لجميع الأعمار.',
                'description_en' => 'A center offering general medicine services for all ages.',
                'phone_number' => '0112345678',
                'open_at' => '08:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز الأسنان',
                'title_en' => 'Dental Center',
                'description_ar' => 'مركز متكامل لطب الأسنان وجراحة الفم.',
                'description_en' => 'A comprehensive center for dental care and oral surgery.',
                'phone_number' => '0112345679',
                'open_at' => '09:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز الأمراض الجلدية',
                'title_en' => 'Dermatology Center',
                'description_ar' => 'مركز متخصص في علاج الأمراض الجلدية.',
                'description_en' => 'A center specializing in dermatological treatments.',
                'phone_number' => '0112345680',
                'open_at' => '08:30',
                'close_at' => '11:30',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز العيون',
                'title_en' => 'Ophthalmology Center',
                'description_ar' => 'مركز متقدم لعلاج أمراض العيون.',
                'description_en' => 'An advanced center for eye care.',
                'phone_number' => '0112345681',
                'open_at' => '08:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز النساء والتوليد',
                'title_en' => 'Obstetrics and Gynecology Center',
                'description_ar' => 'مركز يقدم خدمات النساء والتوليد.',
                'description_en' => 'A center offering obstetrics and gynecology services.',
                'phone_number' => '0112345682',
                'open_at' => '09:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز العلاج الطبيعي',
                'title_en' => 'Physical Therapy Center',
                'description_ar' => 'مركز متخصص في العلاج الطبيعي والتأهيل.',
                'description_en' => 'A center specialized in physical therapy and rehabilitation.',
                'phone_number' => '0112345683',
                'open_at' => '07:30',
                'close_at' => '11:30',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز أمراض القلب',
                'title_en' => 'Cardiology Center',
                'description_ar' => 'مركز متخصص في علاج أمراض القلب.',
                'description_en' => 'A center specialized in treating heart diseases.',
                'phone_number' => '0112345684',
                'open_at' => '08:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز الأورام',
                'title_en' => 'Oncology Center',
                'description_ar' => 'مركز متخصص في علاج السرطان والأورام.',
                'description_en' => 'A center specializing in cancer and oncology treatments.',
                'phone_number' => '0112345685',
                'open_at' => '08:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز الأطفال',
                'title_en' => 'Pediatric Center',
                'description_ar' => 'مركز متخصص في رعاية الأطفال.',
                'description_en' => 'A center specialized in pediatric care.',
                'phone_number' => '0112345686',
                'open_at' => '09:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز الطوارئ',
                'title_en' => 'Emergency Center',
                'description_ar' => 'مركز الطوارئ لتقديم العناية العاجلة.',
                'description_en' => 'Emergency center for urgent care.',
                'phone_number' => '0112345687',
                'open_at' => '24/7',
                'close_at' => '24/7',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز المسالك البولية',
                'title_en' => 'Urology Center',
                'description_ar' => 'مركز متخصص في علاج المسالك البولية.',
                'description_en' => 'A center specializing in urology.',
                'phone_number' => '0112345688',
                'open_at' => '08:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز الغدد الصماء',
                'title_en' => 'Endocrinology Center',
                'description_ar' => 'مركز متخصص في علاج أمراض الغدد الصماء.',
                'description_en' => 'A center specialized in endocrinology.',
                'phone_number' => '0112345689',
                'open_at' => '09:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز الباطنة',
                'title_en' => 'Internal Medicine Center',
                'description_ar' => 'مركز متخصص في علاج الأمراض الباطنية.',
                'description_en' => 'A center specializing in internal medicine.',
                'phone_number' => '0112345690',
                'open_at' => '08:30',
                'close_at' => '11:30',
                'status' => 'published',
                'active' => '1'
            ],
            [
                'title_ar' => 'مركز الأذن والأنف والحنجرة',
                'title_en' => 'ENT Center',
                'description_ar' => 'مركز متخصص في أمراض الأذن والأنف والحنجرة.',
                'description_en' => 'A center specialized in ENT diseases.',
                'phone_number' => '0112345691',
                'open_at' => '08:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '0'
            ],
            [
                'title_ar' => 'مركز جراحة العظام',
                'title_en' => 'Orthopedic Surgery Center',
                'description_ar' => 'مركز متخصص في جراحة العظام.',
                'description_en' => 'A center specialized in orthopedic surgery.',
                'phone_number' => '0112345692',
                'open_at' => '09:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '0'
            ],
            [
                'title_ar' => 'مركز الطب الرياضي',
                'title_en' => 'Sports Medicine Center',
                'description_ar' => 'مركز متخصص في علاج الإصابات الرياضية.',
                'description_en' => 'A center specializing in sports injuries treatment.',
                'phone_number' => '0112345693',
                'open_at' => '07:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '0'
            ],
            [
                'title_ar' => 'مركز التحاليل الطبية',
                'title_en' => 'Medical Lab Center',
                'description_ar' => 'مركز لإجراء التحاليل الطبية المخبرية.',
                'description_en' => 'A center for conducting medical laboratory tests.',
                'phone_number' => '0112345694',
                'open_at' => '08:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '0'
            ],
            [
                'title_ar' => 'مركز الصيدلية',
                'title_en' => 'Pharmacy Center',
                'description_ar' => 'مركز يحتوي على صيدلية تقدم الأدوية والعلاجات.',
                'description_en' => 'A center with a pharmacy offering medicines and treatments.',
                'phone_number' => '0112345695',
                'open_at' => '08:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '0'
            ],
            [
                'title_ar' => 'مركز الصحة العامة',
                'title_en' => 'Public Health Center',
                'description_ar' => 'مركز يقدم خدمات الصحة العامة الوقائية.',
                'description_en' => 'A center offering public health and preventive services.',
                'phone_number' => '0112345696',
                'open_at' => '09:00',
                'close_at' => '11:00',
                'status' => 'published',
                'active' => '0'
            ]
        ];

        $addresses = [
            ' {
                "address" => "شارع الملك عبد الله, الرياض, 12345, المملكة العربية السعودية",
                "latitude" => 24.713552,
                "longitude" => 46.675296
            }',
            '{"address":"فخرى جعيصه, الغربية, 31515, مصر","latitude":30.80192,"longitude":31.0116352}',
            '{
                "address" => "شارع الهرم, الجيزة, 12556, مصر",
                "latitude" => 30.013056,
                "longitude" => 31.209380
            }',
            '{
                "address" => "شارع التحرير, القاهرة, 11411, مصر",
                "latitude" => 30.048979,
                "longitude" => 31.241194
            }',
            '{
                "address" => "شارع فوزى معاذ, الإسكندرية, 21500, مصر",
                "latitude" => 31.215640,
                "longitude" => 29.955572
            }',
            '{
                "address" => "شارع سليم الأول, اسطنبول, 34000, تركيا",
                "latitude" => 41.008238,
                "longitude" => 28.978359
            }',
            '{
                "address" => "شارع الشيخ زايد, دبي, 12345, الإمارات العربية المتحدة",
                "latitude" => 25.276987,
                "longitude" => 55.296249
            }',
            '{
                "address" => "شارع شارع السلام, بغداد, 10001, العراق",
                "latitude" => 33.315139,
                "longitude" => 44.366066
            }',
            '{
                "address" => "شارع الفاروق, عمان, 11118, الأردن",
                "latitude" => 31.963158,
                "longitude" => 35.930359
            }',
            '{
                "address" => "شارع الطائف, مكة, 21955, المملكة العربية السعودية",
                "latitude" => 21.422487,
                "longitude" => 39.826206
            }',
            ' {
                "address" => "شارع قصر النيل, القاهرة, 11511, مصر",
                "latitude" => 30.043463,
                "longitude" => 31.235711
            }'
        ];

        $urlimage = env('BACK_END_URL');
        // $urlimage = 'http://127.0.0.1:8000';
        $imagepath = 'images/organizations/images';
        $iconpath = 'images/organizations/icons';
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

        foreach ($centers as $center) {
            if (empty($imagesarray) || empty($iconsarray)) {
                throw new Exception("The images or icons array is empty. Please check the directories.");
            }

            $image = $imagesarray[array_rand($imagesarray)];
            $icon = $iconsarray[array_rand($iconsarray)];

            $imageurl = $urlimage . '/'  . $imagepath . '/' . $image;
            $iconurl = $urlimage . '/'  . $iconpath . '/' . $icon;
            // $imageurl = $urlimage . '/' . 'public/' . $path . '/' . $imageuser;
            DB::table('organizations')->insert([
                'email'          => $faker->unique()->safeEmail,       // إضافة البريد الإلكتروني
                'password'       => Hash::make('asd'),                 // كلمة المرور مشفرة
                'title_ar'       => $center['title_ar'],                    // العنوان باللغة العربية
                'title_en'       => $center['title_en'],                    // العنوان باللغة الإنجليزية
                'description_ar' => $center['description_ar'],                   // الوصف باللغة العربية
                'description_en' => $center['description_en'],                   // الوصف باللغة الإنجليزية
                'location'       => '{"address":"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية","latitude":21.40281772305478,"longitude":39.84603881835938}',                     // العنوان
                'categories_ids'  => "[\"15\",\"11\",\"7\",\"6\",\"10\"]", // قائمة معرفات الفئات (إذا كانت متعددة، يتم تخزينها كـ JSON)
                'features' => json_encode(["Access to basic features", "Email support", "Simple analytics", "Custom dashboard"]),
                'phone_number'   => $center['phone_number'],                 // رقم الهاتف
                'url'             => $faker->url,                        // الرابط
                'open_at'         => $center['open_at'],  // ساعة الفتح
                'close_at'        => $center['close_at'],  // ساعة الإغلاق
                'image' => $imageurl,
                'icon' => $iconurl,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
