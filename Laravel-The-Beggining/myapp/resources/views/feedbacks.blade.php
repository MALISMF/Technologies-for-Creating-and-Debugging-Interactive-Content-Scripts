@extends('layouts.app')

@section('title', 'Все сообщения')

@section('content')
<h1>Все сообщения</h1>

@if (count($feedbacks) === 0)
    <p>Пока нет сообщений.</p>
@else
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Сообщение</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback['name'] }}</td>
                    <td>{{ $feedback['message'] }}</td>
                    <td>{{ $feedback['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
