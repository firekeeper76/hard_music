@include('admin._meta')
<meta name="_token" content="{{ csrf_token() }}"/>
<title>管理员列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
		{{--日期范围：--}}
		{{--<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">--}}
		{{-----}}
		{{--<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">--}}
		{{--<input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="">--}}
		{{--<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i></button>--}}
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20">  <a href="javascript:;" onclick="admin_add('添加管理员','/admin/admin/add','600','350')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="9">管理员列表</th>
			</tr>
			<tr class="text-c">

				<th width="40">ID</th>
				<th>手机</th>
				<th>真实姓名</th>
				<th>角色</th>
				<th>最后登录时间</th>
				<th>是否已启用</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody id="tbody">
		@foreach($admins as $key=>$value)
			<tr class="text-c">

				<td>{{$value->id}}</td>
				<td>{{$value->phone}}</td>
				<td>{{$value->realname}}</td>

				<td>{{$value->role->name}}</td>
				<td>{{$value->login_at}}</td>
				@if($value->state ==  1)
				<td class="td-status"><span class="label label-success radius">已启用</span></td>
				<td class="td-manage">
					<a style="text-decoration:none" onClick="admin_stop(this,'{{$value->id}}')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>
					<a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','/admin/admin/edit?id={{$value->id}}','{{$value->id}}','300','200')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
					<a title="删除" href="javascript:;" onclick="admin_del(this,'{{$value->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
				</td>
				@else
					<td class="td-status"><span class="label label-default radius">已禁用</span></td>
					<td class="td-manage">
						<a onClick="admin_start(this,'{{$value->id}}')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>
						<a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','/admin/admin/edit?id={{$value->id}}','{{$value->id}}','300','200')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
						<a title="删除" href="javascript:;" onclick="admin_del(this,'{{$value->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
					</td>
				@endif
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
<!--_footer 作为公共模版分离出去-->
@include('admin._footer')
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">





/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '/admin/admin/del',
			dataType: 'json',
			data:{'id':id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
			success: function(res){

                if(res['StateCode'] == 100){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }else{
                    layer.msg('删除失败了!',{icon: 5,time:1000});
                }
			},
			error:function(data) {
				layer.msg('删除失败');
			},
		});		
	});
}

/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-停用*/
function admin_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……

        $.ajax({
            url:'/admin/admin/update',
            type:'post',
            data:{'id':id,'state':0},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success:function (res) {
                if(res['StateCode'] == 100){
                    $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,'+id+')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
                    $(obj).remove();
                    layer.msg('已停用!',{icon: 5,time:1000});
                }else{
                    layer.msg('停用失败了!',{icon: 5,time:1000});
                }
            },
            error:function () {
                layer.msg('请稍后再试!',{icon: 5,time:1000});
            }

        });


	});
}

/*管理员-启用*/
function admin_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.ajax({
			url:'/admin/admin/update',
			type:'post',
			data:{'id':id,'state':1},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
			success:function (res) {

				if(res['StateCode'] == 100){
                    $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,'+id+')" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                    $(obj).remove();
                    layer.msg('已启用!', {icon: 6,time:1000});
				}else{
                    layer.msg('启用失败了!',{icon: 5,time:1000});
				}
            },
			error:function () {
                layer.msg('请稍后再试!',{icon: 5,time:1000});
            }

		});
		

	});
}
</script>
</body>
</html>