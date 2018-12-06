<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class AdminController extends Controller
{
    public function admin(){
        $admins = Admin::get();
        $count = Admin::count();
        return view('admin.admin.admin-list',['admins'=>$admins,'count'=>$count]);
    }

    public function add(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            $rule = [
                'phone' => 'required|min:11|max:11|unique:admin',
                'password' => 'required|min:3|max:25',
                'password_confirmation' => 'required|same:password',
                'role_id' => 'required|integer',
                'realname' =>'required|min:2',
            ];

            $validator = Validator::make($data, $rule);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $result['StateCode'] = 201;
                $result['message'] = $errors->first();
                return response() -> json($result);
            }
            $data['salt'] = md5(rand(1,50));
            $data['password'] = md5($data['salt'].$data['password']);

            if(Admin::create($data)){
                $result['StateCode'] = 100;

            }else{
                $result['StateCode'] = 200;
            }
            return response() -> json($result);
        }

        return view('admin.admin.admin-add');
    }


    public function update(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            if(Admin::where('id',$data['id'])->update($data)){
                $result['StateCode'] = 100;
            }else{
                $result['StateCode'] = 200;
            }
            return response()->json($result);
        }

        $admin = Admin::find($request->get('id'));
        return view('admin.admin.admin-edit',['admin'=>$admin]);
    }


    public function del(Request $request){
        if(Admin::destroy($request->get('id'))){
            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200;
        }
        return response()->json($result);
    }
    public function deleted(Request $request){
        $admins = Admin::onlyTrashed()->get();
        $count = Admin::onlyTrashed()->count();
        return view('admin.admin.admin-deleted-list',['admins'=>$admins,'count'=>$count]);
    }
    public function restore(Request $request){
        if(Admin::withTrashed()->find($request->get('id'))->restore()){
            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200;
        }
        return response()->json($result);
    }


    public function forceDelete(Request $request){
        if(Admin::withTrashed()->find($request->get('id'))->forceDelete()){
            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200;
        }
        return response()->json($result);
    }

}
