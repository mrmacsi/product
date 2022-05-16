<?php

namespace Database\Seeders;

use App\Models\ShipmentCost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShipmentCost::factory()->create([
            'cost' => 10,
            'active' => 1
        ]);
    }
}
