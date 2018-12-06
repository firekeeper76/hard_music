<?php

namespace App\Http\Controllers\Index;

use App\Playlist;
use App\User;
use App\User_auths;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class ApiController extends Controller
{
    public function  weibo(Request $request){

        header("Content-Type:text/html;charset=utf-8");

        $code = $request->get('code');


        //使用Curl请求url
        $url = 'https://api.weibo.com/oauth2/access_token';
        //要传的数据
        $data = [
            'client_id' => '2234448020',
            'client_secret'=>'aa35938c0cb04be8aa7f47850e0bd06b',
            'grant_type'=>'authorization_code',
            'code'=>$code,
            'redirect_uri'=>'http://www.firekeeper.cn/weibo'  //回调地址
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //post变量.一定要用http_build_query处理下请求,把数据转货成字符串,防止乱码
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $res = curl_exec($ch);//返回的数据是json格式要转化成数组
        curl_close($ch);


        $json_arr = json_decode($res,true);  //返回的数据是json格式要转化成数组
        //转成数组后拿下到下面的两个参数
        $token = $json_arr['access_token'];
        $uid = $json_arr['uid'];
        //发送get请求,获取登陆用户的信息
        $userinfo = file_get_contents('https://api.weibo.com/2/users/show.json?access_token='.$token.'&uid='.$uid);
        //打印用户的信息

//        dump($userinfo);

//        $tom = "https://api.weibo.com/oauth2/access_token?client_id=500234060&client_secret=d7de56aa11796cbb4af952bd311d1a72&grant_type=authorization_code&redirect_uri=http://www.liweip.cn/weibo&code=".$code;
//        $url = $tom;
//        $curl = curl_init();
//        curl_setopt($curl,CURLOPT_URL,$url);
//        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
//        curl_setopt($curl,CURLOPT_POST,TRUE);
//        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
//        curl_setopt($curl,CURLOPT_USERPWD,"username:password");
//        $data = curl_exec($curl);
//        curl_close($curl);
//        $result = json_decode($data,true);
//        $access_token = $result['access_token'];
//        $uid = $result['uid'];
//        $url = "https://api.weibo.com/2/users/show.json?access_token=".$access_token;//获取用户信息
//        $data = file_get_contents($url,'rb');
//

        $data = json_decode($userinfo,true);

        $auths = User_auths::where('identity_type','weibo')->where('identifier',$uid)->first();
        $user_id = Session::get('id','');


//        1，该微博在本站未注册过
        if(!$auths){

            //            1-1，该微博未在本站注册过，当前用户已登录，尝试进行绑定操作；
            if($user_id){
                $wb['identity_type'] = 'weibo';
                $wb['identifier'] = $uid;
                $wb['user_id'] = $user_id;
                $wb['credential'] = $token;
                User_auths::create($wb);
                return redirect('user?id='.$user_id);
            }else{
//                1-2，该微博未在本站注册过，当前没有用户登录，进行注册关联并登录；
                $user['nickname'] = $data['screen_name'];
                $user['avatar'] = $this->download($data['avatar_hd']);
                //创建用户信息 并返回用户id
                $user_id = $this->third_register($user);

                $wb['identity_type'] = 'weibo';
                $wb['identifier'] = $uid;
                $wb['user_id'] = $user_id;
                $wb['credential'] = $token;
                User_auths::create($wb);

                Session::put('is_vip',0);
                Session::put('nickname',$user['nickname']);
                Session::put('id',$user_id);
                Session::put('avatar',$user['avatar']);
                return redirect('/');
            }
        }else{

            //2，该微博已经在本站存在，当前用户未登录，直接登录成功；
            if(!$user_id){
                $id = $auths['user_id'];
                $user = User::find($id);
                Session::put('nickname',$user->nickname);
                Session::put('id',$user->id);
                Session::put('avatar',$user->avatar);
                if($user['is_vip'] == 1){
                    if($user['vip_end_time'] > date('Y-m-d H:i:s',time())){
                        Session::put('is_vip',1);
                    }else{
                        User::where('id',$user->id)->update(['is_vip'=>0]);
                        Session::put('is_vip',0);
                    }
                }else{
                    Session::put('is_vip',0);
                }
                return redirect('/');
            }
        }


    }


    public function download($url)
    {
        $ext=strrchr($url,'.');
        if(!in_array($ext,['.jpg','.png','.jpeg','.gif'])){
            return $url;
        }
        $baseName=basename($url);
        $date = date('Ymd');
//        $saveUrl="/uploads/user_images/$date/".$baseName;
        $Folder = "uploads/user_images/$date/";
        if(!is_dir($Folder)){//文件夹不存在
            mkdir($Folder);
        }
        $saveUrl = base_path() . "/public/uploads/user_images/$date/$baseName";
        //文件保存绝对路径
//        $path=__DIR__.DS.$saveUrl.DS.$baseName;
        $img = file_get_contents($url);
        file_put_contents($saveUrl, $img);
        $head_img = "uploads/user_images/$date/$baseName";
        return $head_img;
    }



    public function  weibo_cancel(){
//        $request = Request::instance();
//        return $this->redirect('/');
    }

    public function third_register($user){

        $user = User::create($user);//创建用户信息
        $user_id = $user->id;
        if($user_id){
            $playlist['name'] = '我喜欢的音乐';
            $playlist['user_id'] = $user_id;
            $playlist['is_action'] = 0;
            Playlist::create($playlist);//创建用户默认歌单
        }
        return $user_id;
    }


}
