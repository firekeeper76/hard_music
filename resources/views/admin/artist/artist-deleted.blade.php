@include('admin._meta')
<title>歌手列表</title>
<meta name="_token" content="{{ csrf_token() }}"/>
<link rel="stylesheet" href="/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<link rel="stylesheet" href="/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
{{--<link rel="stylesheet" href="/css/jquery.page.css">--}}
{{--<script type="text/javascript" src="/js/jquery.min.js"></script>--}}
{{--<script type="text/javascript" src="/js/jquery.page.js"></script>--}}

{{--<script src="/js/vue2-0.js"></script>--}}
<style>
	.blk{
		list-style: none;
		padding-top:10px;
		padding-left:10px;
	}
	.blk-inside{
		padding-left:20px;
	}

	.page-bar{
		margin:40px;
	}
	ul,li{
		margin: 0px;
		padding: 0px;
	}
	li{
		list-style: none
	}

	#pull_right{
		text-align:center;
	}
	.pull-right {
		/*float: left!important;*/
	}
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
	.clear{
		clear: both;
	}
	.active{
		color:red;
	}
</style>
</head>
<body class="pos-r">

<div class="pos-a" style="width:200px;left:0;top:0; bottom:0; height:100%; border-right:1px solid #e5e5e5; background-color:#f5f5f5; overflow:auto;">
	{{--<ul id="treeDemo" class="ztree"></ul>--}}

	<div class="blk">
		<a href="/admin/artist/deleted" onclick="" class="" id="all"><li>全部</li></a>
		@foreach($categorys as $category)
			<div class="blk">
				<h5><b>{{$category->catename}}</b></h5>
				<div class="blk-inside">
				@if($category->son)
					@foreach($category->son as $cate)
						<a href="/admin/artist/deleted?category_id={{$cate->id}}" id="cate{{$cate->id}}" onclick="" class=""><li>{{$cate->catename}}</li></a>
					@endforeach
				@endif
				</div>
				<hr>
			</div>
		@endforeach

	</div>

</div>

