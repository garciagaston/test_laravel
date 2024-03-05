<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'api' => preg_replace('/\.$/', '', $this->faker->sentence(2)),
            'description' => $this->faker->text(250),
            'link' => $this->faker->url(),
            'category_id' => optional(Category::inRandomOrder()->first())->id ?? Category::factory()->create()->id,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
