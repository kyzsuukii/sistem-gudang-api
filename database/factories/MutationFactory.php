<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Mutation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mutation>
 */
class MutationFactory extends Factory
{
    protected $model = Mutation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['in', 'out']);
        $quantity = $this->faker->numberBetween(1, 20);

        $userIds = User::pluck('id')->toArray();
        $itemIds = Item::pluck('id')->toArray();

        return [
            'id' => $this->faker->uuid,
            'date' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s'),
            'type' => $type,
            'quantity' => $quantity,
            'user_id' => $this->faker->randomElement($userIds),
            'item_id' => $this->faker->randomElement($itemIds),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
