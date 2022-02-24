<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupsUsersFactory extends Factory
{

    public function definition()
    {
        return [
            'group_id' => 1,
            'user_id' => mt_rand(1, 3)
        ];
    }
}
