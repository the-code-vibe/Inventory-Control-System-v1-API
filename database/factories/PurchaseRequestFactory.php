<?php

namespace Database\Factories;

use App\Models\PurchaseRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PurchaseRequestFactory extends Factory
{
    protected $model = PurchaseRequest::class;

    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'id_products' => Product::inRandomOrder()->first()?->id ?? Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'requested_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
