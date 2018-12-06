<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cache;
use Validator;
class TagController extends Controller
{
    public function tag(Request $request){
        $tags = (new Tag())->tree();
        return view('admin.tag.tag',['tags'=>$tags]);
    }

    public function add(Request $request){
        $data = $request->all();
        $rule = [
            'name' => 'required|min:2|max:10|unique:tag',
            'pid' => 'required|integer'
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $result['StateCode'] = 201;
            $result['message'] = $errors->first();
            return response() -> json($result);
        }

        if(Tag::create($data)) {
            Cache::forget('tag');
            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200;
        }
        return response()->json($result);

    }

    public function update(Request $request){
        $data = $request->all();
        $rule = [
            'name' => 'required|min:2|max:10|unique:tag',
            'pid' => 'required|integer'
        ];
        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $result['StateCode'] = 201;
            $result['message'] = $errors->first();
            return response() -> json($result);
        }
        if(Tag::where('id',$data['id'])->update($data)) {
            Cache::forget('tag');
            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200;
        }
        return response()->json($result);
    }

    public function del(Request $request){
        if(Tag::where('id',$request->get('id'))->delete()) {
            Cache::forget('tag');
            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200;
        }
        return response()->json($result);
    }

}
