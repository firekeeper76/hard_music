<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Album extends Model
{
    use SoftDeletes;
    protected $datas = ['deleted_at'];
    protected $table = 'album';
    public $timestamps = true;
    protected $fillable = [
        'name','cover','public_time','artist_id','company','tags','play','intro'
    ];

    public function artist(){
        return $this->hasOne('\App\Artist','id','artist_id')->withTrashed();
    }

    public function songs(){
        return $this->hasMany('\App\Song','album_id','id');
    }

}
