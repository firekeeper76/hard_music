<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>音乐人</title>
    @include('index.resources')
    <style>
        .blk li{
            height:30px;
            line-height: 30px;
            font-size:15px;
        }
        a{
            color:black;
        }
        a:hover{
            color:rgb(194,12,12);
        }
        .container{
            width:980px;
            max-width:none;
            min-height: 750px ;
            background: #ffffff;
            border-left:1px solid rgba(0,0,0,0.3);
            border-right:1px solid rgba(0,0,0,0.3);
            border-bottom:1px solid rgba(0,0,0,0.3);
        }
        .active{
            color:rgb(194,12,12);
        }
        .active > li {
            border: 1px solid rgba(192,191,192,0.5);
            background: #ffffff;
        }
        body{
            background:rgb(245,245,245);
        }
        .col-5-five{
            width:20%;
            float: left;
        }
    </style>
</head>
<body>

<div class="container" style="min-width:980px;background: rgb(249,249,249)">

    <div class="row" >
        <!--nav-->
            <div class="col-sm-2 col-lg-2  pt-lg-5" >
                <div class="blk">
                    <a href="/discover/artist" class="" id="all"><li>全部</li></a>
                    <hr>
                </div>
                @foreach($categorys as $category)
                    <div class="blk">
                        <h6><b>{{$category->catename}}</b></h6>
                        @if($category->son)
                            @foreach($category->son as $cate)
                                <a href="/discover/artist?cate_id={{$cate->id}}" id="cate{{$cate->id}}" class=""><li id="li{{$cate->id}}">{{$cate->catename}}</li></a>
                            @endforeach
                        @endif
                        <hr>
                    </div>
                @endforeach

        </div>

        <div class="col-lg-10 col-sm-10  p-5 bg-white">

            <div class="row pl-3 pr-3">
                <h3 id="title"></h3>
                <div class="col-lg-11" style="height:3px;background:red;"></div>
                <!--头像-->
                <div class="row pt-3 pb-3 pl-0 pr-0">

                    @foreach($artists as $key=>$artist)
                        @if($key < 10)
                            <div class="col-2 pb-4 mr-3">
                                <a href="/artist?id={{$artist->id}}"><img src="{{URL::asset($artist->avatar)}}"  class="img-fluid" width="130" height="130" alt="" onerror="this.src='{{URL::asset('images/thumb_error.jpg')}}'"></a>
                                <a href="/artist?id={{$artist->id}}"><span style="font-size:14px;">{{$artist->name}}</span></a>
                            </div>
                        @endif
                    @endforeach

                </div><!--头像-->

                <div class="col-11" style="height:1px;border-top:1px dotted;"></div>

                <div class="row pt-3 pb-3 pl-0 pr-0">
                    @foreach($artists as $key=>$artist)
                        @if($key >= 10)
                            <div class="col-2 pb-4 mr-3">
                                <div style="width: 130px;height: 1px; opacity: 0;"></div>
                                <a href="/artist?id={{$artist->id}}" style="width:130px;"><span style="font-size:14px;">{{$artist->name}}</span></a>
                            </div>
                        @endif
                    @endforeach
                </div>

            </div>

        </div>
    </div>



</div>
<script>
    $(function () {
        var url = location.href;
        var arr = url.split('=');
        if(arr[1]){
            $("#cate"+arr[1]).addClass('active');
            $('#title').html($("#li"+arr[1]).html());
        }else{
            $("#all").addClass('active');
            $('#title').html("全&nbsp;部&nbsp;");
        }
    })

</script>
</body>
</html>