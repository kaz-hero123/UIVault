<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function uiInspirations(): BelongsToMany
    {
        return $this->belongsToMany(UiInspiration::class, 'inspirations_tag', 'tag_id', 'ui_inspiration_id');
    }
}
