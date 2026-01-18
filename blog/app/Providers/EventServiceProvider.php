<?php

namespace App\Providers;

use App\Events\CommentCreated;
use App\Listeners\NotifyCommentAuthor;
use App\Listeners\SendCommentNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CommentCreated::class => [
            SendCommentNotification::class,
            NotifyCommentAuthor::class,
        ],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
