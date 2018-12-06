<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>搜索</title>
    @include('index.resources')
    <style>
        .container{
            width:980px;
            min-height: 700px;
            max-width:none;
            background: #ffffff;
            border-left:1px solid rgba(0,0,0,0.3);
            border-right:1px solid rgba(0,0,0,0.3);
            border-bottom:1px solid rgba(0,0,0,0.3);
        }
        /*.pagination{text-align:center;margin-top:20px;margin-bottom: 20px;}*/
        /*.pagination li{margin:0px 10px; border:1px solid #e6e6e6;padding: 3px 8px;display: inline-block;}*/
        /*.pagination .active{background-color: #dd1a20;color: #fff;}*/
        /*.pagination .disabled{color:#aaa;}*/
        .type{
            background: rgba(221,221,221,0.1);

            height:40px;
            line-height: 40px;
        }
        .type_active{
            border-top:3px solid darkred;
        }
        .col-c5{
            width: 20%;
            float:left;
            padding:0;
        }
    </style>
</head>
<body>


<div class="container" >
    <div class="row">

        <div class="col-md-12 col-sm-12  pt-4 pl-5 pr-5">

            <div class="offset-3 col-6">
                <input type="text" class="form-control input-group-lg" id="search" onkeypress="EnterPress(event)" value="">
            </div>
            <div class="row pt-5 pl-3 pr-3">
                <a href="javascript:;" onclick="setType('song')" class="col text-center type " id="song" style="display: inline-block;">歌曲</a>
                <a href="javascript:;" onclick="setType('artist')" class="col text-center type " id="artist" style="display: inline-block;">歌手</a>
                <a href="javascript:;" onclick="setType('album')" class="col text-center type " id="album" style="display: inline-block;">专辑</a>
                <a href="javascript:;" onclick="setType('playlist')" class="col text-center type " id="playlist" style="display: inline-block;">歌单</a>
            </div>

            <div class="table-responsive pt-4"><!--内容-->

                <h5>搜索到:  <span style="font-size:18px;color:darkred;">{{$count}}</span>条记录</h5>

                <hr style="background:#b21f2d;height:1px;">
                @if($type == 'song')
                <table class="table table-sm table-striped table-hover">
                    <tbody class="w-100">
                    <tr class="row mx-0">
                        <th class="col-1">&nbsp;</th>
                        <th class="col-1">&nbsp;</th>
                        <th class="col-4 over-flow">歌曲标题</th>
                        <th class="col-2 over-flow">歌手</th>
                        <th class="col-2 over-flow">操作</th>
                        <th class="col-2 over-flow">专辑</th>
                    </tr>
                    @foreach($data as $key=>$value)
                    <tr class="row mx-0">
                        <td class="col-1">{{$key+1}}</td>
                        <td class="col-1"><a href="javascript:;" onclick="addPlaylist( { 'id':'{{$value->id}}','name':'{{$value->name}}','artist_name':'{{$value->artist->name}}','file_src':'/{{$value->file_src}}','cover':'/{{$value->cover}}','vip':'{{$value->vip}}' } )"><i class="fa fa-play-circle" aria-hidden="true"></i></a></td>
                        <td class="col-4 over-flow">
                            @if($value->mv)<a href="/mv?id={$vo.mv_id}"><i class="fa fa-youtube-play" style="color:red;" aria-hidden="true"></i></a>@endif
                            <a href="/song?id={{$value->id}}" title="{{$value->name}}">{{$value->name}}</a>
                        </td>
                        <td class="col-2 over-flow"><a href="/artist?id={{$value->artist_id}}">{{$value->artist->name}}</a></td>
                        <td class="col-2 over-flow text-left">
                            <a href="javascript:;" onclick="addToPlaylist({ 'id':'{{$value->id}}','name':'{{$value->name}}','artist_name':'{{$value->artist->name}}','file_src':'/{{$value->file_src}}','cover':'/{{$value->cover}}','vip':'{{$value->vip}}' } )" title="添加到播放列表"><i class="fa fa-bars" style="color:darkred;" aria-hidden="true"></i></a>
                            <a href="javascript:" onclick="addToMyPlaylist('{{$value->id}}',1);" title="收藏到歌单"><i class="fa fa-plus-square-o" style="color:darkred;" aria-hidden="true"></i></a>&nbsp;
                            <a href="/{$vo.file_src}" target="_blank" title="下载"><i class="fa fa-arrow-circle-down" style="color:darkred;" aria-hidden="true"></i></a>&nbsp;
                        </td>
                        <td class="col-2 over-flow">@if($value->album_id)<a href="/album?id={{$value->album_id}}">{{$value->album->name}}</a>@endif</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>


                @elseif($type == 'artist')
                    @foreach($data as $key=>$value)
                    <div class="col-c5">
                        <a href="/artist?id={{$value->id}}"> <img src="/{{$value->avatar}}" alt="" height="130" width="130" onerror="this.src='/images/thumb_artist_error.jpg'"></a>
                        <h6  style="width:130px;height: 20px;overflow: hidden;"><a href="/artist?id={{$value->id}}">{{$value->name}}</a></h6>
                    </div>
                    @endforeach
                @elseif($type == 'album')
                    @foreach($data as $key=>$value)
                    <div class="col-c5">
                        <a href="/album?id={{$value->id}}"> <img src="/{{$value->cover}}" alt="" height="130" width="130" onerror="this.src='/images/thumb_album_error.jpg'"></a>
                        <h6  style="width:130px;height: 20px;overflow: hidden;"><a href="/album?id={{$value->id}}">{{$value->name}}</a></h6>
                        <h6  style="width:130px;height: 20px;overflow: hidden;font-size:12px;"><a href="/artist?id={{$value->artist_id}}" style="color:gray">{{$value->artist->name}}</a></h6>
                    </div>
                    @endforeach
                @elseif($type == 'playlist')
                    @foreach($data as $key=>$value)
                    <div class="col-c5">
                        <a href="/playlist?id={{$value->id}}"> <img src="@if($value->cover){{URL::asset($value->cover)}}@else{{URL::asset($value->auto_cover)}}@endif" alt="" height="130" width="130" onerror="this.src='/images/thumb_album_error.jpg'"></a>
                        <h6  style="width:130px;height: 20px;overflow: hidden;"><a href="/playlist?id={{$value->id}}">{{$value->name}}</a></h6>
                        <h6  style="width:130px;height: 20px;overflow: hidden;font-size:12px;color: gray;">by <a href="/user?id={{$value->user_id}}}" style="color:gray">{{$value->user->nickname}}</a></h6>
                    </div>
                    @endforeach
                @endif

            </div>
            <div class="offset-4 col-6">
                {{$data->appends(['keyword'=>$keyword,'type'=>$type])->render()}}
            </div>
        </div>



    </div>
</div>




<script>

    var type;
    var keyword;
    $(function () {
        keyword = getQueryString('keyword');
        type = getQueryString('type');
        if(type){
            $('#'+type).addClass('type_active');
        }else{
            $('#song').addClass('type_active');
        }
        $('#search').val(keyword);
    });
    function setType(t){
        type=t;
        jump();
    }

    function getQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return decodeURI(r[2]);
        return null;
    }

    //搜索
    function EnterPress(e){ //传入 event
        var e = e || window.event;
        if(e.keyCode == 13){
            var keyword_input = $('#search').val();
            if(keyword_input){
                keyword = keyword_input;
                jump();
            }
        }

    }

    function jump(){
        if(type){
            window.location.href="/search?keyword="+keyword+"&type="+type;
        }else{
            window.location.href="/search?keyword="+keyword;
        }
    }

    //播放
    function addPlaylist(json) {
        window.parent.addSong(json);
    }
    //添加到播放列表
    function addToPlaylist(json) {
        window.parent.addSongPlaylist(json);
    }
    function addToMyPlaylist(id,topic_type){
        window.parent.openPlayList(id,topic_type);
    }
</script>

</body>
</html>