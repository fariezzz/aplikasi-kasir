<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 11),
            'customer_id' => fake()->numberBetween(1, 8),
            'code' => fake()->numerify('#-##'),
            'date' => now(),
            'total_price' => 0,
            'status' => 'Pending'
        ];
    }
}
