<?php

namespace App\Http\Controllers\Index;

use App\Album;
use App\Artist;
use App\Banner;
use App\Playlist;
use App\Song;
use App\Tag;
use Cache;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Category;
class IndexController extends Controller
{
    public function index()
    {
        $id = Session::get('id');
        $my_playlist = '';
        if($id){
            $my_playlist = Playlist::where("user_id",$id)->orderBy('id','asc')->get();
        }
        return view('index.index.index',['my_playlist'=>$my_playlist]);
    }
    public function main()
    {

        $start_date = date("Y-m-d H:i:s", strtotime('-30 days'));
        $end_date = date("Y-m-d H:i:s");

        $banners = Cache::remember('banner',1200,function(){
            return Banner::orderBy('sort','desc')->get();
        });

        $playlists = Playlist::whereBetween('public_time',[$start_date,$end_date])->orderBy('play','desc')->limit(8)->get();
        $albums = Album::orderBy('created_at','desc')->limit(5)->get();
        $billboard['song']= Song::whereBetween('created_at',[$start_date,$end_date])->orderBy('play','desc')->limit(10)->get();
        $billboard['album']= Album::whereBetween('created_at',[$start_date,$end_date])->orderBy('play','desc')->limit(10)->get();
        $billboard['playlist']= Playlist::where('public_time','<>','')->whereBetween('created_at',[$start_date,$end_date])->orderBy('play','desc')->limit(10)->get();
//        $billboard['new'] = Db::name('song')->where("create_time between '$start_date' and '$end_date'")->order('play desc')->limit(10)->select();
//        $billboard['playlist'] = Db::name('playlist')->where("public_time between '$start_date' and '$end_date'")->order('play desc')->limit(10)->select();
//        $billboard['album'] = Db::name('album')->where("create_time between '$start_date' and '$end_date'")->order('play desc')->limit(10)->select();


//        name('playlist')->where("public_time between '$start_date' and '$end_date'")->order('play desc')->limit(8)->select();
        return view('index.index.main',['banners'=>$banners,'playlists'=>$playlists,'albums'=>$albums,'billboard'=>$billboard]);

    }

    public function artist(Request $request)
    {
        $category_id = $request->get('cate_id');
        if($category_id){
            $artists = Artist::where('category_id',$category_id)->limit(50)->orderBy('id','asc')->get();
        }else{
            $artists = Artist::limit(50)->orderBy('id','asc')->get();
        }

        $categorys = (new Category)->tree();

        return view('index.index.artist',['categorys'=>$categorys,'artists'=>$artists]);

    }

    public function album(Request $request)
    {
        $albums = Album::orderBy('created_at','desc')->paginate(15);
        return view('index.index.album',['albums'=>$albums]);

    }
    public function playlist(Request $request)
    {
        $tag = $request->get('tag');

        $order = $request->get('order','hot');
        if($order == 'hot'){
            $order = 'play';
        }else{
            $order = 'public_time';
        }
        $playlists = Playlist::where('public_time','<>','')->when($tag, function ($query) use ($tag) {
            return $query->where('tags','like', "%$tag%");
        })->orderBy("$order",'desc')->paginate(15);

        $tag = new Tag();
        $tags = $tag->tree();
        return view('index.index.playlist',['tags'=>$tags,'playlists'=>$playlists,'tag'=>$tag,'order'=>$order]);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $type = $request->get('type','song');
        if($type == 'song'){
            $data = Song::where('name','like',"%$keyword%")->paginate(15);
            $count = Song::where('name','like',"%$keyword%")->count();
        }else if ($type == 'artist'){
            $data = Artist::where('name','like',"%$keyword%")->paginate(15);
            $count = Artist::where('name','like',"%$keyword%")->count();
        }else if($type == 'album'){
            $data = Album::where('name','like',"%$keyword%")->paginate(15);
            $count = Album::where('name','like',"%$keyword%")->count();
        }else {
            $data = Playlist::where('name','like',"%$keyword%")->paginate(15);
            $count = Playlist::where('name','like',"%$keyword%")->count();
        }

        return view('index.search.search',['data'=>$data,'count'=>$count,'type'=>$type,'keyword'=>$keyword]);
    }



}
