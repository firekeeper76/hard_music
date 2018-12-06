<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Song extends Model
{
    use SoftDeletes;
    protected $table = 'song';
    public $timestamps = true;
    protected $datas = ['deleted_at'];
    protected $fillable = [
        'name','artist_id','album_id','duration','file_src','cover','mv_id','tags','play','vip'
    ];
    public function artist(){
        return $this->hasOne('\App\Artist','id','artist_id')->withTrashed();
    }
    public function album(){
        return $this->hasOne('\App\Album','id','album_id')->withTrashed();
    }
}
