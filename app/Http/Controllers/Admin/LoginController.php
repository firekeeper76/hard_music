<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use App\Admin;
use Session;
class LoginController extends Controller
{
    public function login (Request $request){

        if(Input::method() == 'POST'){
            $data = $request->all();

            session()->flash('phone',$data['phone']);
            session()->flash('password',$data['password']);
            $this->validate($request,[
                'phone' => 'required|min:11|max:11',
                'password' => 'required|min:3|max:25',
                'captcha' => 'required|captcha',
            ]);

            $admin = Admin::where('phone',$data['phone'])->first();
            if($admin){
                if($admin->state == 1){
                    $password = md5($admin->salt.$data['password']);
                    if( $admin['password'] == $password ){

                        Session::put('admin',$admin);
                        Session::put('menu',$admin->role->menu);
                        $admin->login_ip = $request->getClientIp();
                        $admin->login_count = $admin->login_count +1;
                        $admin->login_at = date('Y-m-d H:i:s');
                        $admin->save();

                        return redirect('/admin/index');
                    }else{
                        $tips = '用户名或密码错误';
                    }
                }else{
                    $tips = '账号已被禁用';
                }

            }else{
                $tips = '用户名或密码错误';
            }

            return back()->with('tips',$tips);
        }else{
            return view('admin.login.login');
        }

    }

    public function login_off(Request $request){
        $request->session()->flush();
        return redirect('/admin/login');
    }


}
