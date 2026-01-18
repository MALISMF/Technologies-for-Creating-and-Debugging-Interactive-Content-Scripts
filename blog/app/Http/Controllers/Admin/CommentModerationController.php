<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommentModerationController extends Controller
{
    public function index(): View
    {
        $pendingComments = Comment::where('status', 'pending')
            ->with('post')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.comments.index', compact('pendingComments'));
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
