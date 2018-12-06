<?php

namespace App\Http\Controllers\Index;

use App\Album;
use App\Playlist;
use App\Song;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function setPlay(Request $request){
//        1歌曲,2专辑,3歌单
        $type = $request->get('type');
        $id = $request->get('id');
        if($type==1){
            Song::where('id',$id)->increment('play');
        }else if($type==2){
            Album::where('id',$id)->increment('play');
        }else if($type==3){
            Playlist::where('id',$id)->increment('play');
        }
//        return $type;
    }
}
