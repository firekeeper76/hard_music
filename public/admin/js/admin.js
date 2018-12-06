/*
* @Author: Marte
* @Date:   2018-09-20 15:01:19
* @Last Modified by:   Marte
* @Last Modified time: 2018-09-20 15:01:52
*/

layui.use('table', function(){
  var table = layui.table;

  table.render({
    width: 1250,
    elem: '#test'
    ,url:'{:url('admin/getAdmin')}'
    ,cols: [[
      {field:'id', width:80, title: 'ID', sort: true}
      ,{field:'phone', width:200,  title: '手机号', align: 'center'} //width 支持：数字、百分比和不填写。你还可以通过 minWidth 参数局部定义当前单元格的最小宽度，layui 2.2.1 新增
      ,{field:'password', width:350, title: '密码', align: 'center'}
      ,{field:'realname', width:250, title: '姓名', align: 'center'}
      ,{field:'power', width:150, title: '权限', align: 'center'} //单元格内容水平居中
      ,{fixed: 'right', width:200, title:'操作',align: 'center', toolbar: '#barDemo',}
    ]]
    ,page: false

    ,done: function(res, page, count){
      //如果是异步请求数据方式，res即为你接口返回的信息。
      //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
      //分类显示中文名称
      $("[data-field='power']").children().each(function(){
          if($(this).text()=='1'){
             $(this).text("超级管理员");
          }else if($(this).text()=='2'){
             $(this).text("管理员");
          }
      })

      }
  });




//   //监听行工具事件
  table.on('tool(test)', function(obj){
    var data = obj.data;
    //console.log(obj)
    if(obj.event === 'del'){ //删除
      layer.confirm('确认删除', function(index){
        $.ajax({
          type:"post",
          url : "{:url('admin/soft_del')}",
          dataType:'json',
          data: {'admin_id':data.id},
          success:function(data){
            if(data == 1){
              layer.msg('删除成功');
              obj.del();
              layer.close(index);
            } else if (data == 2){
              layer.msg('删除失败');
            } else {
              layer.msg('不能删除初始化管理员');
            }

          }

        });

      });
    } else if(obj.event === 'edit'){  //编辑
      if(data.id != 1){
        layer.msg('权限不足');
      }else if(data.id != {$Request.session.id} && {$Request.session.id} != 1){
        layer.msg('您没有权限修改其他用户');
      }else{
        layer.open({
          type: 1,
          title: '修改',
           area: ['40%', '30%'],
          content: $('#edit-user'), //这里content是一个DOM，这个元素要放在body根节点下
          success: function () {
            $('#phone').val(data.phone);
            $('#admin_id').val(data.id);
          },
        });
      }


    }
  });
});

$(function(){
  $('#submit').on('click', function(event) {
    $.ajax({
      type:"post",
      url : "{:url('admin/edit')}",
      dataType:'json',
      data: {'id':$('#id').val(),'phone':$('#phone').val(),'password':$('#password').val()},
      success:function(data){

        if(data == 1){
          layer.msg('修改成功');
          window.location.reload();
        }else if(data == 2){
          layer.msg('修改失败');
        } else if (data == 3){
          layer.msg('用户名不能为空');
        } else if (data == 4){
          layer.msg('用户已存在');
        }

      },
      error:function(){
        layer.msg('修改失败');
      },
    });

  });

$('#add-btn').on('click', function(event) {
      layer.open({
          type: 1,
          title: '增加管理员',
           area: ['40%', '30%'],
          content: $('#add-user'), //这里content是一个DOM，这个元素要放在body根节点下
          success: function () {

          },
      });
});

$('#add-submit').on('click', function(event) {
    $.ajax({
      type:"post",
      url : "{:url('admin/add')}",
      dataType:'json',
      data: {'phone':$('#phone-add').val(),'password':$('#password-add').val(),'realname':$('#realname-add').val()},
      success:function(data){
        if(data == 1){
          layer.msg('增加成功');
          window.location.reload();
        }else if(data == 2){
          layer.msg('必须填写所有字段');
        } else if (data == 3){
          layer.msg('用户名重复');
        }else if (data == 0){
          layer.msg('用户名重复');
        }
      },
      error:function(){
        layer.msg('增加失败');
      },
    });

  });

});