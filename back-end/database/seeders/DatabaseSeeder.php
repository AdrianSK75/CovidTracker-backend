<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        //$this->call(RadiusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GameSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(GroupsUsersSeeder::class);
    }
}
