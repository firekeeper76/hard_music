<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});




Route::get('/','Index\IndexController@index');
Route::get('/main','Index\IndexController@main');
Route::post('/login','Index\LoginController@login');
Route::post('/register','Index\LoginController@register');
Route::get('/login_off','Index\LoginController@login_off');

Route::get('/weibo','Index\ApiController@weibo'); //微博接口



Route::group(['prefix'=>'discover'],function(){ //主页一级页面
    Route::get('test1','TestController@test1');
    Route::get('artist','Index\IndexController@artist');
    Route::get('album','Index\IndexController@album');
    Route::get('playlist','Index\IndexController@playlist');
});

Route::get('/search','Index\IndexController@search');//搜索

Route::get('/vip','Index\VipController@vip');//会员充值页面
Route::post('/ddpay','Index\VipController@ddpay');//会员充值完成回调

Route::get('/user','Index\UserController@user');//用户主页
Route::any('/user/edit','Index\UserController@user_edit');//修改用户资料
Route::post('/update_user_avatar','Index\UserController@update_user_avatar');//修改用户头像
Route::post('/upload_base64_image','CommonController@upload_base64_image');//上传base64图片
Route::post('/setPlay','Index\CommonController@setPlay');//播放次数

Route::get('/my_playlist','Index\PlaylistController@my_playlist');//我的歌单
Route::get('/playlist','Index\PlaylistController@playlist');//歌单详情页
Route::get('/album','Index\AlbumController@album');//专辑详情页
Route::get('/song','Index\SongController@song');//歌曲详情页
Route::get('/artist','Index\ArtistController@artist');//歌手详情页
Route::get('/artist/intro','Index\ArtistController@intro');//歌手介绍详情页
Route::get('/artist/album','Index\ArtistController@album');//歌手专辑详情页


Route::post('/collection_playlist','Index\CollectionController@collection_playlist');//收藏歌单
Route::post('/create_playlist','Index\PlaylistController@create_playlist');//新建歌单
Route::post('/del_playlist','Index\PlaylistController@del_playlist');//删除歌单
Route::post('/del_playlist_song','Index\PlaylistController@del_playlist_song');//删除歌单
Route::post('/update_playlist','Index\PlaylistController@update_playlist');//更新歌单



Route::post('/comment','Index\CommentController@comment');//评论
Route::post('/getComment','Index\CommentController@getComment');//获取评论
Route::post('/like','Index\LikeController@like');//点赞


Route::post('/collection','Index\CollectionController@collection');//收藏
Route::post('/del_collection','Index\CollectionController@del_collection');//取消收藏

Route::post('/getPlayListSong','Index\SongController@getPlayListSong');//获取歌单歌曲
Route::post('/getAlbumSong','Index\SongController@getAlbumSong');//获取专辑歌曲



//管理员后台



//Route::get('/main','IndexController@show');




