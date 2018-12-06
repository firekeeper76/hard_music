<?php

namespace App\Http\Controllers;
use App\Admin;
use App\Album;
use App\Banner;
use App\Category;

use Illuminate\Support\Facades\Redis;
use App\Collection;
use App\Comment;
use App\Like;
use App\Order;
use App\Song;
use App\Playlist;
use App\Tag;
use App\Test;
use App\User_auths;
use Illuminate\Http\Request;
use think\Exception;
use Validator;
use Cache;
use Cookie;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
class testController extends Controller
{
    public function test1 (Request $request)
    {


        // 这样子才是正常的，刚才我使用 redis desktop 写不进数据，应该是你的配置文件有问题
        // 现在这个新 的 运行的时候 redis-server.exe 指定配置文件，一般都有一个配置文件叫做 redis.windows.conf
        // 你直接在 cmd 存的，这个 redis desk top 也看不到

        // 我的锅，好久没用，忘记写第三个参数，就是因为你之前的 redis-server 启动配置文件问题。
        // 如果以后工作团队有自己的规范，按照团队的规范来，没有就按照 psr 代码规范。
        // 你的代码建议按照这个 规范来。

        dd(cache()->put('i1111i', 'g11111111111111g', 1));
//        $key = 'rds';
//        Redis::setex($key,101,'success');
//        dd(Redis::get($key));
        $key = 'rds';
        if (Cache::has($key)){                //首先查寻cache如果找到
            $values = Cache::get($key);    //直接读取cache0
            dd($values.'2');
        }else{                                   //如果cache里面没有
            $value = 'success1';
            Cache::put($key,$value,50);
        }
        dd(Cache::get($key));
//        phpinfo();
//        $data['name'] = $request->get('payTo').'-'.$request->get('playerId').'-'.$request->get('orderId').'-'.$request->get('sign').'-'.($request->get('payPrice')/100).'-'.$request->get('goodsId');
////        $data['name'] = 'pay';
//        Test::create($data);
//        return view('error.404');
//        $test = Test::where('id',213)->get();
//        dd($test);
//        dd(Song::withTrashed()->find(34)->restore());
//        Test::where('user_id',3)->restore();
//dd(Song::where('id',34)->update(['album_id'=>'']));
//        if($request->isMethod('post')){
//            dd($request->file('song'));
//            $song = $request->file('song')->store('/public/uploads/music/' . date('Ymd') );
//            dd($request->file('song')->getClientOriginalExtension());
//
//            $check = Storage::url($song);
//            dd($check);
//            //上传的头像字段avatar是文件类型
//            $result['code'] = 1;
//            if($check){
//                $result['code'] = 0;
//            }

//            dd($file_src);
//        }
//        Song::where('id',16)->increment('play');
//        $data['identity_type'] = 'phone';
//        $data['identifier'] = '18276491217';
//        $auths = User_auths::where('identity_type',$data['identity_type'])->where('identifier',$data['identifier'])->first();
//        $user = $auths->user;
//
//        $user->is_vip = 0;
//        $user->save();
//        $b = new Test();
//        $b['name'] = 'sddddddda';
//        $c = Cache::get('key',function(){
//            Cache::put('key','set',10);
//            return 'val';
//        });
//        $tag = '华语';
//        $order = 'play';
//        $playlists = Playlist::
//        where('public_time','<>','')->orderBy($order,'desc')->get();
//        foreach($playlists as $playlist){
//            $u = $playlist->user->nickname;
//
//        }

//        $my_playlist = Playlist::where("user_id",'3')->orderBy('id','asc')->get();
//        $a  = Playlist::where('id',5)->first();
//        $songs = Collection::where('topic_type','1')->where('playlist_id',5)->get();
//        $ss = [];
//        foreach ($songs as $key=>$value){
//            $ss[$key] = $value->song;
//            $ss[$key]['album_name'] = $ss[$key]->album->name;
//            $ss[$key]['artist_name'] = $ss[$key]->artist->name;
//        }
//        foreach ($ss as $key=>$value){
//            $ss[$key]['album_name'] = $value->album->name;
//            $ss[$key]['artist_name'] = $value->artist->name;
//        }

//        $comments = Comment::where('topic_type','3')->where('topic_id','5')->orderBy('like','desc')->limit(6)->get();
//
//        foreach ($comments as $key=>$value){
//            $value['nickname'] = $value->user->nickname;
//            $value['avatar'] = $value->user->avatar;
//            if($value['to_id']){
//                $value['to_comment'] = Comment::find($value['to_id']);
//                $value['to_comment']['nickname'] =  $value['to_comment']->user->nickname;
//            }
//        }

//            $id = $request->get('id');
//            $user_id = 0;
//            $collection_songs = Collection::where('topic_type','1')->where('topic_id',16)->when($user_id, function ($query) use ($user_id) {
//                return $query->where('user_id', "$user_id");
//            })->get();

//        $collection_songs = Collection::where('topic_type','1')->where('playlist_id',1)->get();
//            dd($collection_songs);
//            $songs =[];
//            foreach ($collection_songs as $key=>$value){
//                $songs[$key] = $value->song;
//                $songs[$key]['album_name'] = $songs[$key]->album->name;
//                $songs[$key]['artist_name'] = $songs[$key]->artist->name;
//            }
//        $album = Album::find(19);
//        $songs =$album ->songs;
//        foreach ($songs as $key=>$value){
//            $value['artist_name'] = $value->artist->name;
//        }
//        $check = Storage
//        $old_avatar = "uploads/user_images/20181110/5be652bd41aa6.jpg";
//         if(Storage::disk('local')->exists('public/'.$old_avatar)){//判断图片是否存在
//              Storage::disk('local')->delete('public/'.$old_avatar);
//         }

//        $ip = $request->getClientIp();
//        $data['id'] = 5;
//        $data['state'] = 1;
//        $admin = Admin::where('phone','18276491217')->first();
//        Cache::forget('tag');
//        $check  = (new Tag())->tree();
//        $check = DB::table('category')->insert($data);



//            dd(Banner::where('id',13)->restore(13));
//            return response()->json($songs);
//        dd($comments);
//        $check = Like::where('type',1)->where('user_id',14)->where('to_id',16)->count();
//        $check = Song::where('id',21)->select('cover')->first();
//        Song::where('id',21)->update(['cover'=>'sdadas']);
//        dd($check);
//        return response()->json($comments);
//        dd(Artist::find(235));
//        if($request->isMethod('post')){
//            $file = $request->file('cover');
//            $date = date('Ymd');
//
////            $a  = Storage::disk('public')->put('1111111111.jpg', file_get_contents($file->getRealPath()));
//            $a = $file->move(base_path().'/public/uploads/artist_images/'.$date,'1111.'.$file-> getClientOriginalExtension());
//            dd( $a);
//        }
//        $orders = Order::get();
//        foreach ($orders as $key => $value){
//            $orders[$key]['pay_to'] = $value->pay_to;
//        }
//        dd($orders);
//        return view('test');
    }

    // 函数的大括号总是换行的，你可以自己稍微看一下。好的
    public function test2 ()
    {
        $manager = new ImageManager();
//        $image = $manager->make('/111.jpg')->resize(300, 200);
        $manager->make(base_path().'/111.jpg')->resize(300, 200);
//        $manager->insert(base_path().'/222.jpg','bottom-right', 15, 10);
        dd($manager->make(base_path().'/111.jpg')->resize(130,130)->save(base_path().'/222.jpg'));
    }
}
