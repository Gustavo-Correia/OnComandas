<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(3, true);
        $price = fake()->randomFloat(2, 10, 100);
        $cost = $price * 0.6; // 40% de margem

        return [
            'company_id' => Company::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'sku' => strtoupper(fake()->bothify('???-####')),
            'price' => $price,
            'cost' => $cost,
            'stock' => fake()->numberBetween(0, 100),
            'min_stock' => 10,
            'active' => true,
            'featured' => fake()->boolean(20),
        ];
    }
}
