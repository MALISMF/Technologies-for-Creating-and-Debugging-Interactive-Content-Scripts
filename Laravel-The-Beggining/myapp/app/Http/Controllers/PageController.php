<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');  // подключаем home.blade.php
    }

    public function about()
    {
        return view('about'); // подключаем about.blade.php
    }

    public function submitFeedback(Request $request)
    {
        // 1️⃣ Валидация
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'message' => 'required|string|max:500',
        ]);

        // 2️⃣ Сохраняем в JSON-файл с уникальным именем
        $data = [
            'name' => $validated['name'],
            'message' => $validated['message'],
            'created_at' => now()->toDateTimeString(),
        ];

        $filename = 'feedback_' . time() . '_' . uniqid() . '.json';
        $path = storage_path('app/feedback'); // папка storage/app/feedback

        // создаём папку, если не существует
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents($path . '/' . $filename, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // 3️⃣ Перенаправляем с сообщением
        return redirect()->back()->with('success', 'Данные успешно отправлены!');
    }
    
        public function showFeedbacks()
    {
        $path = storage_path('app/feedback');

        $feedbacks = [];

        if (file_exists($path)) {
            $files = scandir($path); // получаем все файлы в папке
            foreach ($files as $file) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['json'])) {
                    $content = file_get_contents($path . '/' . $file);
                    $feedbacks[] = json_decode($content, true);
                }
            }
        }

        return view('feedbacks', ['feedbacks' => $feedbacks]);
    }
}
