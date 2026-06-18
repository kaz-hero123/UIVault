<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        $column = 'status';

        return $query->where($column, 'inbox');
    }

    public function scopeSorted(Builder $query): Builder
    {
        $column = 'status';

        return $query->where($column, 'sorted');
    }
}
