<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            return response()->json(array('status' => 'success', 'user_info' => $user));
        }

        return response()->json(array('status' => 'error', 'message' => 'Tài khoản hoặc mật khẩu chưa đúng'));
    }

    public function userInfo() {
        return response()->json(array('status' => 'success', 'user_info' => Auth::user()));
    }
}
