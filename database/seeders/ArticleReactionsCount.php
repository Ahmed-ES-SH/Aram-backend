<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleReactionsCount extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        // جلب المقالات من قاعدة البيانات
        $articles = DB::table('blogs')->pluck('id');

        if ($articles->isEmpty()) {
            $this->command->info('No articles found in the database. Seeder aborted.');
            return;
        }

        $interactions = [];

        foreach ($articles as $articleId) {
            // إنشاء عدد عشوائي من التفاعلات للمقال
            $likes = random_int(0, 500);
            $dislikes = random_int(0, 100);
            $loves = random_int(0, 300);
            $laughs = random_int(0, 200);

            // حساب عدد التفاعلات الإجمالية
            $totalReactions = $likes + $dislikes + $loves + $laughs;

            if ($totalReactions > 0) {
                $firstReactionAt = Carbon::now()->subDays(random_int(30, 365))->toDateTimeString();
                $lastReactionAt = Carbon::now()->subDays(random_int(1, 29))->toDateTimeString();

                $interactions[] = [
                    'article_id' => $articleId,
                    'likes' => $likes,
                    'dislikes' => $dislikes,
                    'loves' => $loves,
                    'laughs' => $laughs,
                    'totalReactions' => $totalReactions,
                    'first_reaction_at' => $firstReactionAt,
                    'last_reaction_at' => $lastReactionAt,
                ];
            }
        }

        // إدخال التفاعلات في الجدول
        DB::table('article_reactions_count')->insert($interactions);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
