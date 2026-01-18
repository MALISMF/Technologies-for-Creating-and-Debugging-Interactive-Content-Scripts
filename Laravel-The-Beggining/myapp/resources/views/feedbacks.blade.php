@extends('layouts.app')

@section('title', 'Все сообщения')

@section('content')
<h1>Все сообщения</h1>

@if ($feedbacks->count() === 0)
    <p>Пока нет опубликованных отзывов.</p>
@else
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>Имя</th>
                <th>Заголовок</th>
                <th>Сообщение</th>
                <th>Категория</th>
                <th>Рейтинг</th>
                <th>Теги</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->user->name }}</td>
                    <td>{{ $feedback->title }}</td>
                    <td>{{ $feedback->message }}</td>
                    <td>{{ $feedback->category->name }}</td>
                    <td>
                        @for($i = 0; $i < 5; $i++)
                            @if($i < $feedback->rating)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                        ({{ $feedback->rating }})
                    </td>
                    <td>
                        @if($feedback->tags->count() > 0)
                            @foreach($feedback->tags as $tag)
                                <span style="background-color: #e0e0e0; padding: 2px 5px; margin: 2px; border-radius: 3px;">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        @else
                            <span style="color: #999;">нет тегов</span>
                        @endif
                    </td>
                    <td>{{ $feedback->created_at->format('d.m.Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
