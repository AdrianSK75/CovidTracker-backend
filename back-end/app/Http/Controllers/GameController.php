<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Radius;
use App\Models\Game;
use Illuminate\Support\Facades\Artisan;

class GameController extends Controller {
    public function game() {
        $migrate = Artisan::call("migrate:refresh --path=/database/migrations/2021_11_13_080654_create_radii_table.php");
        $seed = Artisan::call('db:seed --class=RadiusSeeder');
        $radius = DB::table('radii')->select('latitude', 'longitude')->get();
        $location = DB::table('games')->select('latitude', 'longitude')->first();
        return response()->json([
            "status" => 200,
            "game" => [
                        'migrate' => $migrate,
                        'seed' => $seed,
                        'radii' => $radius,
                        'location' => $location
                    ],
            "message" => "Game Created Successfully"
        ]);
    }

    public function refresh() {
        $migrate = Artisan::call('migrate:refresh');
        return response()->json([
            "status" => 200,
            "data" => ["migrate" => $migrate]
        ]);
    }

    public function store(Request $request) {
            $validator = Validator::make($request->all(), [
                'difficulty' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
            ]);

            if($validator->fails()) {
                return response()->json(["status" => 422,
                "message" => "Validation error",
                "errors" => $validator->errors()]);
            }
            $game = new Game;
            $game->difficulty = $request->input("difficulty");
            $game->latitude = $request->input("latitude");
            $game->longitude = $request->input("longitude");
            $game->save();
            $seed = Artisan::call('db:seed --class=RadiusSeeder');
            return response()->json([
                "status" => 200,
                "migrate" => $seed,
                "message" => "Game Created Successfully"
            ]);
    }
}

