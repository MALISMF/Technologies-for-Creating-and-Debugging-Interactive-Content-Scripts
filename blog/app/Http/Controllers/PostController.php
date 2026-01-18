<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date|after_or_equal:now',
            'status' => 'required|in:draft,published',
        ]);

        $post = Post::create($validated);

        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $post->publish();
        }

        return redirect()->route('posts.index')->with('success', 'Пост успешно создан!');
    }

    public function show(Post $post): View
    {
        if (!$post->isPublished()) {
            abort(404);
        }

        $post->load('publishedComments');

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ]);

        $post->update($validated);

        if ($validated['status'] === 'published' && !$post->published_at) {
            $post->publish();
        } elseif ($validated['status'] === 'draft') {
            $post->unpublish();
        }

        return redirect()->route('posts.index')->with('success', 'Пост успешно обновлен!');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Пост успешно удален!');
    }
}
