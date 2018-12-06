<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
class Tag extends Model
{
    protected $table = 'tag';
    public $timestamps = false;
    protected $fillable = [
        'name','pid',
    ];

    public function tree(){
        return Cache::rememberforever('tag',function (){
            $data = $this->all();
            return $this->getTree($data);
        });
//        $data = $this->all();
//        return $this->getTree($data);
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
}
