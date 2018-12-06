<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>歌曲</title>
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
        .img1 {
            position: absolute;  animation: spin 20s infinite linear;
        }
        @keyframes spin {
            0%   { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
</head>
<body>

<div class="container">
    <div class="row">

        <div class="col-md-9 col-sm-9  pt-4 pl-5 pr-5" style="border-right:1px solid rgba(0,0,0,0.3);">

            <div style="width:640px;position: relative;">
                <img src="/{{$song->cover}}" width="180" height="180"  alt="" class="img1" style="border-radius:50%;float:left;" onerror="this.src='/images/thumb_song_error.jpg'">
                <div style="float:right;width:460px;" class="pl-3">
                    <h5><span style="background: #b21f2d;border-radius: 60px;font-size:16px;color: #fff;">《单曲》</span>&nbsp;{{$song->name}}</h5>
                    <h6>歌手：<a href="/artist?id={{$song->artist_id}}"  style="color:cornflowerblue;">{{$song->artist->name}}</a></h6>
                    @if($song->album_id)
                    <h6>所属专辑：<a href="/album?id={{$song->album_id}}"  style="color:cornflowerblue;">{{$song->album->name}}</a></h6>
                    @endif
                    <br>
                    <button class="btn btn-danger" onclick="addPlaylist( { 'id':'{{$song->id}}','name':'{{$song->name}}','artist_name':'{{$song->artist->name}}','file_src':'/{{$song->file_src}}','cover':'/{{$song->cover}}','vip':'{{$song->vip}}' } )">播放</button>
                    <button class="btn" onclick="addToMyPlaylist('{{$song->id}}',1)">收藏</button>
                    <a href="#comment"><button class="btn">评论{{$comments_count}}</button></a>
                </div>
            </div>

            <div class="table-responsive pt-4" style=""><!--内容-->
                <div class="pb-3">
                </div>


                <!--评论-->
                <div class="pt-3" >
                    <h5>评论 <span style="font-size:12px;">共 {{$comments_count}} 条评论</span></h5>
                    <hr style="background:#b21f2d;height:3px;">

                    <div class="row"  style="max-width:650px;">
                        <div class="col-2">
                            <img src="{{URL::asset(Session::get('avatar'))}}" width="60" height="60" alt="" onerror="this.src='/images/thumb_user_error.jpg'">
                        </div>
                        <div class="col form-group">
                            <textarea class="form-control" rows="2" id="comment" maxlength="140"></textarea>
                            <span class="text-success" id="comment_tips"></span>
                            <button class="btn btn-sm btn-danger mt-1" style="float:right;" onclick="comment()">评论</button>
                        </div>
                    </div>
                    <div style="float: right;" class="pr-3" id="order_box">
                        <a href="javascript:setOrder('like','hot');" style="color:red;" id="hot">热门</a>
                        <a href="javascript:setOrder('created_at','new');"   id="new">最新</a>
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
                <div class="row pb-3 pt-3" style="width: 640px;">
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
                <h5>为您推荐</h5>
                <hr style="background:darkgray;height:1px; opacity: 0.3;">
                @foreach($other_song as $s)
                    <div class="media mb-3">
                        <a href="/song?id={{$s->id}}"><img src="{{URL::asset($s->cover)}}" class="mr-1" width="50" height="50" alt="" onerror="this.src='/images/thumb_album_error.jpg'"></a>
                        <div class="media-body" >
                            <h6 class="mt-0" style="width:160px;height:20px;overflow:hidden;"> <a href="/song?id={{$s->id}}">{{$s->name}}</a></h6>
                            <span class="text-muted">{{$s->artist->name  }}</span>
                        </div>
                    </div>
                @endforeach

            </div>
            <hr>
            <h6>手机扫描二维码访问</h6>
            <img src="http://qr.liantu.com/api.php?text={{URL::asset('')}}" width="130" height="130" alt="">
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
var topic_type = 1;
var topic_id = "{{$song->id}}";
var order = "like";
var comments_count = "{{$comments_count}}";

var page_over = Math.ceil(comments_count/limit);




//播放
function addPlaylist(json) {
    window.parent.addSong(json);
}
//添加到播放列表
function addToPlaylist(json) {
    window.parent.addSongPlaylist(json);
}
//添加到我的歌单
function addToMyPlaylist(id,topic_type){
    window.parent.openPlayList(id,topic_type);
}
$(function () {
    getComment();
    for (var i=1; i<=page_over;i++){

        $('#page_jump').append("<option value=\""+i+"\">"+i+"</option>");
    }
})
</script>
<script>


    function parent_hash(src){
        window.parent.localhash(src);
    }

</script>
</body>
</html>