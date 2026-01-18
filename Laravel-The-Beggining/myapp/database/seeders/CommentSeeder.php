<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $feedbacks = Feedback::all();

        if ($users->isEmpty() || $feedbacks->isEmpty()) {
            $this->command->warn('Please seed users and feedbacks first!');
            return;
        }

        $comments = [
            'Согласен с автором!',
            'Отличный отзыв, спасибо за информацию.',
            'У меня похожий опыт.',
            'Полезная информация, приму к сведению.',
            'Интересная точка зрения.',
            'Спасибо за детальный обзор!',
        ];

        foreach ($feedbacks as $feedback) {
            // Создаем 1-3 комментария для каждого отзыва
            $commentsCount = rand(1, 3);
            
            for ($i = 0; $i < $commentsCount; $i++) {
                $feedback->comments()->create([
                    'user_id' => $users->random()->id,
                    'content' => $comments[array_rand($comments)],
                ]);
            }
        }
    }
}
