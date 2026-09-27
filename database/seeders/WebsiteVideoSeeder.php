<?php

namespace Database\Seeders;

use App\Models\WebsiteVideo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('website_videos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $videos = [
            [
                'video_id' => 'dQw4w9WgXcQ',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'video_image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                'aspect_ratio' => '16:9',
                'video_type' => 'youtube',
                'is_file' => false,
            ],
            [
                'video_id' => '9bZkp7q19f0',
                'video_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                'video_image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                'aspect_ratio' => '16:9',
                'video_type' => 'youtube',
                'is_file' => false,
            ],
            [
                'video_id' => 'kJQP7kiw5Fk',
                'video_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                'video_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                'aspect_ratio' => '16:9',
                'video_type' => 'youtube',
                'is_file' => false,
            ],
            [
                'video_id' => 'OPf0YbXqDm0',
                'video_url' => 'https://www.youtube.com/watch?v=OPf0YbXqDm0',
                'video_image' => 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                'aspect_ratio' => '16:9',
                'video_type' => 'youtube',
                'is_file' => false,
            ],
            [
                'video_id' => 'cW8VLC9nnTo',
                'video_url' => 'https://www.youtube.com/watch?v=cW8VLC9nnTo',
                'video_image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                'aspect_ratio' => '16:9',
                'video_type' => 'youtube',
                'is_file' => false,
            ],
            [
                'video_id' => 'YQHsXMglC9A',
                'video_url' => 'https://www.youtube.com/watch?v=YQHsXMglC9A',
                'video_image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                'aspect_ratio' => '16:9',
                'video_type' => 'youtube',
                'is_file' => false,
            ],
        ];

        foreach ($videos as $video) {
            WebsiteVideo::create($video);
        }

        $this->command->info('Website videos seeded successfully.');
    }
}