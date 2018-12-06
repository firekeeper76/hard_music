<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>专辑</title>
    @include('index.resources')
    <style>
        .container{
            width:980px;
            max-width:none;
            min-height:700px;
            background: #ffffff;
            border-left:1px solid rgba(0,0,0,0.3);
            border-right:1px solid rgba(0,0,0,0.3);
            border-bottom:1px solid rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">

        <div class="col-md-9 col-sm-9  pt-4 pl-5 pr-5" style="border-right:1px solid rgba(0,0,0,0.3);">

            <div style="width:640px;">
                <img src="{{URL::asset($album->cover)}}" width="180" height="180" alt="" class="" style="float:left;" onerror="this.src='/images/thumb_album_error.jpg'" >
                <div style="float:right;width:460px;" class="pl-3">
                    <h5><span style="background: #b21f2d;border-radius: 60px;font-size:16px;color: #fff;">《专辑》</span>&nbsp;{{$album->name}}</h5>
                    <h6>歌手：<a href="/artist?id={{$album->artist->id}}"  style="color:cornflowerblue;">{{$album->artist->name}}</a></h6>
                    <h6 style="color:gray;">发行时间：{{$album->public_time}}</h6>

                    <h6 style="color:gray;">发行公司：{{$album->company}}</h6>

                    <br>
                    <button class="btn btn-danger" onclick="addSongsPlaylist()">播放</button>
                    <!--<button class="btn ">收藏</button>-->
                    <a href="#comment"><button class="btn">评论{{$comments_count}}</button></a>
                </div>
            </div>

            <div class="table-responsive pt-4" style=""><!--内容-->
                <div class="pb-3">
                    <h6><b>专辑介绍 :</b></h6>
                    <div style="font-size:12px;">
                        {!!$album->intro!!}
                    </div>
                </div>
                <h5>包含歌曲列表</h5>
                <hr style="background:#b21f2d;height:3px;">
                <table class="table table-sm table-striped table-hover" style="max-width:640px">

                    <tbody class="w-100" id="song_list">
                    {{--<tr class="row mx-0" style="max-width: 640px;">--}}
                        {{--<th class="col-1">&nbsp;</th>--}}
                        {{--<th class="col-1">&nbsp;</th>--}}
                        {{--<th class="col-5 over-flow">歌曲标题</th>--}}
                        {{--<th class="col-2 over-flow">操作</th>--}}
                        {{--<th class="col-3 over-flow">歌手</th>--}}
                    {{--</tr>--}}

                    {{--{volist name="song" id="vo" key="index"}--}}
                    {{--<tr class="row mx-0" style="max-width: 640px;">--}}
                        {{--<td class="col-1">{$index}</td>--}}
                        {{--<td class="col-1"><a href="javascript:addPlaylist( { 'id':'{$vo.id}','name':'{$vo.name}','artist_name':'{$vo.artist_name}','file_src':'__PUBLIC__/{$vo.file_src}','cover':'__PUBLIC__/{$vo.cover}','vip':'{$vo.vip}'} )"><i class="fa fa-play-circle" aria-hidden="true"></i></a></td>--}}
                        {{--<td class="col-5 over-flow">--}}
                            {{--{if condition="$vo.mv_id neq ''"}<a href="/mv?id={$vo.mv_id}"><i class="fa fa-youtube-play" style="color:red;" aria-hidden="true"></i></a>{/if}--}}
                            {{--<a href="/song?id={$vo.id}" title="{$vo.name}">{$vo.name}</a>--}}
                        {{--</td>--}}
                        {{--<td class="col-2 over-flow text-center">--}}
                            {{--<a href="javascript:addToPlaylist({  'id':'{$vo.id}','name':'{$vo.name}','artist_name':'{$vo.artist_name}','file_src':'__PUBLIC__/{$vo.file_src}','cover':'__PUBLIC__/{$vo.cover}','vip':'{$vo.vip}' });" title="添加到播放列表"><i class="fa fa-bars" style="color:red;" aria-hidden="true"></i></a>&nbsp;--}}
                            {{--<a href="javascript:addToMyPlaylist('{$vo.id}',1);" title="收藏到歌单"><i class="fa fa-plus-square-o" style="color:red;" aria-hidden="true"></i></a>&nbsp;--}}
                            {{--<a href="/{$vo.file_src}" target="_blank"  title="下载"><i class="fa fa-arrow-circle-down" style="color:red;" aria-hidden="true"></i></a>&nbsp;--}}
                        {{--</td>--}}
                        {{--<td class="col-3 over-flow"><a href="/artist?id={$vo.artist_id}">{$vo.artist_name}</a></td>--}}
                    {{--</tr>--}}
                    {{--{/volist}--}}

                    </tbody>
                </table>

                <!--评论-->
                <div class="pt-3" >
                    <h5>评论 <span style="font-size:12px;">共 {{$comments_count}} 条评论</span></h5>
                    <hr style="background:#b21f2d;height:3px;">

                    <div class="row"  style="max-width:650px;">
                        <div class="col-2">
                            <img src="/{{Session::get('avatar')}}" width="60" height="60" alt="" onerror="this.src='/images/thumb_user_error.jpg'">
                        </div>
                        <div class="col form-group">
                            <textarea class="form-control" rows="2" id="comment" maxlength="140"></textarea>
                            <span class="text-success" id="comment_tips"></span>
                            <button class="btn btn-sm btn-danger mt-1" style="float:right;" onclick="comment()">评论</button>
                        </div>
                    </div>
                    <div style="float: right;" class="pr-3" id="order_box">
                        <a href="javascript:;" onclick="setOrder('like','hot')" style="color:red;" id="hot">热门</a>
                        <a href="javascript:;" onclick="setOrder('created_at','new')"  id="new">最新</a>
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
                <h5>Ta的其他专辑</h5>
                <hr style="background:darkgray;height:1px; opacity: 0.3;">

                <!--专辑循环体-->
                @foreach($other_album as $album)
                <div class="media mb-3">
                    <a href="/album?id={{$album->id}}"><img src="{{URL::asset($album->cover)}}" class="mr-1" width="50" height="50" alt="" onerror="this.src='/images/thumb_album_error.jpg'"></a>
                    <div class="media-body" >
                        <h6 class="mt-0" style="width:160px;height:20px;overflow:hidden;"> <a href="/album?id={{$album->id}}">{{$album->name}}</a></h6>
                        <span class="text-muted">{{$album->public_time  }}</span>
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
var topic_type = 2;
var topic_id = getQueryString('id');
var order = "like";
var comments_count = "{{$comments_count}}";

var page_over = Math.ceil(comments_count/limit);



function addSongsPlaylist(){
    window.parent.addSongsPlaylist(add_playlist,topic_id,2);
}
var add_playlist = [];
$(function () {


    $.ajax({
        url:'/getAlbumSong',
        type:'post',
        dataType:"json",
        data:{'id':topic_id},
        success:function (result) {
            $('#song_list').append("<tr class=\"row mx-0\" style=\"max-width: 640px;\">\n" +
                "                        <th class=\"col-1\">&nbsp;</th>\n" +
                "                        <th class=\"col-1\">&nbsp;</th>\n" +
                "                        <th class=\"col-5 over-flow\">歌曲标题</th>\n" +
                "                        <th class=\"col-2 over-flow\">操作</th>\n" +
                "                        <th class=\"col-3 over-flow\">歌手</th>\n" +
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

                if(result[i]['mv_id']){
                    $('#song_list').append("<tr class=\"row mx-0\">\n" +
                        "                        <td class=\"col-1\">"+(i+1)+"</td>\n" +
                        "                        <td class=\"col-1\">\n" +
                        "                            <a href='javascript:;' onclick=\"addPlaylist( { 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"'} )\"><i class=\"fa fa-play-circle\" aria-hidden=\"true\"></i></a>\n" +
                        "                        </td>\n" +
                        "                        <td class=\"col-5 over-flow\">\n" +
                        "                            <a href=\"/mv?id="+result[i]['mv_id']+"\"><i class=\"fa fa-youtube-play\" style=\"color:red;\" aria-hidden=\"true\"></i></a>\n" +
                        "                            <a href=\"/song?id="+result[i]['id']+"\">"+result[i]['name']+"</a>\n" +
                        "                        </td>\n" +

                        "                        <td class=\"col-2 over-flow\">\n" +
                        "                            <a href='javascript:;' onclick=\"addToPlaylist({ 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"'})\" title=\"添加到播放列表\"><i class=\"fa fa-bars\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                            <a href='javascript:;' onclick=\"addToMyPlaylist('"+result[i]['id']+"',1)\" title=\"收藏到歌单\"><i class=\"fa fa-plus-square-o\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                            <a href=\"/"+result[i]['file_src']+"\" target=\"_blank\"  title=\"下载\"><i class=\"fa fa-arrow-circle-down\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                           &nbsp;\n" +
                        "                        </td>\n" +
                        "                        <td class=\"col-3 over-flow\"><a href=\"/artist?id="+result[i]['artist_id']+"\">"+result[i]['artist_name']+"</a></td>\n" +
                        "                    </tr>");
                }else{
                    $('#song_list').append("<tr class=\"row mx-0\">\n" +
                        "                        <td class=\"col-1\">"+(i+1)+"</td>\n" +
                        "                        <td class=\"col-1\">\n" +
                        "                            <a href='javascript:;' onclick=\"addPlaylist( { 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"' } )\"><i class=\"fa fa-play-circle\" aria-hidden=\"true\"></i></a>\n" +
                        "                        </td>\n" +
                        "                        <td class=\"col-5 over-flow\">\n" +
                        "                            \n" +
                        "                            <a href=\"/song?id="+result[i]['id']+"\">"+result[i]['name']+"</a>\n" +
                        "                        </td>\n" +

                        "                        <td class=\"col-2 over-flow\">\n" +
                        "                            <a href='javascript:;' onclick=\"addToPlaylist({ 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"'})\" title=\"添加到播放列表\"><i class=\"fa fa-bars\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                            <a href='javascript:;' onclick=\"addToMyPlaylist('"+result[i]['id']+"',1)\" title=\"收藏到歌单\"><i class=\"fa fa-plus-square-o\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                            <a href=\"/"+result[i]['file_src']+"\" target=\"_blank\"  title=\"下载\"><i class=\"fa fa-arrow-circle-down\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                        "                            &nbsp;\n" +
                        "                        </td>\n" +
                        "                        <td class=\"col-3 over-flow\"><a href=\"/artist?id="+result[i]['artist_id']+"\">"+result[i]['artist_name']+"</a></td>\n" +
                        "                    </tr>");
                }

            }
            var height = document.body.clientHeight;
            window.parent.setHeight(height);
        },
        error:function (){

        }

    })

    for (var i=1; i<=page_over;i++){
        $('#page_jump').append("<option value=\""+i+"\">"+i+"</option>");
    }
    getComment();
})
</script>

</body>
</html>