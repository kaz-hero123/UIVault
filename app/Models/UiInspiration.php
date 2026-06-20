<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class UiInspiration extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'category_id',
        'status',
        'is_favorite',
        'notes',
        'source_url',
        'dominant_colors',
    ];

    protected $casts = [
        'dominant_colors' => 'array',
        'is_favorite' => 'boolean',
    ];

    /**
     * Saat item dihapus, hapus juga file gambarnya dari disk.
     * Sesuai ARCHITECTURE.md D9 — satu sumber kebenaran, tidak diulang
     * di tiap Livewire component yang memanggil delete().
     */
    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function (UiInspiration $item) {
            Storage::disk('public')->delete($item->image_path);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'inspiration_tag', 'ui_inspiration_id', 'tag_id');
    }

    public function scopeInInbox(Builder $query): Builder
    {
        $colStatus = 'status';

        return $query->where($colStatus, 'inbox');
    }

    public function scopeSorted(Builder $query): Builder
    {
        $colStatus = 'status';

        return $query->where($colStatus, 'sorted');
    }
}
