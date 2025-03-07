<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CardVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('card_visits')->truncate();
        try {
            // جلب user_id من جدول users
            $userIds = User::pluck('id')->toArray();

            if (empty($userIds)) {
                Log::warning('لا يوجد مستخدمون في قاعدة البيانات، لن يتم إدخال بيانات.');
                return;
            }

            $data = [];
            for ($i = 0; $i < 300; $i++) {
                $data[] = [
                    'user_id' => $userIds[array_rand($userIds)], // اختيار user_id عشوائي
                    'ip_address' => $this->generateRandomIp(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('card_visits')->insert($data);
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        } catch (\Exception $e) {
            Log::error('خطأ أثناء تشغيل Seeder: ' . $e->getMessage());
        }
    }

    // دالة لتوليد عنوان IP عشوائي
    private function generateRandomIp()
    {
        return rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 255);
    }
}
