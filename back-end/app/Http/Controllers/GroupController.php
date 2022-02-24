<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Game;
use App\Models\GroupsUsers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GroupController extends GameController
{
    public function dashboard() {
            $groups = Group::all();
            //count the users from every group.
            $players_in_group = $groups->map(function ($group) {
                    return $group->users()->count();
            })->toArray();
            //see what settings have every group game.
            $group_games_settings = $groups->map(function ($group) {
                    return $group->game->address;
            })->toArray();

            return response([
               "groups" => $groups,
               "players" => $players_in_group,
               "settings" => $group_games_settings
            ], 200);
    }

    public function is_in_multiple_groups($user_id) {
            return GroupsUsers::where('user_id', $user_id)->count();
    }

    public function add_the_players_in_groups($player_id, $group_id) {
            return GroupsUsers::create(['group_id' => $group_id, 'user_id' => $player_id]);
    }

    public function create(Request $request) {
            parent::store($request);
            $game = Game::where('user_id', Auth::id())->get();
            $length = count($game);
            $group = Group::create([
                    'game_id' => $game[$length - 1]->id,
                    'mode' => $request->mode,
                    'key_mode' => $request->key_mode
            ]);

            self::add_the_players_in_groups(Auth::id(), $group->id);

            $response = [
               'group' => $group,
               'game' => $game,
            ];
            return response($response, 200);
    }

    public function join($id) {
            $group = Group::findOrFail($id);
            $user = User::findOrFail(auth()->user()->id);
            if (self::is_in_multiple_groups($user->id) > 1) {
                    return response([
                        'message' => 'You can not be in multiple groups!'
                    ], 401);
            }
            self::add_the_players_in_groups($user->id, $group->id);
            return self::current_lobby($id);
    }
    public function current_lobby($id) {
            $current_group = Group::findOrFail($id);
            $players_name_from_group = $current_group->users->map(function ($player) {
                        return $player->name;
            })->toArray();
            return response([
                "players_name" => $players_name_from_group,
                "group_game" => $current_group->game
            ], 200);
    }

    public function run($id) {
            return parent::game($id);
    }

    public function end($id) {
            $group = Group::findOrFail($id);
            return $group->game->user_id;

    }

}
