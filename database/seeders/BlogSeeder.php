<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::table('blogs')->truncate();
        } catch (\Throwable $e) {
            Blog::query()->delete();
        }
        try {
            Storage::disk('public')->deleteDirectory('blog_thumbs');
        } catch (\Throwable $e) {}
        Storage::disk('public')->makeDirectory('blog_thumbs');
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
            $thumb = $b['thumbnail'] ?? '';
            $localThumb = $thumb;
            if (is_string($thumb) && Str::startsWith($thumb, ['http://','https://','//'])) {
                try {
                    $resp = Http::timeout(10)->get($thumb);
                    if ($resp->ok()) {
                        $mime = $resp->header('Content-Type') ?: 'image/jpeg';
                        $ext = Str::contains($mime, 'png') ? 'png' : (Str::contains($mime, 'webp') ? 'webp' : 'jpg');
                        $name = 'blog_thumbs/'.$miotoId.'.'.$ext;
                        Storage::disk('public')->put($name, $resp->body());
                        $localThumb = $name;
                    }
                } catch (\Throwable $e) {
                    $localThumb = $thumb;
                }
            }

            Blog::updateOrCreate(
                ['mioto_id' => $miotoId],
                [
                    'title' => $b['title'] ?? '',
                    'content_text_preview' => $b['content_text_preview'] ?? '',
                    'content_html' => $b['content_html'] ?? '',
                    'thumbnail' => $localThumb,
                ]
            );
            $count++;
        });
        if (method_exists($this->command, 'info')) {
            $this->command->info('Blogs seeded: '.$count);
        }
    }
}