<?php

namespace Tests\Feature;

use App\Livewire\InboxSorter;
use App\Models\Category;
use App\Models\UiInspiration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InboxSorterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_sort_item_correctly_and_transitions_status(): void
    {
        $category = Category::factory()->create(['name' => 'Mobile']);
        $item = UiInspiration::factory()->create([
            'status' => 'inbox',
        ]);

        Livewire::test(InboxSorter::class)
            ->set('title', 'Awesome Design')
            ->set('category_id', $category->id)
            ->set('tagsInput', 'UI Design, mobile, UI DESIGN ')
            ->set('notes', 'Some cool notes')
            ->set('source_url', 'http://example.com')
            ->set('is_favorite', true)
            ->call('sort');

        $item->refresh();

        $this->assertEquals('sorted', $item->status);
        $this->assertEquals('Awesome Design', $item->title);
        $this->assertEquals($category->id, $item->category_id);
        $this->assertEquals('Some cool notes', $item->notes);
        $this->assertEquals('http://example.com', $item->source_url);
        $this->assertTrue($item->is_favorite);

        // Tags should be normalized and deduplicated: 'ui design', 'mobile'
        $this->assertCount(2, $item->tags);
        $this->assertEquals(['ui design', 'mobile'], $item->tags->pluck('name')->toArray());

        // Assert database only has 2 unique tags
        $this->assertDatabaseCount('tags', 2);
    }

    public function test_skip_advances_without_changing_status(): void
    {
        $item1 = UiInspiration::factory()->create(['status' => 'inbox', 'created_at' => now()->subDay()]);
        $item2 = UiInspiration::factory()->create(['status' => 'inbox', 'created_at' => now()]);

        Livewire::test(InboxSorter::class)
            ->assertSet('current.id', $item1->id)
            ->call('skip')
            ->assertSet('current.id', $item2->id);

        $item1->refresh();
        $this->assertEquals('inbox', $item1->status);
    }

    public function test_can_add_category_quick_add(): void
    {
        $item = UiInspiration::factory()->create(['status' => 'inbox']);

        Livewire::test(InboxSorter::class)
            ->set('newCategoryName', 'New Quick Category')
            ->call('addCategory')
            ->assertSet('newCategoryName', '')
            ->assertSet('showAddCategory', false)
            ->assertSet('category_id', Category::where('slug', 'new-quick-category')->first()->id);

        $this->assertDatabaseHas('categories', [
            'name' => 'New Quick Category',
            'slug' => 'new-quick-category',
        ]);
    }

    public function test_can_delete_inspiration_from_inbox(): void
    {
        $item1 = UiInspiration::factory()->create(['status' => 'inbox', 'created_at' => now()->subDay()]);
        $item2 = UiInspiration::factory()->create(['status' => 'inbox', 'created_at' => now()]);

        Livewire::test(InboxSorter::class)
            ->assertSet('current.id', $item1->id)
            ->call('delete')
            ->assertSet('current.id', $item2->id);

        $this->assertDatabaseMissing('ui_inspirations', ['id' => $item1->id]);
    }
}
