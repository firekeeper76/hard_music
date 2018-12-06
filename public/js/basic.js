
$(function(){

    var domain = document.domain;

    if(self == top){
        window.location.href="http://"+domain;
    }

    var height = document.body.clientHeight;
    window.parent.setHeight(height);

});





//播放
function addPlaylist(json) {
    window.parent.addSong(json);
}
//添加到播放列表
function addToPlaylist(json) {
    window.parent.addSongPlaylist(json);
}
//添加到我的歌单
function addToMyPlaylist(id,topic_type){
    window.parent.openPlayList(id,topic_type);
}


/*
获取get参数
 */
function getParam(paramName) {
    paramValue = "", isFound = !1;
    if (this.location.search.indexOf("?") == 0 && this.location.search.indexOf("=") > 1) {
        arrSource = unescape(this.location.search).substring(1, this.location.search.length).split("&"), i = 0;
        while (i < arrSource.length && !isFound) arrSource[i].indexOf("=") > 0 && arrSource[i].split("=")[0].toLowerCase() == paramName.toLowerCase() && (paramValue = arrSource[i].split("=")[1], isFound = !0), i++
    }
    return paramValue == "" && (paramValue = null), paramValue
}
/*
获取get参数,解决中文乱码问题
 */
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURI(r[2]);
    return null;
}







// 设置评论排序
function setOrder(by,id){
    order = by;
    page = 1;
    $('#page_tips').html("第"+page+"页");
    $('#order_box a').css('color','black');
    $("#"+id).css('color','red');
    getComment();
}

function setPage(p){
    page_over = Math.ceil(comments_count/limit);
    if(p=='next'){
        if(page < page_over){
            page += 1;
            $('#page_tips').html("第"+page+"页");
            getComment();
        }
    }else if(p=='prev'){
        if(page > 1){
            page -= 1 ;
            $('#page_tips').html("第"+page+"页");
            getComment();
        }
    }else{
        page = p ;
        $('#page_tips').html("第"+page+"页");
        getComment();
    }
}



function comments(id,name){
    $('#reply_content').attr('placeholder','评论：'+name);
    $('#to_id').val(id);
}
function reply(){
    var content = $('#reply_content').val();
    var to_id = $('#to_id').val();

    if(from_uid){
        if(!content){
            window.parent.setTips('说点什么吧');
        }else{
            // alert(topic_id+"----"+from_id);
            $.ajax({
                url:'/comment',
                type:'post',
                dataType:"json",
                data:{"topic_id":topic_id,'topic_type':topic_type,'content':content,'from_uid':from_uid,'to_id':to_id},
                success:function (result) {
                    // alert(JSON.stringify(result));
                    if(result ==100){
                        window.parent.setTips("评论成功");
                        comments_count+=1;
                        $('#close_modal').click();
                        getComment();
                        $('#reply_content').val(' ');
                    }else{
                        window.parent.setTips("评论失败");
                    }
                },
                error:function (){
                    window.parent.setTips("无法评论，您的网络似乎有问题");
                }

            })
        }
    }else{
        window.parent.setTips('请先登录');
    }
}

// 我的评论
function comment(){
    var content = $('#comment').val();
    if(from_uid){
        if(!content){
            window.parent.setTips('说点什么吧');
        }else{
            $.ajax({
                url:'/comment',
                type:'post',
                dataType:"json",
                data:{"topic_id":topic_id,'topic_type':topic_type,'content':content,'from_uid':from_uid},
                success:function (result) {
                    // alert(JSON.stringify(result));
                    if(result == 100){
                        comments_count+=1;
                        $('#comment_tips').html('评论成功');
                        getComment();
                        $('#comment').val(' ');
                    }else{
                        window.parent.setTips("评论失败");
                    }
                },
                error:function (){
                    window.parent.setTips("无法评论，您的网络似乎有问题");
                }

            })
        }
    }else{
        window.parent.setTips('请先登录');
    }
}

