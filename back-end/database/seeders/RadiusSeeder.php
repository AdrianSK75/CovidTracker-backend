<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Radius;
use App\Models\Game;

class RadiusSeeder extends Seeder
{
    public function run()
    {
        Radius::factory()->times(30)->create();
    }
}
