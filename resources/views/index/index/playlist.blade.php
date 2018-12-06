<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>歌单</title>
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
            color: gray;
        }
        .tags:hover{
            background:gainsboro;
            text-decoration: none;
        }
        .container{
            width:980px;
            min-height: 750px;
            max-width:none;
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

        .col-c5{
            width: 20%;
            padding:0;
        }
        .order_active{
            color: darkred;
        }
    </style>
</head>
<body>

<div class="container p-4">

    <div class="row pl-1 pr-3">
        <div class="col-10 pt-2">
            <span style="font-size:20px;" id="tag_tips"></span>
            &nbsp;
            <button class="btn btn-sm btn-3d" data-toggle="modal" data-target="#tags_modal" >选择分类</button>
        </div>
        <div class="col-2 pt-3 text-center">
            <a href="javascript:;" onclick="setOrder('hot')" ><button class="btn btn-sm" id="hot">热门</button></a>
            <a href="javascript:;" onclick="setOrder('new')" ><button class="btn btn-sm" id="new">最新</button></a>
        </div>
    </div>
    <hr style="float:left;background:#b21f2d;height:3px;width: 900px;">
    <div class="clearfix"></div>
    <div class="row pl-3">

        @foreach($playlists as $playlist)
        <div class="col-c5">
            <a href="/playlist?id={{$playlist->id}}"> <img width="140" src="@if($playlist->cover){{URL::asset($playlist->cover)}}@else{{URL::asset($playlist->auto_cover)}}@endif" title="{{$playlist->name}}" onerror="this.src='{{URL::asset('images/thumb_playlist_error.jpg')}}'"></a>
            <h6  style="width:130px;height: 20px;overflow: hidden;"><a href="/playlist?id={{$playlist->id}}" style="color: #000;" title="{{$playlist->name}}">{{$playlist->name}}</a></h6>
            <h6  style="width:130px;height: 20px;overflow: hidden;font-size:12px;"><a href="/user?id={{$playlist->user_id}}" style="color:gray">by {{$playlist->user->nickname}}</a></h6>
        </div>
        @endforeach

    </div>
    <div class="row">
        <div class="offset-4">
            {{$playlists->links()}}
        </div>
    </div>
</div>

<!--tags Modal-->
<div class="modal fade" id="tags_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><a href="/discover/playlist" class="pl-2 pr-2 text-center" style="color:black;">全部</a></h5>
                <button type="button" class="close" id="close_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="tags_body">
                @foreach($tags as $tag)
                <div class="row pb-3">
                    <div class="col-2">
                        {{$tag->name}}
                    </div>
                    <div class="col-10" style="border-left: 1px solid gainsboro;" >
                        @if($tag->son)
                            @foreach($tag->son as $t)
                                <a href="javascript:;" id="{{$t->name}}" onclick="setTag('{{$t->name}}')" class="tags pl-2 pr-2 text-center">{{$t->name}}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


<script>
var tag ;
var order;
function setTag(tagname){
    tag = tagname;
    order='';
    jump();
}
function setOrder(Order){
    order = Order;
    jump();
}

function jump(){


    // if(tag){
    //     url="/discover/playlist?tag="+tag;
    //     if(order){
    //         url=url+'&order='+order;
    //     }
    // }
    if(order && !tag){
        window.location.href="/discover/playlist?order="+order;
    }else if(tag && !order){
        window.location.href="/discover/playlist?tag="+tag;
    }else{
        window.location.href="/discover/playlist?order="+order+"&tag="+tag;
    }
    // $('#jump_playlist').attr('href',url);
    // $('#jump_playlist').click();
    // alert(url);
    // window.location.href
}
$(function () {
    var active = getParam('order');
    tag = getQueryString('tag');

    if(!tag){
        $('#tag_tips').html('全部');
    }else{
        $('#tag_tips').html(tag);
    }


    if(active == 'new'){
        $('#new').addClass('btn-danger');
    }else{
        $('#hot').addClass('btn-danger');
    }
})
// function getParam(paramName) {
//     paramValue = "", isFound = !1;
//     if (this.location.search.indexOf("?") == 0 && this.location.search.indexOf("=") > 1) {
//         arrSource = unescape(this.location.search).substring(1, this.location.search.length).split("&"), i = 0;
//         while (i < arrSource.length && !isFound) arrSource[i].indexOf("=") > 0 && arrSource[i].split("=")[0].toLowerCase() == paramName.toLowerCase() && (paramValue = arrSource[i].split("=")[1], isFound = !0), i++
//     }
//     return paramValue == "" && (paramValue = null), paramValue
// }
</script>

</body>
</html>