<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Tag;
use App\Models\UiInspiration;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ExplorerGrid extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $category_id = null;

    public ?int $tag_id = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'category_id' => ['except' => null],
        'tag_id' => ['except' => null],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function updatingTagId()
    {
        $this->resetPage();
    }

    public function toggleFavorite(int $id): void
    {
        $inspiration = UiInspiration::find($id);
        if ($inspiration) {
            $inspiration->update([
                'is_favorite' => ! $inspiration->is_favorite,
            ]);
        }
    }

    public function render()
    {
        $query = UiInspiration::sorted();

        if (! empty($this->search)) {
            $column = 'title';
            $query->where($column, 'like', '%'.$this->search.'%');
        }

        if ($this->category_id !== null) {
            $column = 'category_id';
            $query->where($column, $this->category_id);
        }

        if ($this->tag_id !== null) {
            $query->whereHas('tags', function ($q) {
                $column = 'tags.id';
                $q->where($column, $this->tag_id);
            });
        }

        $inspirations = $query->with(['category', 'tags'])->latest()->paginate(12);

        // Transform results to match the contract in VIEW_CONTRACT.md
        $inspirations->getCollection()->transform(function ($item) {
            return (object) [
                'id' => $item->id,
                'title' => $item->title,
                'image_url' => Storage::url($item->image_path),
                'dominant_colors' => $item->dominant_colors ?? [],
                'category' => $item->category ? $item->category->name : null,
                'tags' => $item->tags->pluck('name')->toArray(),
                'is_favorite' => (bool) $item->is_favorite,
                'notes' => $item->notes,
                'source_url' => $item->source_url,
            ];
        });

        $orderCol = 'name';

        return view('livewire.explorer-grid', [
            'inspirations' => $inspirations,
            'categories' => Category::orderBy($orderCol)->get(),
            'tags' => Tag::orderBy($orderCol)->get(),
        ]);
    }
}
