<?php

namespace Database\Seeders;

use App\Models\balance;
use App\Models\Bell;
use App\Models\FinancialTransactions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialTransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // بيانات افتراضية
        $users = [1, 2, 3]; // معرفات المستخدمين التجريبية
        $organizations = [10, 12, 15]; // معرفات المنظمات التجريبية

        foreach ($users as $key => $user_id) {
            $organization_id = $organizations[$key];
            $amount = rand(50, 500); // مبلغ عشوائي بين 50 و 500

            // إنشاء سجل في جدول Bell
            $bill = Bell::create([
                'bell_type' => 'confirm_booked',
                'bell_items' => json_encode([
                    'book_day' => now()->toDateString(),
                    'book_time' => now()->format('h:i A'),
                    'expire_in' => now()->addMinutes(15)->format('h:i A'),
                    'additional_notes' => null,
                    'user_id' => $user_id,
                    'organization_id' => $organization_id,
                ]),
                'account_type' => 'Organization',
                'amount' => $amount,
                'user_id' => $user_id,
            ]);

            // إنشاء سجل في جدول FinancialTransactions
            FinancialTransactions::create([
                'bell_id' => $bill->id,
                'bell_type' => 'confirm_booked',
                'bell_items' => $bill->bell_items,
                'account_type' => 'Organization',
                'amount' => $amount,
                'balance_type' => 'pending_balance',
                'user_id' => $user_id,
                'organization_id' => $organization_id,
            ]);

            // تحديث الأرصدة تلقائيًا
            $balance = balance::where('user_id', $user_id)
                ->orWhere('organization_id', $organization_id)
                ->firstOrNew([
                    'user_id' => $user_id,
                    'organization_id' => $organization_id,
                ]);

            $balance->total_balance = ($balance->total_balance ?? 0) + $amount;
            $balance->pending_balance = ($balance->pending_balance ?? 0) + $amount;
            $balance->save();
        }
    }
}
