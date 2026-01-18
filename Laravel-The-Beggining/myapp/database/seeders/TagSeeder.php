<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'качество', 'slug' => 'quality'],
            ['name' => 'цена', 'slug' => 'price'],
            ['name' => 'сервис', 'slug' => 'service'],
            ['name' => 'скорость', 'slug' => 'speed'],
            ['name' => 'удобство', 'slug' => 'convenience'],
            ['name' => 'надежность', 'slug' => 'reliability'],
            ['name' => 'инновации', 'slug' => 'innovation'],
            ['name' => 'поддержка', 'slug' => 'support'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
