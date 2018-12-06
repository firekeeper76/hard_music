<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="_token" content="{{ csrf_token() }}"/>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/plugins/layui/css/layui.css"  media="all">
  <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body style="padding:10px;">

<a href="javascript:;" title="刷新" onclick="window.location.reload()" id="reload_btn" class="layui-btn layui-btn-primary layui-btn-sm"><i class="layui-icon">&#xe669;
</i></a>
<div style="height: 20px;"></div>


<div class="demoTable">
  搜索歌名：
  <div class="layui-inline">
    <input class="layui-input" name="id" id="demoReload" autocomplete="off">
  </div>
  <button class="layui-btn" data-type="reload">搜索</button>
</div>


<h3>歌曲列表</h3>
<table class="layui-hide" id="test" lay-filter="test"></table>
<script type="text/html" id="switchTpl">
  <input type="checkbox" name="vip" value="@{{d.vip}}" id="@{{ d.id }}" lay-skin="switch" lay-text="是|否" lay-filter="isVip" @{{ d.vip == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>

<script src="/plugins/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    var tableIns;

        layui.use('table', function(){
            var table = layui.table;
            var form = layui.form;
            tableIns = table.render({

            elem: '#test'
            ,url:"/admin/song/get"
            ,where:{'artist_id':'{{$artist_id}}'}
                ,headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            ,cols: [[
            // {field:'id', title: 'ID'}
            {field:'name',   title: '歌名', align: 'center'} //width 支持：数字、百分比和不填写。你还可以通过 minWidth 参数局部定义当前单元格的最小宽度，layui 2.2.1 新增
            ,{field:'tags', title: '标签', align: 'center'}
            ,{field:'album_name', title: '专辑', align: 'center'}
            ,{field:'vip', title:'会员', width:85, templet: '#switchTpl', unresize: true}
            ,{fixed: 'right',  title:'操作',align: 'center', toolbar: '#barDemo',}
        ]]
            ,page: false
            ,id:'testReload'
            ,done: function(res, page, count){
            //如果是异步请求数据方式，res即为你接口返回的信息。
            //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
            //分类显示中文名称
            //         $("[data-field='mv_id']").children().each(function(){
            //             if($(this).text()!='MV' && $(this).text()>=1){
            //                 $(this).text("y");
            //             }
            //         })

        }
    });
            var active = {
                reload: function(){
                    var demoReload = $('#demoReload');

                    //执行重载
                    table.reload('testReload', {
                        where: {
                            name: demoReload.val()
                        }
                    });
                }
            };

            $('.demoTable .layui-btn').on('click', function(){
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
//   //监听行工具事件
        table.on('tool(test)', function(obj){
            var data = obj.data;
            // console.log(data);
            if(obj.event === 'del'){ //删除
                layer.confirm('确认删除吗', function(index){

                    $.ajax({//上传完获取返回的图片路径 更新数据库
                        type:"post",
                        url : "/admin/song/del",
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        data: {'id':data.id},
                        success:function(result){
                            if (result['StateCode'] == 100) {
                                layer.msg('删除成功');
                                obj.del();
                                layer.close(index);
                            }else{
                                layer.msg('删除失败');
                            }
                        },
                        error:function(){
                            layer.msg('请稍后再试');
                        }
                    });



                });
            } else if(obj.event === 'edit'){  //编辑
                show('编辑歌曲','/admin/song/update?id='+data.id);
            }
        });

            form.on('switch(isVip)', function(obj){
                var vip;
                var id = this.id;
                if(obj.elem.checked){
                    vip = 1 ;
                }else{
                    vip = 0;
                }
                $.ajax({//上传完获取返回的图片路径 更新数据库
                    type:"post",
                    url : "/admin/song/update",
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    data: {'id':id,'vip':vip},
                    success:function(result){
                        if (result['StateCode'] == 100) {
                            layer.tips('修改成功', obj.othis);
                        }else if (result['StateCode'] == 200) {
                            layer.tips('修改失败', obj.othis);
                        }else{
                            layer.tips('修改失败', obj.othis);
                        }
                    },
                    error:function(){
                        layer.msg('请稍后再试');
                    }
                });

            });


    });



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


</script>


</body>
</html>