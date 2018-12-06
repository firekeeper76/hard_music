<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>歌手专辑</title>
    @include('index.resources')
    <style>
        /*.pagination{text-align:center;margin-top:20px;margin-bottom: 20px;}*/
        /*.pagination li{margin:0px 10px; border:1px solid #e6e6e6;padding: 3px 8px;display: inline-block;}*/
        /*.pagination .active{background-color: #dd1a20;color: #fff;}*/
        /*.pagination .disabled{color:#aaa;}*/

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
                    <div class="col pt-2 pb-2 nav_artist"><a href="/artist/?id={{$artist->id}}">热门歌曲</a></div>
                    <div class="col pt-2 pb-2 nav_artist active_nav"><a href="/artist/album/?id={{$artist->id}}">所有专辑</a></div>
                    {{--<div class="col pt-2 pb-2 nav_artist "><a href="/artist/mv/?id={$artist.id}">相关MV</a></div>--}}
                    <div class="col pt-2 pb-2 nav_artist"><a href="/artist/intro/?id={{$artist->id}}">艺人介绍</a></div>
                </div>
            </div>

            <div class="row pt-4">
                @foreach($albums as $album)

                <div class="col-3">
                    <a href="/album?id={{$album->id}}"><img class="img-fluid" src="/{{$album->cover}}" width="130" height="130" onerror="this.src='/images/thumb_error.jpg'" alt=""></a>
                    <h6>{{$album->name}}</h6> <h6 class="text-muted" style="display: block;width: 85px;height: 20px;overflow: hidden;">{{$album->created_at}}</h6>
                </div>

                @endforeach

            </div>
            {{$albums->appends(['id'=>$artist->id])->links()}}
            <div class="pb-4"></div>
        </div>

        @include('index.artist.artist_public')
        
    </div>
</div>



</body>
</html>