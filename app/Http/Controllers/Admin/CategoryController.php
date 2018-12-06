<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Cache;
class CategoryController extends Controller
{
    public function category(){
        return view('admin.category.category');
    }
    public function getData(){
        $categorys = Category::where('pid',0)->get();
        $data = array(
            'code'=>0,
            'msg'=>"",
            'count'=> 0,
            'data' => $categorys,
        );
        return response()->json($data);
    }

    public function add(Request $request){
        if ($request->isMethod('post')){
            $data = $request->all();

            $rule = [
                'catename' => 'required|min:2|max:10|unique:category',
            ];
            if($data['sort']){
                $rule['sort'] = 'integer';
            }
            $validator = Validator::make($data, $rule);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $result['StateCode'] = 201;
                $result['message'] = $errors->first();
                return response() -> json($result);
            }
            $category = Category::create($data);
            if($category){
                Cache::forget('category');
                $name = $category->catename;
                $id = $category->id;
                $list = [
                    ['catename'=>$name.'男歌手','pid'=>$id,'sort'=>'1'],
                    ['catename'=>$name.'女歌手','pid'=>$id,'sort'=>'2'],
                    ['catename'=>$name.'组合/乐队','pid'=>$id,'sort'=>'3'],
                ];
                (new Category())->addAll($list);
                $result['StateCode'] = 100;
            }else{
                $result['StateCode'] = 200;
            }
            return response() -> json($result);
        }
        return view('admin.category.category-add');
    }


    public function del(Request $request){
        $id = $request->get('id');
        if(Category::destroy($id)){
            Cache::forget('category');
            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200;
        }
        return response()->json($result);
    }

    public function update(Request $request){

        $id = $request->get('id');
        $data[$request->get('field')] = $request->get('value');
        if(Category::where('id',$id)->update($data)){
            Cache::forget('category');

            $result['StateCode'] = 100;
        }else{
            $result['StateCode'] = 200;
        }
        return response()->json($result);
    }

}
