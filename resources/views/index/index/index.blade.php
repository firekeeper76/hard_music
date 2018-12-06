<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="_token" content="{{ csrf_token() }}"/>
		<link rel="shortcut icon" href="{{ URL::asset('images/favicon.ico') }}">
		<link rel="bookmark" href="{{ URL::asset('images/favicon.ico') }}">
		<link rel="stylesheet" href="{{ URL::asset('plugins/bootstrap4/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('plugins/font-awesome-4.7.0/css/font-awesome.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('css/music.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('index/music/css/smusic.css') }}"/>
		<script src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('plugins/bootstrap4/js/poper.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('plugins/bootstrap4/js/bootstrap.min.js') }}"></script>
		<title>网难云音乐</title>
		<style></style>
	</head>
	<body>

		<nav class="navbar navbar-expand-lg navbar-dark bg-black p-0 border-bottom border-black">
			<div class="container">
				
				<a class="navbar-brand p-0" href="javascript:localhash('main');"><img src="{{ URL::asset('images/logo.png') }}" alt="" height="68"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				</button>
			
			  	<div class="collapse navbar-collapse h-100" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
				      <li class="nav-item active">
				        <a class="nav-link bg-black p-4 active" href="javascript:;" onclick="localhash('/main')">发现音乐 <span class="sr-only">(current)</span></a>
				      </li>
				      <li class="nav-item">
				        <a class="nav-link bg-black p-4" href="javascript:;" onclick="my_playlist()">我的音乐</a>
				      </li>
				      <li class="nav-item">
				        <!--<a class="nav-link bg-black p-4" href="#">朋友</a>-->
				      </li>
				    </ul>
					<form class="form-inline my-2 my-lg-0" onsubmit="return false;">
						<i class="fa fa-search icon_search text-muted"></i>

						<input class="input_search border-0 form-control mr-sm-2 form-control-sm badge-pill pl-4-5" onkeypress="EnterPress(event)"  name="search" type="search" placeholder="搜索" aria-label="Search" id="search">

					</form>
					<!--<a class=" my-2 my-lg-0 btn btn-sm btn-outline-muted badge-pill mr-2" href=""><i class="fa fa-video-camera"></i> 视频投稿</a>-->
					@if (Session::has('id'))
					<ul class="navbar-nav">
						<li class="nav-item dropdown">

							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img class="rounded-circle" src="/{{Session::get('avatar')}}" alt="" height="30px" onerror="this.src='{{URL::asset('images/thumb_user_error.jpg')}}'">
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="javascript:;" onclick="localhash('/user?id={{Session::get('id')}}')"><i class="fa fa-user-o"></i> 我的主页</a>
								<!--<a class="dropdown-item" href="#"><i class="fa fa-envelope-o"></i> 我的消息</a>-->
								<!--<a class="dropdown-item" href="#"><i class="fa fa-bookmark-o"></i>&nbsp;&nbsp;我的等级</a>-->
								<a class="dropdown-item" href="javascript:;" onclick="localhash('/vip')"><i class="fa fa-diamond"></i> VIP会员</a>
								<!--<div class="dropdown-divider"></div>-->
								<!--<a class="dropdown-item" href="#"><i class="fa fa-cog"></i> 个人设置</a>-->
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="javascript:;" onclick="login_off()"><i class="fa fa-power-off"></i> 退出</a>
							</div>
						</li>
					</ul>
					@else
						<button class="btn btn-sm btn-dark" data-toggle="modal" id="login_btn" data-target="#LoginModel" data-whatever="@mdo">登录</button>
					@endif
				</div>
			</div><!--container-->
		</nav>
		<nav class="bg-red p-1 subnav">
			<div class="container" style="min-width: 980px">
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-10">
						<ul class="nav text-light" id="nav_ul">
							<li><a href="javascript:localhash('/main');">推荐</a></li>
							<!--<li ><a href="">排行榜</a></li>-->
							<li><a href="javascript:localhash('/discover/playlist');">歌单</a></li>
							<li><a href="javascript:localhash('/discover/artist');">歌手</a></li>
							<li><a href="javascript:localhash('/discover/album');">新碟上架</a></li>

							<button class="btn btn-sm btn-raised" data-toggle="modal" data-target="#playlist" data-whatever="@mdo" id="playlist_btn" style="display: none;">歌单</button>
						</ul>
					</div>
				</div>
			</div>
		</nav><!--subnav-->

		<iframe src="main" class="w-100" height="" id="main" name="main" width="100%" scrolling="no" frameborder="0"></iframe>


		<div class="btmbar bg-black fixed-bottom border-top border-black">
			<div id="tips" style="display: none;position: absolute;top: -300px; left: 42%;background: #000; opacity: 0.7;" class="p-3"><span id="tips_span" style="color:white">由于版权限制，只有会员能听</span></div>
			<div class="music-list container rounded-top p-0" id="music_list" style="display: none">
				<div class="btmbar_btn">
					<div class="row">
						<div class="col-sm-6 border-right border-dark pr-0">
							<span class="text-light music_title">播放列表</span>
							<!--<button type="button" class="btn btn-link float-right" id="clear"><i class="fa fa-trash-o"></i> 清除</button>-->
						</div>
						<div class="col-sm-6">
							<button type="button" class="btn btn-link float-right" id="close"><i class="fa fa-close"></i></button>
						</div>
					</div>
				</div>
				<div class="grid-music-container f-usn">
					<div class="m-music-list-wrap">
						<!-- Dropdown menu links -->
					</div>
					<div class="m-music-lyric-wrap">
						<div class="inner">
							<ul class="js-music-lyric-content">
								<li class="eof">暂无歌词...</li>
							</ul>
						</div>
					</div>
				</div><!--grid-music-container-->
			</div>
			<div class="container">
				<div class="grid-music-container f-usn">
					<div class="m-music-play-wrap">
						<div class="m-play-controls">
							<a class="u-play-btn prev" title="上一曲"></a>
							<a class="u-play-btn ctrl-play play" title="暂停" id="pp"></a>
							<a class="u-play-btn next" title="下一曲"></a>
							<a class="u-cover"></a>
						</div>
						<div class="m-now-info">
							<h1 class="u-music-title"><strong>标题</strong><small>歌手</small></h1>
							<div class="m-now-controls">
								<div class="u-control u-process">
									<span class="buffer-process"></span>
									<span class="current-process"></span>
								</div>
								<div class="u-control u-time">00:00/00:00</div>
								<div class="u-control u-volume">
									<div class="volume-process" data-volume="0.50">
										<span class="volume-current"></span>
										<span class="volume-bar"></span>
										<span class="volume-event"></span>
									</div>
									<a class="volume-control"></a>
								</div>
							</div>
						</div>
						<div class="m-play-controls">
							<a class="u-play-btn mode mode-list" title="列表循环"></a>
							<a class="u-play-btn mode mode-random " id="random" title="随机播放"></a>
							<a class="u-play-btn mode mode-single" title="单曲循环"></a>
						</div>
					</div>
					<button type="button" id="display" class="btn btn-link text-light" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-list-ul"></i>
					</button>
				</div><!--grid-music-container-->
			</div>
		</div>
		<button id="new_playlist_btn" data-toggle="modal" data-target="#new_playlist" style="display: none;"></button>

		<!--playlist Modal-->
		<div class="modal fade" id="playlist" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalCenterTitle">我的歌单</h5>
						<button type="button" class="close" id="close_modal" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<a href="javascript:;"  data-toggle="modal" data-target="#new_playlist" style="width: 100%;height:40px;background: gainsboro;display: block;text-align: center;line-height: 40px;text-decoration: none;">&nbsp;<span style="color:gray">新建歌单+</span></a>
						@if($my_playlist)
						@foreach($my_playlist as $my)
							<a href="javascript:collection('{{$my->id}}')" class="mt-2" style="width: 100%;height:40px;background: gainsboro;display: block;text-align: center;line-height: 40px;text-decoration: none;">{{$my->name}}&nbsp;<span style="color:gray">{{$my->song_number}}首</span></a>
						@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>

		<!-- new playlist-->
		<div class="modal fade" id="new_playlist" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" >新建歌单</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<input type="text" class="form-control" id="playlist_name" value="">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" onclick="create_playlist()">确定</button>
					</div>
				</div>
			</div>
		</div>

		<!--LoginModal-->
		<div class="modal fade" id="LoginModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">登录</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form  method="post" onsubmit="return false;">
							<div class="form-group">
								<label for="identifier" class="col-form-label">手机号:</label>
								<input type="text" class="form-control" id="identifier">
								<span class="text-danger"></span>
							</div>
							<div class="form-group">
								<label for="credential" class="col-form-label">密码:</label>
								<input type="password" class="form-control" id="credential">
							</div>
							<div class="form-group">
								<label for="code" class="col-form-label">验证码:</label>
								<img style="float:right;cursor: pointer;" id="verify" src="{{captcha_src()}}" alt="captcha" onclick="this.src='{{captcha_src()}}?'+Math.random()"/>
								<input type="text" class="form-control" id="captcha">
							</div>
							<div class="form-check">
								<!--<input type="checkbox" class="form-check-input" onclick="autoLogin()" id="autologin">-->
								<!--<label class="form-check-label" for="autologin">自动登录</label>-->
								<span class="text-danger pl-4" style="font-size: 14px;" id="login_tips"></span>
								<a href="https://api.weibo.com/oauth2/authorize?client_id=2234448020&response_type=code&redirect_uri=http://www.firekeeper.cn/weibo" tabindex="1" title="微博登录">
									<img src="{{URL::asset('images/weibo.png')}}" width="30" height="30" alt="">
									新浪微博
								</a>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-danger" style="width:100%" onclick="login()">登录</button>
								<button type="button" class="btn" style="width:100%" data-toggle="modal" data-target="#RegModel" >没有账号？注册一个</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--RegModal-->
		<div class="modal fade" id="RegModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="">注册</h5>
						<button type="button" class="close" data-dismiss="modal" id="close_reg" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="" onsubmit="return false;">
							<div class="form-group">
								<label for="phone_reg" class="col-form-label">手机号:</label>
								<input type="text" class="form-control"  required id="phone_reg">
								<span class="text-danger"></span>
							</div>
							<div class="form-group">
								<label for="password_reg" class="col-form-label">密码:</label>
								<input type="password" class="form-control" required id="password_reg" onblur="checkPassword()">
							</div>
							<div class="form-group">
								<label for="password_check" class="col-form-label">确认密码:</label>
								<input type="password" class="form-control" required id="password_check" onblur="checkPassword()">
								<span class="text-danger" id="check_tips"></span>
							</div>
							<div class="form-group pt-5">
								<button type="submit" onclick="register()" id="reg_btn" class="btn btn-danger" style="width:100%">注册</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!--  JavaScript  -->
		<!--<script src="music/js/musicList.js"></script>-->
		<script src="{{ URL::asset('index/music/js/smusic.js') }}"></script>
		<script>

            var is_vip = '{{Session::get('is_vip')}}'|| 0;
			//搜索
            function EnterPress(e){ //传入 event
                var e = e || window.event;
                if(e.keyCode == 13){
                    var keyword = $('#search').val();
                    if(keyword){
                        localhash("/search?keyword="+keyword);
					}
                }
            }

            function setHeight(height){
                height += 50;
                $('#main').height(height);
            }

			$(function(){

			    var src = location.hash.replace('#/', '');
			    if(src){
                    localhash(src);
				}

			});

			$('#main').on('load',function(){
			   var local = this.contentWindow.location.href;
			   var sethash = local.replace('{{url('')}}/','');
               location.hash = '/'+sethash;
			});

			function localhash(src){
				$('#main').attr('src',src);
			};

			function this_href(url){
			    // alert(url);
			    window.location.href=url;
			}
            function setTips(msg){
                $('#tips').fadeIn();
                $('#tips_span').html(msg);
                setInterval (function(){
                    $('#tips').fadeOut();
                }, 1500);
            }
            //添加到列表 立刻播放
            function addSong(json){

                var boolean = true;
                var tips;

                if(json.vip == 1 && is_vip == 0){
                    boolean = false;
                    tips = '由于版权限制，只有会员能听';
                    setTips(tips);
				}else{
                    for(var i=0;i<musicList.length;i++){
                        if(json.name == musicList[i]['title']){
                            boolean = false;
                            tips = '歌曲已存在';
                            setTips(tips);
                        }
                    }
                    if(boolean){
                        msc.config.musicList.push({
                            title: json.name,
                            singer: json.artist_name,
                            cover: json.cover,
                            src: json.file_src,
                            lyric  : "",
                            index: json.id
                        });
                        // msc.config.musicList = musicList;
                        msc.musicLength = msc.musicLength+=1;
                        $('#pp').on('click',function(){
                            if($('#pp').hasClass('play')){
                                msc.pause();
                                // this.addClass('pause');
                                // this.removeClass('play');
                            }else{
                                msc.play();
                                // this.addClass('play');
                                // this.removeClass('pause');
                            }
                        });
                        // msc.createListDom();
                        $('.m-music-list-wrap').find('ul').append("<li class=\"f-toe\"><strong>"+json.name+"</strong> -- <small>"+json.artist_name+"</small></li>");
                        // console.log(msc.config.musicList);
                        msc.resetPlayer(json.id);

                        msc.action();
                        $.ajax({
                            url:'/setPlay',
                            type:'post',
                            data:{'type':1,"id":json.id},
                            success:function (res) {

                            }
                        })
                    }
				}


            }
			//添加到列表 不播放
            function addSongPlaylist(json){

                var boolean = true;
                var tips;

                if(json.vip == 1 && is_vip == 0){
                    boolean = false;
                    tips = '由于版权限制，只有会员能听';
                    setTips(tips);
                }else{
                    for(var i=0;i<musicList.length;i++){
                        if(json.name == musicList[i]['title']){
                            boolean = false;
                            tips = '歌曲已存在';
                            setTips(tips);
                        }
                    }
                    if(boolean){
                        msc.config.musicList.push({
                            title: json.name,
                            singer: json.artist_name,
                            cover: json.cover,
                            src: json.file_src,
                            lyric  : "",
                            index: json.id
                        });
                        // msc.config.musicList = musicList;
                        msc.musicLength = msc.musicLength+=1;
                        $('#pp').on('click',function(){
                            if($('#pp').hasClass('play')){
                                msc.pause();
                                // this.addClass('pause');
                                // this.removeClass('play');
                            }else{
                                msc.play();
                                // this.addClass('play');
                                // this.removeClass('pause');
                            }
                        });
                        msc.createListDom();
                        // $('.m-music-list-wrap').find('ul').append("<li class=\"f-toe\"><strong>"+json.name+"</strong> -- <small>"+json.artist_name+"</small></li>");
                        msc.action();

                        $.ajax({
                            url:'/setPlay',
                            type:'post',
                            data:{'type':1,"id":json.id},
                            success:function (res) {

                            }
                        })

                    }
				}


            }

            function addSongsPlaylist(json,id,type) {

                // alert(json.length);
                var boolean = true;
                var tips;


                if (boolean) {
                    for (var i = 0; i < json.length; i++) {
                        if(json[i].vip == 1 && is_vip == 0){
                            continue;
						}else{

                            msc.config.musicList.push({
                                title: json[i].title,
                                singer: json[i].singer,
                                cover: json[i].cover,
                                src: json[i].src,
                                lyric: json[i].lyric,
                                index: json.index
                            });
                            // msc.config.musicList = musicList;
                            msc.musicLength = msc.musicLength += 1;
						}
                    }

                    $('#pp').on('click', function () {
                        if ($('#pp').hasClass('play')) {
                            msc.pause();
                            // this.addClass('pause');
                            // this.removeClass('play');
                        } else {
                            msc.play();
                            // this.addClass('play');
                            // this.removeClass('pause');
                        }
                    });
                    msc.createListDom();
                    msc.resetPlayer(1);
                    // $('.m-music-list-wrap').find('ul').append("<li class=\"f-toe\"><strong>"+json.name+"</strong> -- <small>"+json.artist_name+"</small></li>");
                    msc.action();
                    // }



                    $.ajax({
                        url:'/setPlay',
                        type:'post',
                        data:{'type':type,"id":id},
                        success:function (res) {

                        }
                    })
                }
            }

			var musicList=[
			    {
				title: " ",
				singer: " ",
				cover: " ",
				src: "",
				lyric  : "",
				index: 1
				}
			];


            // 实例化播放器
           var msc = new SMusic({
                musicList : musicList,
                autoPlay  : true,  //是否自动播放
                defaultMode :1 ,   //默认播放模式，随机
                callback   : function (obj) {  //返回当前播放歌曲信息

                },
            });
			var music_list=$("#music_list");
			var display_music=false;
			$("#close").click(function () {
                music_list.css("display","none");
                display_music=false;
            })
			$("#display").click(function () {
				if (display_music){
                    music_list.css("display","none");
                    display_music=false;
				}else {
                    music_list.css("display","block");
                    display_music=true;
				}
            })
			$("#clear").click(function () {
            	// msc.config.musicList=[
                //     {
                //         title: " ",
                //         singer: " ",
                //         cover: " ",
                //         src: " ",
                //         lyric  : "",
                //         index: 1
                //     }
                // ];
            	// msc.musicLength =1;
            	// msc.createListDom();
            	// msc.action();
            })


		</script>
		{{--<script type="text/javascript" src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>--}}
		<script>
			var identity_type = 'phone';
			var autologin = false;
			var user_id = "{{Session::get('id')}}";
			function autoLogin(){
			    autologin = !autologin;
			    alert(autologin);
			}

            // 登录
            function login(){
                var identifier = $('#identifier').val();
                var credential = $('#credential').val();
                var captcha = $('#captcha').val();
				if(!identifier){
                    $('#login_tips').html('账户 不能为空。');
				    return ;
				}
				if(!credential){
                    $('#login_tips').html('密码 不能为空。');
                    return ;
				}
                if(!captcha){
                    $('#login_tips').html('验证码 不能为空。');
                    return ;
                }

                $.ajax({
                    type:"post",
                    url : "/login",
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    data: {"identifier":identifier,"credential":credential,'captcha':captcha,'identity_type':identity_type},
                    success:function(result){
						// console.log(result);
                        if (result.StateCode == 200 || result.StateCode == 201){
							$('#login_tips').html(result.messages);
                            $('#verify').click();
                        }else if(result.StateCode == 100){
                            window.location.reload();
                        }


                    },
                    error:function(){
                        setTips('登录失败，请刷新页面后重试');
                    }
                });

            }
            // 注销
			function login_off(){
                window.location.href="/login_off";
			}

            // 注册
            function register(){
                var identifier = $('#phone_reg').val();
                var credential = $('#password_reg').val();
                var password_confirmation = $('#password_check').val();
                // 判断两次密码是否一致
                if(checkPassword()){
                    $.ajax({
                        type:"post",
                        url : "/register",
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        data: {"identifier":identifier,"credential":credential,'identity_type':identity_type,'password_confirmation':password_confirmation},
                        success:function(result){
							console.log(result);
                            if (result.StateCode == 200 || result.StateCode == 201){
                                $('#check_tips').html(result.messages);
                            }
                            if(result.StateCode == 100){
                                $('#check_tips').html("注册成功啦");
                                $('#close_reg').click();
                            }
                        },
                        error:function(){
                            setTips('注册失败，请刷新页面后重试');
                        }
                    });
                }
            }

            // 确认密码
            function checkPassword(){
                var password = $('#password_reg').val();
                var password_check = $('#password_check').val();
                var boolean = true;
                if(password !== password_check){
                    $('#check_tips').removeClass('text-success');
                    $('#check_tips').addClass('text-danger');
                    $('#check_tips').html('密码不一致');
                    boolean = false;
                }else{
                    $('#check_tips').removeClass('text-danger');
                    $('#check_tips').addClass('text-success');
                    $('#check_tips').html('密码正确');
                    boolean = true;
                }
                return boolean;
            }


            var topic_id,topic_type;

            //打开歌单列表
			function openPlayList(id,type){
                topic_id = id;
                topic_type = type;
                if(user_id){
                    $('#playlist_btn').click();
				}else{
                    setTips('请先登录');
                    $('#login_btn').click();
				}
			}
			function collection(playlist_id){
			    if(!user_id){
                    setTips('请先登录');
				}else{
                    $.ajax({
                        url:'/collection',
                        data:{'topic_id':topic_id,'topic_type':topic_type,'playlist_id':playlist_id,'user_id':user_id},
                        type:'post',
                        success:function (result) {
                            console.log(result);
                            setTips('歌曲已存在');
                            if(result == 100){
                                setTips("收藏成功");
                                setInterval(function() {
                                    window.location.reload();
                                }, 1000);
                            }else if(result == 200){
                                setTips("收藏失败");
                            }else if(result == 201){
                                setTips('歌曲已存在');
                            }else{
                                setTips('歌曲已存在');
							}
                        },
                        error:function () {
                            setTips("请检查网络,稍后再试");
                        }
                    });
				}
			}

			function create_playlist(){
				var name = $('#playlist_name').val();
				if(!name){
				    return;
				}
                $.ajax({
                    url:'/create_playlist',
                    data:{'name':name,'user_id':user_id},
                    type:'post',
                    success:function (result) {
                        // alert(JSON.stringify(result));
                        if(result == 100){
                            window.location.reload();
                        }else{
                            setTips("新建失败");
                        }
                    },
                    error:function () {
                        setTips("新建失败，请稍后再试");
                    }
                });
			}

			function open_new_playlist(){
			    $('#new_playlist_btn').click();
			}

			function login_btn(){
			    $('#login_btn').click();
			}
			function my_playlist(){
			    if(user_id){
                    localhash('/my_playlist');
				}else{
			        setTips('请先登录');
				}
			}


		</script>
	</body>
</html>
