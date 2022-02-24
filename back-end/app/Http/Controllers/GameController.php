<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Radius;
use App\Models\Game;
//use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller {
    public function refresh($game, $id) {
        if (count($game) > 0) {
                Radius::where('game_id', $id)->delete();
        }
        return response()->json([
            "status" => 200,
        ]);
    }
    public function game($game_id) {
        $game = Game::where('user_id', $game_id)->first();
        //return $game->radii;
        self::refresh($game->radii, $game->id);
        Radius::factory()->times(intval($game->difficulty * 33.34))->create();
        $radius = Radius::where('game_id', $game->id)->get();
        $location = Game::where('user_id', auth()->user()->id)->select('latitude', 'longitude')->first();
        return response()->json([
            "status" => 200,
            "game" => [
                        'radii' => $radius,
                        'location' => $location
                    ],
            "message" => "Game Created Successfully"
        ]);
    }

    public function store(Request $request) {
            $validator = Validator::make($request->all(), [
                'difficulty' => 'required',
                'address' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
            ]);

            if($validator->fails()) {
                return response()->json(["status" => 422,
                "message" => "Validation error",
                "errors" => $validator->errors()]);
            }
            Game::create([
                'user_id' => Auth::id(),
                'difficulty' => $request->input("difficulty"),
                'address' => $request->input("address"),
                'latitude' => $request->input("latitude"),
                'longitude' => $request->input("longitude")
            ]);
            return response()->json([
                "status" => 200,
                "message" => "Game Created Successfully"
            ]);
    }

    public function delete() {
            $game = DB::where('user_id', auth()->user()->id)->first();
            if (count(Radius::where('game_id', $game->id)->get()) > 0) {
                    //self::refresh($game);
            }
            $game->delete();

            return response([
               "message" => "The game was deleted"
            ], 200);
    }
}

