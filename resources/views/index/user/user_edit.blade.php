<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户资料修改</title>
    @include('index.resources')

    <script src="/clip/js/jquery-2.1.3.min.js"></script>
    <script src="/clip/js/iscroll-zoom.js"></script>
    <script src="/clip/js/hammer.js"></script>
    <script src="/clip/js/lrz.all.bundle.js"></script>
    <script src="/clip/js/jquery.photoClip.js"></script>



    <style>

        .container{
            width:980px;
            max-width:none;
            background: #ffffff;
            border-left:1px solid rgba(0,0,0,0.3);
            border-right:1px solid rgba(0,0,0,0.3);
            border-bottom:1px solid rgba(0,0,0,0.3);
            min-height: 700px;
        }
        ul,li{
            cursor: pointer;
            list-style: none;
        }
        li:hover{
            background: lightgrey;
        }
        #number a{
            text-decoration: none;
        }
        #number a:hover{
            color:red;
        }

        #clipArea {
            margin: 20px;
            height: 280px;
            width: 280px;
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

<div class="container">
    <div class="row pt-4 pl-5 pr-5">

        <div class="col-sm-12">
            <h5>个人信息</h5>
            <hr>
        </div>
        <div class="col-sm-5">

                <input type="hidden" id="id" value="{{$user->id}}">
                <div class="form-group">
                    <label for="nickname">昵称:</label>
                    <input type="text" class="form-control" name="nickname" id="nickname" value="{{$user->nickname}}">
                </div>
                <div class="form-group">
                    <label for="intro">介绍:</label>
                    <textarea name="intro" class="form-control" id="intro" cols="30" rows="4" maxlength="140">{{$user->intro}}</textarea>
                </div>

                <div class="radio">
                    <label class="radio-inline"><input type="radio" name="sex" value="1" @if($user->sex == 1) checked @endif>&nbsp;男</label>
                    <label class="radio-inline"><input type="radio" name="sex" value="2" @if($user->sex == 2) checked @endif>&nbsp;女</label>
                    <label class="radio-inline"><input type="radio" name="sex" value="0" @if($user->sex == 0) checked @endif>&nbsp;保密</label>
                </div>

                <button class="btn btn-danger mt-5" onclick="save()">保存修改</button>

        </div>
        <div class="col-sm-6">
            上传头像
            <input type="hidden" value="{{$user->avatar}}" id="avatar">
                <div class="">
                    <button onclick="up()" class="btn ">选择文件</button>
                    <button id="clipBtn" class="btn btn-info">截取预览</button>
                    <a href="javascript:save_img();" class="btn btn-danger">确认保存</a>
                    <input type="file" id="file" style="display:none;">
                    <h4 id="pre_tips" style="color: red;">预览效果</h4>
                    <div id="view" style="background-image: url('/{{$user->avatar}}')"></div>
                    <h6 id="tips" style="display: none;color:red;">拖动选取目标区域,鼠标滚轮可放大缩小</h6>
                    <div id="clipArea" style="display: none;"></div>
                </div>

        </div>

    </div>

</div>


<script>
    function save(){
        var sex = $("input[name='sex']:checked").val();
        var nickname = $("#nickname").val();
        var intro = $("#intro").val();
        var id = $("#id").val();
        $.ajax({
            type:"post",
            url : "/user/edit",
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: { 'id':id,'nickname':nickname,'intro':intro,'sex':sex},
            success:function(result){
                console.log(result);
                if(result['StateCode'] == 201){
                    window.parent.setTips(result['messages']);
                }else if(result['StateCode'] == 100){
                    window.parent.setTips('保存成功');
                }else if(result['StateCode'] == 200){
                    window.parent.setTips('请稍后再试.');
                }
            },
            error:function(){
                window.parent.setTips('请稍后再试');
            }
        });
    }
</script>


<!--图片上传-->
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
            // console.log("图片读取中");
        },
        loadComplete: function() {
            $('#tips').css('display',"block");
            $('#clipArea').css('display',"block");
            // console.log("图片读取完成");
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
                data: {'base64_image':base64_img,'type':'user'},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    //传回上传图片的路径
                    // console.log(data);
                    $.ajax({
                        type:"post",
                        url : "/update_user_avatar",
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        data: {'avatar':data,'old_avatar':$('#avatar').val(),'id':$('#id').val()},
                        success:function(result){

                            if(result['StateCode'] == 100){
                                $('#avatar').val(data);
                                window.parent.setTips('头像更新成功');
                                setInterval(function() {
                                    window.parent.location.reload();
                                }, 1000);
                            }else if(result['StateCode'] == 200){
                                window.parent.setTips('更新失败');
                            }
                        },
                        error:function(){
                            window.parent.setTips('请您稍后再试');
                        }
                    });
                },
                error:function(){
                    window.parent.setTips('请稍后再试');
                }
            });
            return ;
        }
        window.parent.setTips("请先选择图片截取后上传");

    }
    $('#tags').focus(function(){
        $('#chooseTags').css('display','block');
    });



</script>

</body>
</html>