@extends('layouts.app')

@section('title', $post->title . ' - Блог')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('posts.index') }}" class="btn" style="background: #6c757d;">← Назад к списку</a>
        <a href="{{ route('posts.edit', $post) }}" class="btn" style="background: #28a745;">Редактировать</a>
    </div>

    <div class="card">
        <h1>{{ $post->title }}</h1>
        <div class="card-meta">
            Опубликовано: {{ $post->published_at->format('d.m.Y H:i') }}
        </div>
        <div style="margin-top: 20px; white-space: pre-wrap;">{{ $post->content }}</div>
    </div>

    <div class="comments">
        <h2>Комментарии ({{ $post->publishedComments->count() }})</h2>

        @forelse($post->publishedComments as $comment)
            <div class="comment">
                <div class="comment-author">{{ $comment->author_name }}</div>
                <div class="comment-date">{{ $comment->created_at->format('d.m.Y H:i') }}</div>
                <div style="margin-top: 10px;">{{ $comment->content }}</div>
            </div>
        @empty
            <p>Пока нет комментариев.</p>
        @endforelse

        <div class="card" style="margin-top: 30px;">
            <h3>Оставить комментарий</h3>
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="author_name">Ваше имя *</label>
                    <input type="text" id="author_name" name="author_name" value="{{ old('author_name') }}" required>
                    @error('author_name')
                        <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="author_email">Email *</label>
                    <input type="email" id="author_email" name="author_email" value="{{ old('author_email') }}" required>
                    @error('author_email')
                        <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Комментарий *</label>
                    <textarea id="content" name="content" required>{{ old('content') }}</textarea>
                    @error('content')
                        <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Отправить комментарий</button>
                </div>
            </form>
        </div>
    </div>
@endsection
