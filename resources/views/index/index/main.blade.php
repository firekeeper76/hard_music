<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		@include('index.resources')
		<title>首页 - 网难云音乐</title>
		<style>

			.contact, .contact .btn {
				background: url("{{ URL::asset('images/contact.png') }}") no-repeat 0 0;
			}
			.n-bilst {
				background: url('{{ URL::asset('images/index_bill.png') }}') no-repeat;
			}

			.carousel-fade .carousel-inner .carousel-item {
				-webkit-transform: translateX(0);
				transform: translateX(0);
				transition-property: opacity;
			}
			.carousel-fade .carousel-inner .carousel-item,
			.carousel-fade .carousel-inner .active.carousel-item-left,
			.carousel-fade .carousel-inner .active.carousel-item-right {
				opacity: 0;
			}
			.carousel-fade .carousel-inner .active,
			.carousel-fade .carousel-inner .carousel-item-next.carousel-item-left,
			.carousel-fade .carousel-inner .carousel-item-prev.carousel-item-right {
				opacity: 1;
			}

		</style>
	</head>
	<body>
		<div id="CarouselBg">
			<div class="content bg_none">
                <div class="row">
                    <div class="col-md-9 pr-0">
						<div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
							<ol class="carousel-indicators">
								@foreach( $banners as $key=>$banner)
									@if($key == 1)
										<li data-target="#carouselExampleIndicators" data-slide-to="{$key-1}" class="active"></li>
									@else
										<li data-target="#carouselExampleIndicators" data-slide-to="{$key-1}"></li>
									@endif
								@endforeach

							</ol>
							<div class="carousel-inner">
								@foreach( $banners as $key=>$banner)
									@if($key == 1)
										<div class="carousel-item active">
											<a href="{{$banner->src_to}}">
												<img class="d-block w-100" width="980" height="341" src="{{$banner->src}}"  bg-color="{{$banner->bg_color}}">
											</a>
										</div>
									@else
										<div class="carousel-item">
											<a href="{{$banner->src_to}}">
												<img class="d-block w-100" width="980" height="341" src="{{$banner->src}}"  bg-color="{{$banner->bg_color}}">
											</a>
										</div>
									@endif
								@endforeach

								<!--<div class="carousel-item active">-->
									<!--<img class="d-block w-100" src="__PUBLIC__/index/carousel/01.jpg" alt="First slide" bg-color="#000000">-->
								<!--</div>-->
								<!--<div class="carousel-item">-->
									<!--<img class="d-block w-100" src="__PUBLIC__/index/carousel/02.jpg" alt="Second slide" bg-color="#9c0411">-->
								<!--</div>-->
								<!--<div class="carousel-item">-->
									<!--<img class="d-block w-100" src="__PUBLIC__/index/carousel/03.jpg" alt="Third slide" bg-color="#f7a1be">-->
								<!--</div>-->
							</div>
							<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
                    </div>
                    <div class="col-md-3 pl-0">
						<div class="contact">

						</div>
                    </div>
                </div>

			</div>
		</div>

		<div class="content border c-border">
			<div class="row">
				<div class="col-md-9 pr-0">
					<div class="p-4">
						<div class="n-new">
							<div class="v-hd2">
								<i class="fa fa-circle-o"></i>
								<a href="">热门推荐</a>
								<div class="tab">
									<a onclick="p_tag('华语')" style="cursor: pointer"  class="s-fc3">华语</a>
									<span class="line">|</span>
									<a onclick="p_tag('欧美')" style="cursor: pointer"  class="s-fc3">欧美</a>
									<span class="line">|</span>
									<a onclick="p_tag('日语')"  style="cursor: pointer"  class="s-fc3">日语</a>
									<span class="line">|</span>
									<a onclick="p_tag('流行')" style="cursor: pointer"   class="s-fc3">流行</a>
									<span class="line">|</span>
									<a onclick="p_tag('轻音乐')" style="cursor: pointer"   class="s-fc3">轻音乐</a>
								</div>
								<span class="more"><a href="/discover/playlist" class="s-fc3">更多</a><i class="fa fa-arrow-right"></i></span>
							</div>
							<ul class="m-cvrlst f-cb">

								@foreach($playlists as $playlist)
								<li>
									<div class="u-cover">
										<img src="@if($playlist->cover){{URL::asset($playlist->cover)}}@else{{URL::asset($playlist->auto_cover)}}@endif" onerror="this.src='{{URL::asset('images/thumb_album_error.jpg')}}'">
										<a title="{{$playlist->name}}" href="/playlist/?id={{$playlist->id}}"  class="msk"></a>
										<div class="bottom">
											<a class="fa fa-play-circle-o f-fr" title="播放" href="/playlist/?id={{$playlist->id}}" data-res-type="13" data-res-id="2399820055" data-res-action="play"></a>
											{{--<div style="float: right;">--}}
											<span class="fa fa-headphones"></span>
											<span class="nb">{{$playlist->play}}</span>
											{{--</div>--}}
										</div>
									</div>
									<p class="dec">
										<a title="{{$playlist->name}}" class="tit s-fc0" href="/playlist/?id={{$playlist->id}}" data-res-id="2399820055" data-res-type="13" data-res-action="log" data-res-data="recommendclick|0|featured|user-playlist">
											{{$playlist->name}}
										</a>
									</p>
								</li>

								@endforeach
	
							</ul>
							<div class="clearfix"></div>
	
						</div>
						
						<div class="n-new">
							<div class="v-hd2">
								<i class="fa fa-circle-o"></i>
								<a href="/discover/album" disabled="disabled">新碟上架</a>
								<span class="more"><a href="/discover/album" class="s-fc3">更多</a><i class="fa fa-arrow-right"></i></span>
							</div>
							
							<div id="newSongList" class="carousel slide" data-ride="false" data-pause="true">
							  <div class="carousel-inner">
							    <div class="carousel-item p-4 active">
							    	<ul class="f-cb roller-flag nav" style="left: 0px; transition: none;" id="auto-id-4acQP1GqMHembq82">

										@foreach($albums as $album)
										<li>
											<div class="u-cover u-cover-alb1">
												<img class="j-img" data-src="" src="{{$album->cover}}" onerror="this.src='{{URL::asset('images/thumb_album_error.jpg')}}'">
												<a title="{{$album->name}}" href="/album?id={{$album->id}}" class="msk"></a>
												<a href="/album?id={{$album->id}}" class="fa fa-play-circle-o f-alpha" title="播放" data-res-type="19" data-res-id="72984236" data-res-action="play"></a>
											</div>
											<p class="f-thide"><a title="{{$album->name}}" href="/album?id={{$album->id}}" class="s-fc0 tit">{{$album->name}}</a></p>
											<p class="tit f-thide" title="{{$album->artist->name}}">
												<a class="s-fc3" href="/artist?id={{$album->artist_id}}">{{$album->artist->name}}</a>
											</p>
										</li>
										@endforeach

									</ul>
									<div class="clearfix"></div>
							    </div>

							  </div>
							  <!--<a class="carousel-control-prev nsl_prev" href="#newSongList" role="button" data-slide="prev">-->
							    <!--<span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
							    <!--<span class="sr-only">Previous</span>-->
							  <!--</a>-->
							  <!--<a class="carousel-control-next nsl_next" href="#newSongList" role="button" data-slide="next">-->
							    <!--<span class="carousel-control-next-icon" aria-hidden="true"></span>-->
							    <!--<span class="sr-only">Next</span>-->
							  <!--</a>-->
							</div>
							
							
							
							<div class="clearfix"></div>
						</div>
						<div class="n-new">
							<div class="v-hd2">
								<i class="fa fa-circle-o"></i>
								<a href="javascript:;">榜单</a>
								<!--<span class="more"><a href="" class="s-fc3">更多</a><i class="fa fa-arrow-right"></i></span>-->
							</div>
							<div class="n-bilst" id="top-flag">
								<dl class="blk ">
									<dt class="top">
										<div class="cver u-cover u-cover-4">
											<img class="j-img" data-src="http://p3.music.126.net/N2HO5xfYEqyQ8q6oxCw8IQ==/18713687906568048.jpg?param=100y100" src="{{URL::asset('images/new_song_b.jpg')}}">
											<a href="javascript:;" class="msk" title="云音乐新歌榜"></a>
										</div>
										<div class="tit">
											<a href="javascript:;" title="云音乐新歌榜"><h3 class="f-fs1 f-thide">云音乐新歌榜</h3></a>
											<div class="btn">
												<!--<a href="javascript:;" class="s-bg s-bg-9 f-tdn" hidefocus="true" title="播放" data-res-type="13" data-res-id="19723756" data-res-action="play" data-res-from="31" data-res-data="19723756">播放</a>-->
												<!--<a href="javascript:;" hidefocus="true" class="s-bg s-bg-10 f-tdn subscribe-flag " data-plid="19723756" title="收藏">收藏</a>-->
											</div>
										</div>
									</dt>
									<dd>
										<ol>
											@foreach($billboard['song'] as $key =>$song)
											@if($key<3)
											<li onmouseover="this.className='z-hvr'" onmouseout="this.className=''">
												<span class="no no-top">{{$key+1}}</span>
												<a href="/song?id={{$song->id}}" class="nm s-fc0 f-thide" style="width: 90px;display: inline-block;" title="{{$song->name}}">{{$song->name}}</a>
												<div class="oper">
													<a href="javascript:;" onclick="addPlaylist( { 'id':'{{$song->id}}','name':'{{$song->name}}','artist_name':'{{$song->artist->name}}','file_src':'{{URL::asset($song->file_src)}}','cover':'{{URL::asset($song->cover)}}','vip':'{{$song->vip}}' } )" class="fa fa-play-circle-o" title="播放" hidefocus="true" data-res-type="18" data-res-id="1310728498" data-res-action="play" data-res-from="31" data-res-data="19723756"></a>
													<a href="javascript:;" onclick="addToPlaylist({  'id':'{{$song->id}}','name':'{{$song->name}}','artist_name':'{{$song->artist->name}}','file_src':'{{URL::asset($song->file_src)}}','cover':'{{URL::asset($song->cover)}}','vip':'{{$song->vip}}' })" class="fa fa-plus" title="添加到播放列表" hidefocus="true" data-res-type="18" data-res-id="1310728498" data-res-action="addto" data-res-from="31" data-res-data="19723756"></a>
													<a href="javascript:;" onclick="addToMyPlaylist('{{$song->id}}',1);" class="fa fa-star-o" title="收藏" hidefocus="true" data-res-level="0" data-res-fee="8" data-res-type="18" data-res-id="1310728498" data-res-action="subscribe"></a>
												</div>
											</li>
											@else
											<li onmouseover="this.className='z-hvr'" onmouseout="this.className=''">
												<span class="no">{{$key+1}}</span>
												<a href="/song?id={{$song->id}}" class="nm s-fc0 f-thide" style="width: 90px;display: inline-block;" title="{{$song->name}}">{{$song->name}}</a>
												<div class="oper">
													<a href="javascript:;" onclick="addPlaylist( { 'id':'{{$song->id}}','name':'{{$song->name}}','artist_name':'{{$song->artist->name}}','file_src':'{{URL::asset($song->file_src)}}','cover':'{{URL::asset($song->cover)}}','vip':'{{$song->vip}}' } )" class="fa fa-play-circle-o" title="播放" hidefocus="true" data-res-type="18" data-res-id="1310728498" data-res-action="play" data-res-from="31" data-res-data="19723756"></a>
													<a href="javascript:;" onclick="addToPlaylist({  'id':'{{$song->id}}','name':'{{$song->name}}','artist_name':'{{$song->artist->name}}','file_src':'{{URL::asset($song->file_src)}}','cover':'{{URL::asset($song->cover)}}','vip':'{{$song->vip}}' })" class="fa fa-plus" title="添加到播放列表" hidefocus="true" data-res-type="18" data-res-id="1310728498" data-res-action="addto" data-res-from="31" data-res-data="19723756"></a>
													<a href="javascript:;" onclick="addToMyPlaylist('{{$song->id}}',1);" class="fa fa-star-o" title="收藏" hidefocus="true" data-res-level="0" data-res-fee="8" data-res-type="18" data-res-id="1310728498" data-res-action="subscribe"></a>
												</div>
											</li>
											@endif
											@endforeach
										</ol>
										<!--<div class="more"><a href="/discover/toplist?id=19723756" class="s-fc0">查看全部&gt;</a></div>-->
									</dd>
								</dl>
								<dl class="blk ">
									<dt class="top">
										<div class="cver u-cover u-cover-4">
											<img class="j-img" data-src="" src="{{URL::asset('images/hot_albun_b.jpg')}}">
											<a href="javascript:;" class="msk" title="云音乐热碟榜"></a>
										</div>
										<div class="tit">
											<a href="javascript:;" title="云音乐热碟榜"><h3 class="f-fs1 f-thide">云音乐热碟榜</h3></a>
											<div class="btn">
												<!--<a href="javascript:;" class="s-bg s-bg-9 f-tdn" hidefocus="true" title="播放" data-res-type="13" data-res-id="3779629" data-res-action="play" data-res-from="31" data-res-data="3779629">播放</a>-->
												<!--<a href="javascript:;" hidefocus="true" class="s-bg s-bg-10 f-tdn subscribe-flag " data-plid="3779629" title="收藏">收藏</a>-->
											</div>
										</div>
									</dt>
									<dd>
										<ol>
											@foreach($billboard['album'] as $key =>$album)
												@if($key<3)
											<li onmouseover="this.className='z-hvr'" onmouseout="this.className=''">
												<span class="no no-top">{{$key+1}}</span>
												<a href="/album?id={{$album->id}}" class="nm s-fc0 f-thide" title="{{$album->name}}">{{$album->name}}</a>
												<div class="oper">
												</div>
											</li>
												@else
											<li onmouseover="this.className='z-hvr'" onmouseout="this.className=''">
												<span class="no">{{$key+1}}</span>
												<a href="/album?id={{$album->id}}" class="nm s-fc0 f-thide"   title="{{$album->name}}">{{$album->name}}</a>
												<div class="oper">
												</div>
											</li>
												@endif
											@endforeach
										</ol>
										<!--<div class="more"><a href="/discover/toplist?id=3779629" class="s-fc0">查看全部&gt;</a></div>-->
									</dd>
								</dl>
								<dl class="blk blk-1">
									<dt class="top">
										<div class="cver u-cover u-cover-4">
											<img class="j-img" data-src="" src="{{URL::asset('images/hot_playlist_b.jpg')}}">
											<a href="javascript:;" class="msk" title="云音乐歌单榜"></a>
										</div>
										<div class="tit">
											<a href="javascript:;" title="云音乐歌单榜"><h3 class="f-fs1 f-thide">云音乐歌单榜</h3></a>
											<div class="btn">
											</div>
										</div>
									</dt>
									<dd>
										<ol>
											@foreach($billboard['playlist'] as $key =>$playlist)
												@if($key<3)
											<li onmouseover="this.className='z-hvr'" onmouseout="this.className=''">
												<span class="no no-top">{{$key+1}}</span>
												<a href="/playlist?id={{$playlist->id}}" class="nm s-fc0 f-thide"  style="display: block;width: 160px;height: 24px;padding-top:8px;"  title="{{$playlist->name}}">{{$playlist->name}}</a>
												<div class="oper">
												</div>
											</li>
												@else
											<li onmouseover="this.className='z-hvr'" onmouseout="this.className=''">
												<span class="no">{{$key+1}}</span>
												<a href="/playlist?id={{$playlist->id}}" class="nm s-fc0 f-thide"  style="display: block;width: 160px;height: 24px;padding-top:8px;"  title="{{$playlist->name}}">{{$playlist->name}}</a>
												<div class="oper">
												</div>
											</li>
												@endif
											@endforeach
										</ol>
										<!--<div class="more"><a href="/discover/toplist?id=2884035" class="s-fc0">查看全部&gt;</a></div>-->
									</dd>
								</dl>
							</div>

						</div>
						
					</div>
				</div>
				<div class="col-sm-3 border-left c-border pl-0">
					<div class="n-myinfo n-myinfo-1 s-bg s-bg-1 p-4">
						@if(Session::has('id'))
							<a href="/me?id={{Session::get('id')}}"><img src="{{ URL::asset(Session::get('avatar')) }}" style="float:left;" width="90" height="90" alt="" onerror="this.src='{{URL::asset('images/thumb_user_error.jpg')}}'"></a>
							<h6>
								<a href="/user?id={{Session::get('id')}}" style="font-size:12px;">{{Session::get('nickname')}}</a>
								@if(Session::get('is_vip')==1)
									<a href="/vip"><img width="20" height="20" src="{{ URL::asset('images/vip_logo.png') }}"></img>vip</a>
								@else
									<a href="/vip"><img width="20" height="20" src="{{ URL::asset('images/vip_logo_gray.png') }}"></img></a>
								@endif
							</h6>

							<a href="/user?id={{Session::get('id')}}"><button class="btn btn-sm btn-danger">我的主页</button></a>
						@else
						<p class="note s-fc3">登录云音乐，可以享受无限收藏的乐趣</p>
						<a id="index-enter-default" href="javascript:;" onclick="login_btn()" class="btn btn-sm btn-danger" tabindex="1">用户登录</a>
						<a href="javascript:;" style="color:dodgerblue;" onclick="weibo_login('https://api.weibo.com/oauth2/authorize?client_id=2234448020&response_type=code&redirect_uri=http://www.firekeeper.cn/weibo')" tabindex="1" title="微博登录">

							<img src="{{URL::asset('images/weibo.png')}}" width="30" height="30" alt="">
							新浪微博
						</a>
						@endif
					</div>
					<div class="p-5">
						<span style="font-size:12px;">扫描二维码，用手机访问</span>
						<img src="http://qr.liantu.com/api.php?text={{URL::asset('')}}" width="130" height="130" alt="">
					</div>
				</div>
			</div>
		</div>

		<script>
            var CarouselBg = $("#CarouselBg");
            var img = $('#myCarousel').find("div.carousel-inner>div.active>a>img")[0];
            CarouselBg.css("background-color",$(img).attr("bg-color"));
            $('#myCarousel').on('slide.bs.carousel', function () {
                setTimeout(function () {
                    var img = $('#myCarousel').find("div.carousel-inner>div.active>a>img")[0];
                    CarouselBg.css("background-color",$(img).attr("bg-color"));
				}, 650);
            });

			function login_btn (){
			    window.parent.login_btn();
			}
			function p_tag(tag){
			    window.location.href="/discover/playlist?tag="+tag;
			}
			function weibo_login(url){
			    window.parent.this_href(url);
			}
			// $(function () {
            //     var domain = document.domain;
            //     console.log(domain);
			// 	if(self == top){
            //         window.location.href="http://"+domain;
			// 	}
			//
            // })
		</script>

	</body>
</html>
