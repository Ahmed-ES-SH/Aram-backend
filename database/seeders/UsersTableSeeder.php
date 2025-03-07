<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('users')->truncate();
        $faker = Faker::create();
        $urlimage = env('BACK_END_URL');
        // $urlimage = 'http://127.0.0.1:8000';
        $path = 'images/users';
        $fullpath = public_path($path);
        $images = scandir($fullpath);
        $imagesarray = array_filter($images, function ($image) {
            return in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });
        foreach (range(1, 50) as $index) {
            $imageuser = $imagesarray[array_rand($imagesarray)];
            $imageurl = $urlimage . '/'    . $path . '/' . $imageuser;
            DB::table('users')->insert([
                'id' => $index,
                'image' => $faker->imageUrl(100, 100, 'people', true, 'User'),
                'password' => '12345678',
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'image' => $imageurl,
                'user_gender' => $faker->randomElement(['male', 'female']),
                'user_birthdate' => $faker->date('Y-m-d'),
                'user_code' => Str::random(10),
                'location' => '{"address":"Muzdalifah Road, كدي, محافظة مكة المكرمة, منطقة مكة المكرمة, 24243, السعودية","latitude":21.40281772305478,"longitude":39.84603881835938}',
                'phone_number' => $faker->phoneNumber,
                'role' => $faker->randomElement(['admin', 'user', 'editor']),
                'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
