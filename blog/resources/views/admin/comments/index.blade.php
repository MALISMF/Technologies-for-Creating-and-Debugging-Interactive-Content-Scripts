@extends('layouts.app')

@section('title', 'Модерация комментариев - Блог')

@section('content')
    <h1>Модерация комментариев</h1>

    @forelse($pendingComments as $comment)
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div style="flex: 1;">
                    <div style="margin-bottom: 10px;">
                        <strong>Автор:</strong> {{ $comment->author_name }} ({{ $comment->author_email }})
                    </div>
                    <div style="margin-bottom: 10px;">
                        <strong>Пост:</strong> 
                        <a href="{{ route('posts.show', $comment->post) }}">{{ $comment->post->title }}</a>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <strong>Дата:</strong> {{ $comment->created_at->format('d.m.Y H:i') }}
                    </div>
                    <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 10px;">
                        {{ $comment->content }}
                    </div>
                </div>
                <div style="margin-left: 20px;">
                    <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" style="display: inline-block; margin-bottom: 10px;">
                        @csrf
                        <button type="submit" class="btn btn-success">Одобрить</button>
                    </form>
                    <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Отклонить</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card">
            <p>Нет комментариев, ожидающих модерации.</p>
        </div>
    @endforelse

    <div class="pagination">
        {{ $pendingComments->links() }}
    </div>
@endsection
