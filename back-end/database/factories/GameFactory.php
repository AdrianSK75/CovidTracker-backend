<?php

namespace Database\Factories;

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
            'difficulty' => rand(1, 3),
            'latitude' => 46.77070,
            'longitude' => 23.60616,
        ];
    }
}
//self::rand_float(-85.00, 85.99)
//self::rand_float(-170.00, 176.99)
