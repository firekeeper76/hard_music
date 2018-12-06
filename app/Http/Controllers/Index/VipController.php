<?php

namespace App\Http\Controllers\Index;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
class VipController extends Controller
{
    public function vip(){
        return view('index.vip.vip');
    }

    public function ddpay(Request $request){

        $data['pay_to'] = $request->get('payTo');
        if($data['pay_to'] == 'default'){
            $data['pay_to'] = 'WeChat';
        }
        $data['user_id'] = $request->get('playerId');
        $data['order_id'] = $request->get('orderId');
        $data['sign'] = $request->get('sign');
        $data['pay_price'] = $request->get('payPrice')/100; //单位是分 转换为元
        $data['goods_id'] = $request->get('goodsId');
        Order::create($data);


        $user['id'] = $data['user_id'];
        $user['vip_end_time'] = date('Y-m-d H:i:s',strtotime('+30 days'));
        $user['is_vip'] = 1;
        User::where('id',$user['id'])->update($user);
        Session::put('is_vip',1);
    }

}
