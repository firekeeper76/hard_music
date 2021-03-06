<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="renderer" content="webkit">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/plugins/layui/css/layui.css"  media="all">
  <script type="text/javascript" src="/clip/js/jquery-2.1.3.min.js"></script>

  <script src="/clip/js/jquery-2.1.3.min.js"></script>
  <script src="/clip/js/iscroll-zoom.js"></script>
  <script src="/clip/js/hammer.js"></script>
  <script src="/clip/js/lrz.all.bundle.js"></script>
  <script src="/clip/js/jquery.photoClip.js"></script>
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->

  <style>
    #clipArea {
      margin: 20px;
      height: 300px;
      width: 640px;
    }
    #file,
    #clipBtn {
      margin: 20px;
    }
    #view {
      margin: 0 auto;
      width: 640px;
      height: 300px;
    }
  </style>
</head>
<body>

    <div style="width:40%">

      <form class="layui-form" action="" method="post" enctype="multipart/form-data" onsubmit="return false" id="form-add">
        <input type="hidden" name="id" id="id" class="layui-form-item" value="{{$artist->id}}">
          <input type="hidden" value="" name="cover" id="cover">
          <input type="hidden" value="" name="avatar" id="avatar">
        <div style="height:20px;"></div>


        <div class="layui-form-item">
          <label class="layui-form-label">上传封面</label>
          <div class="layui-input-block">
            <button onclick="up()" class="layui-btn">选择文件</button>
            <button id="clipBtn" class="layui-btn layui-btn-danger">截取预览</button>
            <a href="javascript:save_img();" class="layui-btn layui-btn-warm">确认保存</a>
            <input type="file" id="file" style="display:none;">
            <h4 id="tips" style="display: none;color:red;">拖动选取目标区域,请将人脸置于中间,系统会自动生成头像</h4>
            <div id="clipArea" style="display: none;"></div>
            <h4 id="pre_head" style="display: none;">头像预览</h4>
            <img src="" id="pv" alt="" width="130" height="130" style="display: none;">
            <h4 id="pre_tips" style="">封面效果</h4>
            <div id="view" style="background: url('/{{$artist->cover}}');"></div>
          </div>
        </div>

        <br/>
        <div class="layui-form-item">
          <label class="layui-form-label"></label>
          <div class="layui-input-inline">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
          </div>
        </div>
      </form>
      </div>
    <div style="height:200px;"></div>

<script src="/plugins/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
    var old_cover = '{{$artist->cover}}';
    var old_avatar = '{{$artist->avatar}}';
layui.use(['form'], function(){
  var form = layui.form
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
    var index;
    layui.use('layedit', function(){
        layedit = layui.layedit;
          index = layedit.build('intro',{
            tool: [
                'strong' //加粗
                ,'italic' //斜体
                ,'underline' //下划线
                ,'del' //删除线

                ,'|' //分割线

                ,'left' //左对齐
                ,'center' //居中对齐
                ,'right' //右对齐

            ]}
        ); //建立编辑器
    });
  form.on('submit(demo1)', function(data){
      console.log(data.field);
        $.ajax({
          type:"post",
          url : "/admin/artist/update",
          dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
          data: data.field,
          success:function(result){
              // alert(JSON.stringify(result));
            if (result == 100){
                layer.msg('添加成功');

                $.ajax({
                    type:"post",
                    url : "/admin/artist/delcover",
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    data: {'cover':old_cover,'avatar':old_avatar},
                    success:function(result){

                    },
                    error:function(){

                    }
                });

                setInterval(function() {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);//关闭当前页
                }, 1000);
              // window.location.reload();
            }else if (result == 200){
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
    form.verify({
        text_sync: function (value) {
            layedit.sync(index);
        }
    });

});

</script>
    <script>
        var count = 0;
        var base64_img;
        function up(){
            $('#file').click();
        }
        var clipArea = new bjj.PhotoClip("#clipArea", {
            size: [640, 300],
            outputSize: [640, 300],
            file: "#file",
            view: "#view",
            ok: "#clipBtn",
            loadStart: function() {
                console.log("图片读取中");
            },
            loadComplete: function() {
                $('#tips').css('display',"block");
                $('#clipArea').css('display',"block");
                console.log("图片读取完成");
            },
            clipFinish: function(dataURL) {
                $('#view').css('display',"block");
                $('#pre_tips').css('display',"block");
                base64_img = dataURL;
                // console.log(dataURL);
            }
        });
        //clipArea.destroy();
        function save_img(){
            if(base64_img){
                $.ajax({
                    type:"post",
                    url : "/upload_base64_image",
                    dataType:'json',
                    data: {'base64_image':base64_img,'type':'artist'},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        console.log(data);
                        if(data){
                            layer.msg('图片上传成功');
                            $('#cover').val(data['cover']);
                            $('#avatar').val(data['avatar']);
                        }
                        else{
                            layer.msg('图片上传失败');
                        }
                    },
                    error:function(){
                        layer.msg('请稍后再试');
                    }
                });
                return ;
            }
            layer.msg("请先选择图片截取后上传");
        }
        //clipArea.destroy();
    </script>

</body>
</html>