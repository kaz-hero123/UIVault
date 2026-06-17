<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class UiInspiration extends Model
{
protected $fillable = [ 'title','image_path','category_id','status','is_favorite','notes','source_url','dominant_colors'];

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
        return $this->belongsToMany(Tag::class, 'inspirations_tag', 'ui_inspiration_id', 'tag_id');
    }

    public function scopeInInbox(Builder $query): Builder
    {
        return $query->where('status','inbox');
    }

    public function scopeSorted(Builder $query): Builder
    {
        return $query->where('status','sorted');
    }

}
