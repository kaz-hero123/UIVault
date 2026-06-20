<?php

namespace Tests\Feature;

use App\Livewire\ExplorerGrid;
use App\Models\Category;
use App\Models\Tag;
use App\Models\UiInspiration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ExplorerGridTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_only_sorted_items(): void
    {
        $sortedItem = UiInspiration::factory()->create(['status' => 'sorted', 'title' => 'Sorted Dashboard']);
        $inboxItem = UiInspiration::factory()->create(['status' => 'inbox', 'title' => 'Inbox Image']);

        Livewire::test(ExplorerGrid::class)
            ->assertSee('Sorted Dashboard')
            ->assertDontSee('Inbox Image');
    }

    public function test_can_search_by_title(): void
    {
        $item1 = UiInspiration::factory()->create(['status' => 'sorted', 'title' => 'Mobile Login Screen']);
        $item2 = UiInspiration::factory()->create(['status' => 'sorted', 'title' => 'Desktop Settings page']);

        Livewire::test(ExplorerGrid::class)
            ->set('search', 'Login')
            ->assertSee('Mobile Login Screen')
            ->assertDontSee('Desktop Settings page');
    }

    public function test_can_filter_by_category(): void
    {
        $cat1 = Category::factory()->create(['name' => 'Web']);
        $cat2 = Category::factory()->create(['name' => 'Mobile']);

        $item1 = UiInspiration::factory()->create(['status' => 'sorted', 'category_id' => $cat1->id, 'title' => 'Web Design']);
        $item2 = UiInspiration::factory()->create(['status' => 'sorted', 'category_id' => $cat2->id, 'title' => 'Mobile App']);

        Livewire::test(ExplorerGrid::class)
            ->set('category_id', $cat1->id)
            ->assertSee('Web Design')
            ->assertDontSee('Mobile App');
    }

    public function test_can_filter_by_tag(): void
    {
        $tag1 = Tag::factory()->create(['name' => 'dark-mode']);
        $tag2 = Tag::factory()->create(['name' => 'light-mode']);

        $item1 = UiInspiration::factory()->create(['status' => 'sorted', 'title' => 'Dark Page']);
        $item1->tags()->attach($tag1);

        $item2 = UiInspiration::factory()->create(['status' => 'sorted', 'title' => 'Light Page']);
        $item2->tags()->attach($tag2);

        Livewire::test(ExplorerGrid::class)
            ->set('tag_id', $tag1->id)
            ->assertSee('Dark Page')
            ->assertDontSee('Light Page');
    }

    public function test_can_toggle_favorite(): void
    {
        $item = UiInspiration::factory()->create(['status' => 'sorted', 'is_favorite' => false]);

        Livewire::test(ExplorerGrid::class)
            ->call('toggleFavorite', $item->id);

        $item->refresh();
        $this->assertTrue($item->is_favorite);

        Livewire::test(ExplorerGrid::class)
            ->call('toggleFavorite', $item->id);

        $item->refresh();
        $this->assertFalse($item->is_favorite);
    }

    public function test_can_delete_inspiration_from_explorer(): void
    {
        $item = UiInspiration::factory()->create(['status' => 'sorted']);

        Livewire::test(ExplorerGrid::class)
            ->call('deleteInspiration', $item->id);

        $this->assertDatabaseMissing('ui_inspirations', ['id' => $item->id]);
    }

    public function test_can_filter_favorites_only(): void
    {
        $fav = UiInspiration::factory()->create(['status' => 'sorted', 'title' => 'Fav Design', 'is_favorite' => true]);
        $nonFav = UiInspiration::factory()->create(['status' => 'sorted', 'title' => 'Non Fav Design', 'is_favorite' => false]);

        Livewire::test(ExplorerGrid::class)
            ->set('favoritesOnly', true)
            ->assertSee('Fav Design')
            ->assertDontSee('Non Fav Design');
    }
}
