<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Radius;
use App\Models\Game;
use Illuminate\Support\Facades\Artisan;
//use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller {
    public function refresh($radii, $id) {
        if (count($radii) > 0) {
                Radius::where('game_id', $id)->delete();
        }
        return response()->json([
            "status" => 200,
        ]);
    }
    public function game($game_id) {
       // return $game_id;
        $game = Game::findOrFail($game_id);
        //return $game;
        //return $game->radii;
        self::refresh($game->radii, $game->id);
        $migrate = Artisan::call('db:seed --class=RadiusSeeder');
        $radius = Radius::where('game_id', $game->id)->get();
        $location = $game->select('latitude', 'longitude')->first();
        return response()->json([
            "status" => 200,
            "for group" => $game_id,
            "game" => [
                        'migrate' => $migrate,
                        'radii' => $radius,
                        'location' => $location
                    ],
            "message" => "Game Created Successfully"
        ]);
    }

    public function store($request) {
            $validator = Validator::make($request->all(), [
                'difficulty' => 'required',
                'name' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(["status" => 422,
                "message" => "Validation error",
                "errors" => $validator->errors()]);
            }
            $game = Game::create([
                'user_id' => Auth::id(),
                'difficulty' => $request->input("difficulty"),
                'name' => $request->input("name"),
                'latitude' => $request->input("latitude"),
                'longitude' => $request->input("longitude")
            ]);
            return response($game);
    }

}

