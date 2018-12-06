<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_auths extends Model
{
    protected $table = 'user_auths';
    protected $fillable = [
        'identifier','credential','identity_type','user_id',
    ];

    public function user(){
        return $this->hasOne('\App\User 原始','id','user_id');
    }


}
