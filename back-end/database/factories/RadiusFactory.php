<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;

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
        $game = Game::findOrFail(1);
        return [
            'latitude' => self::rand_float($game->latitude / 2, $game->latitude * 2),
            'longitude' => self::rand_float($game->longitude / 2, $game->longitude * 2),
        ];
    }
}
