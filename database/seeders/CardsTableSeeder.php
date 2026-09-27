<?php

namespace Database\Seeders;

use App\Modules\Card\Models\Card;
use App\Modules\Card\Models\CardBenefit;
use App\Modules\Keyword\Models\Keyword;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('card_keywords')->truncate();
        DB::table('card_benefits')->truncate();
        DB::table('cards')->truncate();

        $healthCategoryId = DB::table('card_categories')
            ->where('title_en', 'Health')
            ->value('id') ?? 1;

        $relativePath = 'images/cards';
        $baseImageUrl = env('BACK_END_URL') . '/' . $relativePath;

        $cardsData = [
            [
                'title' => 'Basic Health Consultation Card',
                'description' => 'Everyday doctor consultations for symptom checks, quick diagnoses, and e-prescriptions — the essential health companion for your whole family.',
                'price_before_discount' => 120,
                'price' => 89,
                'number_of_promotional_purchases' => 40,
                'duration' => '1 month',
                'image' => $baseImageUrl . '/card-1.png',
                'benefits' => [
                    '2 video consultations',
                    'Symptom assessment & triage',
                    'E-prescription service',
                    '24/7 chat support',
                    'Access to preventive health tips',
                ],
                'keywords' => [
                    'Medical Consultation',
                    'Symptom Assessment',
                    'General Practitioner',
                    'Online Medical Advice',
                    'Preventive Medicine',
                ],
            ],
            [
                'title' => 'Family Health Card',
                'description' => 'Covers the whole family with pediatric and general consultations, plus exclusive discounts on lab tests and medicines.',
                'price_before_discount' => 240,
                'price' => 179,
                'number_of_promotional_purchases' => 25,
                'duration' => '6 months',
                'image' => $baseImageUrl . '/card-2.png',
                'benefits' => [
                    'Consultations for up to 5 family members',
                    'Pediatric consultation included',
                    '15% off lab tests',
                    'Priority booking',
                    'Medicine delivery discount',
                ],
                'keywords' => [
                    'Medical Consultation',
                    'Pediatric Consultation',
                    'General Practitioner',
                    'Online Medical Advice',
                ],
            ],
            [
                'title' => 'Chronic Disease Management Card',
                'description' => 'Ongoing care for diabetes, hypertension, and other chronic conditions with monthly follow-ups and continuous health monitoring.',
                'price_before_discount' => 300,
                'price' => 229,
                'number_of_promotional_purchases' => 18,
                'duration' => '12 months',
                'image' => $baseImageUrl . '/card-3.png',
                'benefits' => [
                    'Monthly specialist follow-up',
                    'Lab results review',
                    'Medication reminders',
                    'Blood pressure & sugar tracking',
                    'Dietitian support',
                ],
                'keywords' => [
                    'Chronic Disease Management',
                    'Internal Medicine',
                    'Lab Results Review',
                    'Dietitian Consultation',
                    'Preventive Medicine',
                ],
            ],
            [
                'title' => 'Nutrition & Diet Plan Card',
                'description' => 'Personalized meal plans and dietitian sessions to reach your health goals — weight management, performance, or medical diets.',
                'price_before_discount' => 150,
                'price' => 99,
                'number_of_promotional_purchases' => 35,
                'duration' => '3 months',
                'image' => $baseImageUrl . '/card-4.png',
                'benefits' => [
                    '4 dietitian sessions',
                    'Custom meal plan',
                    'BMI & body composition tracking',
                    'Weekly progress reports',
                    'Recipe library access',
                ],
                'keywords' => [
                    'Nutrition Advice',
                    'Dietitian Consultation',
                    'Symptom Assessment',
                ],
            ],
            [
                'title' => 'Mental Health & Wellbeing Card',
                'description' => 'Confidential psychological counseling and mental wellness support, available whenever you need it.',
                'price_before_discount' => 260,
                'price' => 199,
                'number_of_promotional_purchases' => 22,
                'duration' => '6 months',
                'image' => $baseImageUrl . '/card-5.png',
                'benefits' => [
                    '6 private counseling sessions',
                    'CBT therapy sessions',
                    'Anonymous chat support',
                    'Stress management tools',
                    'Family & couples sessions discount',
                ],
                'keywords' => [
                    'Psychological Counseling',
                    'Mental Health Support',
                    'Online Medical Advice',
                ],
            ],
            [
                'title' => 'Skin & Dermatology Care Card',
                'description' => 'Expert dermatology consultations, acne and skin treatments, and personalized skincare routines.',
                'price_before_discount' => 180,
                'price' => 139,
                'number_of_promotional_purchases' => 30,
                'duration' => '3 months',
                'image' => $baseImageUrl . '/card-6.png',
                'benefits' => [
                    '3 dermatology consultations',
                    'Photo-based skin analysis',
                    'Personalized skincare regimen',
                    'Acne & pigmentation treatment plan',
                    'Follow-up sessions',
                ],
                'keywords' => [
                    'Dermatology Advice',
                    'Symptom Assessment',
                    'Medical Consultation',
                ],
            ],
            [
                'title' => 'Premium 360 Medical Card',
                'description' => 'All-inclusive VIP medical access — unlimited consultations, specialist referrals, home care, and a dedicated health line.',
                'price_before_discount' => 600,
                'price' => 449,
                'number_of_promotional_purchases' => 10,
                'duration' => '12 months',
                'image' => $baseImageUrl . '/card-7.png',
                'benefits' => [
                    'Unlimited consultations',
                    'Priority specialist referrals',
                    'Home healthcare visits',
                    'X-ray & scan interpretation',
                    '24/7 dedicated health line',
                ],
                'keywords' => [
                    'Home Healthcare',
                    'X-ray Interpretation',
                    'Internal Medicine',
                    'Preventive Medicine',
                    'Chronic Disease Management',
                ],
            ],
            [
                'title' => 'Home Healthcare Card',
                'description' => 'Home nurse visits, at-home lab sample collection, and medication delivery for convenient care at home.',
                'price_before_discount' => 220,
                'price' => 169,
                'number_of_promotional_purchases' => 15,
                'duration' => '6 months',
                'image' => $baseImageUrl . '/card-8.png',
                'benefits' => [
                    '4 home nurse visits',
                    'At-home lab sample collection',
                    'Medication delivery',
                    'Elder care support',
                    'Daily health check-ins',
                ],
                'keywords' => [
                    'Home Healthcare',
                    'Lab Results Review',
                    'Preventive Medicine',
                ],
            ],
        ];

        $order = 1;

        foreach ($cardsData as $card) {
            $benefits = $card['benefits'];
            $keywordTitles = $card['keywords'];
            unset($card['benefits'], $card['keywords']);

            $card = Card::create([
                'title' => $card['title'],
                'description' => $card['description'],
                'price_before_discount' => $card['price_before_discount'],
                'price' => $card['price'],
                'number_of_promotional_purchases' => $card['number_of_promotional_purchases'],
                'duration' => $card['duration'],
                'image' => $card['image'],
                'order' => $order++,
                'active' => true,
                'category_id' => $healthCategoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($benefits as $benefit) {
                CardBenefit::create([
                    'card_id' => $card->id,
                    'title' => $benefit,
                ]);
            }

            $keywordIds = Keyword::whereIn('title', $keywordTitles)->pluck('id')->toArray();

            $card->keywords()->attach($keywordIds);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
