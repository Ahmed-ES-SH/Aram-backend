<?php

namespace Database\Seeders;

use App\Models\Conversation;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            Conversation::create([
                'participant_one_id' => 51,
                'participant_one_type' => 'User',
                'participant_two_id' => 2,
                'participant_two_type' => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
