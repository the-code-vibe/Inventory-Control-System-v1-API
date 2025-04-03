<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'avatar' => 'https://i.pravatar.cc/150?img=' . rand(1, 70),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password_hash' => Hash::make('123456'),
            'phone' => $this->faker->phoneNumber,
            'role' => $this->faker->randomElement(['admin', 'stockkeeper']),
            'status' => $this->faker->randomElement([1, 0]),
            'code_verification_account' => Str::random(10),
        ];
    }
}
