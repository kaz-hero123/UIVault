<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Tag;
use App\Models\UiInspiration;
use Illuminate\Support\Str;
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

    /**
     * Data yang dikirim ke view untuk FE.
     * - $current: UiInspiration model (atau null kalau inbox kosong)
     * - $categories: semua kategori untuk dropdown
     * - $remainingCount: jumlah sisa di inbox
     */
    public function render()
    {
        $orderCol = 'name';

        return view('livewire.inbox-sorter', [
            'categories' => Category::orderBy($orderCol)->get(),
        ]);
    }

    private function loadNext(): void
    {
        $this->current = UiInspiration::inInbox()
            ->whereNotIn('id', $this->skippedIds)
            ->oldest()
            ->first();
        $this->remainingCount = UiInspiration::inInbox()
            ->whereNotIn('id', $this->skippedIds)
            ->count();
    }

    // Tag normalisasi: trim + lowercase + firstOrCreate
    private function syncTags(): void
    {
        if (! $this->current || blank($this->tagsInput)) {
            return;
        }

        $tagNames = array_filter(
            array_map(fn ($t) => Str::lower(trim($t)), explode(',', $this->tagsInput))
        );

        $tagIds = [];
        foreach ($tagNames as $name) {
            $tagIds[] = Tag::firstOrCreate(['name' => $name])->id;
        }

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
