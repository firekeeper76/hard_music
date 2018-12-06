<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collection';
    public $timestamps = false;
    protected $fillable = [
        'topic_id','topic_type','user_id','playlist_id','created_at',
    ];

    public function song(){
        return $this->hasOne('\App\Song','id','topic_id')->withTrashed();
    }
    public function playlist(){
        return $this->hasOne('\App\Playlist','id','topic_id');
    }
}
