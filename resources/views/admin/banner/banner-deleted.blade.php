@include('admin._meta')
<![endif]-->
<meta name="_token" content="{{ csrf_token() }}"/>
<title>图片列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> Banner <span class="c-gray en">&gt;</span> Banner回收站 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	{{--<div class="text-c"> 日期范围：--}}
		{{--<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate" style="width:120px;">--}}
		{{-----}}
		{{--<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" class="input-text Wdate" style="width:120px;">--}}
		{{--<input type="text" name="" id="" placeholder=" 图片名称" style="width:250px" class="input-text">--}}
		{{--<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜图片</button>--}}
	{{--</div>--}}

	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort">
			<thead>
				<tr class="text-c">

					<th width="80">ID</th>

					<th width="200">封面</th>

					<th width="90">背景颜色</th>
					<th>图片路径</th>
					<th>排序(大->小)</th>
					<th>删除时间</th>

					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			@foreach($banners as $banner)
				<tr class="text-c">

					<td>{{$banner->id}}</td>
					<td><a href="/{{$banner->src}}" target="_blank"><img width="210" class="picture-thumb" src="/{{$banner->src}}"></a></td>
					<td class="text-c"><div style="width:20px;height:20px;background: {{$banner->bg_color}};"></div>{{$banner->bg_color}}</td>
					<td class="text-l" ><a class="maincolor" href="/#/{{$banner->src_to}}" target="_blank">{{URL::asset('')}}#/{{$banner->src_to}}</a></td>
					<td>{{$banner->sort}}</td>
					<td>{{$banner->deleted_at}}</td>
					<td class="td-manage"> <a style="text-decoration:none" class="ml-5" onClick="picture_restore(this,'{{$banner->id}}')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="picture_del(this,'{{$banner->id}}','{{$banner->src}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
				</tr>

			@endforeach
			</tbody>
		</table>
	</div>
</div>

<!--_footer 作为公共模版分离出去-->
@include('admin._footer')
 <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
// $('.table-sort').dataTable({
// 	"aaSorting": [[ 1, "desc" ]],//默认第几个排序
// 	"bStateSave": true,//状态保存
// 	"aoColumnDefs": [
// 	  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
// 	  {"orderable":false,"aTargets":[0,8]}// 制定列不参与排序
// 	]
// });

/*图片-添加*/
function picture_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*图片-查看*/
function picture_show(title,url,id){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*图片-审核*/
function picture_shenhe(obj,id){
	layer.confirm('审核文章？', {
		btn: ['通过','不通过'], 
		shade: false
	},
	function(){
		$(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="picture_start(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
		$(obj).remove();
		layer.msg('已发布', {icon:6,time:1000});
	},
	function(){
		$(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="picture_shenqing(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未通过</span>');
		$(obj).remove();
    	layer.msg('未通过', {icon:5,time:1000});
	});	
}

/*图片-下架*/
function picture_stop(obj,id){
	layer.confirm('确认要下架吗？',function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_start(this,id)" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
		$(obj).remove();
		layer.msg('已下架!',{icon: 5,time:1000});
	});
}

/*图片-发布*/
function picture_start(obj,id){
	layer.confirm('确认要发布吗？',function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_stop(this,id)" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
		$(obj).remove();
		layer.msg('已发布!',{icon: 6,time:1000});
	});
}

/*图片-申请上线*/
function picture_shenqing(obj,id){
	$(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">待审核</span>');
	$(obj).parents("tr").find(".td-manage").html("");
	layer.msg('已提交申请，耐心等待审核!', {icon: 1,time:2000});
}

/*图片-编辑*/
function picture_edit(title,url,id){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*图片-删除*/
function picture_del(obj,id,src){

	layer.confirm('确认要删除吗？删除后不可撤回',function(index){
		$.ajax({
			type: 'POST',
			url: '/admin/banner/force/delete',
			dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
			data:{'id':id,'src':src},
			success: function(res){

			    if (res == 100){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
				} else{
                    layer.msg('删除失败!',{icon:2,time:1000});
				}

			},
			error:function(data) {
                layer.msg('请稍后再试!',{icon:2,time:1000});
			},
		});		
	});
}


/*图片-恢复删除*/
function picture_restore(obj,id){

    layer.confirm('确认要恢复吗？',function(index){
        $.ajax({
            type: 'POST',
            url: '/admin/banner/restore',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data:{'id':id},
            success: function(res){

                if (res == 100){
                    $(obj).parents("tr").remove();
                    layer.msg('已恢复!',{icon:1,time:1000});
                } else{
                    layer.msg('恢复失败!',{icon:2,time:1000});
                }

            },
            error:function(data) {
                layer.msg('请稍后再试!',{icon:2,time:1000});
            },
        });
    });
}

</script>
</body>
</html>