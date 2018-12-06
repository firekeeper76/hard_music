<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Cache;
class BannerController extends Controller
{
    public function banner(){
        $banners = Banner::orderBy('sort','desc')->get();
        return view('admin.banner.banner',['banners'=>$banners]);
    }

    public function add(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(Banner::create($data)){
                $result = 100;
            }else{
                $result = 200;
            }
            return response()->json($result);
        }
        return view('admin.banner.banner-add');
    }

    public function update(Request $request){
        if($request->isMethod('post')){
            $data = $request->except('old_src');
            $old_src = $request->get('old_src');
            if(Banner::where('id',$data['id'])->update($data)){
                Cache::forget('banner');
                if(Storage::disk('local')->exists('public/'.$old_src)){//判断图片是否存在
                    Storage::disk('local')->delete('public/'.$old_src);
                }
                $result = 100;
            }else{
                $result = 200;
            }
            return response()->json($result);
        }
        $banner = Banner::find($request->get('id'));
        return view('admin.banner.banner-update',['banner'=>$banner]);
    }

    public function del(Request $request){
        if(Banner::destroy($request->get('id'))){
            Cache::forget('banner');
           $result = 100;
        }else{
            $result = 200;
        }
        return response()->json($result);
    }


    public function deleted(){
        $banners = Banner::onlyTrashed()->orderBy('deleted_at','desc')->get();
        return view('admin.banner.banner-deleted',['banners'=>$banners]);
    }

    public function forceDelete(Request $request){
        $id = $request->get('id');
        $src = $request->get('src');
        if(Banner::withTrashed()->find($id)->forceDelete()){
            if($src){
                if(Storage::disk('local')->exists('public/'.$src)){//判断图片是否存在
                    Storage::disk('local')->delete('public/'.$src);
                }
            }
            $result = 100;
        }else{
            $result = 200;
        }
        return response()->json($result);
    }


    public function restore(Request $request){
        if(Banner::withTrashed()->find($request->get('id'))->restore()){
            Cache::forget('banner');
            $result = 100;
        }else{
            $result = 200;
        }
        return response()->json($result);
    }
}
