<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish-scheduled';
    protected $description = 'Публикует посты, запланированные на текущее время';

    public function handle(): int
    {
        $posts = Post::where('status', 'draft')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->get();

        if ($posts->isEmpty()) {
            $this->info('Нет постов для публикации.');
            return Command::SUCCESS;
        }

        $count = 0;
        foreach ($posts as $post) {
            $post->publish();
            $count++;
            $this->info("Пост '{$post->title}' опубликован.");
        }

        $this->info("Опубликовано постов: {$count}");

        return Command::SUCCESS;
    }
}
