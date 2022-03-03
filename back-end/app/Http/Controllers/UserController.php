<?php

namespace App\Http\Controllers;

use App\Models\GroupsUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function profile() {
            return response([
                Auth::user(),
                Auth::user()->game
            ], 200);
    }

    public function login(Request $request) {
            $fields = $request->validate([
                'name' => 'required|string',
                'password' => 'required|string'
            ]);
            //return $fields;
            $user = User::where('name', $fields['name'])->first();
            if (!$user || !Hash::check($fields['password'], $user->password)) {
                    return response([
                        'message' => 'Bad creds'
                    ], 401);
            }
            $token = $user->createToken('usertoken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response($response, 200);
    }

    public function logout(Request $request) {
            //$is_in_group = GroupsUsers::where('user_id', auth()->id())->first();
            //if (count($is_in_group) == 1) {
              //  $is_in_group->delete();
            //}
            $user_tokens = auth()->user()->tokens->each;
            $user_tokens->delete();

            return [
                'message' => 'The '. auth()->user()->name .' was Logged out'
            ];
    }

    public function register(Request $request) {
            $fields = $request->validate([
                    'name' => 'required|string',
                    'password' => 'required|string|confirmed'
            ]);
            $user = User::create([
                'name' => $fields['name'],
                'password' => Hash::make($fields['password'])
            ]);
            $token = $user->createToken('usertoken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response($response, 200);
    }

}
