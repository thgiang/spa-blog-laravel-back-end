<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagerController extends Controller
{
    public function index() {
        $perPage = request('per_page', 16);
        $users = User::orderBy('id', 'DESC')->paginate($perPage);
        return response()->json($users);
    }

    public function search(Request $request) {
        if(!$request->keyword) {
            return response()->json(array('status' => 'error', 'message' => "Bạn cần điền keyword trước khi tìm kiếm"));
        }
        $users = User::where('username', 'like', '%'.$request->keyword.'%')->orWhere('name', 'like', '%'.$request->keyword.'%')->orWhere('email', 'like', '%'.$request->keyword.'%')->paginate(100);

        return response()->json(array('status' => 'success', 'data' => $users));
    }

    public function deleteUser($id) {
        $user = User::where('id', $id)->first();
        if(!$user) {
            return response()->json(array('status' => 'error', 'message' => "Không tìm thấy user này"));
        }
        if($user->id == Auth::user()->id) {
            return response()->json(array('status' => 'error', 'message' => "Bạn không thể xóa tài khoản của chính mình"));
        }
        $user->delete();
        return response()->json(array('status' => 'success', 'message' => "Xóa thành công"));
    }

    public function show($id) {
        return response()->json(User::where('id', $id)->first());
    }

    public function save(Request $request) {
        if(!$request->id) {
            return response()->json(array('status' => 'error', 'message' => 'Wrong request'));
        }

        $user = User::where('id', $request->id)->first();
        if(!$user) {
            return response()->json(array('status' => 'error', 'message' => 'User not found'));
        }

        // Map data from request
        $user->role = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != '') {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json(array('status' => 'success', 'data' => $user));
    }

    public function create(Request $request) {
        $requireFields = array('name', 'username', 'email', 'password');
        foreach($requireFields AS $requireField) {
            if(!$request->{$requireField}) {
                return response()->json(array('status' => 'error', 'message' => $requireField.' field is required'));
            }
        }

        // Map data from request
        $user = new User();
        foreach($requireFields AS $requireField) {
            $user->{$requireField} = $request->{$requireField};
        }
        $user->password = Hash::make($request->password);
        $user->api_token = generateToken();
        $user->save();
        return response()->json(array('status' => 'success', 'data' => $user));
    }
}
