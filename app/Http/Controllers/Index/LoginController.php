<?php

namespace App\Http\Controllers\Index;



use App\Playlist;
use App\User;
use App\User_auths;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
class LoginController extends Controller
{
    /*
     * 用户普通登录
     * 方法：POST
     * 参数：identifier，credential，captcha，identity_type
     */
    public function login(Request $request)
    {
        $data = $request->all();
        $rule = [
            'captcha' => 'required|captcha',
            'identifier' => 'required|min:11|max:11',
            'credential' => 'required|min:3|max:25',
        ];
        if($data['identity_type'] == 'phone'){
            $rule['identifier'] = 'required|min:11|max:11';
        }

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $result['StateCode'] = 200;
            $result['messages'] = $errors->first();
            return response() -> json($result);
        }
        $auths = User_auths::where('identity_type',$data['identity_type'])->where('identifier',$data['identifier'])->first();

        $result['StateCode'] = 201;
        $result['messages'] = '用户名或密码错误';
        if($auths){
            $credential = md5($data['credential'].'music');
            if( $auths->credential == $credential ){
                $user = User::find($auths->user_id);

                if($user['is_vip'] == 1){
                    if($user['vip_end_time'] < date('Y-m-d H:i:s',time())){
                        $user->is_vip = 0;
                        $user->save();
                        Session::put('is_vip',0);
                    }else {
                        Session::put('is_vip',1);
                    }
                }else{
                    Session::put('is_vip',0);
                }
                Session::put('nickname',$user['nickname']);
                Session::put('id',$user['id']);
                Session::put('avatar',$user['avatar']);
                $result['StateCode'] = 100;
            }else{
                $result['StateCode'] = 201;
                $result['messages'] = '用户名或密码错误';
            }
        }else{
            $result['StateCode'] = 201;
            $result['messages'] = '用户名或密码错误';
        }
        return response() -> json($result);

    }

    public function register(Request $request)
    {
        $data = $request->all();
//        return response() -> json($data);
        $rule = [
            'identifier' => 'required|min:11|max:11|unique:user_auths',
            'credential' => 'required|min:3|max:25',
            'password_confirmation' => 'required|same:credential'
        ];
        if($data['identity_type'] == 'phone'){
            $rule['identifier'] = 'required|min:11|max:11|unique:user_auths';
        }

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $result['StateCode'] = 200;
            $result['messages'] = $errors->first();
            return response() -> json($result);
        }

        $user = User::create(['is_vip'=>0]);//创建用户信息
        $user_id = $user->id;
        if($user_id){
            $playlist['name'] = '我喜欢的音乐';
            $playlist['user_id'] = $user_id;
            $playlist['is_action'] = 0;
            Playlist::create($playlist);//创建用户默认歌单

            $user_auths = new User_auths();  //写入用户登录方式
            $user_auths->identifier = $data['identifier'];
            $user_auths->identity_type = $data['identity_type'];
            $user_auths->credential = md5($data['credential'].'music');
            $user_auths->user_id = $user_id;
            if($user_auths->save()){
                $result['StateCode'] = 100;
                $result['messages'] = '注册成功';
            }

        }else{
            $result['StateCode'] = 200;
            $result['messages'] = '创建用户失败';
        }
        return response() -> json($result);
    }

    public function login_off(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }



}
