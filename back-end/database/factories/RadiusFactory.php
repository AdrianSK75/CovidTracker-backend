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
        $game = Game::findOrFail(auth()->user()->id);
        return [
            'game_id' => $game->id,
            'latitude' => self::rand_float(-80.99999, 80.99999),
            'longitude' => self::rand_float(-175.99999, 175.99999),
        ];
    }
}
