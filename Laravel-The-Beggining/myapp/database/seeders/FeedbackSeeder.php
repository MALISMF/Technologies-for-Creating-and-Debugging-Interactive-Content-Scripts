<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('Please seed users and categories first!');
            return;
        }

        $feedbacks = [
            [
                'title' => 'Отличный продукт!',
                'message' => 'Очень доволен качеством и функциональностью. Рекомендую всем!',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'Хорошее соотношение цена-качество',
                'message' => 'За такую цену получил больше, чем ожидал. Спасибо!',
                'rating' => 4,
                'is_published' => true,
            ],
            [
                'title' => 'Неплохо, но есть что улучшить',
                'message' => 'В целом неплохо, но есть несколько моментов, которые можно доработать.',
                'rating' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'Быстрый и качественный сервис',
                'message' => 'Очень быстро получил помощь, все вопросы решены оперативно.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'Удобный интерфейс',
                'message' => 'Интерфейс интуитивно понятный, легко разобраться даже новичку.',
                'rating' => 4,
                'is_published' => false,
            ],
        ];

        foreach ($feedbacks as $feedbackData) {
            $feedback = Feedback::create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'title' => $feedbackData['title'],
                'message' => $feedbackData['message'],
                'rating' => $feedbackData['rating'],
                'is_published' => $feedbackData['is_published'],
            ]);

            // Привязываем случайные теги
            if ($tags->isNotEmpty()) {
                $randomTags = $tags->random(rand(1, 3));
                $feedback->tags()->attach($randomTags->pluck('id'));
            }
        }
    }
}
