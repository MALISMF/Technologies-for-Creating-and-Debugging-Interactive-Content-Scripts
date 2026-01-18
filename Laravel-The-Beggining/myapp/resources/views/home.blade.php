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
        <input type="text" name="name" value="{{ old('name') }}" required>
    </label>
    <br><br>
    <label>
        Категория:<br>
        <select name="category_id">
            <option value="">Выберите категорию</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </label>
    <br><br>
    <label>
        Сообщение:<br>
        <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
    </label>
    <br><br>
    <label>
        Рейтинг (0-5):<br>
        <input type="number" name="rating" min="0" max="5" value="{{ old('rating', 0) }}">
    </label>
    <br><br>
    <button type="submit">Отправить</button>
</form>
@endsection
