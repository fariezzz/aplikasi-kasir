<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Education',
            'slug' => 'education'
        ]);

        Category::create([
            'name' => 'Tales',
            'slug' => 'tales'
        ]);

        Supplier::factory(5)->create();

        User::factory(10)->create();
        Product::factory(5)->create();

        Transaction::create([
            'user_id' => fake()->numberBetween(1, 11),
            'status' => 'Pending'
        ]);

        User::factory()->create([
            'name' => 'Muhammad Fariez',
            'email' => 'rajameksiko@gmail.com',
            'username' => 'fariez04',
            'password' => bcrypt('12345'),
            'role' => 'Admin'
        ]);

        Order::factory(5)->create();
    }
}
