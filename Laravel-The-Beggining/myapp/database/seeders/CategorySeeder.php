<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Продукты',
                'slug' => 'products',
                'description' => 'Отзывы о продуктах',
            ],
            [
                'name' => 'Услуги',
                'slug' => 'services',
                'description' => 'Отзывы об услугах',
            ],
            [
                'name' => 'Технологии',
                'slug' => 'technology',
                'description' => 'Отзывы о технологических решениях',
            ],
            [
                'name' => 'Образование',
                'slug' => 'education',
                'description' => 'Отзывы об образовательных программах',
            ],
            [
                'name' => 'Здоровье',
                'slug' => 'health',
                'description' => 'Отзывы о медицинских услугах',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
