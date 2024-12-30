<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_article()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();

        $article = Article::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('articles', [
            'title' => $article->title,
        ]);
    }

    public function test_can_update_article()
    {
        $article = Article::factory()->create();

        $updatedTitle = 'Updated Title';
        $article->update(['title' => $updatedTitle]);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $updatedTitle,
        ]);
    }

    public function test_can_delete_article()
    {
        $article = Article::factory()->create();

        $article->delete();

        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }

    public function test_article_belongs_to_category()
    {
        $article = Article::factory()->create();

        $this->assertInstanceOf(Category::class, $article->category);
    }

    public function test_article_belongs_to_user()
    {
        $article = Article::factory()->create();

        $this->assertInstanceOf(User::class, $article->user);
    }
}
