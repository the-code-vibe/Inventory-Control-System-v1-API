<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            ProviderSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PurchaseSeeder::class,
            PurchaseRequestSeeder::class,
        ]);
    }
}
