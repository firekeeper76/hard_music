<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>歌手详情</title>
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
    </style>
</head>
<body>

<div class="container">
    <div class="row">

        <div class="col-md-9 col-sm-9  pt-4 pl-5 pr-5" style="border-right:1px solid rgba(0,0,0,0.3);">
            <h4>{{$artist->name}}</h4>
            <div style="max-width:640px;background:rgb(248,248,248)">
                <img src="/{{$artist->cover}}" class="img-fluid" style="width:640px; height:300px;" alt="" onerror="this.src='/images/error.jpg'">
                <div class="row pl-3" style="max-width:640px;">
                    <div class="col pt-2 pb-2 nav_artist active_nav"><a href="/artist?id={{$artist->id}}">热门歌曲</a></div>
                    <div class="col pt-2 pb-2 nav_artist "><a href="/artist/album?id={{$artist->id}}">所有专辑</a></div>
                    {{--<div class="col pt-2 pb-2 nav_artist "><a href="/artist/mv?id={{$artist->id}}">相关MV</a></div>--}}
                    <div class="col pt-2 pb-2 nav_artist "><a href="/artist/intro?id={{$artist->id}}">艺人介绍</a></div >
                </div>
            </div>
            <div class="table-responsive pt-4"><!--内容-->
                <table class="table table-sm table-striped table-hover" style="max-width:640px">
                    <tbody class="w-100">
                    <tr class="row mx-0" style="max-width: 640px;">
                        <th class="col-1">&nbsp;</th>
                        <th class="col-1">&nbsp;</th>
                        <th class="col-5 over-flow">歌曲标题</th>
                        <th class="col-2 over-flow">操作</th>
                        <th class="col-3 over-flow">专辑</th>
                    </tr>
                    @if(count($artist->song) > 0)
                    @foreach($artist->song as $key=>$value)
                    <tr class="row mx-0" style="max-width: 640px;">
                        <td class="col-1">{{$key+1}}</td>
                        <td class="col-1"><a href="javascript:;" onclick="addPlaylist( { 'id':'{{$value->id}}','name':'{{$value->name}}','artist_name':'{{$artist->name}}','file_src':'/{{$value->file_src}}','cover':'/{{$value->cover}}','vip':'{{$value->vip}}' } )"><i class="fa fa-play-circle" aria-hidden="true"></i></a></td>
                        <td class="col-5 over-flow">
                            @if($value->mv_id)<a href="/mv?id={{$value->mv_id}}"><i class="fa fa-youtube-play" style="color:red;" aria-hidden="true"></i></a>@endif
                            <a href="/song?id={{$value->id}}" title="{{$value->name}}">{{$value->name}}</a>
                        </td>
                        <td class="col-2 over-flow text-left">
                            <a href="javascript:;" onclick="addToPlaylist({ 'id':'{{$value->id}}','name':'{{$value->name}}','artist_name':'{{$artist->name}}','file_src':'/{{$value->file_src}}','cover':'/{{$value->cover}}','vip':'{{$value->vip}}' } )" title="添加到播放列表"><i class="fa fa-bars" style="color:darkred;" aria-hidden="true"></i></a>&nbsp;
                            <a href="javascript:;" onclick="addToMyPlaylist('{{$value->id}}',1)" title="收藏到歌单"><i class="fa fa-plus-square-o" style="color:darkred;" aria-hidden="true"></i></a>&nbsp;
                            <a href="/{{$value->file_src}}" target="_blank" title="下载"><i class="fa fa-arrow-circle-down" style="color:darkred;" aria-hidden="true"></i></a>&nbsp;
                        </td>
                        <td class="col-3 over-flow">@if($value->album_id)<a href="/album?id={{$value->album_id}}">{{$value->album->name}}</a>@endif</td>
                    </tr>
                    @endforeach
                    @else
                        <tr class="row mx-0" style="max-width: 640px;">
                            <td class="col text-center">这名歌手还没有发布歌曲</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="pb-4"></div>
        </div>
        @include('index.artist.artist_public')
        
    </div>
</div>
<script>
    function addPlaylist(json) {
        window.parent.addSong(json);
    }
    function addToPlaylist(json) {
        window.parent.addSongPlaylist(json);
    }
    function addToMyPlaylist(id,topic_type){
        window.parent.openPlayList(id,topic_type);
    }
    function parent_hash(src){
        window.parent.localhash(src);
    }

</script>


</body>
</html>