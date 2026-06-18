<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function uiInspirations(): BelongsToMany
    {
        return $this->belongsToMany(UiInspiration::class, 'inspiration_tag', 'tag_id', 'ui_inspiration_id');
    }
}
