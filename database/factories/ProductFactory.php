<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Provider;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'id_provider' => Provider::inRandomOrder()->first()?->id ?? Provider::factory(),
            'id_category' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(10, 200),
            'create_at' => $this->faker->dateTimeBetween('-1 year', '-6 months'),
            'update_at' => $this->faker->dateTimeBetween('-5 months', 'now'),
            'unit_type' => $this->faker->randomElement(['kg', 'g', 'T', 'unit', 'L', 'ml']),
        ];
    }
}
