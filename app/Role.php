<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Role extends Model
{
    use SoftDeletes;
    protected $table = "role";
    public $timestamps = true;
    protected $datas = ['deleted_at'];
    protected $fillable = [
       'name'
    ];

//    public function auth(){
//        return $this->belongsToMany('\App\Auth','role_auth','role_id','auth_id');
//    }
    public function menu(){
        return $this->belongsToMany('\App\Menu','role_menu','role_id','menu_id');
    }

}
