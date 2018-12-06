<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/plugins/layui/css/layui.css"  media="all">
  <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
  <style>
    .bg_album{
      width: 150px;
      background-image: url("{{URL::asset('images/bg_album.png')}}");
    }
  </style>
</head>
<body>

<div style="height:20px;"></div>

<div class="layui-fluid">

  <div class="layui-row">
    {{--<div class="layui-col-xs12 layui-col-md3">--}}
      {{--<form action="" id="s" class="layui-form layui-form-pane" onsubmit="return false">--}}
        {{--<div class="layui-form-item">--}}
          {{--<label class="layui-form-label">分类</label>--}}
          {{--<div class="layui-input-inline">--}}


              {{--<select lay-verify="required" required lay-filter="category">--}}
                {{--<option value="">全部</option>--}}
                {{--{volist name="category" id="vo"}--}}
                {{--<optgroup label="{$vo.catename}">--}}
                  {{--{volist name="$vo['son']" id="v"}--}}
                  {{--<option value="{$v.id}" >{$v.catename}</option>--}}
                  {{--{/volist}--}}
                {{--</optgroup>--}}
                {{--{/volist}--}}
              {{--</select>--}}

          {{--</div>--}}
        {{--</div>--}}
      {{--</form>--}}
    {{--</div>--}}
    {{--<div class="layui-col-xs12 layui-col-md4">--}}
      {{--<form action="" id="search" class="layui-form layui-form-pane" onsubmit="return false">--}}
        {{--<div class="layui-form-item">--}}
          {{--<label class="layui-form-label">搜索</label>--}}
          {{--<div class="layui-input-inline">--}}
            {{--<input type="text" name="name" id="name" lay-verify="required" placeholder="歌手名" autocomplete="off" class="layui-input">--}}
          {{--</div>--}}
          {{--<button type="submit" class="layui-btn" style="display: none;">搜索</button>--}}
        {{--</div>--}}

      {{--</form>--}}
    {{--</div>--}}
    <button class="layui-btn" onclick="show('添加专辑','/admin/album/add?id={{$artist_id}}')">添加专辑</button>
    <a href="javascript:;" id="reload_btn" title="刷新" onclick="window.location.reload()" class="layui-btn layui-btn-primary layui-btn-sm"><i class="layui-icon">&#xe669;</i></a>

    <div style="padding-top:20px;"></div>
   </div>

  {{--</div>--}}

  <div class="layui-row" id="content">

    {{--<div class="layui-col-xs6 layui-col-sm3 layui-col-md4 layui-col-lg1" style="margin-bottom: 5px;">--}}
      {{--<a href="javascript:;" id="add" onclick="add()"><img src="/images/add.png" width='130' height='130' title="添加一张专辑"  alt=""></a>--}}
    {{--</div>--}}
    @foreach($albums as $album)
      <div style="width: 10%;float:left;">
        <a href="/admin/album/detail?id={{$album->id}}" style="display: block;width: 150px;">
          <div class="bg_album">
            <img src="{{URL::asset($album->cover)}}" title="{{$album->name}}" height="130" width="130" onerror="this.src='/images/thumb_album_error.jpg'">
          </div>
        </a>
        <h6  style="width:130px;height: 20px;overflow: hidden;"><a href="/admin/album/detail?id={{$album->id}}" style="color: black;" title="{{$album->name}}">{{$album->name}}</a>&nbsp;<a href="javascript:;" onclick="del('{{$album->id}}')" title="删除"><i class="layui-icon layui-icon-delete"></i></a></h6>
      </div>
    @endforeach

  </div>


</div>
<div id="pages"></div>
<script src="/plugins/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>


  function show(title,url){
    layui.use('layer', function(){
        var layer = layui.layer;
        var index = layer.open({
            type: 2,
            content: url,
            title:title,
            area: ['340px', '900px'],
            maxmin: true
        });
        layer.full(index);
    });
  }

  function del(id){
      layui.use('layer', function(){
          layer.confirm('确认删除吗', function(index){
            $.ajax({
                type:"post",
                url : "/admin/album/del",
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: {'id':id},
                success:function(result){
                    if (result['StateCode'] == 100){
                        layer.msg('删除专辑成功');
                        setInterval(function() {
                            $('#reload_btn').click();
                        }, 1000);
                    }else{
                        layer.msg('删除失败');
                    }
                },
                error:function(){
                    layer.msg('请稍后再试');
                }
            });
          });
      });

  }
</script>

</body>
</html>