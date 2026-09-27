<?php

namespace Database\Seeders;

use App\Models\CommentLike;
use App\Models\Invoice;
use App\Models\Order;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\UserArticleInteraction;
use App\Modules\Card\Models\Card;
use App\Modules\Card\Models\OwnedCard;
use App\Modules\Conversation\Models\Notification;
use App\Modules\FamilyMember\Models\FamilyMember;
use App\Modules\Organization\Models\Organization;
use App\Modules\Organization\Models\OrganizationReview;
use App\Modules\Organization\Models\ReviewLikesCheck;
use App\Modules\Payment\Models\Wallet;
use App\Modules\Payment\Models\WithdrawRequest;
use App\Modules\User\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('wallets')->truncate();
        DB::table('withdraw_requests')->truncate();
        DB::table('orders')->truncate();
        DB::table('invoices')->truncate();
        DB::table('owned_cards')->truncate();
        DB::table('notifications')->truncate();
        DB::table('user_article_interactions')->truncate();
        DB::table('comment_likes')->truncate();
        DB::table('review_likes_checks')->truncate();
        DB::table('family_members')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $faker = Faker::create();

        $userIds = User::pluck('id')->toArray();
        $organizationIds = Organization::pluck('id')->toArray();
        $articleIds = Article::pluck('id')->toArray();
        $cardIds = Card::pluck('id')->toArray();
        $allIds = array_merge($userIds, $organizationIds);

        if (empty($userIds)) {
            $this->command->warn('No users found, skipping user activity seeding.');
            return;
        }

        // ========== 1. WALLETS ==========
        // One wallet per user (account_type = user)
        $this->seedWallets($userIds, $organizationIds, $faker);
        $this->command->info('Wallets seeded.');

        // ========== 2. ORDERS + INVOICES ==========
        $this->seedOrdersAndInvoices($userIds, $organizationIds, $allIds, $faker);
        $this->command->info('Orders and invoices seeded.');

        // ========== 3. OWNED CARDS ==========
        $this->seedOwnedCards($userIds, $organizationIds, $cardIds, $allIds, $faker);
        $this->command->info('Owned cards seeded.');

        // ========== 4. NOTIFICATIONS ==========
        $this->seedNotifications($userIds, $organizationIds, $allIds, $faker);
        $this->command->info('Notifications seeded.');

        // ========== 5. USER ARTICLE INTERACTIONS ==========
        if (!empty($articleIds)) {
            $this->seedUserArticleInteractions($userIds, $articleIds, $faker);
            $this->command->info('User article interactions seeded.');
        }

        // ========== 6. COMMENT LIKES ==========
        $this->seedCommentLikes($userIds, $faker);
        $this->command->info('Comment likes seeded.');

        // ========== 7. REVIEW LIKES CHECKS ==========
        $this->seedReviewLikesChecks($userIds, $organizationIds, $faker);
        $this->command->info('Review likes checks seeded.');

        // ========== 8. WITHDRAW REQUESTS ==========
        $this->seedWithdrawRequests($userIds, $organizationIds, $faker);
        $this->command->info('Withdraw requests seeded.');

        // ========== 9. FAMILY MEMBERS ==========
        $this->seedFamilyMembers($userIds, $faker);
        $this->command->info('Family members seeded.');
    }

    protected function seedWallets(array $userIds, array $organizationIds, $faker): void
    {
        $now = now();

        // 1 wallet per user (account_type = user)
        foreach ($userIds as $userId) {
            Wallet::create([
                'user_id' => $userId,
                'account_type' => 'user',
                'available_balance' => $faker->randomFloat(2, 0, 800),
                'pending_balance' => $faker->randomFloat(2, 0, 300),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // A few organization wallets to make the platform feel active
        foreach (array_slice($organizationIds, 0, 20) as $orgId) {
            Wallet::create([
                'user_id' => $orgId,
                'account_type' => 'organization',
                'available_balance' => $faker->randomFloat(2, 50, 3000),
                'pending_balance' => $faker->randomFloat(2, 0, 500),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    protected function seedOrdersAndInvoices(array $userIds, array $organizationIds, array $allIds, $faker): void
    {
        $statuses = ['pending', 'paid', 'faild'];
        $methods = ['thawani', 'credit_card', 'wallet', 'cash'];

        for ($i = 0; $i < 80; $i++) {
            $status = $statuses[array_rand($statuses)];
            $ownerIsUser = $faker->boolean(70);
            $ownerId = $ownerIsUser
                ? $faker->randomElement($userIds)
                : $faker->randomElement($organizationIds);

            $amount = $faker->randomFloat(2, 10, 5000);
            $paidAt = $status === 'paid' ? $faker->dateTimeBetween('-6 months', 'now') : null;

            $order = Order::create([
                'session_id' => 'sess_' . Str::random(32),
                'amount' => $amount,
                'status' => $status,
                'user_id' => $ownerId,
                'user_type' => $ownerIsUser ? 'user' : 'organization',
                'paid_at' => $paidAt,
                'created_at' => $paidAt ?? $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);

            Invoice::create([
                'invoice_number' => (string) Str::uuid(),
                'total_invoice' => $amount,
                'before_discount' => $faker->optional(0.5)->randomFloat(2, $amount, $amount * 1.2),
                'discount' => $faker->optional(0.4)->randomFloat(2, 0, 20),
                'tax_amount' => $faker->optional(0.7)->randomFloat(2, 0, $amount * 0.1),
                'ref_code' => $faker->optional(0.5)->bothify('REF-####-????'),
                'invoice_type' => $faker->randomElement(['cards', 'book', 'service', 'deal_service']),
                'owner_id' => $ownerId,
                'owner_type' => $ownerIsUser ? 'user' : 'organization',
                'status' => $status === 'paid' ? 'paid' : $faker->randomElement(['pending', 'canceled']),
                'currency' => 'OMR',
                'payment_method' => $methods[array_rand($methods)],
                'created_at' => $paidAt ?? $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }

    protected function seedOwnedCards(array $userIds, array $organizationIds, array $cardIds, array $allIds, $faker): void
    {
        $statuses = ['active', 'inactive', 'expired'];
        $generatedNumbers = [];

        for ($i = 0; $i < 60; $i++) {
            $cardNumber = $faker->numerify('################');
            if (in_array($cardNumber, $generatedNumbers)) {
                continue;
            }
            $generatedNumbers[] = $cardNumber;

            $ownerIsUser = $faker->boolean(75);
            $ownerId = $ownerIsUser
                ? $faker->randomElement($userIds)
                : $faker->randomElement($organizationIds);

            $issueDate = $faker->dateTimeBetween('-2 years', 'now');
            $status = $statuses[array_rand($statuses)];
            $expiryDate = match ($status) {
                'expired' => $faker->dateTimeBetween('-2 years', '-1 day'),
                'active' => $faker->dateTimeBetween('now', '+2 years'),
                default => $faker->dateTimeBetween('now', '+2 years'),
            };
            $usageLimit = $faker->optional(0.7)->numberBetween(1, 50);

            OwnedCard::create([
                'cvv' => $faker->numberBetween(100, 999),
                'owner_id' => $ownerId,
                'issue_date' => $issueDate,
                'usage_limit' => $usageLimit,
                'expiry_date' => $expiryDate,
                'current_usage' => $usageLimit ? $faker->numberBetween(0, $usageLimit) : 0,
                'owner_type' => $ownerIsUser ? 'user' : 'organization',
                'card_number' => $cardNumber,
                'status' => $status,
                'card_id' => !empty($cardIds) ? $faker->randomElement($cardIds) : null,
                'created_at' => $issueDate,
                'updated_at' => now(),
            ]);
        }
    }

    protected function seedNotifications(array $userIds, array $organizationIds, array $allIds, $faker): void
    {
        $contents = [
            'Your order has been confirmed successfully.',
            'تم تأكيد طلبك بنجاح.',
            'A new message has arrived in your conversations.',
            'وصلت رسالة جديدة إلى محادثاتك.',
            'Your wallet balance has been updated.',
            'تم تحديث رصيد محفظتك.',
            'Your appointment has been approved.',
            'تمت الموافقة على موعدك.',
            'New offer available for you.',
            'يوجد عرض جديد متاح لك.',
            'Your card is about to expire.',
            'بطاقتك على وشك الانتهاء.',
            'A review you liked was updated.',
            'تم تحديث تقييم أعجبك.',
            'Your withdraw request was processed.',
            'تمت معالجة طلب السحب الخاص بك.',
            'Welcome back to the platform!',
            'مرحباً بعودتك إلى المنصة!',
            'Someone replied to your comment.',
            'رد شخص على تعليقك.',
        ];

        for ($i = 0; $i < 150; $i++) {
            $senderType = $faker->randomElement(['user', 'organization']);
            $recipientType = $faker->randomElement(['user', 'organization']);
            $senderId = $senderType === 'user'
                ? $faker->randomElement($userIds)
                : $faker->randomElement($organizationIds);
            $recipientId = $recipientType === 'user'
                ? $faker->randomElement($userIds)
                : $faker->randomElement($organizationIds);

            Notification::create([
                'content' => $faker->randomElement($contents),
                'is_read' => $faker->boolean(65),
                'sender_id' => $senderId,
                'sender_type' => $senderType,
                'recipient_id' => $recipientId,
                'recipient_type' => $recipientType,
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }

    protected function seedUserArticleInteractions(array $userIds, array $articleIds, $faker): void
    {
        $types = ['like', 'love', 'dislike', 'laughter'];

        for ($i = 0; $i < 100; $i++) {
            UserArticleInteraction::create([
                'interaction_type' => $types[array_rand($types)],
                'user_id' => $faker->randomElement($userIds),
                'article_id' => $faker->randomElement($articleIds),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }

    protected function seedCommentLikes(array $userIds, $faker): void
    {
        $commentIds = DB::table('article_comments')->pluck('id')->toArray();

        if (empty($commentIds)) {
            return;
        }

        for ($i = 0; $i < 120; $i++) {
            CommentLike::create([
                'user_id' => $faker->randomElement($userIds),
                'comment_id' => $faker->randomElement($commentIds),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }

    protected function seedReviewLikesChecks(array $userIds, array $organizationIds, $faker): void
    {
        $reviews = OrganizationReview::whereIn('organization_id', $organizationIds)
            ->get(['id', 'organization_id'])
            ->all();

        if (empty($reviews)) {
            return;
        }

        for ($i = 0; $i < 200; $i++) {
            $review = $faker->randomElement($reviews);

            ReviewLikesCheck::create([
                'user_id' => $faker->randomElement($userIds),
                'review_id' => $review->id,
                'organization_id' => $review->organization_id,
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }

    protected function seedWithdrawRequests(array $userIds, array $organizationIds, $faker): void
    {
        $statuses = ['approved', 'pending', 'rejected'];
        $methods = ['bank_transfer', 'wallet', 'paypal'];

        for ($i = 0; $i < 20; $i++) {
            $isUser = $faker->boolean(60);

            WithdrawRequest::create([
                'user_id' => $isUser ? $faker->randomElement($userIds) : $faker->randomElement($organizationIds),
                'account_type' => $isUser ? 'user' : 'organization',
                'amount' => $faker->randomFloat(2, 10, 500),
                'bank_number' => $faker->bothify('OM----------#########'),
                'note' => $faker->optional(0.6)->sentence,
                'status' => $statuses[array_rand($statuses)],
                'meta' => [
                    'method' => $methods[array_rand($methods)],
                    'iban' => $faker->bothify('OM## #### #### #### #### ####'),
                    'processed_by' => $faker->name,
                ],
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }

    protected function seedFamilyMembers(array $userIds, $faker): void
    {
        $relationships = ['Father', 'Mother', 'Brother', 'Sister', 'Son', 'Daughter', 'Uncle', 'Aunt', 'Grandfather', 'Grandmother', 'Cousin', 'Spouse'];
        $statuses = ['pending', 'accepted', 'rejected'];
        $createdPairs = [];

        for ($i = 0; $i < 20; $i++) {
            $userId = $faker->randomElement($userIds);
            $memberId = $faker->randomElement($userIds);

            if ($userId === $memberId) {
                continue;
            }

            $pairKey = $userId . '-' . $memberId;
            if (in_array($pairKey, $createdPairs)) {
                continue;
            }
            $createdPairs[] = $pairKey;

            FamilyMember::create([
                'user_id' => $userId,
                'family_member_id' => $memberId,
                'relationship' => $relationships[array_rand($relationships)],
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}