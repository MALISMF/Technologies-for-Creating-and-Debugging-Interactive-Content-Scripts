<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаем пользователей
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(5)->create();

        // Заполняем данные в правильном порядке (с учетом связей)
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            FeedbackSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
