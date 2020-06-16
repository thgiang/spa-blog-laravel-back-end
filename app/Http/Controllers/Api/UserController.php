<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request) {
        if(!$request->username || !$request->password) {
            return response()->json(array('status' => 'error', 'message' => "username and password are required"));
        }

        $user = User::where('username', $request->username)->first();
        if(!$user) {
            $user = User::where('email', $request->username)->first();
        }

        if($user && (Hash::check($request->password, $user->password))) {
            return response()->json(array('status' => 'success', 'data' => $user));
        }

        return response()->json(array('status' => 'error', 'message' => 'Wrong username or password'));
    }
}
