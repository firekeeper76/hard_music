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
<body>

    <div style="width:40%">
      <form class="layui-form" action="" method="post" enctype="multipart/form-data" onsubmit="return false" id="form-add">
        <input type="hidden" name="cover" id="cover" value="">
        <input type="hidden" name="artist_id" id="artist_id" value="{{$artist_id}}">

        <div class="layui-form-item">
          <label class="layui-form-label">专辑名称</label>
          <div class="layui-input-block">
            <input type="text" name="name" id="album_name" autocomplete="off" placeholder="" class="layui-input" value="">
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">发行公司</label>
          <div class="layui-input-block">
            <input type="text" name="company" id="company" autocomplete="off" placeholder="" class="layui-input" value="">
          </div>
        </div>
        <div class="layui-form-item">
          <div class="layui-inline">
              <label class="layui-form-label">发布日期</label>
              <div class="layui-input-inline">
                  <input type="text" name="public_time" id="date" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
              </div>
          </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">标签</label>
          <div class="layui-input-block">
            <input type="text" name="tags" id="tags" value="" autocomplete="off" placeholder="" class="layui-input">
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
        <div class="layui-form-item">
          <label class="layui-form-label">上传封面</label>
          <div class="layui-input-block">
            <button onclick="up()" class="layui-btn">选择文件</button>
            <button id="clipBtn" class="layui-btn layui-btn-danger">截取</button>
            <a href="javascript:;" id="save_img" class="layui-btn layui-btn-warm" onclick="save_img()">保存</a>
            <input type="file" id="file" style="display:none;">

            <h4 id="pre_tips" style="display: none;">预览效果</h4>
            <div id="view" style="display:none;"></div>
            <h4 id="tips" style="display: none;color:red;">拖动选取目标区域,可用滚轮调整图片大小</h4>
            <div id="clipArea" style="display: none;"></div>
          </div>
        </div>
        <div style="height:20px;"></div>
        <br/>
        <div class="layui-form-item">
          <label class="layui-form-label">简介</label>
          <div class="layui-input-block">
            <textarea id="intro" name="intro" lay-verify="text_sync" style="display: none;"></textarea>
          </div>
        </div>

        <div class="layui-form-item">
          <label class="layui-form-label"></label>
          <div class="layui-input-inline">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
          </div>
        </div>
      </form>
      </div>

    <form action="" class="layui-form" id="form-song" onsubmit="return false" style="margin-top: 50px;display:none;">
      <input type="hidden" id="album_name_song" >
      <input type="hidden" id="album_id_song" >
      <div class="layui-form-item">
        <label class="layui-form-label">曲目</label>
        <div class="layui-input-block">
          <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-normal" id="testList">上传歌曲</button>
            <button type="button" class="layui-btn" id="testListAction">开始上传</button>
            <div class="layui-upload-list">
              <table class="layui-table">
                <thead>
                <tr><th>歌名</th>
                  <th>大小</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr></thead>
                <tbody id="demoList"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div style="height:200px;"></div>

<script src="/plugins/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
layui.use(['form','laydate'], function(){
  var form = layui.form
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;

    var index;
    laydate.render({
        elem: '#date'
    });
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
      // console.log(data.field);
        $.ajax({
          type:"post",
          url : "/admin/album/add",
          dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
          data: data.field,
          success:function(result){

            if (result['StateCode'] == 100){
                layer.msg('添加专辑成功');
                $('#album_id_song').val(result['album_id']);
                $('#form-add').css('display','none');
                $('#form-song').css('display','block');
                // var index = parent.layer.getFrameIndex(window.name);
                // parent.layer.close(index);//关闭当前页
              // window.location.reload();
            }else if (result['StateCode'] == 201){
                layer.msg(result['message']);
            }else{
                layer.msg('添加失败');
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
layui.use('upload', function() {
    var $ = layui.jquery
        , upload = layui.upload;
    var files;
    var demoListView = $('#demoList')
        ,uploadListIns = upload.render({
        elem: '#testList'
        ,url: "/admin/song/upload"
        ,accept: 'audio'
        ,field : 'song'
            ,headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        ,data:{'album_id':0,'artist_id':$('#artist_id').val(),'cover':$('#cover').val(),'tags':$('#tags').val()}
        ,multiple: true
        ,auto: false
        ,bindAction: '#testListAction'
        ,choose: function(obj){
            this.data.cover = $('#cover').val();
            this.data.tags = $('#tags').val();
            this.data.album_id = $('#album_id_song').val();

            // alert(JSON.stringify(this.data));
            files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
            //读取本地文件
            obj.preview(function(index, file, result){
                // file.name = file.name.split(file.name.lastIndexOf("."));
                var tr = $(['<tr id="upload-'+ index +'">'
                    ,'<td>'+ file.name +'</td>'
                    ,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
                    ,'<td>等待上传</td>'
                    ,'<td>'
                    ,'<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>'
                    ,'<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>'
                    ,'</td>'
                    ,'</tr>'].join(''));

                //单个重传
                tr.find('.demo-reload').on('click', function(){
                    obj.upload(index, file);
                });

                //删除
                tr.find('.demo-delete').on('click', function(){
                    delete files[index]; //删除对应的文件
                    tr.remove();
                    uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                });

                demoListView.append(tr);
            });
        }
        ,done: function(res, index, upload){
            if(res.code == 0){ //上传成功
                // alert(JSON.stringify(res.name));
                var tr = demoListView.find('tr#upload-'+ index)
                    ,tds = tr.children();
                tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                tds.eq(3).html(''); //清空操作
                return delete this.files[index]; //删除文件队列已经上传成功的文件
            }
            this.error(index, upload);
        }
        ,error: function(index, upload){
            var tr = demoListView.find('tr#upload-'+ index)
                ,tds = tr.children();
            tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
            tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
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
                // $.ajax({
                //     type:"post",
                //     url : "{:url('common/upload_img')}",
                //     dataType:'json',
                //     data: {'img':dataURL,'type':'song'},
                //     success:function(data){
                //         $('#cover').val(data.cover);
                //     },
                //     error:function(){
                //         console.log('接口错误');
                //     }
                //
                // });
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
                  data: {'base64_image':base64_img,'type':'album'},
                  success:function(data){
                      // alert(data);
                      if (data) {
                          $('#cover').val(data);
                          layer.msg('上传成功');
                      }else{
                          layer.msg('上传失败');
                      }

                  },
                  error:function(){
                      layer.msg('请稍后重试');
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