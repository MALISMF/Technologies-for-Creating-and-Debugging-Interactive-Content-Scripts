<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        if (!$post->isPublished()) {
            abort(404);
        }

        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create($validated);

        event(new CommentCreated($comment));

        return redirect()->route('posts.show', $post)
            ->with('success', 'Комментарий отправлен на модерацию!');
    }

    public function approve(Comment $comment): RedirectResponse
    {
        $comment->approve();

        return redirect()->back()->with('success', 'Комментарий одобрен!');
    }

    public function reject(Comment $comment): RedirectResponse
    {
        $comment->reject();

        return redirect()->back()->with('success', 'Комментарий отклонен!');
    }
}
