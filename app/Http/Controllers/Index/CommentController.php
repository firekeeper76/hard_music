<?php

namespace App\Http\Controllers\Index;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function comment(Request $request)
    {

        if (Comment::create($request->all())) {
            $result = 100;
        } else {
            $result = 200;
        }
        return $result;
    }

    public function getComment(Request $request)
    {
        $data = $request->all();
        $start = $data['page'] * $data['limit'] - $data['limit'];
        $comments = Comment::where('topic_type', $data['topic_type'])->where('topic_id', $data['topic_id'])->orderBy($data['order'], 'desc')->offset($start)->limit($data['limit'])->get();
        foreach ($comments as $key => $value) {
            $value['user'] = $value->user;

            if ($value['to_id']) {
                $value['to_comment'] = Comment::find($value['to_id']);
                $value['to_comment']['user'] = $value['to_comment']->user;
            }
        }
//        $comment = Db::name('comment')->where("topic_type=$topic_type and topic_id=$topic_id")->order("$order desc")->limit($start,$limit)->select();
//        foreach ($comment as $k => $v) {
//            if($v['to_id']){
//                $comment[$k]['to_comment'] = Db::name('comment')->where("id=".$v['to_id'])->find();
//            }
//        }
        return response()->json($comments);
    }
}
