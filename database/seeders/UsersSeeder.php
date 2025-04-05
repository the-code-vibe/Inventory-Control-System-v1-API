<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(20)->create();

        // User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'vitorgabrieldeoliveiradev@gmail.com',
        //     'password_hash' => Hash::make('123456'),
        //     'role' => 'admin',
        //     'status' => 1,
        // ]);
    }
}
