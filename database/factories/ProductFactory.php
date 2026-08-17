<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $price = fake()->numberBetween(8, 120) * 1000; // Rp 8.000 - Rp 120.000
        $hasDiscount = fake()->boolean(30);

        return [
            'category_id' => Category::factory(),
            'name' => Str::title($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'price' => $price,
            'discount_price' => $hasDiscount ? (int) ($price * fake()->randomFloat(2, 0.7, 0.9)) : null,
            'stock' => fake()->numberBetween(0, 100),
            'weight' => fake()->randomElement(['100 gram', '150 gram', '250 gram', '500 gram', '1 pcs', '1 box (6 pcs)']),
            'description' => fake()->paragraph(4),
            'information' => fake()->paragraph(2),
            'is_active' => true,
            'is_featured' => fake()->boolean(20),
            'is_new' => fake()->boolean(25),
            'sold_count' => fake()->numberBetween(0, 500),
        ];
    }
}
