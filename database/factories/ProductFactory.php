<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
        // produk acak baik nama, harga, dan stok
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 1000), // Harga antara 10 dan 1000
            'stock' => $this->faker->numberBetween(1, 100), // Stok antara 1 dan 100
            // 'category_id' => \App\Models\Category::inRandomOrder()->value('id'), // Kategori acak dari tabel categories
        ];
    }
}
