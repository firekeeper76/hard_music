<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户</title>
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
    </style>
</head>
<body>

<div class="container">
    <div class="row pt-4 pl-5 pr-5">

        <div class="col-sm-12">
            <div style="width:980px;">
                <img src="/{{$user->avatar}}" width="180" height="180" alt="" class="" style="float:left;" onerror="this.src='/images/thumb_user_error.jpg'">
                <div style="float:left;width:670px;" class="pl-3">
                    <h5>{{$user->nickname}}</h5>
                    <hr>
                    @if($user->is_vip == 1)
                        <h6><a href="/vip"><img width="20" height="20" src="{{ URL::asset('images/vip_logo.png') }}"></img><span style="color:darkred">vip</span></a></h6>
                    @else
                        <h6><a href="/vip"><img width="20" height="20" src="{{ URL::asset('images/vip_logo_gray.png') }}" ></img><span style="color:gray"></span></a></h6>
                    @endif
                    <div id="number">
                        <!--<a href="">12312关注</a>-->
                        <!--&nbsp;|&nbsp;-->
                        <!--<a href="">12312粉丝</a>-->
                    </div>
                    <div style="height: 5px;"></div>
                    <span style="font-size: 14px;">社交网络：</span>
                    @foreach($user->user_auths as $v)
                        @if($v->identity_type == 'weibo')
                            <img src="/images/weibo.png" width="25" height="25" alt="">
                        @endif
                    @endforeach
                    <div style="height: 5px;"></div>
                    <br>
                    @if($type == 1)
                        <a href="/user/edit?id={{$user->id}}" class="btn btn-sm btn-danger"> 修改个人资料</a>
                    @endif
                </div>
            </div>
        </div>


    </div>
    <div class="row pt-4 pl-5 pr-5">
        <div class="col-12">

            <div class=" pt-4" style=""><!--内容-->
                <h5>{{$user->nickname}} 创建的歌单</h5>
                <hr style="background:#b21f2d;height:3px;">
            </div>

            <div class="row pl-3">
                @if($type==1)
                    @foreach($user->playlist as $v)
                        @if($v->public_time)
                            <div class="col-2 p-0 pb-4 ">
                                <a href="playlist?id={{$v->id}}"><img src="@if($v->cover){{URL::asset($v->cover)}}@else{{URL::asset($v->auto_cover)}}@endif"  class="" width="130" height="130" alt="" onerror="this.src='/images/thumb_playlist_error.jpg'"></a>
                                <a href="playlist?id={{$v->id}}"><span style="font-size:14px;">{{$v->name}}</span></a>
                            </div>
                        @else
                            <div class="col-2 p-0 pb-4 ">
                                <a href="/my_playlist"><img src="@if($v->cover){{URL::asset($v->cover)}}@else{{URL::asset($v->auto_cover)}}@endif"  class="" width="130" height="130" alt="" onerror="this.src='/images/thumb_playlist_error.jpg'"></a>
                                <a href="/my_playlist"><span style="font-size:14px;">{{$v->name}}</span></a>
                            </div>
                        @endif
                    @endforeach

                @else
                    @foreach($user->playlist as $v)
                        @if($v->public_time)
                            <div class="col-2 p-0 pb-4 ">
                                <a href="playlist?id={{$v->id}}"><img src="@if($v->cover){{URL::asset($v->cover)}}@else{{URL::asset($v->auto_cover)}}@endif"  class="" width="130" height="130" alt="" onerror="this.src='/images/thumb_playlist_error.jpg'"></a>
                                <a href="playlist?id={{$v->id}}"><span style="font-size:14px;">{{$v->name}}</span></a>
                            </div>
                        @endif
                    @endforeach

                @endif
            </div>

        </div>
    </div>
</div>


</body>
</html>