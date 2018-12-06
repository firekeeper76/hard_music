<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

    <meta name="description" content="Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>管理员登录</title>
<!-- start: Css -->
<link rel="stylesheet" type="text/css" href="{{URL::asset('plugins/bootstrap3/css/bootstrap.min.css')}}">
<!-- plugins -->
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/animate.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/style.css')}}" />
  <script type="text/javascript" src="{{URL::asset('js/jquery-3.2.1.min.js')}}"></script>
<style type="text/css">
  .form-signin-wrapper {
  background: url("{{URL::asset('images/xj-bg.jpg')}}") !important;
}
</style>
</head>

<body id="mimin" class="dashboard form-signin-wrapper">
<div class="container">
  <form class="form-signin" action="" method="post">
    {{ csrf_field() }}

    <div class="panel periodic-login"> <span class="atomic-number">登录</span>
      <div class="panel-body text-center">
        <h1 class="atomic-symbol"><img src="{{URL::asset('images/admin_logo.png')}}" width="30%" alt=""></h1>
        <p class="atomic-mass">   </p>
        <p class="element-name">   </p>
        <i class="icons icon-arrow-down"  ></i>
        <div class="form-group form-animate-text" style="margin-top:40px !important;">
          <input type="text" class="form-text" autocomplete="off" name="phone" value="@if (Session::has('phone')){{Session::get('phone')}}@endif" required>
          <span class="bar"></span>
          <label>手机</label>
        </div>
        <div class="form-group form-animate-text" style="margin-top:40px !important;">
          <input type="password" class="form-text" autocomplete="off" name="password" value="@if (Session::has('password')){{Session::get('password')}}@endif" required>
          <span class="bar"></span>
          <label>密码</label>
        </div>

        <div class="form-group form-animate-text" style="margin-top:40px !important;">
          <input class="form-text" placeholder="" autocomplete="off" name="captcha" id="input_code" style="width:200px;float:left;" type="text">
          <img style="float:right;cursor: pointer;" id="code" src="{{captcha_src()}}" alt="captcha" onclick="this.src='{{captcha_src()}}'+Math.random()"/>
        </div>
        <!--<input type="hidden" name="__token__" value="{$Request.token}" id="token"/>-->
        <!-- <label class="pull-left">
          <input type="checkbox" class="icheck pull-left" name="repassword"/>
          记住密码 </label> -->
        <div style="clear:both;height:0px;"></div><br>
        <span id="msg" style="color:red;">
          @if (count($errors) > 0)

               @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach

            @endif

            @if (Session::has('tips')){{Session::get('tips')}}@endif
        </span>
        <input type="submit" id="login" class="btn col-md-12" value="登 录"/>
      </div>
      <div class="text-center" style="padding:5px;"> 版权所有：lw </div>
    </div>
  </form>
</div>

<script type="text/javascript">

// $(function(){
//
//   $('#login').on('click',function(event){
//
//     $.ajax({
//       type:"post",
//       url : "/admin/login",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//         },
//       dataType:'json',
//       data: $("form").serialize(),
//       success:function(res){
//           console.log(res);
//
//       },
//       error:function(){
//         alert('接口错误');
//       }
//
//     });
//   })
//   function check(){
//     return false;
//   }
//
// })

</script>

</body>
</html>