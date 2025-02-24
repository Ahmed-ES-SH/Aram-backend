<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        DB::table('books')->truncate();
        // بيانات المواعيد
        $appointments = [];

        // حالات المواعيد
        $statuses = ['done', 'waiting', 'expired', 'acceptable', 'unacceptable'];

        // تاريخ اليوم
        $today = Carbon::today();

        // إنشاء 20 موعدًا
        for ($i = 1; $i <= 20; $i++) {
            $bookDay = $today->copy()->addDays($i); // تاريخ الموعد
            $bookTime = Carbon::createFromTime(rand(8, 18), rand(0, 59)); // وقت الموعد
            $expireIn = $bookDay->copy()->addDays(rand(1, 30)); // تاريخ انتهاء الموعد
            $status = $statuses[array_rand($statuses)]; // حالة الموعد

            $appointments[] = [
                'book_day' => $bookDay,
                'book_time' => $bookTime,
                'expire_in' => $expireIn,
                'additional_notes' => "ملاحظات إضافية للموعد رقم $i",
                'user_id' => 51, // معرف المستخدم
                'organization_id' => 12, // معرف المنظمة
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // إدخال البيانات في جدول المواعيد
        DB::table('books')->insert($appointments);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
