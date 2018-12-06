<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Cache;
use Illuminate\Support\Facades\DB;


class Category extends Model
{
    use SoftDeletes;
    protected $table = 'category';
    public $timestamps = false;
    protected $datas = ['deleted_at'];
    protected $fillable = [
        'catename','pid','sort',
    ];

    public function tree(){
        return Cache::rememberforever('category',function (){
            $data = $this->orderBy('sort','asc')->get();
            return $this->getTree($data);
        });
    }

    public function getTree($data,$id=0){

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


    public function addAll(Array $data)
    {
        $rs = DB::table('category')->insert($data);
        return $rs;
    }


}
