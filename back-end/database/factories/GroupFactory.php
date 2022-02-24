<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


        return [
            'game_id' => 1,
            'mode' => 1.

        ];
    }
}
