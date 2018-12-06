<?php

namespace App\Http\Controllers\Index;

use App\Comment;
use App\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    //type 1评论,2MV,3动态
    public function like(Request $request){
        $data = $request->all();
        $check = Like::where('type',$data['type'])->where('user_id',$data['user_id'])->where('to_id',$data['to_id'])->count();
        if($check != 0){//已经点赞
            return 200;
        }else{
            if($data['type'] = 1){
                Comment::where('id',$data['to_id'])->increment('like');
            }
            Like::create($data);
        }
    }
}
