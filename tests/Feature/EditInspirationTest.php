<?php

namespace Tests\Feature;

use App\Livewire\EditInspiration;
use App\Models\Category;
use App\Models\UiInspiration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditInspirationTest extends TestCase
{
    use RefreshDatabase;

    public function test_mount_fills_properties(): void
    {
        $category = Category::factory()->create(['name' => 'Web']);
        $inspiration = UiInspiration::factory()->create([
            'title' => 'Initial Title',
            'category_id' => $category->id,
            'notes' => 'Old notes',
            'source_url' => 'http://old.com',
            'is_favorite' => false,
            'status' => 'sorted',
        ]);
        $inspiration->tags()->create(['name' => 'clean']);

        Livewire::test(EditInspiration::class, ['inspiration' => $inspiration])
            ->assertSet('title', 'Initial Title')
            ->assertSet('category_id', $category->id)
            ->assertSet('tagsInput', 'clean')
            ->assertSet('notes', 'Old notes')
            ->assertSet('source_url', 'http://old.com')
            ->assertSet('is_favorite', false);
    }

    public function test_can_save_updates_and_redirects(): void
    {
        $category = Category::factory()->create(['name' => 'Web']);
        $inspiration = UiInspiration::factory()->create([
            'status' => 'sorted',
        ]);

        Livewire::test(EditInspiration::class, ['inspiration' => $inspiration])
            ->set('title', 'Updated Title')
            ->set('category_id', $category->id)
            ->set('tagsInput', 'clean, simple')
            ->set('notes', 'New notes')
            ->set('source_url', 'http://new.com')
            ->set('is_favorite', true)
            ->call('save')
            ->assertRedirect(route('explorer'));

        $inspiration->refresh();
        $this->assertEquals('Updated Title', $inspiration->title);
        $this->assertEquals($category->id, $inspiration->category_id);
        $this->assertEquals('New notes', $inspiration->notes);
        $this->assertEquals('http://new.com', $inspiration->source_url);
        $this->assertTrue($inspiration->is_favorite);

        $this->assertEquals(['clean', 'simple'], $inspiration->tags->pluck('name')->toArray());
    }
}
