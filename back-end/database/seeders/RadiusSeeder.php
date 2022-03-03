<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Radius;
use App\Models\Group;
use App\Models\GroupsUsers;

class RadiusSeeder extends Seeder
{
    public function run() {
        $group_with_users = GroupsUsers::where('user_id', auth()->user()->id)->first();
        $group = Group::findOrFail($group_with_users->group_id);
        Radius::factory()->times(intval($group->game->difficulty * 50))->create();
    }
}
