<?php

namespace Database\Seeders;

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
        try {
            // جلب user_id من جدول users
            $userIds = User::pluck('id')->toArray();
            $usercods = User::pluck('user_code')->toArray();

            if (empty($userIds)) {
                Log::warning('لا يوجد مستخدمون في قاعدة البيانات، لن يتم إدخال بيانات.');
                return;
            }

            $data = [];
            for ($i = 0; $i < 500; $i++) {
                $userId = $userIds[array_rand($userIds)];
                $usercode = $usercods[array_rand($usercods)];
                $userId2 = $userIds[array_rand($userIds)];

                $data[] = [
                    'user_id' => $userId,
                    'buyer_id' => $userId2, // جعل المشتري هو نفس المستخدم بشكل افتراضي
                    'promo_code' => $usercode,
                    'uniqId' => Str::uuid(),
                    'amount' => number_format(mt_rand(1000, 99999) / 100, 2),
                    'status' => 'completed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('purchases')->insert($data);
        } catch (\Exception $e) {
            Log::error('خطأ أثناء تشغيل Seeder: ' . $e->getMessage());
        }
    }
}
