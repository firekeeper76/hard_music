<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Admin extends Model
{
    use SoftDeletes;
    protected $table = "admin";
    public $timestamps = true;
    protected $datas = ['deleted_at'];
    protected $fillable = [
        'phone','password','salt','realname','state','role_id','login_at','login_ip','login_count'
    ];

    public function role(){
        return $this->hasOne('\App\Role','id','role_id');
    }


}
