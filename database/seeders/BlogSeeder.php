<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/mioto_blog_data_with_html.json');
        if (!File::exists($path)) {
            return;
        }
        $json = File::get($path);
        $items = collect(json_decode($json, true));
        $count = 0;
        $items->each(function ($b) use (&$count) {
            $miotoId = $b['id'] ?? null;
            if (!$miotoId) return;
            Blog::updateOrCreate(
                ['mioto_id' => $miotoId],
                [
                    'link' => $b['link'] ?? '',
                    'title' => $b['title'] ?? '',
                    'content_text_preview' => $b['content_text_preview'] ?? '',
                    'content_html' => $b['content_html'] ?? '',
                    'thumbnail' => $b['thumbnail'] ?? '',
                ]
            );
            $count++;
        });
        if (method_exists($this->command, 'info')) {
            $this->command->info('Blogs seeded: '.$count);
        }
    }
}