Route::get('/admin','Admin\LoginController@login'); //后台登录
    Route::group(['prefix'=>'admin'],function(){

        Route::any('/login','Admin\LoginController@login'); //后台登录
        Route::any('/login_off','Admin\LoginController@login_off'); //后台注销登录
        //使用中间件拦截未登陆
        Route::group(['middleware' => 'Admin'],function(){
            Route::get('/index','Admin\IndexController@index'); //后台主页
            Route::get('/welcome','Admin\IndexController@welcome'); //后台主页

            Route::get('/admin','Admin\AdminController@admin'); //管理员列表
            Route::group(['prefix'=>'admin'],function(){
                Route::get('/deleted','Admin\AdminController@deleted'); //管理员被删除列表
                Route::post('/restore','Admin\AdminController@restore'); //管理员恢复删除
                Route::any('/add','Admin\AdminController@add'); //添加管理员
                Route::get('/edit','Admin\AdminController@update'); //添加管理员
                Route::post('/update','Admin\AdminController@update'); //更新管理员
                Route::post('/del','Admin\AdminController@del'); //软删除管理员
                Route::post('/force/delete','Admin\AdminController@forceDelete'); //物理删除管理员
            });

            Route::get('/category','Admin\CategoryController@category'); //分类列表
            Route::group(['prefix'=>'category'],function(){
                Route::get('/getdata','Admin\CategoryController@getData'); // 获取分类
                Route::any('/add','Admin\CategoryController@add'); // 添加分类
                Route::any('/del','Admin\CategoryController@del'); // 删除分类
                Route::any('/update','Admin\CategoryController@update'); // 修改分类
            });

            Route::get('/tag','Admin\TagController@tag'); //标签列表
            Route::group(['prefix'=>'tag'],function(){
                Route::post('/add','Admin\TagController@add'); //标签添加
                Route::post('/update','Admin\TagController@update'); //标签修改
                Route::post('/del','Admin\TagController@del'); //标签删除
            });

            Route::get('/banner','Admin\BannerController@Banner'); //Banner列表
            Route::group(['prefix'=>'banner'],function(){
                Route::any('/add','Admin\BannerController@add'); //Banner添加
                Route::any('/update','Admin\BannerController@update'); //Banner修改
                Route::post('/del','Admin\BannerController@del'); //Banner软删除
                Route::get('/deleted','Admin\BannerController@deleted'); //Banner回收站
                Route::post('/force/delete','Admin\BannerController@forceDelete'); //物理删除Banner
                Route::post('/restore','Admin\BannerController@restore'); //Banner恢复删除
            });

            Route::get('/artist','Admin\ArtistController@artist'); //歌手列表
            Route::group(['prefix'=>'artist'],function(){
                Route::post('/get','Admin\ArtistController@getArtist'); //歌手列表
                Route::any('/add','Admin\ArtistController@add'); //添加歌手
                Route::any('/cover','Admin\ArtistController@cover'); //修改歌手封面页
                Route::any('/update','Admin\ArtistController@update'); //修改歌手信息
                Route::post('/delcover','Admin\ArtistController@delCover'); //删除图片
                Route::any('/deleted','Admin\ArtistController@deleted'); //软删除歌手列表
                Route::any('/del','Admin\ArtistController@del'); //软删除歌手
                Route::post('/restore','Admin\ArtistController@restore'); //恢复软删除歌手
                Route::post('/force/del','Admin\ArtistController@forceDelete'); //彻底删除歌手
                Route::get('/detail','Admin\ArtistController@detail'); //歌手详情信息

            });
            Route::get('/album','Admin\AlbumController@album'); //专辑详情
            Route::group(['prefix'=>'album'],function(){
                Route::any('/add','Admin\AlbumController@add'); //添加专辑
                Route::get('/detail','Admin\AlbumController@detail'); //专辑详情
                Route::any('/song','Admin\AlbumController@song'); //获取专辑歌曲列表
                Route::any('/update','Admin\AlbumController@update'); //修改专辑页
                Route::post('/cover','Admin\AlbumController@cover'); //修改封面
                Route::post('/del','Admin\AlbumController@del'); //软删除专辑和专辑歌曲
            });

            Route::get('/song','Admin\SongController@song'); //歌曲
            Route::group(['prefix'=>'song'],function(){
                Route::any('/upload','Admin\SongController@upload'); //上传歌曲
                Route::any('/update','Admin\SongController@update'); //修改歌曲
                Route::get('/get','Admin\SongController@getSong'); //修改歌曲
                Route::post('/del','Admin\SongController@del'); //软删除歌曲
            });

            Route::get('/comment','Admin\CommentController@comment'); //评论
            Route::group(['prefix'=>'comment'],function(){
                Route::post('/del','Admin\CommentController@del'); //软删除评论
                Route::any('/deleted','Admin\CommentController@deleted'); //软删除评论
            });
            Route::get('/order','Admin\OrderController@order'); //评论
            Route::group(['prefix'=>'order'],function(){
            });
        });
    });



Route::any('/test1','TestController@test1');

//Route::any('/test1','TestController@test1')->middleware('Admin');
Route::any('/test2','TestController@test2');