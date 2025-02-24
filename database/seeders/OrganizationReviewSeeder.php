<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\organizationReview;
use App\Models\User;
use Faker\Factory as Faker;

class OrganizationReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = User::pluck('id')->toArray(); // جلب جميع معرفات المستخدمين

        if (empty($userIds)) {
            return; // تجنب حدوث خطأ في حالة عدم وجود مستخدمين
        }

        $reviews = [];

        for ($i = 0; $i < 10; $i++) {
            $reviews[] = [
                'stars' => $faker->numberBetween(1, 5),
                'head_line' => $faker->sentence(6),
                'content' => $faker->paragraph(3),
                'like_counts' => $faker->optional()->numberBetween(0, 100) ?? 0,
                'user_id' => $faker->randomElement($userIds),
                'organization_id' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        organizationReview::insert($reviews);
    }
}
