<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/", [GameController::class, 'refresh']);
Route::post("/", [GameController::class, 'store']);
Route::get('/game', [GameController::class, 'game']);
Route::get('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::get("/test", function() {});


