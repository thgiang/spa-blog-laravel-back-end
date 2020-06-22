<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Support\Facades\Validator;
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
        // validate incoming request
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => 'required|string|max:255',
            'role' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            $errorString = "<br>";
            foreach ($validator->errors()->toArray() as $field => $message) {
                $errorString .= $field .': '.$message[0].'<br>';
            }
            return response()->json(['status' => 'error', 'message' => $errorString]);
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'username' => 'required|string|max:191|unique:users',
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            $errorString = "<br>";
            foreach ($validator->errors()->toArray() as $field => $message) {
                $errorString .= $field .': '.$message[0].'<br>';
            }
            return response()->json(['status' => 'error', 'message' => $errorString]);
        }

        // Map data from request
        $requireFields = array('name', 'username', 'email', 'password', 'role');
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
