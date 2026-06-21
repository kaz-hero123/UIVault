<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Tag;
use App\Models\UiInspiration;
use Livewire\Component;

class InboxSorter extends Component
{
    public ?UiInspiration $current = null;

    // Form fields
    public string $title = '';

    public ?int $category_id = null;

    public string $tagsInput = ''; // comma-separated, e.g. "ui design, branding"

    public string $notes = '';

    public string $source_url = '';

    public bool $is_favorite = false;

    public array $skippedIds = [];

    public int $remainingCount = 0;

    // Quick-add Category properties
    public bool $showAddCategory = false;

    public string $newCategoryName = '';

    public function mount()
    {
        $this->loadNext();
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
        $this->resetForm();
        $this->loadNext();
    }

    public function skip()
    {
        if ($this->current) {
            $this->skippedIds[] = $this->current->id;
        }
        $this->resetForm();
        $this->loadNext();
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
        $this->resetForm();
        $this->loadNext();
    }

    /**
     * Data yang dikirim ke view untuk FE.
     * - $current: UiInspiration model (atau null kalau inbox kosong)
     * - $categories: semua kategori untuk dropdown
     * - $remainingCount: jumlah sisa di inbox
     */
    public function render()
    {
        $orderCol = 'name';
        $colName = 'name';

        return view('livewire.inbox-sorter', [
            'categories' => Category::orderBy($orderCol, 'asc')->get(),
            'existingTags' => Tag::pluck($colName, null)->toArray(),
        ]);
    }

    private function loadNext(): void
    {
        $this->current = UiInspiration::inInbox()
            ->whereNotIn('id', $this->skippedIds, 'and')
            ->oldest()
            ->first();
        $this->remainingCount = UiInspiration::inInbox()
            ->whereNotIn('id', $this->skippedIds, 'and')
            ->count();
    }

    // Tag normalisasi: trim + lowercase + firstOrCreate
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
