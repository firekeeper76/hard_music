<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的歌单</title>
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
        .tags_active{
            background: darkseagreen;
            text-decoration: none;
        }
        .tags_active:hover{
            background: darkseagreen;
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
    </style>
</head>
<body>

<div class="container">
    <div class="row">

        <!--左边栏-->
        <div class="col-sm-3  pt-4  pl-3 pr-3"  style="min-height: 700px;border-right: 1px solid gainsboro;">

            <div class="mb-5">
                <h6>创建的歌单 <a href="javascript:new_playlist();" title="创建新歌单" style="color: darkred;"><i class="fa  fa-plus-square-o"></i></a></h6>
                <hr style="background:darkgray;height:1px; opacity: 0.3;">

                <!--专辑循环体-->
                @foreach($playlists as $key=>$playlist)

                <li id="li{{$key+1}}" onclick="getPlayList('{{$playlist->id}}','{{$playlist->name}}','{{$playlist->song_number}}','@if($playlist->cover){{$playlist->cover}}@else{{$playlist->auto_cover}}@endif','{{$playlist->created_at}}','{{$playlist->tags}}','{{$playlist->user->nickname}}','{{$playlist->user_id}}','{{$playlist->user->avatar}}','{{$playlist->public_time}}','{{$playlist->is_action}}','{{$playlist->play}}')">
                    <div class="media">
                        <img src="@if($playlist->cover){{URL::asset($playlist->cover)}}@else{{URL::asset($playlist->auto_cover)}}@endif" class="mr-1" width="40" height="40" alt="" onerror="this.src='{{URL::asset('images/thumb_playlist_error.jpg')}}'">
                        <div class="media-body" >
                            <h6 class="mt-0" style="font-size:12px;width:90px;height:15px;overflow:hidden;">{{$playlist->name}}</h6>
                            <span class="text-muted" style="font-size:12px;">{{$playlist->song_number}} 首&nbsp;&nbsp;</span>
                            @if($playlist->is_action != 0)
                            <a href="javascript:;" onclick="del_playlist('{{$playlist->id}}')" style="z-index: 1;" title="删除" style="font-size:7px;" class="text-muted"><i class="fa fa-trash-o"></i></a>
                            @endif
                        </div>
                    </div>
                </li>
                @endforeach
            </div>

            <div class="mb-5">
                <h6>收藏的歌单</h6>
                <hr style="background:darkgray;height:1px; opacity: 0.3;">

                <!--专辑循环体-->

                @foreach($collection_playlist as $key=>$value)

                <li id="li{{$key+1}}" onclick="getCollectionPlayList('{{$value->topic_id}}','{{$value->playlist->name}}','{{$value->playlist->song_number}}','@if($value->playlist->cover){{$value->playlist->cover}}@else{{$value->playlist->auto_cover}}@endif','{{$value->playlist->created_at}}','{{$value->playlist->tags}}','{{$value->playlist->user->nickname}}','{{$value->user_id}}','{{$value->playlist->user->avatar}}','{{$value->playlist->public_time}}','{{$value->playlist->is_action}}','{{$value->playlist->play}}')">
                    <div class="media">
                        <img src="@if($value->playlist->cover){{URL::asset($value->playlist->cover)}}@else{{URL::asset($value->playlist->auto_cover)}}@endif" class="mr-1" width="40" height="40" alt="" onerror="this.src='{{URL::asset('images/thumb_playlist_error.jpg')}}'">
                        <div class="media-body" >
                            <h6 class="mt-0" style="font-size:12px;width:90px;height:15px;overflow:hidden;">{{$value->playlist->name}}</h6>
                            <span class="text-muted" style="font-size:12px;">{{$value->playlist->song_number}} 首&nbsp;by {{$value->playlist->user->nickname}}&nbsp;&nbsp;</span>
                            <a href="javascript:;" onclick="del_collection('{{$value->id}}')" style="z-index: 1;" title="取消收藏" style="font-size:7px;" class="text-muted"><i class="fa fa-trash-o"></i></a>
                        </div>
                    </div>
                </li>
                @endforeach

            </div>
        </div>



        <div class="col-sm-9  pt-4 pl-5 pr-5" style="border-right:1px solid rgba(0,0,0,0.3);">

            <div style="width:640px;">
                <img src="" id="cover" width="180" height="180" alt="" class="" style="float:left;" onerror="this.src='{{URL::asset('images/error.jpg')}}'">
                <div style="float:right;width:460px;" class="pl-3">
                    <h5><span style="background: #b21f2d;border-radius: 60px;font-size:16px;color: #fff;">《歌单》</span> <a
                            href="javascript:;" style="text-decoration: none;" onclick="jump_playlist();"><span id="playlist_name">我喜欢的音乐</span></a><a
                            href="javascript:;" onclick="rename()" id="rename" style="text-decoration: none;" title="编辑" data-toggle="modal" data-target="#edit_modal"></a> </h5>

                    <div class="mt-2" style="font-size:13px;">
                        <img src="" id="head_img" width="40" height="40" alt=""  onerror="this.src='{{URL::asset('images/thumb_user_error.jpg')}}'">
                        <a href=""  style="color:deepskyblue;" id="nickname">用户昵称</a>
                        &nbsp;
                        <span style="color:gray;"><span id="create_time">2016-04-15</span>  创建</span>
                    </div>

                    <div class="mt-2 mb-4" id="tag">
                    </div>

                        <button class="btn btn-danger" onclick="addSongsPlaylist()">播放</button>
                        <div style="display: inline-block;" id="button_group">

                        </div>

                </div>
            </div>

            <div class="table-responsive pt-4"><!--内容-->

                <div class="row" style="max-width: 640px;">
                    <div class="col-6">
                        <h5>歌曲列表 <span style="font-size:14px;" id="song_number"></span></h5>
                    </div>
                    <div class="col-6  text-right" id="play">

                    </div>
                </div>
                <hr style="background:#b21f2d;height:3px;">
                <table class="table table-sm table-striped table-hover">

                    <tbody class="w-100" id="song_list">
                    <tr class="row mx-0">
                        <th class="col-1">&nbsp;</th>
                        <th class="col-1">&nbsp;</th>
                        <th class="col-3 over-flow">歌曲标题</th>
                        <th class="col-2 over-flow">歌手</th>
                        <th class="col-3 over-flow">操作</th>
                        <th class="col-2 over-flow">专辑</th>
                    </tr>

                    <!--<tr class="row mx-0">-->
                        <!--<td class="col-1">01</td>-->
                        <!--<td class="col-1">-->
                            <!--<a href="javascript:addPlaylist( { 'id':'{vo.id}','name':'{vo.name}','artist_name':'{vo.artist_name}','file_src':'__PUBLIC__/{vo.file_src}','cover':'__PUBLIC__/{vo.cover}', } );"><i class="fa fa-play-circle" aria-hidden="true"></i></a>-->
                        <!--</td>-->
                        <!--<td class="col-3 over-flow">-->
                            <!--<a href="/mv?id={vo.mv_id}"><i class="fa fa-youtube-play" style="color:red;" aria-hidden="true"></i></a>-->
                            <!--<a href="javascript:;">自我主义</a>-->
                        <!--</td>-->
                        <!--<td class="col-2 over-flow"><a href="javascript:;">斋藤飞鸟</a></td>-->
                        <!--<td class="col-3 over-flow">-->
                            <!--<a href="javascript:addToPlaylist({  'id':'{vo.id}','name':'{vo.name}','artist_name':'{vo.artist_name}','file_src':'__PUBLIC__/{vo.file_src}','cover':'__PUBLIC__/{vo.cover}', });" title="添加到播放列表"><i class="fa fa-bars" style="color:red;" aria-hidden="true"></i></a>&nbsp;-->
                            <!--<a href="javascript:;" title="收藏到歌单"><i class="fa fa-plus-square-o" style="color:red;" aria-hidden="true"></i></a>&nbsp;-->
                            <!--<a href="__PUBLIC__/{vo.file_src}" target="_blank"  title="下载"><i class="fa fa-arrow-circle-down" style="color:red;" aria-hidden="true"></i></a>&nbsp;-->
                        <!--</td>-->
                        <!--<td class="col-2 over-flow"><a href="javascript:;">danyuange</a></td>-->
                    <!--</tr>-->



                    </tbody>
                </table>

            </div>
        </div>

        
    </div>
</div>

<!--tags Modal-->
<div class="modal fade" id="tags_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">添加标签</h5>
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
                                <a href="javascript:;" onclick="setTag('{{$t->name}}')" id="{{$t->name}}" onclick="" class="tags pl-2 pr-2 text-center">{{$t->name}}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="reset_tag()">重置</button>
                <button class="btn btn-danger" onclick="save_tag()">保存</button>
            </div>

        </div>
    </div>
</div>

<!--edit Modal-->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >编辑歌单</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="">
                <input type="text" id="rename_input" placeholder="" class="form-control">
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" onclick="save_playlist()">保存</button>
            </div>

        </div>
    </div>
</div>

<script>
    var tagslist = '';//标签列表
    var oldtags=[];
    var temp_tags = '';
    var playlist_id ;
    var is_action;
    var add_playlist = [];
    var jump_playlist_url ='';
    var playlist_type;
    //分享
    function share(){
        var boolean = confirm('确认分享吗？分享后该歌单不可删除，不可取消分享');
        if(boolean){
            var date = new Date();
            var month = date.getMonth()+1;
            if(month <10){
                month = '0'+month;
            }
            var public_time = date.getFullYear()+"-"+month+"-"+date.getDate();


            $.ajax({
                url: '/update_playlist',
                type: 'post',
                dataType: "json",
                data: {'id': playlist_id, 'public_time': public_time},
                success: function (result) {
                    // alert(JSON.stringify(tags));
                    if(result){
                        window.location.reload();
                    }
                },
                error: function () {

                }
            });
        }
    }

    function jump_playlist(){
        if(jump_playlist_url){
            location.href=jump_playlist_url;
        }else{
            return;
        }
    }
    //设置标签
    function setTag(tagname){
        // console.log('1--'+oldtags);
        for(var i=0;i<oldtags.length;i++){
            if(oldtags[i] == tagname){
                $('#'+tagname).removeClass('tags_active');
                oldtags.splice(i,i);
                return false;
            }
        }
        if(oldtags.length>=5){
            window.parent.setTips('最多设置5个标签');
            return false;
        }
        $('#'+tagname).addClass('tags_active');
        if(tagslist== ''){
            oldtags[0] = tagname;
        }else{
            oldtags[oldtags.length] = tagname;
        }
        // console.log('2--'+oldtags);
    }
    function reset_tag(){
        for(var i=0;i<oldtags.length;i++){
            $('#'+oldtags[i]).removeClass('tags_active');
        }
        oldtags = [];
        var arr = tagslist.split(',');

        for(var i=0;i<arr.length;i++){
            oldtags[i] = arr[i];
            $('#'+arr[i]).addClass('tags_active');
        }
    }
    function save_tag() {
        var tags = oldtags.join(',');
        if (tags == tagslist){
            $('#close_modal').click();
            return false;
        }
        $.ajax({
            url: '/update_playlist',
            type: 'post',
            dataType: "json",
            data: {'id': playlist_id, 'tags': tags},
            success: function (result) {
                // alert(JSON.stringify(tags));
                if(result){
                    window.parent.setTips('设置成功');
                    window.location.reload();
                }
            },
            error: function () {
                window.parent.setTips('请稍后再试');
            }
        });
    }

    function render_list() {
        $('#song_list').empty();
        $.ajax({
            url:'/getPlayListSong',
            type:'post',
            dataType:"json",
            data:{'id':playlist_id},
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
                        cover: '/'+result[i]['cover'],
                        src: '/'+result[i]['file_src'],
                        lyric  : "",
                        index: 1,
                        id:result[i]['id'],
                        vip:result[i]['vip']
                    });
                    if(!result[i]['album_name']){
                        result[i]['album_name'] = ' ';
                    }
                    if(playlist_type!='collection'){
                        if(result[i]['mv_id']){
                            $('#song_list').append("<tr class=\"row mx-0\">\n" +
                                "                        <td class=\"col-1\">"+(i+1)+"</td>\n" +
                                "                        <td class=\"col-1\">\n" +
                                "                            <a onclick=\"addPlaylist( { 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"'} )\"><i class=\"fa fa-play-circle\" aria-hidden=\"true\"></i></a>\n" +
                                "                        </td>\n" +
                                "                        <td class=\"col-4 over-flow\">\n" +
                                "                            <a href=\"/mv?id="+result[i]['mv_id']+"\"><i class=\"fa fa-youtube-play\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>\n" +
                                "                            <a href=\"/song?id="+result[i]['id']+"\">"+result[i]['name']+"</a>\n" +
                                "                        </td>\n" +
                                "                        <td class=\"col-2 over-flow\"><a href=\"/artist?id="+result[i]['artist_id']+"\">"+result[i]['artist_name']+"</a></td>\n" +
                                "                        <td class=\"col-2 over-flow\">\n" +
                                "                            <a href='javascript:;' onclick=\"addToPlaylist({ 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"'})\" title=\"添加到播放列表\"><i class=\"fa fa-bars\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                                "                            <a href='javascript:;' onclick=\"addToMyPlaylist('"+result[i]['id']+"',1)\" title=\"收藏到歌单\"><i class=\"fa fa-plus-square-o\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                                "                            <a href=\"/"+result[i]['file_src']+"\" target=\"_blank\"  title=\"下载\"><i class=\"fa fa-arrow-circle-down\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                                "                            <a href=\"javascript:;\" onclick=\"del('"+result[i]['id']+"','"+playlist_id+"')\"  title=\"删除\"><i class=\"fa fa-trash-o\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
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
                                "                            <a href=\"javascript:;\" onclick=\"del('"+result[i]['id']+"','"+playlist_id+"')\" title=\"删除\"><i class=\"fa fa-trash-o\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                                "                        </td>\n" +
                                "                        <td class=\"col-2 over-flow\"><a href=\"/album?id="+result[i]['album_id']+"\">"+result[i]['album_name']+"</a></td>\n" +
                                "                    </tr>");
                        }
                    }else{
                        if(result[i]['mv_id']){
                            $('#song_list').append("<tr class=\"row mx-0\">\n" +
                                "                        <td class=\"col-1\">"+(i+1)+"</td>\n" +
                                "                        <td class=\"col-1\">\n" +
                                "                            <a onclick=\"addPlaylist( { 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"'} )\"><i class=\"fa fa-play-circle\" aria-hidden=\"true\"></i></a>\n" +
                                "                        </td>\n" +
                                "                        <td class=\"col-4 over-flow\">\n" +
                                "                            <a href=\"/mv?id="+result[i]['mv_id']+"\"><i class=\"fa fa-youtube-play\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>\n" +
                                "                            <a href=\"/song?id="+result[i]['id']+"\">"+result[i]['name']+"</a>\n" +
                                "                        </td>\n" +
                                "                        <td class=\"col-2 over-flow\"><a href=\"/artist?id="+result[i]['artist_id']+"\">"+result[i]['artist_name']+"</a></td>\n" +
                                "                        <td class=\"col-2 over-flow\">\n" +
                                "                            <a href='javascript:;' onclick=\"addToPlaylist({ 'id':'"+result[i]['id']+"','name':'"+result[i]['name']+"','artist_name':'"+result[i]['artist_name']+"','file_src':'/"+result[i]['file_src']+"','cover':'/"+result[i]['cover']+"', 'vip':'"+result[i]['vip']+"'})\" title=\"添加到播放列表\"><i class=\"fa fa-bars\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                                "                            <a href='javascript:;' onclick=\"addToMyPlaylist('"+result[i]['id']+"',1)\" title=\"收藏到歌单\"><i class=\"fa fa-plus-square-o\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +
                                "                            <a href=\"/"+result[i]['file_src']+"\" target=\"_blank\"  title=\"下载\"><i class=\"fa fa-arrow-circle-down\" style=\"color:darkred;\" aria-hidden=\"true\"></i></a>&nbsp;\n" +

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

                                "                        </td>\n" +
                                "                        <td class=\"col-2 over-flow\"><a href=\"/album?id="+result[i]['album_id']+"\">"+result[i]['album_name']+"</a></td>\n" +
                                "                    </tr>");
                        }
                    }


                }
                var height = document.body.clientHeight;
                window.parent.setHeight(height);
            },
            error:function (){
                // alert("无法评论，您的网络似乎有问题");
            }

        })
    }

    //点击我创建的歌单-获取右边栏歌单信息
    function getPlayList(id,name,song_number,cover,create_time,tags,nickname,uid,head_img,public_time,is_action,play){
        playlist_id = id;
        playlist_type = 'my';
        tagslist = tags;
        jump_playlist_url ='';
        $('#button_group').empty();
        playlist_id = id;
        $('#playlist_name').html(name);
        $('#create_time').html(create_time);
        $('#cover').attr('src','/'+cover);
        $('#nickname').html(nickname);
        $('#nickname').attr('href','/user?id='+uid);
        $('#head_img').attr('src','/'+head_img);
        $('#song_number').html(song_number+" 首");
        $('#play').empty();
        $('#rename').empty();
        if(is_action==1){
            $('#rename').append("<i class=\"fa fa-pencil fa-fw\"></i>");
        }
        var tag = tags.split(",");

        if(oldtags[0]){
            for (var i=0; i<oldtags.length;i++){
                $('#'+oldtags[i]).removeClass('tags_active');
            }
        }
        var arr =  tagslist.split(',');
        oldtags = arr;
        if(arr != ''){
            for (var i=0; i<arr.length;i++){
                $('#'+arr[i]).addClass('tags_active');
            }
        }
        $('#tag').empty();
        if(is_action != 0 || public_time){
            $('#tag').append("<span style=\"color:gray;font-size:14px;\">标签：</span>");
            if(tag[0]){
                for(var i=0;i<tag.length;i++){
                    $('#tag').append("<a href=\"/discover/playlist?tag="+tag[i]+"\" class=\"pl-2 pr-2 text-center tags\" style=\"\">"+tag[i]+"</a>");
                }
            }
            $('#tag').append("<a href=\"\" class=\"pl-2 pr-2 text-center tags\"  data-toggle=\"modal\" data-target=\"#tags_modal\" style=\"\">+</a>");
            $('#button_group').empty();
            if(public_time){
                $('#play').empty();
                $('#play').append("<h6>播放次数: <span style=\"color:darkred;\"> "+play+" </span></h6>");
                $('#button_group').append("<button class=\"btn\" disabled=\"disabled\">已分享</button>");
            }else{
                $('#button_group').append("\n" +
                    "                        <button class=\"btn btn-danger\" onclick=\"share()\" id=\"share\">分享给大家</button>");
            }
        }

       render_list();
    }
    //点击我收藏的歌单-获取右边栏歌单信息
    function getCollectionPlayList(id,name,song_number,cover,create_time,tags,nickname,uid,head_img,public_time,is_action,play){
        tagslist = tags;
        playlist_type = 'collection';
        playlist_id = id;
        jump_playlist_url ='/playlist?id='+id;
        $('#playlist_name').html(name);
        $('#create_time').html(create_time);
        $('#cover').attr('src','/'+cover);
        $('#nickname').html(nickname);
        $('#nickname').attr('href','/user?id='+uid);
        $('#head_img').attr('src','/'+head_img);
        $('#song_number').html(song_number+" 首");
        $('#play').empty();
        $('#play').append("<h6>播放次数: <span style=\"color:darkred;\"> "+play+" </span></h6>");
        var tag = tags.split(",");
        if(oldtags[0]){
            for (var i=0; i<oldtags.length;i++){
                $('#'+oldtags[i]).removeClass('tags_active');
            }
        }
        var arr =  tagslist.split(',');
        oldtags = arr;
        if(arr != ''){
            for (var i=0; i<arr.length;i++){
                $('#'+arr[i]).addClass('tags_active');
            }
        }
        $('#tag').empty();

            $('#tag').append("<span style=\"color:gray;font-size:14px;\">标签：</span>");
            if(tag[0]){
                for(var i=0;i<tag.length;i++){
                    $('#tag').append("<a href=\"/discover/playlist?tag="+tag[i]+"\" class=\"pl-2 pr-2 text-center tags\" style=\"\">"+tag[i]+"</a>");
                }
            }

        if(public_time){
            $('#button_group').empty();
            $('#button_group').append("<button class=\"btn\" disabled=\"disabled\">已收藏</button>");
        }else{
            $('#button_group').empty();

        }

        render_list('collection');
    }
    //删除歌单歌曲
    function del(topic_id,playlist_id){
        var boolean = confirm('确定从歌单里删除这首歌吗？');
        if(boolean) {
            $.ajax({
                url: '/del_playlist_song',
                type: 'post',
                dataType: "json",
                data: {'topic_id': topic_id, 'playlist_id': playlist_id},
                success: function (result) {
                    if (result) {
                        window.parent.setTips('删除成功');
                        render_list();
                    }else{
                        window.parent.setTips('请稍后再试');
                    }
                },
                error: function () {
                    window.parent.setTips('请稍后再试');
                }
            });
        }
    }
    function addSongsPlaylist(){
        // alert(1);
        window.parent.addSongsPlaylist(add_playlist);
    }
    function addToMyPlaylist(id,topic_type){
        window.parent.openPlayList(id,topic_type);
    }
    //播放
    function addPlaylist(json) {
        window.parent.addSong(json);
    }
    //添加到播放列表
    function addToPlaylist(json) {
        window.parent.addSongPlaylist(json);
    }
    //创建新歌单
    function new_playlist(){
        window.parent.open_new_playlist();
    }
    //删除歌单
    function del_playlist(id){
        var boolean = confirm("确定要删除这个歌单吗？");
        if (boolean==true)
        {
            $.ajax({
                url: '/del_playlist',
                type: 'post',
                dataType: "json",
                data: {'id': id},
                success: function (result) {
                    if(result){
                        window.parent.setTips('删除成功');
                        window.location.reload();
                    }
                },
                error: function () {
                    window.parent.setTips('请稍后再试');
                }
            });
        }
    }
    // 取消收藏歌单
    function del_collection(id){
        var boolean = confirm("确认取消收藏吗？");
        if (boolean==true)
        {
            $.ajax({
                url: '/del_collection',
                type: 'post',
                dataType: "json",
                data: {'id': id},
                success: function (result) {
                    if(result){
                        window.parent.setTips('取消收藏成功');
                        window.location.reload();
                    }
                },
                error: function () {
                    window.parent.setTips('请稍后再试');
                }
            });
        }
    }

    //歌单重命名
    function rename(){
        $('#rename_input').attr('placeholder',$('#playlist_name').html());
    }

    function save_playlist(){
        var name = $('#rename_input').val();
        if(name){
            $.ajax({
                url: '/update_playlist',
                type: 'post',
                dataType: "json",
                data: {'id': playlist_id,'name':name},
                success: function (result) {
                    if(result){
                        window.parent.setTips('设置成功');
                        window.location.reload();
                    }
                },
                error: function () {
                    window.parent.setTips('请稍后再试');
                }
            });
        }
    }

    $(function () {
        $('#li1').click();
    })
</script>

</body>
</html>