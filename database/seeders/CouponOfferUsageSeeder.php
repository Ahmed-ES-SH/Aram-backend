<?php

namespace Database\Seeders;

use App\Modules\Coupon\Models\Coupon;
use App\Modules\Coupon\Models\CouponOrganization;
use App\Modules\Coupon\Models\CouponUsage;
use App\Modules\Coupon\Models\CouponUser;
use App\Modules\Organization\Models\Organization;
use App\Modules\Promotion\Models\Offer;
use App\Modules\Promotion\Models\OfferUsage;
use App\Modules\User\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponOfferUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('coupon_users')->truncate();
        DB::table('coupon_usages')->truncate();
        DB::table('coupon_organizations')->truncate();
        DB::table('offer_usages')->truncate();
        DB::table('category_offer')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $faker = Faker::create();

        $userIds = User::pluck('id')->toArray();
        $organizationIds = Organization::pluck('id')->toArray();
        $coupons = Coupon::all();
        $offers = Offer::all();
        $orderIds = DB::table('orders')->pluck('id')->toArray();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        if (empty($userIds) || empty($organizationIds) || empty($coupons)) {
            $this->command->warn('Missing base data, skipping coupon/offer usage seeding.');
            return;
        }

        // ========== COUPON USERS (~40) ==========
        // Only coupons of type user/general can be assigned to users
        $userCoupons = $coupons->whereIn('type', ['user', 'general'])->all();
        if (!empty($userCoupons)) {
            for ($i = 0; $i < 40; $i++) {
                $coupon = $faker->randomElement($userCoupons);
                $usageLimit = $faker->optional(0.6)->numberBetween(1, 10);

                CouponUser::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => $faker->randomElement($userIds),
                    'organization_id' => $faker->optional(0.2)->randomElement($organizationIds),
                    'usage_limit' => $usageLimit,
                    'current_usage' => $usageLimit ? $faker->numberBetween(0, $usageLimit) : 0,
                    'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }

        // ========== COUPON USAGES (~60) ==========
        if (!empty($userCoupons)) {
            for ($i = 0; $i < 60; $i++) {
                $coupon = $faker->randomElement($userCoupons);
                $isUser = $faker->boolean(70);
                $orderAmount = $faker->randomFloat(2, 20, 2000);
                $discount = $coupon->benefit_type === 'percentage' && $coupon->discount_value
                    ? round($orderAmount * ($coupon->discount_value / 100), 2)
                    : $coupon->discount_value ?? 0;

                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => $isUser ? $faker->randomElement($userIds) : null,
                    'organization_id' => $isUser ? null : $faker->randomElement($organizationIds),
                    'order_id' => !empty($orderIds) ? $faker->randomElement($orderIds) : null,
                    'order_amount' => $orderAmount,
                    'discount_applied' => min($discount, $orderAmount),
                    'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }

        // ========== COUPON ORGANIZATIONS (~30) ==========
        $orgCoupons = $coupons->whereIn('type', ['organization', 'general'])->all();
        if (!empty($orgCoupons)) {
            for ($i = 0; $i < 30; $i++) {
                $coupon = $faker->randomElement($orgCoupons);
                $usageLimit = $faker->optional(0.6)->numberBetween(1, 20);

                CouponOrganization::create([
                    'coupon_id' => $coupon->id,
                    'organization_id' => $faker->randomElement($organizationIds),
                    'usage_limit' => $usageLimit,
                    'current_usage' => $usageLimit ? $faker->numberBetween(0, $usageLimit) : 0,
                    'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }

        // ========== OFFER USAGES (~50) ==========
        for ($i = 0; $i < 50; $i++) {
            $isUser = $faker->boolean(65);

            OfferUsage::create([
                'account_type' => $isUser ? 'user' : 'organization',
                'times_used' => $faker->numberBetween(1, 6),
                'discount_applied' => $faker->randomFloat(2, 5, 300),
                'user_id' => $isUser ? $faker->randomElement($userIds) : null,
                'organization_id' => $isUser ? null : $faker->randomElement($organizationIds),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }

        // ========== CATEGORY OFFER (~30 pivots) ==========
        if (!empty($offers) && !empty($categoryIds)) {
            $pivots = [];
            for ($i = 0; $i < 30; $i++) {
                $pivots[] = [
                    'offer_id' => $faker->randomElement($offers->pluck('id')->all()),
                    'category_id' => $faker->randomElement($categoryIds),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('category_offer')->insert($pivots);
        }

        $this->command->info('Coupon and offer usage seeded successfully.');
    }
}