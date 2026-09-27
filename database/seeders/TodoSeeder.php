<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Todo;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\DB;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('todos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $userIds = User::pluck('id')->take(8)->toArray();

        if (empty($userIds)) {
            $this->command->warn('No users found, skipping todo seeding.');
            return;
        }

        $todoTemplates = [
            ['title' => 'Complete Project Documentation', 'description' => 'Finish the API documentation for the new module.', 'priority' => 'high', 'is_completed' => false],
            ['title' => 'Review Pull Requests', 'description' => 'Check the pending PRs from the frontend team.', 'priority' => 'high', 'is_completed' => false],
            ['title' => 'Update Dependencies', 'description' => 'Run composer update and npm update to get latest packages.', 'priority' => 'medium', 'is_completed' => false],
            ['title' => 'Team Meeting', 'description' => 'Weekly sync with the development team.', 'priority' => 'medium', 'is_completed' => true],
            ['title' => 'Clean up temporary files', 'description' => 'Remove old logs and temp uploads from verify folder.', 'priority' => 'low', 'is_completed' => false],
            ['title' => 'Research new JS framework', 'description' => 'Look into the latest features of Vue 3.', 'priority' => 'low', 'is_completed' => true],
            ['title' => 'Prepare monthly report', 'description' => 'Compile performance metrics for the monthly meeting.', 'priority' => 'high', 'is_completed' => true],
            ['title' => 'Write unit tests', 'description' => 'Add coverage for the payment module.', 'priority' => 'high', 'is_completed' => false],
            ['title' => 'Onboard new developer', 'description' => 'Introduce the new hire to the codebase and workflows.', 'priority' => 'medium', 'is_completed' => true],
            ['title' => 'Fix reported bug', 'description' => 'Reproduce and fix the checkout pagination bug.', 'priority' => 'high', 'is_completed' => false],
            ['title' => 'Reply to client emails', 'description' => 'Answer pending inquiries from the support inbox.', 'priority' => 'low', 'is_completed' => false],
            ['title' => 'Design system audit', 'description' => 'Review icons and spacing tokens for consistency.', 'priority' => 'medium', 'is_completed' => false],
            ['title' => 'Backup production database', 'description' => 'Run the scheduled backup and verify the archive.', 'priority' => 'low', 'is_completed' => true],
            ['title' => 'Refactor legacy controller', 'description' => 'Split the oversized controller into smaller services.', 'priority' => 'medium', 'is_completed' => false],
            ['title' => 'Update deployment pipeline', 'description' => 'Add staging environment to the CI workflow.', 'priority' => 'high', 'is_completed' => false],
            ['title' => 'Read latest framework release notes', 'description' => 'Review breaking changes in the new Laravel version.', 'priority' => 'low', 'is_completed' => true],
            ['title' => 'Draft Q3 roadmap', 'description' => 'Outline priorities for the next quarter.', 'priority' => 'medium', 'is_completed' => false],
            ['title' => 'Test checkout flow', 'description' => 'Run an end-to-end purchase on staging.', 'priority' => 'high', 'is_completed' => true],
            ['title' => 'Update API error codes', 'description' => 'Document the new error response format.', 'priority' => 'medium', 'is_completed' => false],
            ['title' => 'Clear stale sessions', 'description' => 'Remove expired user sessions from the cache.', 'priority' => 'low', 'is_completed' => false],
        ];

        foreach ($userIds as $userId) {
            $count = random_int(3, 5);

            foreach (array_slice($todoTemplates, 0, $count) as $todo) {
                Todo::create(array_merge($todo, ['user_id' => $userId]));
            }

            // Rotate template pool so different users get different tasks
            array_pop($todoTemplates);
            array_unshift($todoTemplates, $todoTemplates[count($todoTemplates) - 1]);
        }

        $this->command->info('Todos seeded successfully for ' . count($userIds) . ' users.');
    }
}