<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function uiInspirations(): BelongsToMany
    {
        return $this->belongsToMany(UiInspiration::class, 'inspiration_tag', 'tag_id', 'ui_inspiration_id');
    }

    /**
     * Parse input koma-separated, normalisasi (trim + lowercase), lalu
     * firstOrCreate tiap tag. Return array of tag IDs siap untuk sync().
     *
     * Dipakai bersama oleh InboxSorter dan EditInspiration.
     * Sesuai ARCHITECTURE.md D11 — satu sumber kebenaran, tidak diduplikasi
     * di tiap component.
     *
     * @return int[]
     */
    public static function syncManyFromInput(string $input): array
    {
        $tagNames = array_filter(
            array_map(fn ($t) => Str::lower(trim($t)), explode(',', $input))
        );

        $tagIds = [];
        foreach ($tagNames as $name) {
            $tagIds[] = static::firstOrCreate(['name' => $name])->id;
        }

        return $tagIds;
    }
}
