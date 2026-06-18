<?php

namespace Database\Factories;

use App\Models\UiInspiration;
use Illuminate\Database\Eloquent\Factories\Factory;

class UiInspirationFactory extends Factory
{
    protected $model = UiInspiration::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'image_path' => 'inspirations/'.$this->faker->uuid().'.jpg',
            'category_id' => null,
            'status' => 'inbox',
            'is_favorite' => $this->faker->boolean(),
            'notes' => $this->faker->paragraph(),
            'source_url' => $this->faker->url(),
            'dominant_colors' => ['#ffffff', '#000000'],
        ];
    }
}
