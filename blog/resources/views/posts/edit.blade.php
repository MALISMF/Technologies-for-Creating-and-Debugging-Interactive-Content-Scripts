@extends('layouts.app')

@section('title', 'Редактировать пост - Блог')

@section('content')
    <h1>Редактировать пост</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Заголовок *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required>
            @error('title')
                <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Содержание *</label>
            <textarea id="content" name="content" required>{{ old('content', $post->content) }}</textarea>
            @error('content')
                <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="published_at">Дата публикации</label>
            <input type="datetime-local" id="published_at" name="published_at" 
                   value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
            @error('published_at')
                <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Статус *</label>
            <select id="status" name="status" required>
                <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Черновик</option>
                <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Опубликовано</option>
            </select>
            @error('status')
                <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn">Обновить пост</button>
            <a href="{{ route('posts.index') }}" class="btn" style="background: #6c757d; margin-left: 10px;">Отмена</a>
        </div>
    </form>
@endsection
