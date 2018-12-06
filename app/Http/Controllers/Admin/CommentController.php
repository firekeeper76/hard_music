<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        $keyword = $request->get('keyword');
        if ($keyword) {
            $comments = Comment::where('content', 'like', "%$keyword%")->orderBy('created_at', 'desc')->paginate(10);
            $count = Comment::where('content', 'like', "%$keyword%")->count();
        } else {
            $comments = Comment::orderBy('created_at', 'desc')->paginate(10);
            $count = Comment::count();
        }
        return view('admin.comment.comment', ['comments' => $comments, 'count' => $count]);
    }

    public function del(Request $request)
    {
        $id = $request->get('id');
        if (Comment::destroy($id)) {
            $result = 100;
        } else {
            $result = 200;
        }
        return response()->json($result);
    }

    public function deleted(Request $request)
    {
        $keyword = $request->get('keyword');
        if ($keyword) {
            $comments = Comment::onlyTrashed()->where('content', 'like', "%$keyword%")->orderBy('created_at', 'desc')->paginate(10);
            $count = Comment::onlyTrashed()->where('content', 'like', "%$keyword%")->count();
        } else {
            $comments = Comment::onlyTrashed()->orderBy('created_at', 'desc')->paginate(10);
            $count = Comment::onlyTrashed()->count();
        }
        return view('admin.comment.comment-deleted', ['comments' => $comments, 'count' => $count]);
    }

}
