<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/*
上传base64图片函数
*/
function upload_base64_image($type,$base64_image){
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
            $Folder = "static/uploads/".$type."_images/$date";
            if(!is_dir($Folder)){//文件夹不存在
                mkdir($Folder);
            }
            $image_file = "static/$src";
//            //服务器文件存储路径
            if (file_put_contents($image_file, base64_decode(str_replace($result[1], '', $base64_image)))){
                $image = \think\Image::open($image_file);
                $image->thumb(130,130,\think\Image::THUMB_CENTER)->save("$Folder/thumb_{$image_name}");
                $result_img['cover'] = $src;
                $result_img['head_img'] = "uploads/".$type."_images/$date/thumb_{$image_name}";
                return $result_img;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }else if($type == 'song' || $type =='album' || $type == 'user'){
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

            $Folder = "static/uploads/".$type."_images/$date/";
            if(!is_dir($Folder)){//文件夹不存在
                mkdir($Folder);
            }
            $image_file = "static/$src";

            //服务器文件存储路径
            if (file_put_contents($image_file, base64_decode(str_replace($result[1], '', $base64_image)))){
                return $src;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }else if($type == 'banner'){
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
            $src = "uploads/banner/{$image_name}";

            $Folder = "static/uploads/banner/";
            if(!is_dir($Folder)){//文件夹不存在
                mkdir($Folder);
            }
            $image_file = "static/$src";

            //服务器文件存储路径
            if (file_put_contents($image_file, base64_decode(str_replace($result[1], '', $base64_image)))){
                return $src;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


}


/*
 * 递归分类标签函数
*/
function recursion($data, $id=0) {
    $list = array();
    foreach($data as $v) {
        if($v['pid'] == $id) {
            $v['son'] = recursion($data, $v['id']);
            if(empty($v['son'])) {
                unset($v['son']);
            }
            array_push($list, $v);
        }
    }
    return $list;
}


function test (){
    return '公共函数';
}