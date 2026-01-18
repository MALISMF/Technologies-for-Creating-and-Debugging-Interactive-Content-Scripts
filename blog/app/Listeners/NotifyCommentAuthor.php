<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Illuminate\Support\Facades\Log;

class NotifyCommentAuthor
{
    public function handle(CommentCreated $event): void
    {
        $comment = $event->comment;
        
        Log::info('Уведомление автору комментария', [
            'author_email' => $comment->author_email,
            'comment_id' => $comment->id,
        ]);

        // Здесь можно добавить отправку email автору комментария
        // Mail::to($comment->author_email)->send(new CommentSubmittedConfirmation($comment));
    }
}
