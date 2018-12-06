<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Artist extends Model
{
    use SoftDeletes;

    protected $table = 'artist';
    public $timestamps = true;
    protected $datas = ['deleted_at'];
    protected $fillable = [
        'name','cover','avatar','category_id','intro','company'
    ];

    public function song(){
        return $this->hasMany('\App\Song','artist_id','id');
    }
    public function category(){
        return $this->hasOne('\App\Category','id','category_id');
    }
}
