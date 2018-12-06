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
      height: 175px;
      width: 475px;
    }
    #file,
    #clipBtn {
      margin: 20px;
    }
    #view {
      margin: 0 auto;
      width: 980px;
      height: 345px;
    }
  </style>
</head>
<body>

    <div style="width:40%">

      <form class="layui-form"  method="post" enctype="multipart/form-data" onsubmit="return false"  id="form-add">
        <div style="height:20px;"></div>

        <input type="hidden" value="{{$banner->src}}" id="src" autocomplete="off" placeholder="" class="layui-input">
        <div class="layui-form-item">
          <div class="layui-inline">
            <label class="layui-form-label">图片链接到</label>
            <div class="layui-input-inline">
              <select name="" id="src_to_type">
                <option value="song" @if(explode('?',$banner->src_to)[0] == 'song') selected @endif>歌曲</option>
                <option value="artist" @if(explode('?',$banner->src_to)[0] == 'artist') selected @endif>歌手</option>
                <option value="album" @if(explode('?',$banner->src_to)[0] == 'album') selected @endif>专辑</option>
                <option value="playlist" @if(explode('?',$banner->src_to)[0] == 'playlist') selected @endif>歌单</option>
              </select>
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">id</label>
            <div class="layui-input-inline">
              <input class='layui-input' type="text" id="src_to_id" value="{{explode('=',$banner->src_to)[1]}}">
            </div>
          </div>
        </div>
        {{--<div class="layui-form-item">--}}
          {{--<label class="layui-form-label">图片链接到</label>--}}
          {{--<div class="layui-input-block">--}}
            {{--<input type="text" name="" id="src_to" autocomplete="off" placeholder="" class="layui-input">--}}
          {{--</div>--}}
        {{--</div>--}}
        <div style="height:20px;"></div>
        <div class="layui-form-item">
          <label class="layui-form-label">背景色</label>
          <div class="layui-input-block">
            <input type="text" id="bg_color" autocomplete="off" placeholder="" value="{{$banner->bg_color}}" class="layui-input">
            <div style="width: 20px;height: 20px;background: {{$banner->bg_color}};"></div>
          </div>

        </div>
        <div style="height:20px;"></div>
        <div class="layui-form-item">
          <label class="layui-form-label">排序（从大到小）</label>
          <div class="layui-input-block">
            <input type="text" id="sort" autocomplete="off" placeholder="" value="{{$banner->sort}}" class="layui-input">
          </div>

        </div>
        <div style="height:20px;"></div>
        <div class="layui-form-item">
          <label class="layui-form-label">上传封面</label>
          <div class="layui-input-block">
            <button onclick="up()" class="layui-btn ">选择文件</button>
            <button id="clipBtn" class="layui-btn layui-btn-danger">截取预览</button>
            <a href="javascript:save_img();" class="layui-btn layui-btn-warm">确认保存</a>
            <input type="file" id="file" style="display:none;">
            <h4 id="tips" style="display: none;color:red;">拖动选取目标区域,鼠标滚轮可放大缩小,双击旋转图片</h4>
            <div id="clipArea" style="display: none;"></div>
            <h4 id="pre_tips" style="display: none;">预览效果</h4>
            <div id="view" style=" background-image: url('/{{$banner->src}}')"></div>
          </div>
        </div>

        <br/>
        <div class="layui-form-item">
          <label class="layui-form-label"></label>
          <div class="layui-input-inline">
            <button class="layui-btn" onclick="update()">立即提交</button>
          </div>
        </div>
      </form>
      </div>
    <div style="height:200px;"></div>
<script src="/plugins/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
layui.use(['form'], function(){
  var form = layui.form
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
    var index;



});

</script>
    <script>
      var id = '{{$banner->id}}';
      var old_src = '{{$banner->src}}';

      function update(){

          var src = $('#src').val();

          var bg_color = $('#bg_color').val();
          var src_to_type = $('#src_to_type').val();
          var src_to_id = $('#src_to_id').val();
          var sort = $('#sort').val();
          var src_to;

          if(!src_to_type){
              layer.msg('类型不能为空');
              return ;
          }
          if(!src_to_id){
              layer.msg('id不能为空');
              return ;
          }
          if(!src){
            layer.msg('请先上传图片');
            return ;
          }
          if(!bg_color){
              layer.msg('背景色不能为空');
              return;
          }

          src_to = src_to_type+"?id="+src_to_id;
          var data;
          if(src == old_src){
            data  = {'id':id,'src_to':src_to,'bg_color':bg_color,'sort':sort};
          }else{
              data  = {'id':id,'src':src,'src_to':src_to,'bg_color':bg_color,'sort':sort,'old_src':old_src};
          }

          $.ajax({
              type:"post",
              url : "/admin/banner/update",
              dataType:'json',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              },
              data: data,
              success:function(result){
                  if (result == 100){
                      layer.msg('修改成功');
                      setInterval(function() {
                          var index = parent.layer.getFrameIndex(window.name);
                          parent.$('.btn-refresh').click();
                          parent.layer.close(index);
                      }, 1000);
                  }else if (result == 200){
                      layer.msg('修改失败');
                  }
              },
              error:function(){
                  layer.msg('请稍后再试');
              }
          });
      }


        var count = 0;
        var base64_img;
        function up(){
            $('#file').click();
        }
        var clipArea = new bjj.PhotoClip("#clipArea", {
            size: [475, 175],
            outputSize: [980, 345],
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
                    data: {'base64_image':base64_img,'type':'banner'},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data){
                            layer.msg('图片上传成功');
                            $('#src').val(data);
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


    </script>







</body>
</html>