<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseRequest;

class PurchaseRequestSeeder extends Seeder
{
    public function run()
    {
        PurchaseRequest::factory()->count(15)->create();
    }
}
