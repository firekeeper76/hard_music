<?php

namespace App\Http\Controllers\Index;

use Session;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function user(Request $request){
        $id = $request->get('id');
        $type = 0;
        if($id == Session::get('id')){// type1 = 用户自己
            $type = 1;
        }
        $user = User::findOrFail($id);

        return view('index.user.user',['user'=>$user,'type'=>$type]);
    }

    public function user_edit(Request $request){
        if($request->isMethod('post')){


            $data = $request->all();
            $rule = [
                'nickname' => 'required|min:2|max:20',
                'sex' => 'required',
                'id' => 'required'
            ];
            $validator = Validator::make($data, $rule);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $result['StateCode'] = 201;
                $result['messages'] = $errors->first();
                return response() -> json($result);
            }
//
            if(User::where('id',$data['id'])->update($data)){
                $result['StateCode'] = 100;
            }else{
                $result['StateCode'] = 200;
            }


            return response() -> json($result);

        }
        $id = $request->get('id');
        if($id != Session::get('id')){// type1 = 用户自己
            return redirect('/main');
        }
        $user = User::find($id);
        return view('index.user.user_edit',['user'=>$user]);
    }

    public function update_user_avatar(Request $request){
        $data = $request->except('old_avatar');
        $old_avatar = $request->get('old_avatar');


        if(User::where('id',$data['id'])->update($data)){//更新成功
            Session::put('avatar',$data['avatar']);
            if(Storage::disk('local')->exists('public/'.$old_avatar)){//判断图片是否存在
                Storage::disk('local')->delete('public/'.$old_avatar);
            }
            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200; //更新失败
        }
        return response()->json($result);
    }




}
