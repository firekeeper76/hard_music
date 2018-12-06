@include('admin._meta')
  <link rel="stylesheet" href="/plugins/layui/css/layui.css"  media="all">
<meta name="_token" content="{{ csrf_token() }}"/>
  <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 音乐管理 <span class="c-gray en">&gt;</span> 分类列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div style="padding-left:20px;">
    <button type="" id="add-btn" class="layui-btn">增加分类</button>
    <table class="layui-hide" id="test" lay-filter="test"></table>
</div>
<script type="text/html" id="barDemo">
    {{--<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>--}}
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>

</script>

<script src="/plugins/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use('table', function(){
  var table = layui.table;
  var form = layui.form;
  table.render({
    width: 520,
    elem: '#test'
    ,url:"/admin/category/getdata"
    ,cols: [[
      {field:'id',  title: 'ID', sort: true}
      ,{field:'catename',   title: '分类名', align: 'center' }
      ,{field:'sort',  title: '排序', align: 'center' , edit: 'text', sort:true}  //width 支持：数字、百分比和不填写。你还可以通过 minWidth 参数局部定义当前单元格的最小宽度，layui 2.2.1 新增
      ,{fixed: 'right',  title:'操作',align: 'center', toolbar: '#barDemo',}
    ]]
    ,page: false
    ,done: function(res, page, count){

      }
  });
  // form.on('switch(show)', function(obj){ // 监听按钮操作
  //   // layer.tips(this.value + ' ' + this.name + '：'+ obj.elem.checked, obj.othis);
  //
  //   var id = this.value //id 值
  //   ,field = this.name; //字段
  //   var value = 2;
  //   if(obj.elem.checked){
  //     value = 1;
  //   }
  //   // layer.msg(value);
  //
  //
  //   // $.ajax({
  //   //     url:"",
  //   //     type:"post",
  //   //     data:{"id":id,"field":field,"value":value},
  //   //     success:function(result){
  //   //       if(result==1){
  //   //         layer.msg(' 修改成功');
  //   //       }else if(result ==2){
  //   //         layer.msg(' 修改失败');
  //   //       } else {
  //   //         layer.msg(result);
  //   //         layui.use('table', function(){
  //   //             var table = layui.table;
  //   //             table.reload('test', {
  //   //               url: "{:url('category/getCate')}",
  //   //             });
  //   //         });
  //   //       }
  //   //     },
  //   //     error:function(result){
  //   //       layer.msg('字段修改失败,修改接口异常');
  //   //     }
  //   // });
  //
  //
  // });


  //监听单元格编辑
  table.on('edit(test)', function(obj){

    var value = obj.value //得到修改后的值
    ,data = obj.data //得到所在行所有键值
    ,field = obj.field; //得到字段
    $.ajax({
        url:"/admin/category/update",
        type:"post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data:{"id":data.id,"field":field,"value":value},
        success:function(result){
            // alert(JSON.stringify(result));
          if(result['StateCode']==100){
            layer.msg('修改成功');
          }else if(result['StateCode'] ==200){
            layer.msg('修改失败');
          } else {
            layer.msg(result);
            layui.use('table', function(){
                var table = layui.table;
                table.reload('test', {
                  url: "/admin/category/getdata",
                });
            });
          }
        },
        error:function(result){
          layer.msg('字段修改失败,修改接口异常');
        }
    });
  });

  //监听行工具事件
  table.on('tool(test)', function(obj){
    var data = obj.data;
    //console.log(obj)
    if(obj.event === 'del'){ //删除
      layer.confirm('确认删除', function(index){
        $.ajax({
          type:"post",
          url : "/admin/category/del",
          dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
          data: {'id':data.id},
          success:function(res){
            if(res['StateCode'] == 100){
              layer.msg('删除成功');
              obj.del();
              layer.close(index);
            } else {
              layer.msg('删除失败');
            }
          },
          error:function(){
            layer.msg('请稍后再试');
          }

        });

      });
    }
  });
});

$(function(){
    $('#add-btn').on('click', function(event) {
        layer.open({
            type: 2,
            area: ['500px','250px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            title: '添加分类',
            content: '/admin/category/add'
        });
    });

});




</script>



</body>
</html>