<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Illuminate\Support\Facades\Log;

class SendCommentNotification
{
    public function handle(CommentCreated $event): void
    {
        $comment = $event->comment;
        
        Log::info('Новый комментарий создан', [
            'comment_id' => $comment->id,
            'post_id' => $comment->post_id,
            'author' => $comment->author_name,
            'status' => $comment->status,
        ]);

        // Здесь можно добавить отправку email уведомления администратору
        // Mail::to(config('mail.admin'))->send(new NewCommentNotification($comment));
    }
}
