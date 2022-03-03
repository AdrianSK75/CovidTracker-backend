<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;
use App\Models\Group;
use App\Models\GroupsUsers;

class RadiusFactory extends Factory
{
    public function rand_float($left = 0, $right = 1, $mul = 1000000)
    {
        if ($left > $right) {
            $aux = $left;
            $left = $right;
            $right = $aux;
        }
        return mt_rand($left * $mul, $right * $mul) / $mul;
    }

    public function definition()
    {
        $group_with_users = GroupsUsers::where('user_id', auth()->user()->id)->first();
        $group = Group::findOrFail($group_with_users->group_id);
        return [
            'game_id' => $group->game->id,
            'latitude' => self::rand_float(-80.99999, 80.99999),
            'longitude' => self::rand_float(-175.99999, 175.99999),
        ];
    }
}
