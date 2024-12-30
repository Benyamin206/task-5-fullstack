<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(3),
            'image' => $this->faker->imageUrl(640, 480, 'articles'),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
