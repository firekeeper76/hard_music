<?php

namespace App\Http\Controllers\Index;

use App\Album;
use App\Collection;
use App\Comment;
use App\Song;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SongController extends Controller
{
    public function song(Request $request)
    {
        $id = $request->get('id');
        $song = Song::findOrFail($id);

        $comments_count = Comment::where('topic_type',1)->where('topic_id',$id)->count();
        $tags = $song->tags;
        $arr = explode(",", $tags);
        if($arr){
            $other_song = Song::where('tags','like',"%".$arr[0]."%")->get();
        } else {
            $other_song = Song::orderBy('play','desc')->limit(5)->get();
        }

//
        return view('index.song.song',['song'=>$song,'comments_count'=>$comments_count,'other_song'=>$other_song]);
    }


    public function getPlayListSong(Request $request)
    {
        $id = $request->get('id');
        $collection_songs = Collection::where('topic_type','1')->where('playlist_id',$id)->orderBy('created_at','desc')->get();
        $songs =[];
        foreach ($collection_songs as $key=>$value){
            $songs[$key] = $value->song;
            $songs[$key]['artist_name'] = $songs[$key]->artist->name;
            if( $songs[$key]->album_id){
                $songs[$key]['album_name'] = $songs[$key]->album->name;
            }

        }
        return response()->json($songs);
    }

    public function getAlbumSong(Request $request)
    {
        $id = $request->get('id');
        $songs = Album::find($id)->songs;
        foreach ($songs as $key=>$value){
            $value['artist_name'] = $value->artist->name;
        }
        return response()->json($songs);
    }

}
