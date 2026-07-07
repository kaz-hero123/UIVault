<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryManager extends Component
{
    public ?int $editingId = null;

    public string $editingName = '';

    public function startEdit(int $id): void
    {
        $category = Category::find($id, ['*']);
        if ($category) {
            $this->editingId = $category->id;
            $this->editingName = $category->name;
        }
    }

    public function saveEdit(): void
    {
        if (blank($this->editingName)) {
            return;
        }

        $category = Category::find($this->editingId, ['*']);
        if ($category) {
            $name = trim($this->editingName);
            $slug = Str::slug($name);

            // Validasi agar slug/kategori tidak duplikat dengan yang lain
            $colSlug = 'slug';
            $colId = 'id';
            $exists = Category::where($colSlug, '=', $slug, 'and')
                ->where($colId, '!=', $category->id)
                ->exists();

            if (! $exists) {
                $category->update([
                    'name' => $name,
                    'slug' => $slug,
                ]);
            }
        }

        $this->editingId = null;
        $this->editingName = '';
    }

    public function delete(int $id): void
    {
        $category = Category::find($id, ['*']);
        if ($category) {
            $category->delete();
        }
    }

    public function render()
    {
        $orderCol = 'name';

        return view('livewire.category-manager', [
            'categories' => Category::withCount('uiInspirations')->orderBy($orderCol)->get(),
        ]);
    }
}
