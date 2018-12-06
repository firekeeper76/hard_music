<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    public $timestamps = true;
    protected $fillable = [
        'nickname','intro','sex','birthday','region','is_vip','avatar','vip_end_time'
    ];


    public function user_auths(){
        return $this->hasMany('\App\User_auths','user_id','id');
    }

    public function playlist(){
        return $this->hasMany('\App\Playlist','user_id','id');
    }
}
