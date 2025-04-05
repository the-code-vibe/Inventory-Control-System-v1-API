<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        Purchase::factory()->count(30)->create();
    }
}
