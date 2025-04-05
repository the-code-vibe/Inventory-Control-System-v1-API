<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition()
    {
        $quantity = $this->faker->numberBetween(1, 50);
        $price = $this->faker->randomFloat(2, 10, 1000);

        return [
            'uuid' => Str::uuid(),
            'id_products' => Product::inRandomOrder()->first()?->id ?? Product::factory(),
            'id_providers' => Provider::inRandomOrder()->first()?->id ?? Provider::factory(),
            'quantity' => $quantity,
            'price' => $price,
            'purcharse_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}