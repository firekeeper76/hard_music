<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户</title>
    @include('index.resources')
    <style>
        .tags{
            height:20px;
            display: inline-block;
            background:ghostwhite;
            border-radius: 10px;
            border: 1px solid darkgray;
            line-height: 20px;
            font-size:14px;
        }
        .tags:hover{
            background:gainsboro;
            text-decoration: none;
        }
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
    </style>
</head>
<body>

<div class="container">
    <div class="row pt-4 pl-5 pr-5">

        <div class="col-sm-12">
            <div style="width:980px;">
                <img src="__PUBLIC__/{$user.head_img}" width="180" height="180" alt="" class="" style="float:left;" onerror="this.src='__PUBLIC__/images/thumb_user_error.jpg'">
                <div style="float:left;width:670px;" class="pl-3">
                    <h5>{$user.nickname} &nbsp;</h5>
                    <hr>
                    {if condition="$user.is_vip eq 1"}<i class="fa fa-diamond" style="color: darkred;font-size:12px;">vip会员</i>  {else}
                    <a href="/vip">成为会员</a>{/if}
                    <div id="number">
                        <!--<a href="">12312关注</a>-->
                        <!--&nbsp;|&nbsp;-->
                        <!--<a href="">12312粉丝</a>-->
                    </div>
                    {volist name="$auths" id="vo"}
                    <div style="height: 5px;"></div>
                    {if condition="$vo.identity_type eq 'weibo'"}<img src="__PUBLIC__/images/weibo.png" width="25" height="25" alt=""><span>已绑定微博 id: {$vo.identifier} </span>{/if}
                    <div style="height: 5px;"></div>
                    {/volist}
                    <br>
                    <a href="/me/edit?id={$user.id}" class="btn btn-danger"> 修改个人资料</a>
                </div>
            </div>
        </div>


    </div>
    <div class="row pt-4 pl-5 pr-5">
        <div class="col-12">

            <div class=" pt-4" style=""><!--内容-->
                <h5>我创建的歌单</h5>
                <hr style="background:#b21f2d;height:3px;">
            </div>

            <div class="row pl-3">
                {volist name="playlist" id="vo"}
                <div class="col-2 p-0 pb-4 ">
                    <a href="/my/playlist"><img src="__PUBLIC__/{if condition='$vo.cover'}{$vo.cover}{else}{$vo.auto_cover}{/if}"  class="" width="130" height="130" alt="" onerror="this.src='__PUBLIC__/images/thumb_playlist_error.jpg'"></a>
                    <a href="/my/playlist"><span style="font-size:14px;">{$vo.name}</span></a>
                </div>
                {/volist}
            </div>

        </div>
    </div>
</div>



</body>
</html>