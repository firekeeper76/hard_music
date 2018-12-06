<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    public $timestamps = true;
    protected $fillable = [
        'pay_to','user_id','order_id','sign','pay_price','goods_id'
    ];
    public function user(){
        return $this->hasOne('\App\User','id','user_id');
    }
    public function getPayToAttribute($value){
        if ($value=='AliPay'){
            $result = '支付宝';
        }else if($value == 'WeChat'){
            $result = '微信';
        }else{
            $result = '未知';
        }
        return $result;
    }

    public function getGoodsIdAttribute($value){
        if ($value=='vip_month'){
            $result = '会员一个月';
        }else{
            $result = '未知';
        }
        return $result;
    }

}
