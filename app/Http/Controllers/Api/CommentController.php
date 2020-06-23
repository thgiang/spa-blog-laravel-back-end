<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function show($blog_id, Request $request) {
        $comments = Comment::where('blog_id', $blog_id)->with('user')->where('accepted', true)->orderBy('id', 'DESC')->paginate('50');
        foreach($comments AS $comment) {
            $comment->user->avatar = url('images/avatars/'.($comment->user->id%8+1).'.png');
        }
        return response()->json($comments);
    }

    public function save($blog_id, Request $request) {
        if(!is_numeric($blog_id) || !$request->text) {
            return response()->json(array('status' => 'error', 'message' => 'Invalid request'));
        }
        $blog = Blog::where('id', $blog_id)->first();
        if(!$blog) {
            return response()->json(array('status' => 'error', 'message' => 'Blog not found'));
        }

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->blog_id = $blog_id;
        $comment->text = $request->text;
        $comment->save();
        $comment->user = Auth::user();
        $comment->user->avatar = url('images/avatars/'.($comment->user->id%8+1).'.png');
        return response()->json(array('status' => 'success', 'data' => $comment));
    }
}
