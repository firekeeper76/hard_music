<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_auths extends Model
{
    protected $table = 'user_auths';
    public $timestamps = true;
    protected $fillable = [
        'identifier','credential','identity_type','user_id',
    ];

    public function user(){
        return $this->hasOne('\App\User','id','user_id');
    }
}
