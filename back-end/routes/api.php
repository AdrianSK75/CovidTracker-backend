<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Radius;
use Illuminate\Support\Facades\Artisan;


Route::get('/game', function()
{
    $migrate = Artisan::call('migrate:refresh', ['--seed' => true]);
    $radius = Radius::all();
    return [$radius, $migrate];

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get("/game", function() {
       // return Game::all();
//});
