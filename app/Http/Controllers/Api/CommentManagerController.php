<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentManagerController extends Controller
{
    public function index(Request $request) {
        $perPage = request('per_page', 16);
        $comments = Comment::orderBy('id', 'DESC')->with('user')->paginate($perPage);
        return response()->json($comments);
    }

    public function delete($id, Request $request) {
        $comment = Comment::where('id', $id)->first();
        if(!$comment) {
            return response()->json(array('status' => 'error', 'Comment not found'));
        }
        $comment->delete();

        return response()->json(array('status' => 'success', 'Deleted!'));
    }
}
