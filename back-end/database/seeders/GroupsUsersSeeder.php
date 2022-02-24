<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GroupsUsers;

class GroupsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 3; ++$i) {
                GroupsUsers::factory()->create();
        }
    }
}
