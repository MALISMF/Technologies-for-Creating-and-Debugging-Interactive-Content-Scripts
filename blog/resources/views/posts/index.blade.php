@extends('layouts.app')

@section('title', 'Главная - Блог')

@section('content')
    <h1>Блог</h1>
    
    <div style="margin-bottom: 20px;">
        <a href="{{ route('posts.create') }}" class="btn">Создать новый пост</a>
    </div>

    @forelse($posts as $post)
        <div class="card">
            <h2><a href="{{ route('posts.show', $post) }}" style="color: #333; text-decoration: none;">{{ $post->title }}</a></h2>
            <div class="card-meta">
                Опубликовано: {{ $post->published_at->format('d.m.Y H:i') }}
            </div>
            <p>{{ \Illuminate\Support\Str::limit($post->content, 200) }}</p>
            <div style="margin-top: 15px;">
                <a href="{{ route('posts.show', $post) }}" class="btn">Читать далее</a>
                <a href="{{ route('posts.edit', $post) }}" class="btn" style="background: #28a745;">Редактировать</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                </form>
            </div>
        </div>
    @empty
        <div class="card">
            <p>Пока нет опубликованных постов.</p>
        </div>
    @endforelse

    <div class="pagination">
        {{ $posts->links() }}
    </div>
@endsection
