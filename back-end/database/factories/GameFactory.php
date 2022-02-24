<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
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

            return [
                'user_id' => 1,
                "address" => $this->faker->name(),
                'difficulty' => 1,
                'latitude' => self::rand_float(-80.99999, 80.99999),
                'longitude' => self::rand_float(-175.99999, 175.99999)
            ];
    }
}
