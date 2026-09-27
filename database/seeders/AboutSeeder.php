<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::updateOrInsert(
            ['id' => 1], // شرط البحث
            [
                'first_section_title_en' => 'Welcome to Aram',
                'first_section_title_ar' => 'مرحباً بكم في آرام',
                'first_section_content_en' => 'Aram is a leading platform that offers premium cards packed with special features, exclusive benefits, and rewarding experiences for every member who joins our community.',
                'first_section_content_ar' => 'آرام منصة رائدة تقدم بطاقات متميزة مليئة بالمزايا الخاصة والفوائد الحصرية والتجارب المجزية لكل عضو ينضم إلى مجتمعنا.',

                'second_section_title_en' => 'Our Mission',
                'second_section_title_ar' => 'رسالتنا',
                'second_section_content_en' => 'Our mission is to deliver cards with special features that simplify daily life, reward loyalty, and open the door to privileged access across a wide network of partners and services.',
                'second_section_content_ar' => 'تتمثل رسالتنا في تقديم بطاقات بمزايا خاصة تبسط الحياة اليومية وتكافئ الولاء وتفتح الباب أمام امتيازات حصرية عبر شبكة واسعة من الشركاء والخدمات.',

                'thired_section_title_en' => 'Why Choose Aram',
                'thired_section_title_ar' => 'لماذا تختار آرام',
                'thired_section_content_en' => 'With Aram, every card comes with special features designed around you: exclusive offers, cashback rewards, dedicated support, and a secure digital experience you can rely on.',
                'thired_section_content_ar' => 'مع آرام، تأتي كل بطاقة بمزايا خاصة مصممة من أجلك: عروض حصرية، مكافآت نقدية، دعم مخصص، وتجربة رقمية آمنة يمكنك الاعتماد عليها.',

                'fourth_section_title_en' => 'Join Our Community',
                'fourth_section_title_ar' => 'انضم إلى مجتمعنا',
                'fourth_section_content_en' => 'Join thousands of satisfied members today. Aram cards with special features are more than just a card — they are a gateway to a smarter and richer lifestyle.',
                'fourth_section_content_ar' => 'انضم إلى آلاف الأعضاء الراضين اليوم. بطاقات آرام ذات المزايا الخاصة هي أكثر من مجرد بطاقة — إنها بوابة لأسلوب حياة أذكى وأكثر رفاهية.',

                'show_map' => true,
                'address' => 'Riyadh, Saudi Arabia',

                // ===============================
                // إضافة صور لكل قسم من Unsplash
                // ===============================
                'first_section_image'  => 'https://images.unsplash.com/photo-1506765515384-028b60a970df?auto=format&w=1200',
                'second_section_image' => 'https://images.unsplash.com/photo-1522199755839-a2bacb67c546?auto=format&w=1200',
                'thired_section_image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&w=1200',
                'fourth_section_image' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?auto=format&w=1200',

                'main_video' => null,
                'link_video' => null,

                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
