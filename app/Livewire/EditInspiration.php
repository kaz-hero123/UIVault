<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Tag;
use App\Models\UiInspiration;
use Livewire\Component;

class EditInspiration extends Component
{
    public UiInspiration $inspiration;

    public string $title = '';

    public ?int $category_id = null;

    public string $tagsInput = '';

    public string $notes = '';

    public string $source_url = '';

    public bool $is_favorite = false;

    public function mount(UiInspiration $inspiration): void
    {
        $this->inspiration = $inspiration;
        $this->title = $inspiration->title ?? '';
        $this->category_id = $inspiration->category_id;
        $this->tagsInput = $inspiration->tags->pluck('name')->implode(', ');
        $this->notes = $inspiration->notes ?? '';
        $this->source_url = $inspiration->source_url ?? '';
        $this->is_favorite = (bool) $inspiration->is_favorite;
    }

    public function save()
    {
        $this->inspiration->update([
            'title' => $this->title ?: null,
            'category_id' => $this->category_id,
            'notes' => $this->notes ?: null,
            'source_url' => $this->source_url ?: null,
            'is_favorite' => $this->is_favorite,
        ]);

        $tagIds = Tag::syncManyFromInput($this->tagsInput);
        $this->inspiration->tags()->sync($tagIds);

        return redirect()->route('explorer');
    }

    public function render()
    {
        $orderCol = 'name';

        return view('livewire.edit-inspiration', [
            'categories' => Category::orderBy($orderCol)->get(),
            'existingTags' => Tag::pluck('name')->toArray(),
        ]);
    }
}
