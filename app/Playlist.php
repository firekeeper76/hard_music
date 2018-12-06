<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlist';
    protected $primaryKey = "id";    //定义用户表主键
    public $timestamps = true;         //是否有created_at和updated_at字段

    protected $fillable = [
        'name','song_num','user_id','cover','auto_cover','play','public_time','is_action','tags'
    ];

    public function user(){
        return $this->hasOne('\App\User','id','user_id');
    }

}
