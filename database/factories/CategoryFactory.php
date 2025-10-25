<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(2, true);
        
        $colors = [
            '#EF4444', // red
            '#F59E0B', // amber
            '#10B981', // green
            '#3B82F6', // blue
            '#8B5CF6', // purple
            '#EC4899', // pink
        ];

        $icons = [
            'pizza', 'burger', 'drink', 'dessert', 'salad', 
            'pasta', 'coffee', 'beer', 'wine', 'ice-cream'
        ];

        return [
            'company_id' => Company::factory(),
            'parent_id' => null,
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'icon' => fake()->randomElement($icons),
            'color' => fake()->randomElement($colors),
            'active' => true,
        ];
    }

    /**
     * Categoria com subcategorias
     */
    public function withChildren(int $count = 3)
    {
        return $this->has(
            Category::factory()->count($count),
            'children'
        );
    }
}
