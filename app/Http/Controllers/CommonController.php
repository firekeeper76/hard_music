<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
class CommonController extends Controller
{
    /*
    上传base64图片函数
    */
    public function upload_base64_image(Request $request){
        $base64_image = $request->get('base64_image');
        $type = $request->get('type');


        if($type == 'artist'){

            $base64_image = str_replace(' ', '+', $base64_image);
            //post的数据里面，加号会被替换为空格，需要重新替换回来，如果不是post的数据，则注释掉这一行

            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)){
                //匹配成功
                if($result[2] == 'jpeg'){
                    $image_name = uniqid().'.jpg';
                    //纯粹是看jpeg不爽才替换的
                }else{
                    $image_name = uniqid().'.'.$result[2];
                }
                $date = date('Ymd');
                $src = "uploads/".$type."_images/$date/{$image_name}";
                $Folder = "uploads/".$type."_images/$date";
                if(!is_dir($Folder)){//文件夹不存在
                    mkdir($Folder);
                }

//            //服务器文件存储路径
                if (file_put_contents($src, base64_decode(str_replace($result[1], '', $base64_image)))){
                    $image = new ImageManager();
                    $image->make(base_path().'/public/'.$src)->resize(130,130)->save(base_path().'/public/'.$Folder."/thumb_{$image_name}");
                    $result_img['avatar'] = "uploads/".$type."_images/$date/thumb_{$image_name}";
                    $result_img['cover'] = $src;

                    return response()->json($result_img);
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            $base64_image = str_replace(' ', '+', $base64_image);
            //post的数据里面，加号会被替换为空格，需要重新替换回来，如果不是post的数据，则注释掉这一行

            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)){
                //匹配成功
                if($result[2] == 'jpeg'){
                    $image_name = uniqid().'.jpg';
                    //纯粹是看jpeg不爽才替换的
                }else{
                    $image_name = uniqid().'.'.$result[2];
                }
                $date = date('Ymd');
                $src = "uploads/".$type."_images/$date/{$image_name}";

                $Folder = "uploads/".$type."_images/$date/";
                if(!is_dir($Folder)){//文件夹不存在
                    mkdir($Folder);
                }

                //服务器文件存储路径
                if (file_put_contents($src, base64_decode(str_replace($result[1], '', $base64_image)))){
                    return response()->json($src);
                }else{
                    return false;
                }

            }else{
                return false;
            }
        }
//        else if($type == 'banner'){
//            $base64_image = str_replace(' ', '+', $base64_image);
//            //post的数据里面，加号会被替换为空格，需要重新替换回来，如果不是post的数据，则注释掉这一行
//
//            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)){
//                //匹配成功
//                if($result[2] == 'jpeg'){
//                    $image_name = uniqid().'.jpg';
//                    //纯粹是看jpeg不爽才替换的
//                }else{
//                    $image_name = uniqid().'.'.$result[2];
//                }
//                $date = date('Ymd');
//                $src = "uploads/$type/$date/{$image_name}";
//
//                $Folder = "uploads/$type/$date/";
//                if(!is_dir($Folder)){//文件夹不存在
//                    mkdir($Folder);
//                }
//
//
//                //服务器文件存储路径
//                if (file_put_contents($src, base64_decode(str_replace($result[1], '', $base64_image)))){
//                    return response()->json($src);
//                }else{
//                    return false;
//                }
//            }else{
//                return false;
//            }
//        }

    }

}
