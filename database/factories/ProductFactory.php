<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => '1',
            'supplier_id' => fake()->numberBetween(1, 5),
            'name' => fake()->sentence(4, true),
            'code' => fake()->numerify('#-##'),
            'stock' => fake()->numberBetween(1, 10),
            'price' => 10000,
        ];
    }
}
