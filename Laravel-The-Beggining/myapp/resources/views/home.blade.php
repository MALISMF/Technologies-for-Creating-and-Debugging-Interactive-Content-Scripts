@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<h1>Форма обратной связи</h1>

<!-- Вывод ошибок -->
@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Успешное сообщение -->
@if (session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('feedback.submit') }}">
    @csrf
    <label>
        Имя:<br>
        <input type="text" name="name" value="{{ old('name') }}">
    </label>
    <br><br>
    <label>
        Сообщение:<br>
        <textarea name="message">{{ old('message') }}</textarea>
    </label>
    <br><br>
    <button type="submit">Отправить</button>
</form>
@endsection
