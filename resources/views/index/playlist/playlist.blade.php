<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>歌单</title>
    @include('index.resources')
    <style>
        .container{
            width:980px;
            max-width:none;
            background: #ffffff;
            border-left:1px solid rgba(0,0,0,0.3);
            border-right:1px solid rgba(0,0,0,0.3);
            border-bottom:1px solid rgba(0,0,0,0.3);
        }
        .tags{
            height:20px;
            display: inline-block;
            background:ghostwhite;
            border-radius: 10px;
            border: 1px solid darkgray;
            line-height: 20px;
            font-size:14px;
            color:black;
        }
        .tags:hover{
            background:gainsboro;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">

        <div class="col-md-9 col-sm-9  pt-4 pl-5 pr-5" style="border-right:1px solid rgba(0,0,0,0.3);">

            <div style="width:640px;">
                <img src="@if($playlist->cover){{URL::asset($playlist->cover)}}@else{{URL::asset($playlist->auto_cover)}}@endif" width="180" height="180" alt="" class="" style="float:left;" onerror="this.src='{{URL::asset('images/thumb_playlist_error.jpg')}}'">
                <div style="float:right;width:460px;" class="pl-3">
                    <h5><span style="background: #b21f2d;border-radius: 60px;font-size:16px;color: #fff;">《歌单》</span>&nbsp;{{$playlist->name}}</h5>
                    <div class="mt-2" style="font-size:13px;">
                        <a href="/user?id={{$playlist->user_id}}"><img src="{{URL::asset($playlist->user->avatar)}}" id="head_img" width="40" height="40" alt=""  onerror="this.src='{{URL::asset('images/thumb_user_error.jpg')}}'"></a>
                        <a href="/user?id={{$playlist->user_id}}"  style="color:deepskyblue;" id="nickname">{{$playlist->user->nickname}}</a>&nbsp;
                        <span style="color:gray;"><span id="create_time">{{$playlist->public_time}}</span>  创建</span>
                    </div>
                    <div class="pt-2 pb-2" id="tag">
                        <span style="color:gray;font-size:14px;">标签：</span>

                    </div>
                    <button class="btn btn-danger" onclick="addSongsPlaylist()">播放</button>
                    @if($is_collection != 0)
                    <button class="btn" onclick="collection()" id="" disabled="disabled">已收藏</button>
                    @else
                    <button class="btn" onclick="collection()" id="collection">收藏</button>
                    @endif
                    <a href="#comment"><button class="btn">评论{{$comments_count}}</button></a>
                </div>
            </div>

            <div class="table-responsive pt-4" style=""><!--内容-->
                <div class="pb-3">
                    <h6><b>歌单介绍 :</b></h6>
                </div>
                <h5>包含歌曲列表</h5>
                <hr style="background:#b21f2d;height:3px;">
                <table class="table table-sm table-striped table-hover" style="max-width:640px">

                    <tbody class="w-100" id="song_list">
                    <!--<tr class="row mx-0" style="max-width: 640px;">-->
                        <!--<th class="col-1">&nbsp;</th>-->
                        <!--<th class="col-1">&nbsp;</th>-->
                        <!--<th class="col-4 over-flow">歌曲标题</th>-->
                        <!--<th class="col-2 over-flow">操作</th>-->
                        <!--<th class="col-2 over-flow">歌手</th>-->
                        <!--<th class="col-2 over-flow">专辑</th>-->
                    <!--</tr>-->
                    <!--<tr class="row mx-0" style="max-width: 640px;">-->
                        <!--<td class="col-1">01</td>-->
                        <!--<td class="col-1">bof</td>-->
                        <!--<td class="col-4 over-flow">歌曲标题</td>-->
                        <!--<td class="col-2 over-flow">操作</td>-->
                        <!--<td class="col-2 over-flow">歌手</td>-->
                        <!--<td class="col-2 over-flow">专辑</td>-->
                    <!--</tr>-->


                    </tbody>
                </table>

                <!--评论-->
                <div class="pt-3" >
                    <h5>评论 <span style="font-size:12px;">共 {{$comments_count}} 条评论</span></h5>
                    <hr style="background:#b21f2d;height:3px;">

                    <div class="row"  style="max-width:650px;">
                        <div class="col-2">
                            <img src="{{URL::asset(Session::get('avatar'))}}" width="60" height="60" alt="" onerror="this.src='{{URL::asset('images/thumb_user_error.jpg')}}'">
                        </div>
                        <div class="col form-group">
                            <textarea class="form-control" rows="2" id="comment" maxlength="140"></textarea>
                            <span class="text-success" id="comment_tips"></span>
                            <button class="btn btn-sm btn-danger mt-1" style="float:right;" onclick="comment()">评论</button>
                        </div>
                    </div>
                    <div style="float: right;" class="pr-3" id="order_box">
                        <a href="javascript:;" onclick="setOrder('like','hot')" style="color:red;" id="hot">热门</a>
                        <a href="javascript:;" onclick="setOrder('created_at','new')" id="new">最新</a>
                    </div>
                    <div class="clearfix"></div>
                    <div id="commentsData">

                    </div>
                    <!--单条评论-->
                    <!--<div class="row mb-3"  style="max-width:650px;">-->
                        <!--<div class="col-2">-->
                            <!--<img src="images/130.jpg" width="60" height="60" alt="" onerror="this.src='__PUBLIC__/images/thumb_user_error.jpg'">-->
                        <!--</div>-->
                        <!--<div class="col" style="max-width: 650px;">-->

                            <!--<div style="font-size:13px;">-->
                                <!--<div style="height:45px;">-->
                                    <!--<a href="" style="color:#0056b3">昵称 :</a>-->
                                    <!--dsalkjflkdjflkdsdsadsdsadssad dsadssad  sad sadsad是的撒多adflasjfalsjsalkjflkdjflkdsflasjfa-->
                                <!--</div>-->

                                <!--<div>-->
                                    <!--<span style="color:darkgray">2016-04-15</span>-->
                                    <!--<div style="float:right;">-->
                                        <!--<a href="javascript:;">点赞</a>-->
                                        <!--<a href="javascript:;" data-toggle="modal" data-target="#comments" onclick="comments(1,'abc')">评论</a>-->
                                    <!--</div>-->

                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--单条评论+子评论-->
                    <!--<div class="row mb-3"  style="max-width:650px;">-->
                        <!--<div class="col-2">-->
                        <!--<img src="images/130.jpg" width="60" height="60" alt="" onerror="this.src='__PUBLIC__/images/thumb_user_error.jpg'">-->
                        <!--</div>-->
                        <!--<div class="col" style="max-width: 650px;">-->

                            <!--<div style="font-size:13px;">-->
                                <!--<div style="height:45px;">-->
                                    <!--<a href="" style="color:#0056b3">昵称 :</a>-->
                                    <!--dsalkjflkdjflkdsdsadsdsadssad dsadssad-->
                                <!--</div>-->

                                <!--<div style="width:90%;background:rgba(255,211,211,0.3);padding-left: 30px;">-->
                                    <!--<a href="" style="color:#0056b3">昵称 :</a>-->
                                    <!--dsalkjflkdjflkdsdsadsdsadssad dsadssadjflkdjflkdsdsadsdsadssad dsadssadjflkdjflkdsdsadsdsadssad dsadssadjflkdjflkdsdsadsdsadssad dsadssadjflkdjflkdsdsadsdsadssad dsadssad-->
                                <!--</div>-->

                                <!--<div>-->
                                    <!--<span style="color:darkgray">2016-04-15</span>-->
                                    <!--<div style="float:right;">-->
                                        <!--<a href="javascript:;">点赞</a>-->
                                        <!--<a href="javascript:;" data-toggle="modal" data-target="#comments" onclick="comments(1,'bbb')">评论</a>-->
                                    <!--</div>-->

                                <!--</div>-->

                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                </div>
                <div class="row pt-3 pb-3" style="width: 640px;">
                    <div class="col-sm-2">
                        <button class="btn" onclick="setPage('prev')">上一页</button>
                    </div>
                    <div class="col-sm-2" id="page_tips">
                        第1页
                    </div>
                    <div class="col-sm-2">
                        <button class="btn" onclick="setPage('next')">下一页</button>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" id="page_jump" value="" onchange="setPage(this.value)" style="width: 70px;">

                        </select>
                    </div>

                </div>
            </div>
        </div>


        <!--右边栏-->
        <div class="col-sm-3  pt-4  pl-3 pr-3" >

            <div class="mb-5">
                <h5>其他热门歌单</h5>
                <hr style="background:darkgray;height:1px; opacity: 0.3;">
                @foreach($other_playlist as $p)
                <div class="media mb-3">
                    <a href="/playlist?id={{$p->id}}"><img src="@if($p->cover){{URL::asset($p->cover)}}@else{{URL::asset($p->auto_cover)}}@endif" class="mr-1" width="50" height="50" alt="" onerror="this.src='{{URL::asset('images/thumb_playlist_error.jpg')}}'"></a>
                    <div class="media-body" >
                        <h6 class="mt-0" style="width:160px;height:20px;overflow:hidden;"> <a href="/playlist?id={{$p->id}}">{{$p->name}}</a></h6>
                        <span class="text-muted">{{$p->public_time}}</span>
                    </div>
                </div>
                @endforeach

            </div>


        </div>
        
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="comments" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">评论</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="to_id" value="">
                <textarea class="form-control" rows="2" id="reply_content" maxlength="140" placeholder="评论：aa"></textarea>
                <span class="text-muted" style="font-size:12px;">最多输入140个字</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="reply()">评论</button>
            </div>
        </div>
    </div>
</div>


<script>

var limit = 6;
var page = 1;
var from_uid = "{{Session::get('id')}}";
var topic_type = 3;
var topic_id = "{{$playlist->id}}";
var order = "like";
var comments_count = "{{$comments_count}}";

var page_over = Math.ceil(comments_count/limit);
    //收藏歌单
    function collection(){
        if(!from_uid){
            window.parent.setTips('请先登录');
        }else{
            // alert(topic_id+"----"+from_id);
            $.ajax({
                url:'/collection_playlist',
                type:'post',
                dataType:"json",
                data:{"topic_id":topic_id,'topic_type':2,'user_id':from_uid},
                success:function (result) {
                    // alert(JSON.stringify(result));
                    if(result ==100){
                        $('#collection').attr('disabled','disabled');
                        $('#collection').html('已收藏');
                    }else{
                        window.parent.setTips('收藏失败');
                    }
                },
                error:function (){
                    window.parent.setTips('收藏失败，请检查网络');
                }
            })
        }
    }




//播放
// function addPlaylist(json) {
//     window.parent.addSong(json);
// }
// //添加到播放列表
// function addToPlaylist(json) {
//     window.parent.addSongPlaylist(json);
// }
// //添加到我的歌单
// function addToMyPlaylist(id,topic_type){
//     window.parent.openPlayList(id,topic_type);
// }


var add_playlist=[];

function addSongsPlaylist(json){

    window.parent.addSongsPlaylist(add_playlist,topic_id,topic_type);
}
var tags = '{{$playlist->tags}}';
tags = tags.split(',');
for(var i=0;i<tags.length;i++){
    $('#tag').append(" <a href=\"/discover/playlist?tag="+tags[i]+"\" class=\"pl-2 pr-2 text-center tags\" >"+tags[i]+"</a>");
}

for (var i=1; i<=page_over;i++){
    $('#page_jump').append("<option value=\""+i+"\">"+i+"</option>");
}

$(function () {


    $.ajax({
        url:'/getPlayListSong',
        type:'post',
        dataType:"json",
        data:{'id':topic_id},
        success:function (result) {
            $('#song_list').append("<tr class=\"row mx-0\">\n" +
                "                        <th class=\"col-1\">&nbsp;</th>\n" +
                "                        <th class=\"col-1\">&nbsp;</th>\n" +
                "                        <th class=\"col-4 over-flow\">歌曲标题</th>\n" +
                "                        <th class=\"col-2 over-flow\">歌手</th>\n" +
                "                        <th class=\"col-2 over-flow\">操作</th>\n" +
                "                        <th class=\"col-2 over-flow\">专辑</th>\n" +
                "                    </tr>");
            add_playlist=[];
            for (var i=0; i<result.length; i++){
                add_playlist.push({
                    title: result[i]['name'],
                    singer: result[i]['artist_name'],
                    cover: "/"+result[i]['cover'],
                    src: '/'+result[i]['file_src'],
                    lyric  : "",
                    index: 1,
                    id:result[i]['id'],
                    vip:result[i]['vip']
                });
                if(!result[i]['album_name']){
                    result[i]['album_name'] = ' ';
                }
                if(result[i]['mv_id']){
                    $('#song_list').append("<tr class=\"row mx-0\">\n" +
                        "                        <td class=\"col-1\">"+(i+1)+"</td>\n" +
                        "                        <td class=\"col-1\">\n" +
                        "                            <a href='javascript:;' onclick=\"addPlaylist( { 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"'} )\"><i class=\"fa fa-play-circle\" aria-hidden=\"true\"></i></a>\n" +
                        "                        </td>\n" +
                        "                        <td class=\"col-4 over-flow\">\n" +
                        "                            <a href=\"/mv?id="+result[i]['mv_id']+"\"><i class=\"fa fa-youtube-play\" style=\"color:red;\" aria-hidden=\"true\"></i></a>\n" +
                        "                            <a href=\"/song?id="+result[i]['id']+"\">"+result[i]['name']+"</a>\n" +
                        "                        </td>\n" +
                        "                        <td class=\"col-2 over-flow\"><a href=\"/artist?id="+result[i]['artist_id']+"\">"+result[i]['artist_name']+"</a></td>\n" +
                        "                        <td class=\"col-2 over-flow\">\n" +
                        "                            <a href=javascript:;' onclick=\"addToPlaylist({ 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"'})\" title=\"添加到播放列表\"><i class=\"fa fa-bars\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                            <a href='javascript:;' onclick=\"addToMyPlaylist('"+result[i]['id']+"',1)\" title=\"收藏到歌单\"><i class=\"fa fa-plus-square-o\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                            <a href=\"/"+result[i]['file_src']+"\" target=\"_blank\"  title=\"下载\"><i class=\"fa fa-arrow-circle-down\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                           &nbsp;\n" +
                        "                        </td>\n" +
                        "                        <td class=\"col-2 over-flow\"><a href=\"/album?id="+result[i]['album_id']+"\">"+result[i]['album_name']+"</a></td>\n" +
                        "                    </tr>");
                }else{

                    $('#song_list').append("<tr class=\"row mx-0\">\n" +
                        "                        <td class=\"col-1\">"+(i+1)+"</td>\n" +
                        "                        <td class=\"col-1\">\n" +
                        "                            <a href='javascript:;' onclick=\"addPlaylist( { 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"' } )\"><i class=\"fa fa-play-circle\" aria-hidden=\"true\"></i></a>\n" +
                        "                        </td>\n" +
                        "                        <td class=\"col-4 over-flow\">\n" +
                        "                            \n" +
                        "                            <a href=\"/song?id="+result[i]['id']+"\">"+result[i]['name']+"</a>\n" +
                        "                        </td>\n" +
                        "                        <td class=\"col-2 over-flow\"><a href=\"/artist?id="+result[i]['artist_id']+"\">"+result[i]['artist_name']+"</a></td>\n" +
                        "                        <td class=\"col-2 over-flow\">\n" +
                        "                            <a href='javascript:;' onclick=\"addToPlaylist({ 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"'})\" title=\"添加到播放列表\"><i class=\"fa fa-bars\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                            <a href='javascript:;' onclick=\"addToMyPlaylist('"+result[i]['id']+"',1)\" title=\"收藏到歌单\"><i class=\"fa fa-plus-square-o\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                            <a href=\"/"+result[i]['file_src']+"\" target=\"_blank\"  title=\"下载\"><i class=\"fa fa-arrow-circle-down\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                            &nbsp;\n" +
                        "                        </td>\n" +
                        "                        <td class=\"col-2 over-flow\"><a href=\"/album?id="+result[i]['album_id']+"\">"+result[i]['album_name']+"</a></td>\n" +
                        "                    </tr>");
                }

            }
            var height = document.body.clientHeight;
            window.parent.setHeight(height);
        },
        error:function (){
            // alert("无法评论，您的网络似乎有问题");
        }

    })
    getComment();
})




</script>

</body>
</html>