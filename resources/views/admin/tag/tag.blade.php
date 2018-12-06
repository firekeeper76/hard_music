@include('admin._meta')
  <link rel="stylesheet" href="/plugins/layui/css/layui.css"  media="all">
  <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<meta name="_token" content="{{ csrf_token() }}"/>
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 音乐管理 <span class="c-gray en">&gt;</span> 分类列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>

<button type="" onclick="add()" id="add-btn" class="layui-btn">添加标签</button>
<form class="layui-form" action="" method="post" id="form" enctype="multipart/form-data" onsubmit="return false" style="display: none;">
    <div style="height:30px"></div>
    <div class="layui-form-item">
        <label class="layui-form-label">标签名</label>
        <div class="layui-input-inline">
            <input type="text" name="name" id="name" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
        </div>
    </div>
    <div style="height:20px"></div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择所属</label>
        <div class="layui-input-inline">
            <select name="pid" lay-verify="required" required>
                <option value="">请选择</option>
                @foreach($tags as $tag)
                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div style="height:30px"></div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
        </div>
    </div>
</form>

<!--修改-->
<form class="layui-form" action="" method="post" id="edit_form" enctype="multipart/form-data" onsubmit="return false" style="display: none;">
    <div style="height:30px"></div>
    <div class="layui-form-item">
        <label class="layui-form-label">标签名</label>
        <div class="layui-input-inline">
            <input type="text" name="name" id="tag_name" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
        </div>
    </div>
    <input type="hidden" value="" name="id" id="id"/>
    <div style="height:20px"></div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择所属</label>
        <div class="layui-input-inline">
            <select name="pid" id="pid" required>
                <option value="">请选择</option>
                @foreach($tags as $tag)
                <option value="{{$tag->id}}">{{$tag->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div style="height:30px"></div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <button class="layui-btn" lay-submit="" lay-filter="demo2">提交</button>
            <button class="layui-btn layui-btn-danger" lay-submit="" lay-filter="demo3">删除</button>
        </div>
    </div>
</form>

<!--内容-->
<div class="layui-fluid">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>标签</legend>
    </fieldset>
    @foreach($tags as $tag)
    <div class="layui-row" style="margin-top:10px;">

        <div class="layui-col-xs2" style="text-align: center;">
            <b>{{$tag->name}}</b>
        </div>
        <div class="layui-col-xs3" style="border:1px solid rgba(0,0,0,0.1);background-color: rgba(0,0,0,0.1)">
            @if($tag->son)
                @foreach($tag->son as $t)
                <a href="javascript:;" onclick="edit('{{$t->id}}','{{$t->name}}','{{$t->pid}}')">{{$t->name}}</a>&nbsp;|&nbsp;
                @endforeach
            @endif
        </div>
        <div class="layui-col-md3">
        </div>
    </div>
    @endforeach
</div>



<script src="/plugins/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->

<script>
    layui.use(['form'], function(){
        var form = layui.form
            ,layer = layui.layer
        var index;
        form.on('submit(demo1)', function(data){

            $.ajax({
                type:"post",
                url : "/admin/tag/add",
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: data.field,
                success:function(result){

                    if (result['StateCode'] == 100){
                        window.location.reload();
                    }else if (result['StateCode'] == 200){
                        layer.msg('添加失败');
                    }else{
                        layer.msg(result['message']);
                    }
                },
                error:function(){
                    layer.msg('请稍后再试');
                }
            });

            return false;
        });

        form.on('submit(demo2)', function(data){
            $.ajax({
                type:"post",
                url : "/admin/tag/update",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                dataType:'json',
                data: data.field,
                success:function(result){

                    if (result['StateCode'] == 100){
                        window.location.reload();
                    }else if (result['StateCode'] == 200){
                        layer.msg('修改失败');
                    }else{
                        layer.msg(result['message']);
                    }
                },
                error:function(){
                    layer.msg('请稍后再试');
                }
            });
            return false;
        });
        form.on('submit(demo3)', function(data){
            // alert(JSON.stringify(data.field));

            $.ajax({
                type:"post",
                url : "/admin/tag/del",
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: {'id':data.field.id},
                success:function(result){
                    if (result['StateCode'] == 100){
                        window.location.reload();
                    }else if (result['StateCode'] == 200){
                        layer.msg('删除失败');
                    }
                },
                error:function(){
                    layer.msg('请稍后再试');
                }
            });
            return false;
        });

    });

    function add(){

        layui.use('layer', function(){
            var layer = layui.layer;

            var index = layer.open({
                type: 1,
                content: $('#form'),
                title:'添加',
                area: ['400px', '400px'],
                maxmin: true
            });
        });
    }
    function edit(id,tag_name,pid){
        $('#id').val(id);
        $('#tag_name').val(tag_name);
        layui.use('layer', function(){
            var layer = layui.layer;
            var index = layer.open({
                type: 1,
                content: $('#edit_form'),
                title:'修改',
                area: ['400px', '400px'],
                maxmin: true
            });
        });
    }

</script>


</body>
</html>