<?php


namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_can_create_a_category()
    {
        // Buat user untuk relasi user_id
        $user = User::factory()->create();

        // Data kategori baru
        $data = [
            'name' => 'Test Category',
            'user_id' => $user->id,
        ];

        // Simpan kategori
        $category = Category::create($data);

        // Assert kategori berhasil dibuat
        $this->assertDatabaseHas('categories', $data);
        $this->assertEquals('Test Category', $category->name);
    }

    /** @test */
    public function test_it_can_read_categories()
    {
        // Buat kategori menggunakan factory
        $categories = Category::factory(3)->create();

        // Ambil semua kategori
        $fetchedCategories = Category::all();

        // Assert jumlah kategori sama dengan yang dibuat
        $this->assertCount(3, $fetchedCategories);
        $this->assertEquals($categories->pluck('name'), $fetchedCategories->pluck('name'));
    }

    /** @test */
    public function test_it_can_update_a_category()
    {
        // Buat kategori
        $category = Category::factory()->create([
            'name' => 'Old Name',
        ]);

        // Update nama kategori
        $category->update(['name' => 'Updated Name']);

        // Assert perubahan disimpan ke database
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Name',
        ]);
        $this->assertEquals('Updated Name', $category->fresh()->name);
    }

    /** @test */
    public function test_it_can_delete_a_category()
    {
        // Buat kategori
        $category = Category::factory()->create();

        // Hapus kategori
        $category->delete();

        // Assert kategori dihapus dari database
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