function getComment(){
    $('#commentsData').html('');
    $.ajax({
        url:'/getComment',
        data:{'topic_type':topic_type,'topic_id':topic_id,'page':page,'limit':limit,'order':order},
        type:'post',
        success:function (result) {
            console.log(result);
            for(var i=0;i<result.length;i++){
                if(result[i]['to_id']){
                    $('#commentsData').append("<div class=\"row mb-3\"  style=\"max-width:650px;\">\n" +
                        "                        <div class=\"col-2\">\n" +
                        "                        <img src=\"/"+result[i]['user']['avatar']+"\" width=\"60\" height=\"60\" alt=\"\" onerror=\"this.src='{{URL::asset('images/thumb_user_error.jpg')}}'\">\n" +
                        "                        </div>\n" +
                        "                        <div class=\"col\" style=\"max-width: 650px;\">\n" +
                        "\n" +
                        "                            <div style=\"font-size:13px;\">\n" +
                        "                                <div style=\"height:45px;\">\n" +
                        "                                    <a href=\"/user?id="+result[i]['from_uid']+"\" style=\"color:#0056b3\">"+result[i]['user']['nickname']+" :</a>\n" +
                        "                                    "+result[i]['content']+"\n" +
                        "                                </div>\n" +
                        "\n" +
                        "                                <div style=\"width:90%;background:rgba(221,211,211,0.3);padding-left: 30px;\">\n" +
                        "                                    <a href=\"/user?id="+result[i]['to_comment']['user']['id']+"\" style=\"color:#0056b3\">"+result[i]['to_comment']['user']['nickname']+" :</a>\n" +
                        "                                    "+result[i]['to_comment']['content']+"\n" +
                        "                                </div>\n" +
                        "\n" +
                        "                                <div>\n" +
                        "                                    <span style=\"color:darkgray\">"+result[i]['created_at']+"</span>\n" +
                        "                                    <div style=\"float:right;\">\n" +
                        "                                        <a href=\"javascript:like("+result[i]['id']+");\"><i class='fa fa-thumbs-o-up' id='like"+result[i]['id']+"'></i> &nbsp; <span id='lc"+result[i]['id']+"'>( "+result[i]['like']+" )</span></a>\n" +
                        "                                        <a href=\"javascript:;\" data-toggle=\"modal\" data-target=\"#comments\" onclick=\"comments("+result[i]['id']+",'"+result[i]['user']['nickname']+"')\">评论</a>\n" +
                        "                                    </div>\n" +
                        "\n" +
                        "                                </div>\n" +
                        "\n" +
                        "                            </div>\n" +
                        "                        </div>\n" +
                        "                    </div>");
                }else{
                    $('#commentsData').append("<div class=\"row mb-3\"  style=\"max-width:650px;\">\n" +
                        "                        <div class=\"col-2\">\n" +
                        "                            <img src=\"/"+result[i]['user']['avatar']+"\" width=\"60\" height=\"60\" alt=\"\" onerror=\"this.src='{{URL::asset('images/thumb_user_error.jpg')}}'\">\n" +
                        "                        </div>\n" +
                        "                        <div class=\"col\" style=\"max-width: 650px;\">\n" +
                        "\n" +
                        "                            <div style=\"font-size:13px;\">\n" +
                        "                                <div style=\"height:45px;\">\n" +
                        "                                    <a href=\"/user?id="+result[i]['from_uid']+"\" style=\"color:#0056b3\">"+result[i]['user']['nickname']+" :</a>\n" +
                        "                                    "+result[i]['content']+"\n" +
                        "                                </div>\n" +
                        "\n" +
                        "                                <div>\n" +
                        "                                    <span style=\"color:darkgray\">"+result[i]['created_at']+"</span>\n" +
                        "                                    <div style=\"float:right;\">\n" +
                        "                                        <a href=\"javascript:like("+result[i]['id']+");\"><i class='fa fa-thumbs-o-up' id='like"+result[i]['id']+"'></i> &nbsp; <span id='lc"+result[i]['id']+"'>( "+result[i]['like']+" )</span></a>\n" +
                        "                                        <a href=\"javascript:;\" data-toggle=\"modal\" data-target=\"#comments\" onclick=\"comments("+result[i]['id']+",'"+result[i]['user']['nickname']+"')\">评论</a>\n" +
                        "                                    </div>\n" +
                        "\n" +
                        "                                </div>\n" +
                        "                            </div>\n" +
                        "                        </div>\n" +
                        "                    </div>");
                }


            }
            var height = document.body.clientHeight;
            window.parent.setHeight(height);
        },
        error:function () {

        }

    })
}
//点赞
function like(id){
    if(!from_uid){
        window.parent.login_btn();
    }else{
        $('#like'+id).css('color',"blue");
        $('#like'+id).removeClass('fa-thumbs-o-up');
        $('#like'+id).addClass('fa-thumbs-up');
        $('#lc'+id).empty();
        $.ajax({
            url:'/like',
            data:{'type':'1','to_id':id,'user_id':from_uid},
            type:'post',
            success:function (result) {
                // alert(JSON.stringify(result));
                if(result == 200){
                    window.parent.setTips("已经点过赞了");
                }else{
                    window.parent.setTips("点赞成功");
                }
            },
            error:function () {

            }
        })
    }
}



