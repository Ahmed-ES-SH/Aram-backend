<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('comments')->truncate();
        // الحصول على جميع IDs للمستخدمين
        $usersIds = DB::table('users')->pluck('id')->toArray();
        $usersTypes = ['User', 'Organization'];

        // الحصول على جميع IDs للمقالات
        $articlesIds = DB::table('blogs')->pluck('id')->toArray();

        // إنشاء كائن Faker
        $faker = Faker::create();

        // إضافة 50 تعليق عشوائي
        for ($i = 0; $i < 50; $i++) {
            DB::table('comments')->insert([
                'user_id' => $usersIds[array_rand($usersIds)], // اختيار ID مستخدم عشوائي
                'user_type' => $usersTypes[array_rand($usersTypes)], // اختيار ID مستخدم عشوائي
                'article_id' => 9, // اختيار ID مقال عشوائي
                'content' => $faker->sentence(10), // إنشاء نص عشوائي مكون من 10 كلمات
                'created_at' => now(), // إضافة timestamp للإنشاء
                'updated_at' => now(), // إضافة timestamp للتحديث
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
