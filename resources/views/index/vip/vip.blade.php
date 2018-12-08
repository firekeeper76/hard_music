<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会员</title>
    @include('index.resources')
    <style>
        .container{
            width:980px;
            max-width:none;
            min-height: 700px;
            background: #ffffff;
            border-left:1px solid rgba(0,0,0,0.3);
            border-right:1px solid rgba(0,0,0,0.3);
            border-bottom:1px solid rgba(0,0,0,0.3);
        }
        ul,li{
            cursor: pointer;
            list-style: none;
        }
        li:hover{
            background: lightgrey;
        }
        #number a{
            text-decoration: none;
        }
        #number a:hover{
            color:red;
        }
        .choose{
            height: 50px;
            width: 150px;
            background: ghostwhite;
            cursor: pointer;
            line-height: 50px;
            text-align: center;
        }
        .choose{
            height: 50px;
            width: 150px;
            background: ghostwhite;
            cursor: pointer;
            line-height: 50px;
            text-align: center;
        }
        .choose_active{
            border: 1px darkred solid;
        }
        .pay_way{
            height: 30px;
            display: inline-block;
            width: 80px;
            background: ghostwhite;
            cursor: pointer;
            line-height: 30px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row pt-4 pl-5 pr-5">

        <div class="col-6">
            <img src="/images/banner_vip.jpg" width="440" height="440" alt="">
        </div>
        <div class="col-6 pl-5" style="height: 440px;">
            <h3>云音乐VIP会员</h3>
            <hr class="mb-5">
            <h1 class="mb-5" style="color: darkred;">&nbsp;</h1>
            <div class=" choose choose_active">1个月</div>
            <div class="pt-4">
                <span class="pay_way choose_active" onclick="pay_way('default')" id="default">微信</span>&nbsp;
                <span class="pay_way" onclick="pay_way('AliPay')" id="AliPay">支付宝</span>&nbsp;
            </div>

            <div class="pt-5">
                <button class="btn btn-lg btn-danger" onclick="is_login()">立即购买</button>
                <button class="btn btn-lg btn-danger" data-toggle="modal"  data-target="#pay_modal" id="pay_btn" style="display: none;">立即购买</button>
            </div>
        </div>



    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="pay_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">支付 :</h5>&nbsp;
                <button type="button" class="close" id="pay_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="qrcode" width="200" height="200" alt="">
                <h4 style="color:darkred" id="price"></h4>
                <h5>打开手机 <span id="pay_tips">微信</span> 扫一扫</h5>
            </div>
            <div class="modal-footer">
                <span style="color: darkred; font-size: 12px;">系统到账可能存在延时，如有漏单请联系客服</span>
                <button class="btn btn-sm" onclick="pay_end()">已经支付完成?点击这里</button>
            </div>
        </div>
    </div>
</div>


<script>
var payTo = 'default';
var user_id = '{{Session::get('id')}}';
var orderid ;
function pay_way(way){
    if(way == 'AliPay'){
        $('#AliPay').addClass('choose_active');
        $('#default').removeClass('choose_active');
        $('#pay_tips').html('支付宝');
    }else{
        $('#default').addClass('choose_active');
        $('#AliPay').removeClass('choose_active');
        $('#pay_tips').html('微信');
    }
    payTo = way;
}
function is_login(){
    if(user_id){
        pay_vip();
        $('#pay_btn').click();
    }else{
        window.parent.login_btn();
    }
}
    function pay_vip(){
            $.ajax({
                url:'http://120.78.142.80/myPay/appid_create_order',
                type:"post",
                data:{ 'payTo':payTo,'appId':'XBgVrcYXgXVD6268E9521D6A8A8F55AB','playerId':user_id,'goodsId':'vip_month'},
                success:function (result) {
                    console.log(result.orderInfo['orderId']);
                    // console.log(JSON.stringify(result));
                    orderid = result.orderInfo['orderId'];
                    $('#price').html(result.orderInfo['payPrice']/100+" 元");
                    $('#qrcode').attr('src',"http://qr.liantu.com/api.php?w=460&text="+result.orderInfo['qrcodeURL']);
                },
                error:function (result) {
                    // alert(JSON.stringify(result));
                }
            })
    }

    function pay_end(){
        $.ajax({
            url:'http://120.78.142.80/myPay/is_pay_succ',
            type:"post",
            data:{ 'orderId':orderid,'appId':"XBgVrcYXgXVD6268E9521D6A8A8F55AB"},
            success:function (result) {

                console.log(JSON.stringify(result));
                if(result.code == 200){
                    window.parent.setTips('支付成功');
                    window.parent.myReload();
                    $.ajax({
                        url:'/isvip',
                        type:"post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success:function (result) {
                            console.log('aa-'+result);
                        },
                        error:function (result) {
                        }
                    });
                    setInterval(function() {
                        window.location.href="/user?id="+user_id;
                    }, 1000);
                }else{
                    window.parent.setTips('还没支付完成噢');
                }
            },
            error:function (result) {
                window.parent.setTips('如长时间未到账，请联系管理员');
            }
        })
    }
</script>

</body>
</html>