<?php

namespace Tests\Feature;

use App\Livewire\CategoryManager;
use App\Models\Category;
use App\Models\UiInspiration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_categories(): void
    {
        Category::factory()->create(['name' => 'Web Design']);

        Livewire::test(CategoryManager::class)
            ->assertSee('Web Design');
    }

    public function test_can_edit_category_name_and_slug(): void
    {
        $category = Category::factory()->create(['name' => 'Old Name', 'slug' => 'old-name']);

        Livewire::test(CategoryManager::class)
            ->call('startEdit', $category->id)
            ->assertSet('editingId', $category->id)
            ->assertSet('editingName', 'Old Name')
            ->set('editingName', ' New Cool Name ')
            ->call('saveEdit')
            ->assertSet('editingId', null)
            ->assertSet('editingName', '');

        $category->refresh();
        $this->assertEquals('New Cool Name', $category->name);
        $this->assertEquals('new-cool-name', $category->slug);
    }

    public function test_can_delete_category_nullifies_associated_inspirations(): void
    {
        $category = Category::factory()->create(['name' => 'Mobile']);
        $inspiration = UiInspiration::factory()->create([
            'category_id' => $category->id,
            'status' => 'sorted',
        ]);

        Livewire::test(CategoryManager::class)
            ->call('delete', $category->id);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);

        $inspiration->refresh();
        $this->assertNull($inspiration->category_id);
    }
}
