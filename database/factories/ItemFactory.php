<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryIds = Category::pluck('id')->toArray();

        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->words(2, true),
            'code' => $this->faker->unique()->bothify('ITEM-###'),
            'category_id' => $this->faker->randomElement($categoryIds),
            'location' => $this->faker->city,
            'description' => $this->faker->optional()->sentence,
            'stock' => $this->faker->numberBetween(0, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
