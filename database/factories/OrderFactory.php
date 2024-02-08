<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->numerify('A-##'),
            'transaction_id' => 1,
            'product_id' => fake()->numberBetween(1, 5),
            'user_id' => fake()->numberBetween(1, 11),
            'quantity' => fake()->numberBetween(1, 20),
            'total_price' => 100000
        ];
    }
}
