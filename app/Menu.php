<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Menu extends Model
{
    use SoftDeletes;
    protected $table = "menu";
    public $timestamps = true;
    protected $datas = ['deleted_at'];
    protected $fillable = [
        'name','url','pid'
    ];


}
