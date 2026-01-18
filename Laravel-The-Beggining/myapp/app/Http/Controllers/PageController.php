<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        return view('home', compact('categories'));
    }

    public function about()
    {
        return view('about');
    }

    public function submitFeedback(Request $request)
    {
        // 1️⃣ Валидация
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'message' => 'required|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'rating' => 'nullable|integer|min:0|max:5',
        ]);

        // 2️⃣ Получаем или создаем пользователя
        $user = User::firstOrCreate(
            ['email' => strtolower(str_replace(' ', '_', $validated['name'])) . '@feedback.local'],
            [
                'name' => $validated['name'],
                'password' => bcrypt('password')
            ]
        );

        // 3️⃣ Получаем категорию (по умолчанию первую)
        $categoryId = $validated['category_id'] ?? Category::first()?->id;

        if (!$categoryId) {
            return redirect()->back()->withErrors(['category_id' => 'Необходимо выбрать категорию. Сначала создайте категории через API или сидеры.']);
        }

        // 4️⃣ Создаем отзыв в базе данных
        $feedback = Feedback::create([
            'user_id' => $user->id,
            'category_id' => $categoryId,
            'title' => 'Отзыв от ' . $validated['name'],
            'message' => $validated['message'],
            'rating' => $validated['rating'] ?? 0,
            'is_published' => false, // По умолчанию не опубликован
        ]);

        // 5️⃣ Перенаправляем с сообщением
        return redirect()->back()->with('success', 'Отзыв успешно отправлен!');
    }
    
    public function showFeedbacks()
    {
        $feedbacks = Feedback::with(['user', 'category', 'tags'])
            ->published()
            ->recent()
            ->get();

        return view('feedbacks', compact('feedbacks'));
    }
}
