<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProviderFactory extends Factory
{
    protected $model = Provider::class;

    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->company,
            'contact' => $this->faker->phoneNumber,
            'cnpj' => str_pad($this->faker->randomNumber(9), 14, '0', STR_PAD_LEFT),
        ];
    }
}
