<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="stylesheet" href="/plugins/layui/css/layui.css"  media="all">
  <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>

<div id="add-main" style="padding-top:10px;">
       <form class="layui-form" id="add-form" action="" onsubmit="return false">
         <div class="layui-form-item center" >
          <label class="layui-form-label" style="width: 100px;" >分类名称</label>
          <div class="layui-input-block">
           <input type="text" name="catename" id="catename" required value="" style="width: 240px" lay-verify="required" placeholder="请输入分类名称" autocomplete="off" class="layui-input">
              <div class="layui-form-mid layui-word-aux">自动生成子分类: **男歌手，**女歌手，**组合/乐队</div>
          </div>
         </div>
           <div class="layui-form-item center" >
               <label class="layui-form-label" style="width: 100px;" >排序</label>
               <div class="layui-input-block">
                   <input type="text" name="sort" id="sort" value="" style="width: 240px"  placeholder="" autocomplete="off" class="layui-input">
               </div>
           </div>
         <div class="layui-form-item">
          <div class="layui-input-block">
           <button class="layui-btn" lay-submit lay-filter="save" onclick="add()" id="add-submit">立即添加</button>
          </div>
         </div>
       </form>
</div>


<script src="/plugins/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    var layer
    layui.use('layer', function(){
        layer = layui.layer;
    });
    function add() {
        if($('#catename').val()){
            $.ajax({
                type:"post",
                url : "/admin/category/add",
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: {'catename':$('#catename').val(),'sort':$('#sort').val()},
                success:function(data){

                    if(data['StateCode'] == 100){
                        layer.msg('增加成功');
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.$('.btn-refresh').click();
                        parent.layer.close(index);
                    }else if(data['StateCode'] == 201){
                        layer.msg('增加失败,'+ data['message']);
                    }else{
                        layer.msg('增加失败');
                    }
                },
                error:function(){
                    layer.msg('请稍后再试');
                },
            });
        }
    }

</script>



</body>
</html>