<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Banner extends Model
{
    use SoftDeletes;
    protected $table = 'banner';
    public $timestamps = true;
    protected $datas = ['deleted_at'];
    protected $fillable = [
        'src','src_to','bg_color','sort'
    ];


}
