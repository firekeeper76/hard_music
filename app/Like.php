<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //type 1评论,2MV,3动态
    protected $table = 'like';
    public $timestamps = false;
    protected $fillable = [
        'type','to_id','user_id','created_time'
    ];



}
