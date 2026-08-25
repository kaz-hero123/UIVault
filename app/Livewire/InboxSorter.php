<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Tag;
use App\Models\UiInspiration;
use Livewire\Component;
use Livewire\WithPagination;

class InboxSorter extends Component
{
    use WithPagination;

    public string $mode = 'grid';
    public ?UiInspiration $current = null;

    // Form fields
    public string $title = '';
    public ?int $category_id = null;
    public string $tagsInput = ''; // comma-separated
    public string $notes = '';
    public string $source_url = '';
    public bool $is_favorite = false;

    public array $skippedIds = [];

    // Quick-add Category properties
    public bool $showAddCategory = false;
    public string $newCategoryName = '';

    public function mount()
    {
        // No auto-load next anymore, we start in grid mode.
    }

    public function selectItem(int $id)
    {
        $this->current = UiInspiration::inInbox()->find($id);
        
        if ($this->current) {
            $this->title = $this->current->title ?? '';
            $this->category_id = $this->current->category_id;
            $this->tagsInput = $this->current->tags()->pluck('name')->implode(', ');
            $this->notes = $this->current->notes ?? '';
            $this->source_url = $this->current->source_url ?? '';
            $this->is_favorite = $this->current->is_favorite ?? false;
            $this->mode = 'sort';
        }
    }

    public function backToGrid()
    {
        $this->resetForm();
        $this->current = null;
        $this->mode = 'grid';
    }

    public function sort()
    {
        if (! $this->current) {
            return;
        }

        $this->current->update([
            'title' => $this->title ?: null,
            'category_id' => $this->category_id,
            'notes' => $this->notes ?: null,
            'source_url' => $this->source_url ?: null,
            'is_favorite' => $this->is_favorite,
            'status' => 'sorted',
        ]);

        $this->syncTags();
        $this->backToGrid();
    }

    public function skip()
    {
        if ($this->current) {
            $this->skippedIds[] = $this->current->id;
        }
        $this->backToGrid();
    }

    public function toggleFavorite()
    {
        $this->is_favorite = ! $this->is_favorite;
    }

    public function addCategory()
    {
        if (blank($this->newCategoryName)) {
            return;
        }

        $category = Category::firstOrCreateFromName($this->newCategoryName);
        $this->category_id = $category->id;
        $this->newCategoryName = '';
        $this->showAddCategory = false;
    }

    public function delete()
    {
        if (! $this->current) {
            return;
        }

        UiInspiration::destroy($this->current->id);
        $this->backToGrid();
    }

    public function render()
    {
        $orderCol = 'name';
        $colName = 'name';

        $inboxItems = [];
        $remainingCount = 0;

        if ($this->mode === 'grid') {
            $query = UiInspiration::inInbox()->whereNotIn('id', $this->skippedIds, 'and');
            $remainingCount = (clone $query)->count();
            $inboxItems = $query->oldest()->paginate(24);
        } else {
            $remainingCount = UiInspiration::inInbox()->whereNotIn('id', $this->skippedIds, 'and')->count();
        }

        return view('livewire.inbox-sorter', [
            'categories' => Category::orderBy($orderCol, 'asc')->get(),
            'existingTags' => Tag::pluck($colName, null)->toArray(),
            'inboxItems' => $inboxItems,
            'remainingCount' => $remainingCount,
        ]);
    }

    private function syncTags(): void
    {
        if (! $this->current || blank($this->tagsInput)) {
            return;
        }

        $tagIds = Tag::syncManyFromInput($this->tagsInput);
        $this->current->tags()->sync($tagIds);
    }

    private function resetForm(): void
    {
        $this->title = '';
        $this->category_id = null;
        $this->tagsInput = '';
        $this->notes = '';
        $this->source_url = '';
        $this->is_favorite = false;
    }
}
