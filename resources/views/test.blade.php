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

<img src="/uploads/artist_images/20181005/5bb7471878e44.jpg" width="130" height="130" alt="">

{{$name}}
<form action="/test1" method="post" enctype="multipart/form-data">
    <input type="file" name="song">
    <button type="submit">111</button>
</form>


</body>
</html>