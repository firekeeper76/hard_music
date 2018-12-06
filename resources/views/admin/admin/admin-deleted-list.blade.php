@include('admin._meta')
<meta name="_token" content="{{ csrf_token() }}"/>
<title>被删除管理员列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 被删除管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">

	<div class="cl pd-5 bg-1 bk-gray mt-20"></span> <span class="r">共有数据：<strong>{{$count}}</strong> 条</span> </div>
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
				<th>删除时间</th>
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
				<td>{{$value->deleted_at}}</td>

				<td class="td-manage">
					<a title="恢复" href="javascript:;" onclick="admin_restore(this,'{{$value->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
					<a title="删除" href="javascript:;" onclick="admin_del(this,'{{$value->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
				</td>

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


/*管理员-恢复*/
function admin_restore(obj,id){
    layer.confirm('确认要恢复吗？',function(index){
        $.ajax({
            type: 'POST',
            url: '/admin/admin/restore',
            dataType: 'json',
            data:{'id':id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(res){

                if(res['StateCode'] == 100){
                    $(obj).parents("tr").remove();
                    layer.msg('已恢复!',{icon:1,time:1000});
                }else{
                    layer.msg('恢复失败了!',{icon: 5,time:1000});
                }
            },
            error:function(data) {
                layer.msg('恢复失败');
            },
        });
    });
}

/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？删除后不可恢复',function(index){
		$.ajax({
			type: 'POST',
			url: '/admin/admin/force/delete',
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


</script>
</body>
</html>