<div style="margin-left:200px;">
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 音乐管理 <span class="c-gray en">&gt;</span> 歌手回收站 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
	<div class="page-container">
		<div class="text-c">
			{{--日期范围：--}}
			{{--<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate" style="width:120px;">--}}
			{{-----}}
			{{--<input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" class="input-text Wdate" style="width:120px;">--}}
			<input type="text" name="" id="keyword" autocomplete="off" onkeypress="EnterPress(event)" placeholder=" 歌手名称" style="width:250px" class="input-text">
			<button name="" id="" class="btn btn-success" type="submit" onclick="search()"><i class="Hui-iconfont">&#xe665;</i> 搜歌手</button>
		</div>
		{{--<div class="cl pd-5 bg-1 bk-gray mt-20"><a class="btn btn-primary radius" onclick="artist_add('添加歌手','/admin/artist/add')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加歌手</a></span> <span class="r">共有数据：<strong id="count">{{$count}}</strong> 条</span> </div>--}}
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>
					<tr class="text-c">

						<th >ID</th>
						<th >缩略图</th>
						<th >歌手</th>
						<th >介绍</th>
						<th >所属公司</th>
						{{--<th >发布状态</th>--}}
						<th >操作</th>
					</tr>
				</thead>
				<tbody id="song_list">
					@foreach($artists as $artist)
					<tr class="text-c va-m">

						<td>{{$artist->id}}</td>
						<td><a onClick="artist_img('修改 {{$artist->name}} 的封面','/admin/artist/cover?id={{$artist->id}}')" title="修改 {{$artist->name}} 的封面" href="javascript:;"><img width="60" class="product-thumb" src="/{{$artist->avatar}}"></a></td>
						<td><a style="text-decoration:none" onClick="product_show('哥本哈根橡木地板','product-show.html','10001')" href="javascript:;"> <b class="text-success">{{$artist->name}}</b></a></td>
						<td class="text-l">{{$artist->intro}}</td>
						<td><span class="price">{{$artist->company}}</span></td>
						{{--<td class="td-status"><span class="label label-success radius">已发布</span></td>--}}
						<td class="td-manage">

							<a style="text-decoration:none" onClick="artist_restore(this,'{{$artist->id}}')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>
							{{--<a style="text-decoration:none" class="ml-5" onClick="product_edit('编辑','product-add.html','10001')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>--}}
							<a style="text-decoration:none" class="ml-5" onClick="artist_del(this,'{{$artist->id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			{{$artists->render()}}

		</div>
	</div>
</div>

<!--_footer 作为公共模版分离出去-->
@include('admin._footer')
 <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/zTree/v3/js/jquery.ztree.all-3.5.min.js"></script>
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    $(function () {
        var url = location.href;
        var arr = url.split('=');
        if(arr[1]){
            $("#cate"+arr[1]).addClass('active');
            // $('#title').html($("#li"+arr[1]).html());
        }else{
            $("#all").addClass('active');
        }
    });
    //搜索
    function EnterPress(e){ //传入 event
        var e = e || window.event;
        if(e.keyCode == 13){
            var keyword = $('#keyword').val();
            if(keyword){
                window.location.href="/admin/artist/deleted?keyword="+keyword;
            }
        }
    }
    function search(){

        var keyword = $('#keyword').val();
        if(keyword){
			window.location.href="/admin/artist/deleted?keyword="+keyword;
        }
	}
//
// var zNodes =[
// 	{ id:1, pId:0, name:"一级分类", open:true},
// 	{ id:11, pId:1, name:"二级分类"},
// 	{ id:111, pId:11, name:"三级分类"},
// 	{ id:112, pId:11, name:"三级分类"},
// 	{ id:113, pId:11, name:"三级分类"},
// 	{ id:114, pId:11, name:"三级分类"},
// 	{ id:115, pId:11, name:"三级分类"},
// 	{ id:12, pId:1, name:"二级分类 1-2"},
// 	{ id:121, pId:12, name:"三级分类 1-2-1"},
// 	{ id:122, pId:12, name:"三级分类 1-2-2"},
// ];
//
//
//
// $(document).ready(function(){
// 	var t = $("#treeDemo");
// 	t = $.fn.zTree.init(t, setting, zNodes);
// 	//demoIframe = $("#testIframe");
// 	//demoIframe.on("load", loadReady);
// 	var zTree = $.fn.zTree.getZTreeObj("tree");
// 	//zTree.selectNode(zTree.getNodeByParam("id",'11'));
// });

// $('.table-sort').dataTable({
// 	"aaSorting": [[ 1, "desc" ]],//默认第几个排序
// 	"bStateSave": true,//状态保存
// 	"aoColumnDefs": [
// 	  {"orderable":false,"aTargets":[0,7]}// 制定列不参与排序
// 	]
// });
/*歌手-添加*/
function artist_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*歌手图片修改*/
function artist_img(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*产品-审核*/
function product_shenhe(obj,id){
	layer.confirm('审核文章？', {
		btn: ['通过','不通过'], 
		shade: false
	},
	function(){
		$(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="product_start(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
		$(obj).remove();
		layer.msg('已发布', {icon:6,time:1000});
	},
	function(){
		$(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="product_shenqing(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未通过</span>');
		$(obj).remove();
    	layer.msg('未通过', {icon:5,time:1000});
	});	
}
/*产品-下架*/
function artist_restore(obj,id){
	layer.confirm('确认要下架吗？',function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_start(this,id)" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
		$(obj).remove();
		layer.msg('已下架!',{icon: 5,time:1000});
	});
}

/*产品-发布*/
function product_start(obj,id){
	layer.confirm('确认要发布吗？',function(index){
		$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_stop(this,id)" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
		$(obj).remove();
		layer.msg('已发布!',{icon: 6,time:1000});
	});
}

/*产品-申请上线*/
function product_shenqing(obj,id){
	$(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">待审核</span>');
	$(obj).parents("tr").find(".td-manage").html("");
	layer.msg('已提交申请，耐心等待审核!', {icon: 1,time:2000});
}

/*产品-编辑*/
function product_edit(title,url,id){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

    /*产品-恢复*/
    function artist_restore(obj,id){
        layer.confirm('确认要恢复吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '/admin/artist/restore',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data:{'id':id},
                success: function(res){

                    if(res == 100){
                        $(obj).parents("tr").remove();
                        layer.msg('已恢复!',{icon:1,time:1000});
                    }else{
                        layer.msg('恢复失败!',{icon:2,time:1000});
                    }
                },
                error:function() {
                    layer.msg('请稍后再试!',{icon:2,time:1000});
                },
            });
        });
    }

/*歌手-删除*/
function artist_del(obj,id){
	layer.confirm('确认要删除吗？删除后无法恢复',function(index){
		$.ajax({
			type: 'POST',
			url: '/admin/artist/force/del',
			dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
			data:{'id':id},
			success: function(res){
			    if(res == 100){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
				}else{
                    layer.msg('删除失败!',{icon:2,time:1000});
				}
			},
			error:function() {
                layer.msg('请稍后再试!',{icon:2,time:1000});
			},
		});		
	});
}
</script>
</body>
</html>