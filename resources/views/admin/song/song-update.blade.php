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
      width: 300px;
    }
    #file,
    #clipBtn {
      margin: 20px;
    }
    #view {

      width: 180px;
      height: 180px;
    }
  </style>
</head>
<body style="padding:10px;">

<div class="layui-fluid">
  <div class="layui-row">

    <div class="layui-col-md4">
      <form class="layui-form" action="" method="post" enctype="multipart/form-data" onsubmit="return false" id="form-add">
        <input type="hidden" name="id" value="{{$song->id}}">
        <div class="layui-form-item">
          <label class="layui-form-label">歌名</label>
          <div class="layui-input-block">
            <input type="text" name="name" id="name" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input" value="{{$song->name}}">
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">需要会员</label>
          <div class="layui-input-block">

            <input type="radio" name="vip" value="0" title="否" @if($song->vip == 0) checked="" @endif>
            <input type="radio" name="vip" value="1" title="是" @if($song->vip == 1) checked="" @endif>
          </div>
        </div>

        <div class="layui-inline">
          <label class="layui-form-label">搜索选择框</label>
          <div class="layui-input-inline">
            <select name="album_id" lay-verify="" lay-search="">
              <option value="">直接选择或搜索选择</option>
              @foreach($albums as $album)
                @if($song->album_id == $album->id)
                  <option value="{{$album->id}}" selected="selected">{{$album->name}}</option>
                  @else
                  <option value="{{$album->id}}">{{$album->name}}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>
        <div style="height:20px;"></div>
        <div class="layui-form-item">
          <label class="layui-form-label">标签</label>
          <div class="layui-input-block">
            <input type="text" name="tags" id="tags" value="{{$song->tags}}" autocomplete="off" placeholder="" class="layui-input">
          </div>
          <div id="chooseTags" class="layui-fluid" style="display: none;">

            @foreach($tags as $tag)
              <div class="layui-row" style="margin-top:10px;">

                <div class="layui-col-xs2" style="text-align: center;">
                  <b>{{$tag->name}}</b>
                </div>
                <div class="layui-col-xs7" style="border:1px solid rgba(0,0,0,0.1);background-color: rgba(0,0,0,0.1)">
                  @if($tag->son)
                    @foreach($tag->son as $t)
                      <a href="javascript:;" onclick="setTag('{{$t->name}}')">{{$t->name}}</a>&nbsp;|&nbsp;
                    @endforeach
                  @endif
                </div>
                <div class="layui-col-md3">
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div style="height:20px;"></div>


        {{--<div class="layui-form-item">--}}
        {{--{if condition="$song['mv_id'] != ''"}--}}
        {{--<label class="layui-form-label">已有MV</label>--}}
        {{--<div class="layui-input-block">--}}
        {{--<!--<a href="javascript:open_video();" class="layui-btn"> 查看MV</a>-->--}}
        {{--<a href="javascript:$('#upload_mv_div').css('display','block');" class="layui-btn">修改</a>--}}
        {{--</div>--}}
        {{--{/if}--}}
        {{--</div>--}}
        {{--<div class="layui-form-item" style="display:none;" id="upload_mv_div">--}}
        {{--<label class="layui-form-label">上传MV</label>--}}
        {{--<div class="layui-input-block">--}}
        {{--<button type="button" class="layui-btn" id="test5">选择视频</button>--}}
        {{--<button type="button" class="layui-btn layui-btn-warm" id="upload_mv"><i class="layui-icon"></i>确认上传</button>--}}
        {{--</div>--}}
        {{--</div>--}}

        <br/>
        <div class="layui-form-item">
          <label class="layui-form-label"></label>
          <div class="layui-input-inline">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">保存修改</button>
          </div>
        </div>
      </form>
    </div>
    <div class="layui-col-md4">
      <div class="layui-form-item">
        <label class="layui-form-label">上传封面</label>
        <div class="layui-input-block">
          <button onclick="up()" class="layui-btn">选择文件</button>
          <button id="clipBtn" class="layui-btn">截取预览</button>
          <a href="javascript:save_img();" class="layui-btn layui-btn-warm">确认保存</a>
          <input type="file" id="file" style="display:none;">
          <h4 id="tips" style="display: none;color:red;">拖动选取目标区域</h4>
          <div id="clipArea" style="display: none;"></div>
          <h4 id="pre_tips" >封面效果</h4>
          <div id="view" style="background-image: url('/{{$song->cover}}');"></div>
        </div>
      </div>
    </div>

  </div>
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

  form.on('submit(demo1)', function(data){

      // console.log(data.field);
        $.ajax({
          type:"post",
          url : "/admin/song/update",
          dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
          data: data.field,
          success:function(result){
              // alert(JSON.stringify(result));
            if (result['StateCode'] == 100){
                layer.msg('修改成功');
                setInterval(function() {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.$('#reload_btn').click();
                    parent.layer.close(index);//关闭当前页
                }, 1000);
            }else if (result['StateCode'] == 200){
              layer.msg('修改失败');
            }else {
                layer.msg('修改失败');
            }
          },
          error:function(){
            layer.msg('请稍后再试');
          }
        });

    return false;
  });


});
// layui.use('upload', function() {
//     var $ = layui.jquery
//         , upload = layui.upload;
//     upload.render({
//         elem: '#test5'
//         ,auto:false
//         ,field:'video'
//         ,bindAction:'#upload_mv'
//         ,url: "{:url('mv/upload_mv')}"
//         ,data:{'artist_id':"{$song.artist_id}"}
//         ,accept: 'video' //视频
//         ,done: function(res){
//             if(res['code']==0){
//                 $('#mv_id').val(res['mv_id']);
//                 layer.msg('上传MV成功');
//             }else{
//                 layer.msg('上传失败');
//             }
//         }
//     });
// })
</script>
    <script>
      var count = 0;
      var base64_img;

        function up(){
            $('#file').click();
        }
        var clipArea = new bjj.PhotoClip("#clipArea", {
            size: [180, 180],
            outputSize: [180, 180],
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
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  },
                  data: {'base64_image':base64_img,'type':'song'},
                  success:function(res){
                      $.ajax({//上传完获取返回的图片路径 更新数据库
                          type:"post",
                          url : "/admin/song/update",
                          dataType:'json',
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                          },
                          data: {'id':'{{$song->id}}','cover':res},
                          success:function(result){
                              if (result['StateCode'] == 100) {
                                  layer.msg('封面修改成功');

                              }else if (result['StateCode'] == 200) {
                                  layer.msg('封面修改失败');
                              }else{
                                  layer.msg(result['message']);
                              }
                          },
                          error:function(){
                              layer.msg('请稍后再试');
                          }
                      });

                  },
                  error:function(){
                      layer.msg('请稍后再试');
                  }
              });
              return ;
          }
          layer.msg("请先选择图片截取后上传");

      }
      $('#tags').focus(function(){
          $('#chooseTags').css('display','block');
      });
      function setTag(tag_name){
          var tags = $('#tags').val();
          if(tags != ''){
              var arr =  tags.split(',');
              if(arr.length>=5){
                  layer.msg('不能超过5个标签');
              }else{
                  var boolean = true;
                  for (var i = 0 ;i<arr.length;i++){
                      if(tag_name == arr[i]){
                          boolean = false;
                          layer.msg('标签重复');
                      }
                  }
                  if(boolean == true){
                      $('#tags').val(tags+=','+tag_name);
                  }
              }
          }else{
              $('#tags').val(tag_name);
          }
      }



    </script>

</body>
</html>