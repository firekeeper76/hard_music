<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comment';
    public $timestamps = false;
    protected $datas = ['deleted_at'];
    protected $fillable = [
        'topic_id','topic_type','content','from_uid','to_id','like','created_at',
    ];

    public function user(){
        return $this->hasOne('\App\User','id','from_uid');
    }

}
