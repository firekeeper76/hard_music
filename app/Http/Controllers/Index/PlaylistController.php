<?php

namespace App\Http\Controllers\Index;

use App\Collection;
use App\Comment;
use App\Playlist;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
class PlaylistController extends Controller
{
    public function playlist(Request $request){

        //收藏表 主题类型1歌曲,2专辑,3歌单
        //评论表 主题类型1歌曲,2专辑,3歌单

        $id = $request->get('id');
        $user_id = Session::get('id');
        if($user_id){
            $is_collection = Collection::where('user_id',$user_id)->where('topic_type','2')->where('topic_id',$id)->count();
        }else{
            $is_collection = 0;
        }
//        $playlist = Playlist::where('id',$id)->first();
        $playlist = Playlist::findOrFail($id);


        $comments_count = Comment::where('topic_id',$id)->where('topic_type','3')->count();
        $other_playlist = Playlist::where("public_time", '<>' ,'')->orderBy('play','desc')->limit(5)->get();


        return view('index.playlist.playlist',['playlist'=>$playlist,'other_playlist'=>$other_playlist,'comments_count'=>$comments_count,'is_collection'=>$is_collection]);
    }
    public function create_playlist(Request $request){
        if(Playlist::create($request->all())){
            return 100;
        }else{
            return 201;
        }
    }

    public function my_playlist(Request $request){
        $user_id = Session::get('id');
        if(!$user_id){
            return redirect('/main');
        }else{
            $playlists = Playlist::where('user_id',$user_id)->get();
            $collection_playlist = Collection::where('topic_type',2)->where('user_id',$user_id)->get();
            $tag_model = new Tag();
            $tags = $tag_model->tree();
            return view('index.playlist.my',['playlists'=>$playlists,'collection_playlist'=>$collection_playlist,'tags'=>$tags]);
        }
    }

    public function del_playlist_song(Request $request){
        if(Collection::where('topic_id',$request->get('topic_id'))->where('playlist_id',$request->get('playlist_id'))->delete()){
            Playlist::where('id',$request->get('playlist_id'))->decrement('song_number');
            return 100;
        }
    }
    public function del_playlist(Request $request){

        $id = $request->get('id');
        if(Playlist::where('id',$id)->delete()){
            Collection::where('playlist_id',$id)->delete();
            return 100;
        }

    }
    public function update_playlist(Request $request){

        $data = $request->all();
        if($request->get('public_time')){
            $data['is_action'] = 0;
        }
        if(Playlist::where('id',$data['id'])->update($data)){
            return 100;
        }

    }
}
