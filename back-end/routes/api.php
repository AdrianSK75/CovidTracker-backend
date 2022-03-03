<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Models\Game;
use App\Models\GroupsUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post("/", [GameController::class, 'store']);
    Route::delete("/", [GameController::class, 'refresh']);
    Route::get('/game', [GameController::class, 'game']);

    Route::post("/group/create", [GroupController::class, 'create']);
    Route::post("/group/{group::id}/join", [GroupController::class, 'join']);
    Route::get("/group/{group::id}", [GroupController::class, 'current_lobby']);
    //Route::get("/left", [GroupController::class, 'left']);
    Route::get("/group/{group::id}/run", [GroupController::class, 'run']);
    Route::get("/groups", [GroupController::class, 'dashboard']);
    Route::get("group/{group::id}/delete", [GroupController::class, 'end']);

    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile']);

    Route::get("/test", function() {
        return GroupsUsers::where('user_id', auth()->id())->first();
    });
});

