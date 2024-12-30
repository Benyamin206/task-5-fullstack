<?php

namespace Tests\Feature;

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    /**
     * Set up the environment.
     */
    public function setUp(): void
    {
        parent::setUp();
        
        // Create a user and authenticate using Passport
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');  // Ensure authentication
    }

    /** @test */
    public function it_can_create_an_article()
    {
        // Prepare category
        $category = Category::factory()->create();

        // Data to create an article
        $data = [
            'title' => 'New Article',
            'content' => 'This is the content of the article.',
            'category_id' => $category->id,
        ];

        // Send post request to create article
        $response = $this->postJson('/api/v1/articles', $data);

        // Assert the article is created successfully
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'title' => 'New Article',
            'content' => 'This is the content of the article.',
        ]);
    }

    /** @test */
    public function it_can_list_all_articles()
    {
        // Create multiple articles
        Article::factory()->count(5)->create(['user_id' => $this->user->id]);

        // Send GET request to list all articles
        $response = $this->getJson('/api/v1/articles');

        // Assert the response contains articles and status is OK
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'content', 'user_id', 'category_id', 'created_at', 'updated_at'],
            ],
        ]);
    }

    /** @test */
    public function it_can_show_an_article()
    {
        // Create an article
        $article = Article::factory()->create(['user_id' => $this->user->id]);

        // Send GET request to show the article
        $response = $this->getJson("/api/v1/articles/{$article->id}");

        // Assert the response contains article details
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $article->title,
            'content' => $article->content,
        ]);
    }

    /** @test */
    public function it_can_update_an_article()
    {
        // Create an article
        $article = Article::factory()->create(['user_id' => $this->user->id]);

        // Data to update the article
        $data = [
            'title' => 'Updated Title',
            'content' => 'Updated content of the article.',
            'category_id' => $article->category_id,
        ];

        // Send PUT request to update the article
        $response = $this->putJson("/api/v1/articles/{$article->id}", $data);

        // Assert the response status is OK and contains updated data
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => 'Updated Title',
            'content' => 'Updated content of the article.',
        ]);
    }

    /** @test */
    public function it_can_delete_an_article()
    {
        // Create an article
        $article = Article::factory()->create(['user_id' => $this->user->id]);

        // Send DELETE request to delete the article
        $response = $this->deleteJson("/api/v1/articles/{$article->id}");

        // Assert the article is deleted
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Article deleted successfully',
        ]);

        // Assert the article is no longer in the database
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    /** @test */
    public function it_requires_authentication_for_all_articles_operations()
    {
        // Send request without authentication token
        $response = $this->postJson('/api/v1/articles', []);

        // Assert the response is unauthorized
        $response->assertStatus(401);
    }
}
