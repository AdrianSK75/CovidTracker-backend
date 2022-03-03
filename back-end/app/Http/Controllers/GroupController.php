<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Game;
use App\Models\GroupsUsers;
use App\Models\Radius;
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
                    return $group->game->name;
            })->toArray();
            // current group
            $current_group = GroupsUsers::where('user_id', auth()->id())->first();
            $current_group = $current_group == null ? 0 : $current_group->group_id;
            return response([
               "groups" => $groups,
               "current_group" => $current_group,
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
            $user = User::findOrFail(auth()->id());

            $group = Group::create([
                    'game_id' => $user->game[count($user->game) - 1]->id,
                    'mode' => $request->mode,
                    'key_mode' => $request->key_mode
            ]);

            self::add_the_players_in_groups(Auth::id(), $group->id);

            $response = [
               'group' => $group,
               'game' => $user->game,
            ];
            return response($response, 200);
    }

    public function join($id) {
            $group = Group::findOrFail($id);
            $user = User::findOrFail(auth()->user()->id);
            if (self::is_in_multiple_groups($user->id) >= 1) {
                    return response([
                        'message' => 'You can not be in multiple groups!'
                    ], 401);
            }
            self::add_the_players_in_groups($user->id, $group->id);
            return response("Enjoy the game!", 200);
    }

    public function current_lobby($id) {
            $current_group = Group::findOrFail($id);
            $creator = User::findOrFail($current_group->game->user_id);
            $players_name_from_group = $current_group->users->map(function ($player) {
                        return $player->name;
            })->toArray();
            return response([
                "players_name" => $players_name_from_group,
                "group_game" => $current_group->game,
                "creator" => $creator->name
            ], 200);
    }

    public function run($id) {
            $group = Group::findOrFail($id);
            $game = $group->game->id;
            return parent::game($game);
    }

    public function end($id) {
            $group = Group::findOrFail($id);
            if ($group->game->user_id == auth()->id()) {
                    $group_users = GroupsUsers::where('group_id', $group->id)->first();
                    $group_users->delete();
                    $game = Game::findOrFail($group->game->id);
                    if (count($game->radii) > 0) {
                            Radius::where('game_id', $game->id)->delete();
                    }
                    $group->delete();
                    $game->delete();
                    return 200;
            } else {
                    $current_user_from_group = GroupsUsers::where('user_id', auth()->user()->id)->first();
                    return response($current_user_from_group->delete(), 200);
            }

    }

}
