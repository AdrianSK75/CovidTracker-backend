<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function login() {
        $users = User::all();
        return response()->json([
            "status" => 200,
            "data" => $users,
            "message" => "Account Created Successfully"
        ]);
    }
    public function register(Request $request) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(["status" => 422,
                "message" => "Validation error",
                "errors" => $validator->errors()]);
            }
            $user = new User;
            $user->name = $request->input("name");
            $user->password = Hash::make($request->input("password"));
            $user->save();
            return response()->json([
                "status" => 200,
                "message" => "Account Created Successfully"
            ]);
    }

}
