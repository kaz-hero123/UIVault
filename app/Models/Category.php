<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function uiInspirations(): HasMany
    {
        return $this->hasMany(UiInspiration::class);
    }

    /**
     * Cari atau buat category berdasarkan nama, dengan normalisasi trim.
     * Dipakai oleh InboxSorter::addCategory() dan CategoryManager::saveEdit().
     * Sesuai ARCHITECTURE.md D11 — logic milik domain entity ini sendiri,
     * bukan Service terpisah.
     */
    public static function firstOrCreateFromName(string $name): static
    {
        $name = trim($name);
        $slug = Str::slug($name);

        return static::firstOrCreate(
            ['slug' => $slug],
            ['name' => $name]
        );
    }
}
