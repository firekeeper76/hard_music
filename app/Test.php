<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Test extends Model
{
    use SoftDeletes;
    protected $table = 'test';
    public $timestamps = true;
    protected $datas = ['deleted_at'];
    protected $fillable = [
        'name' ,
    ];

    const name = 'diyi';
    const namea = 'dier';
    const names = [
        self::name =>'第一',
        self::namea =>'第二'
    ];

    public function user(){
        return $this->hasOne('App\Index\User','id','user_id');
    }

    public function getNameAttribute($value)
    {
        if($value =='diyi'){
            $result ='第一';
        }else{
            $result = '第二';
        }
        return $result;
    }




}
