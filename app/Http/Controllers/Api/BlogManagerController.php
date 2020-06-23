<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogManagerController extends Controller
{
    public function index() {
        exit("Manage blogs");
    }

    public function save(Request $request) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:191','min:5'],
            'thumbnail' => ['required'],
            'cat_id' => 'required|numeric',
            'description' => ['required'],
            'content' => ['required'],
        ]);

        if ($validator->fails()) {
            $errorString = "<br>";
            foreach ($validator->errors()->toArray() as $field => $message) {
                $errorString .= $field .': '.$message[0].'<br>';
            }
            return response()->json(['status' => 'error', 'message' => $errorString]);
        }

        // Init new blog or write to the old once
        $blog = false;
        if(isset($request->id) && $request->id > 0) {
            $blog = Blog::where('id', $request->id)->first();
            if(Auth::user()->role == "writer" && $blog->user_id != Auth::user()->id) {
                return response()->json(['status' => 'error', 'message' => "You dont have permission to edit this blog"]);
            }
        }
        if(!$blog) {
            $blog = new Blog();
        }

        // Map data from request
        $requireFields = array('title', 'thumbnail', 'cat_id', 'description', 'content');
        foreach($requireFields AS $requireField) {
            $blog->{$requireField} = $request->{$requireField};
        }
        $blog->user_id = Auth::user()->id;
        $blog->save();
        return response()->json(array('status' => 'success', 'data' => $blog));
    }

    public function delete($id, Request $request) {
        $blog = Blog::where('id', $id)->first();
        if(!$blog) {
            return response()->json(array('status' => 'error', 'Blog not found'));
        }
        $blog->delete();
        return response()->json(array('status' => 'success', 'Deleted!'));
    }
}
