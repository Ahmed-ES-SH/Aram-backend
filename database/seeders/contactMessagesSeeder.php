<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class contactMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('contact_messages')->truncate();
        // إنشاء كائن Faker
        $faker = Faker::create();

        // تعبئة الجدول بـ 30 عنصرًا
        for ($i = 0; $i < 30; $i++) {
            DB::table('contact_messages')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'message' => $faker->sentence(10), // رسالة قصيرة
                'status' => $faker->randomElement(['pending', 'reviewed', 'closed']), // قيمة عشوائية للحالة
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }
    }
}
