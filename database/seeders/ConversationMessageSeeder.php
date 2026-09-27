<?php

namespace Database\Seeders;

use App\Modules\Conversation\Models\Conversation;
use App\Modules\Conversation\Models\ConversationBlock;
use App\Modules\Conversation\Models\Message;
use App\Modules\Organization\Models\Organization;
use App\Modules\User\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('conversations')->truncate();
        DB::table('messages')->truncate();
        DB::table('conversation_blocks')->truncate();

        $faker = Faker::create();

        $userIds = User::pluck('id')->toArray();
        $organizationIds = Organization::pluck('id')->toArray();

        if (empty($userIds) || empty($organizationIds)) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
            return;
        }

        $bilingualMessages = [
            ['en' => 'Hello, is this service still available?', 'ar' => 'مرحباً، هل هذه الخدمة ما زالت متوفرة؟'],
            ['en' => 'Yes, it is available. How can we help you?', 'ar' => 'نعم، متوفرة. كيف يمكننا مساعدتك؟'],
            ['en' => 'I would like to get a quote for my project.', 'ar' => 'أود الحصول على عرض سعر لمشروعي.'],
            ['en' => 'Sure, please send us your requirements.', 'ar' => 'بالتأكيد، يرجى إرسال متطلباتك إلينا.'],
            ['en' => 'When can we start the work?', 'ar' => 'متى يمكننا بدء العمل؟'],
            ['en' => 'We can start next week.', 'ar' => 'يمكننا البدء الأسبوع المقبل.'],
            ['en' => 'What is the expected delivery time?', 'ar' => 'ما هو وقت التسليم المتوقع؟'],
            ['en' => 'The delivery time is about two weeks.', 'ar' => 'مدة التسليم حوالي أسبوعين.'],
            ['en' => 'Can we schedule a call to discuss details?', 'ar' => 'هل يمكننا جدولة مكالمة لمناقشة التفاصيل؟'],
            ['en' => 'Of course, let me know a convenient time for you.', 'ar' => 'بالطبع، أخبرني بالوقت المناسب لك.'],
            ['en' => 'Thank you, we are very satisfied with your service.', 'ar' => 'شكراً لك، نحن راضون جداً عن خدمتكم.'],
            ['en' => 'Great to hear that! Feel free to reach out anytime.', 'ar' => 'يسعدنا سماع ذلك! لا تتردد في التواصل معنا في أي وقت.'],
        ];

        $conversationIds = [];
        for ($i = 0; $i < 30; $i++) {
            $user = $faker->randomElement($userIds);
            $organization = $faker->randomElement($organizationIds);

            $conversation = Conversation::create([
                'participant_one_id' => $user,
                'participant_one_type' => User::class,
                'participant_two_id' => $organization,
                'participant_two_type' => Organization::class,
                'deleted_by' => $faker->boolean(10) ? [$faker->randomElement(['user', 'organization'])] : null,
            ]);
            $conversationIds[] = $conversation->id;

            $messageCount = $faker->numberBetween(5, 12);

            for ($m = 0; $m < $messageCount; $m++) {
                $template = $faker->randomElement($bilingualMessages);
                $fromUser = $m % 2 === 0;

                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $fromUser ? $user : $organization,
                    'sender_type' => $fromUser ? 'user' : 'organization',
                    'receiver_id' => $fromUser ? $organization : $user,
                    'receiver_type' => $fromUser ? 'organization' : 'user',
                    'message' => $fromUser ? $template['en'] : $template['ar'],
                    'message_type' => 'text',
                    'is_read' => $faker->boolean(70),
                    'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }

        for ($b = 0; $b < 8; $b++) {
            ConversationBlock::create([
                'conversation_id' => $faker->randomElement($conversationIds),
                'blocked_by' => $faker->randomElement($userIds),
                'blocked_user' => $faker->randomElement($userIds),
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $this->command->info('Conversations, messages and blocks seeded successfully.');
    }
}