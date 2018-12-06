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
            min-height: 750px ;
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
        /*.pagination{text-align:center;margin-top:20px;margin-bottom: 20px;}*/
        /*.pagination li{margin:0px 10px; border:1px solid #e6e6e6;padding: 3px 8px;display: inline-block;}*/
        /*.pagination .page-item .active{background-color: #dd1a20;color: #fff;}*/
        /*.pagination .disabled{color:#aaa;}*/
        .col-c5{
            width: 20%;
            padding:0;
        }
        .bg_album{
            width: 150px;
            background-image: url("{{URL::asset('images/bg_album.png')}}");
        }
    </style>
</head>
<body>

<div class="container p-3">

    <h3>全部新碟</h3>
    <hr style="float:left;background:#b21f2d;height:3px;width: 900px;">
    <div class="clearfix"></div>
    <div class="row pl-3">
        @foreach($albums as $album)
            <div class="col-c5">
                <a href="/album?id={{$album->id}}" style="display: block;width: 150px;">
                    <div class="bg_album">
                        <img src="{{URL::asset($album->cover)}}" title="{{$album->name}}" height="130" width="130" onerror="this.src='/images/thumb_album_error.jpg'">
                    </div>
                </a>
                <h6  style="width:130px;height: 20px;overflow: hidden;"><a href="/album?id={{$album->id}}" style="color: black;"  title="{{$album->name}}">{{$album->name}}</a></h6>
                <h6  style="width:130px;height: 20px;overflow: hidden;font-size:12px;"><a href="/artist?id={{$album->artist->id}}" style="color:gray">{{$album->artist->name}}</a></h6>
            </div>
        @endforeach

    </div>
    <div class="row">
        <div class="offset-4">
            {{ $albums->render() }}
        </div>
    </div>
</div>




<script>



</script>

</body>
</html>