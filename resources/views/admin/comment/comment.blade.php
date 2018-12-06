@include('admin._meta')

<title>评论列表</title>
<meta name="_token" content="{{ csrf_token() }}"/>
<style>
	.pagination {
		display: inline-block;
		padding-left: 0;
		margin: 20px 0;
		border-radius: 4px;
	}
	.pagination > li {
		display: inline;
	}
	.pagination > li > a,
	.pagination > li > span {
		position: relative;
		float: left;
		padding: 6px 12px;
		margin-left: -1px;
		line-height: 1.42857143;
		color: #428bca;
		text-decoration: none;
		background-color: #fff;
		border: 1px solid #ddd;
	}
	.pagination > li:first-child > a,
	.pagination > li:first-child > span {
		margin-left: 0;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
	}
	.pagination > li:last-child > a,
	.pagination > li:last-child > span {
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
	}
	.pagination > li > a:hover,
	.pagination > li > span:hover,
	.pagination > li > a:focus,
	.pagination > li > span:focus {
		color: #2a6496;
		background-color: #eee;
		border-color: #ddd;
	}
	.pagination > .active > a,
	.pagination > .active > span,
	.pagination > .active > a:hover,
	.pagination > .active > span:hover,
	.pagination > .active > a:focus,
	.pagination > .active > span:focus {
		z-index: 2;
		color: #fff;
		cursor: default;
		background-color: #428bca;
		border-color: #428bca;
	}
	.pagination > .disabled > span,
	.pagination > .disabled > span:hover,
	.pagination > .disabled > span:focus,
	.pagination > .disabled > a,
	.pagination > .disabled > a:hover,
	.pagination > .disabled > a:focus {
		color: #777;
		cursor: not-allowed;
		background-color: #fff;
		border-color: #ddd;
	}
</style>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 评论管理 <span class="c-gray en">&gt;</span> 评论列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
		{{--日期范围：--}}
		{{--<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">--}}
		{{-----}}
		{{--<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">--}}
		<input type="text" class="input-text" style="width:250px" autocomplete="off" onkeypress="EnterPress(event)" placeholder="输入关键词" id="keyword" name="">
		<button type="submit" class="btn btn-success radius" onclick="search()" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜评论</button>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> 共有数据：<strong>{{$count}}</strong> 条</span> <span class="r"></span> </div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-hover table-bg table-sort">
			<thead>
				<tr class="text-c">

					<th width="60">ID</th>
					<th width="60">用户名</th>
					<th>留言内容</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($comments as $comment)
				<tr class="text-c">
					<td>{{$comment->id}}</td>
					<td><a href="javascript:;"><i class="avatar size-L radius"><img alt="" src="/{{$comment->user->avatar}}" onerror="this.src='static/h-ui/images/ucnter/avatar-default-S.gif'"></i></a></td>
					<td class="text-l"><div class="c-999 f-12">
							<u style="cursor:pointer" class="text-primary">{{$comment->user->nickname}}&nbsp;</u> <time title="{{$comment->created_at}}" datetime="{{$comment->created_at}}">{{$comment->created_at}}</time> <span class="ml-20"></span> <span class="ml-20"></span></div>

						<div>{{$comment->content}}</div></td>
					<td class="td-manage"> <a title="删除" href="javascript:;" onclick="comment_del(this,'{{$comment->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{$comments->render()}}
	</div>
</div>

<!--_footer 作为公共模版分离出去-->
@include('admin._footer')
 <!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin//datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin//laypage/1.2/laypage.js"></script>
<script type="text/javascript">
// $(function(){
// 	$('.table-sort').dataTable({
// 		"aaSorting": [[ 1, "desc" ]],//默认第几个排序
// 		"bStateSave": true,//状态保存
// 		"aoColumnDefs": [
// 		  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
// 		  {"orderable":false,"aTargets":[0,2,4]}// 制定列不参与排序
// 		]
// 	});
//
// });
//搜索
function EnterPress(e){ //传入 event
    var e = e || window.event;
    if(e.keyCode == 13){
        var keyword = $('#keyword').val();
        // if(keyword){
            window.location.href="/admin/comment?keyword="+keyword;
        // }
    }
}
function search(){

    var keyword = $('#keyword').val();
    // if(keyword){
        window.location.href="/admin/comment?keyword="+keyword;
    // }
}
/*评论-删除*/
function comment_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '/admin/comment/del',
			data:{'id':id},
			dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
			success: function(data){
			    if(data == 100){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
				}else{
                    layer.msg('删除失败了!',{icon:2,time:1000});
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