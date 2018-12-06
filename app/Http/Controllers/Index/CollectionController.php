<?php

namespace App\Http\Controllers\Index;

use App\Collection;
use App\Playlist;
use App\Song;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
class CollectionController extends Controller
{
    public function collection(Request $request){

        if (Collection::where('playlist_id',$request->get('playlist_id'))->where('topic_id',$request->get('topic_id'))->count() != 0){
            $result = 201;
            return response()->json($result);
        }

        if(Collection::create($request->all())){
            Playlist::where('id',$request->get('playlist_id'))->increment('song_number');
            $check = Song::where('id',$request->get('topic_id'))->select('cover')->first();
            if($check->cover){
                Playlist::where('id',$request->get('playlist_id'))->update(['auto_cover'=>$check->cover]);
            }
            $result = 100;
        }else{
            $result = 200;
        }

       return response()->json($result);
    }



    public function collection_playlist(Request $request){

        if($request->get('user_id') == Session::get('id')){
            if(Collection::create($request->all())){
                $result = 100;
            }else{
                $result = 200;
            }
        }else{
            $result = 201;
        }

        return response()->json($result);
    }

    public function del_collection(Request $request){
        if(Collection::where('id',$request->get('id'))->delete()){
            return response()->json(100);
        }
    }

}
