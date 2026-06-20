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

    public bool $favoritesOnly = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'category_id' => ['except' => null],
        'tag_id' => ['except' => null],
        'favoritesOnly' => ['except' => false],
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

    public function updatingFavoritesOnly()
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

    public function deleteInspiration(int $id): void
    {
        $inspiration = UiInspiration::find($id);
        if ($inspiration) {
            $inspiration->delete();
        }
    }

    public function render()
    {
        $query = UiInspiration::sorted();

        if (! empty($this->search)) {
            $colTitle = 'title';
            $query->where($colTitle, 'like', '%'.$this->search.'%');
        }

        if ($this->category_id !== null) {
            $colCategoryId = 'category_id';
            $query->where($colCategoryId, $this->category_id);
        }

        if ($this->tag_id !== null) {
            $query->whereHas('tags', function ($q) {
                $colTagsId = 'tags.id';
                $q->where($colTagsId, $this->tag_id);
            });
        }

        if ($this->favoritesOnly) {
            $colIsFavorite = 'is_favorite';
            $query->where($colIsFavorite, true);
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
