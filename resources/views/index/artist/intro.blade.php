<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>歌手介绍</title>
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
                    <div class="col pt-2 pb-2 nav_artist"><a href="/artist?id={{$artist->id}}">热门歌曲</a></div>
                    <div class="col pt-2 pb-2 nav_artist "><a href="/artist/album?id={{$artist->id}}">所有专辑</a></div>
                    {{--<div class="col pt-2 pb-2 nav_artist "><a href="/artist/mv?id={{$artist->id}}">相关MV</a></div>--}}
                    <div class="col pt-2 pb-2 nav_artist active_nav"><a href="/artist/intro?id={{$artist->id}}">艺人介绍</a></div>
                </div>
            </div>

            <div class="pt-4" >
                @if($artist->intro)
                {!!$artist->intro!!}
                @else
                    <span style="color: gray;">暂无艺人信息</span>
                @endif
            </div>
            <div class="pb-4"></div>
        </div>

        @include('index.artist.artist_public')
        
    </div>
</div>



</body>
</html>