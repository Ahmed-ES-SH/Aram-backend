<?php

namespace Database\Seeders;

use App\Models\Bell;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('purchases')->truncate();
        try {
            // جلب user_id من جدول users
            $userIds = User::pluck('id')->toArray();
            $belles = [["id" =>  32, "amount" => 79.97], ["id" =>  34, "amount" => 107.99], ["id" =>  35, "amount" => 59.98], ["id" =>  33, "amount" => 239.97]];

            $usercods = User::pluck('user_code')->toArray();

            if (empty($userIds)) {
                Log::warning('لا يوجد مستخدمون في قاعدة البيانات، لن يتم إدخال بيانات.');
                return;
            }

            $data = [];
            for ($i = 0; $i < 500; $i++) {
                $userId = $userIds[array_rand($userIds)];
                $bell = $belles[rand(0, 3)];
                $usercode = $usercods[array_rand($usercods)];
                $userId2 = $userIds[array_rand($userIds)];

                $data[] = [
                    'user_id' => $userId,
                    'bell_id' => $bell['id'],
                    'buyer_id' => $userId2, // جعل المشتري هو نفس المستخدم بشكل افتراضي
                    'buyer_type' => ['Organization', 'User'][rand(0, 1)], // جعل المشتري هو نفس المستخدم بشكل افتراضي
                    'promo_code' => $usercode,
                    'uniqId' => Str::uuid(),
                    'amount' => $bell['amount'],
                    'status' => 'completed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('purchases')->insert($data);
        } catch (\Exception $e) {
            Log::error('خطأ أثناء تشغيل Seeder: ' . $e->getMessage());
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
