@include('admin.common._meta')

<title>资讯列表 - 资讯管理 - H-ui.admin v3.0</title>
<meta name="keywords" content="H-ui.admin v3.0,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v3.0，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
<style>
    .icheckbox-blue, .iradio-blue{
        position: absolute;
        top: 50%;
        transform: translate(0, -50%);
        left: 32%;
    }
</style>
</head>
<body>
@include('admin.common._header')

@include('admin.common._menu')

<section class="Hui-article-box">
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        资讯管理
        <span class="c-gray en">&gt;</span>
        资讯列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="Hui-article">
        <article class="cl pd-20">
            <div class="text-c">
				<span class="select-box inline">
				<select name="" class="select">
                    <option value="0">全部分类</option>
                    <option value="1">分类一</option>
                    <option value="2">分类二</option>
                </select>
				</span>
                日期范围：
                <input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})" id="logmin" class="input-text Wdate" style="width:120px;">
                -
                <input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})" id="logmax" class="input-text Wdate" style="width:120px;">
                <input type="text" name="" id="" placeholder=" 资讯名称" style="width:250px" class="input-text">
                <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜资讯</button>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l">
				<a href="javascript:;" onclick="all_del()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
				<a class="btn btn-primary radius" data-title="添加网站" onclick="article_add('添加网站','{{url('admin/externalLinksWeb/create')}}', '800', '500')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加网站</a>
				</span>
                <span class="r">共有数据：<strong>{{$count}}</strong> 条</span>
            </div>
            <div class="mt-20 skin-minimal">
                <table class="table table-border table-bordered table-bg table-hover table-sort">
                    <thead>
                    <tr class="text-c">
                        <th width="25" style="position: relative;"><input id="checkboxAll" type="checkbox" name="" value=""></th>
                        <th width="80">ID</th>
                        <th width="">网站名称</th>
                        <th width="">网站域名</th>
                        <th width="">开启优化【自动发布外链 | 随机出现在网站管理列表站点的页面下方】</th>
                        <th width="200">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                        <tr class="text-c">
                            <td class="zsort" data-id="{{$v->web_id}}" style="position: relative;">
                                <input name="picCheck" type="checkbox" value="{{$v->web_id}}">
                            </td>
                            <td>100{{$v->web_id}}</td>
                            <td>{{$v->web_name}}</td>
                            <td>{{$v->web_domain}}</td>
                            <td>
                                <div class="switch size-MINI switchIsOpen" data-on="success" data-off="warning" data-id="{{$v->cate_id}}">
                                    @if($v->is_open_pseudo == 1)
                                        <input type="checkbox" checked data-on-text="YES" data-off-text="NO"/>
                                    @else
                                        <input type="checkbox" data-on-text="YES" data-off-text="NO" />
                                    @endif
                                </div>
                            </td>
                            <td class="f-14 td-manage">
                                <a style="text-decoration:none" class="ml-5" onClick="article_edit('友链编辑','{{url('admin/externalLinksWeb/edit', ['id'=>$v->web_id])}}', '800', '500')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                <a style="text-decoration:none" class="ml-5" onClick="del('{{$v->web_id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </article>
    </div>
</section>

@include('admin.common._footer')

        <!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('resources/views/admin/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/views/admin/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/views/admin/lib/laypage/1.2/laypage.js')}}"></script>
<script type="text/javascript">
    $(function(){
        $('.switchIsOpen').on('switch-change', function (e, data) {
            var $el = $(data.el),
                    value = data.value;
            var id = $(this).data('id');
            console.log(id);
            if(value){
                //为真，开启
                $.ajax({
                    type: "post",
                    url: "{{url('admin/externalLinksWeb/edit_category_is_open_pseudo')}}",
                    data:{
                        _token : "{{ csrf_token() }}",
                        _method : "PUT",
                        is_open_pseudo : 1,
                        id : id
                    },
                    dataType: "json",
                    success: function(responseData){
                        console.log(data);
                        if (responseData.code == 1) {
                            layer.msg(responseData.msg,{icon:"6",time:responseData.wait*1000});
                        } else {
                            layer.msg(responseData.msg,{icon:"6",time:responseData.wait*1000});
                        }
                    }
                });
            }else{
                //为假，关闭
                $.ajax({
                    type: "post",
                    url: "{{url('admin/externalLinksWeb/edit_category_is_open_pseudo')}}",
                    data:{
                        _token : "{{ csrf_token() }}",
                        _method : "PUT",
                        is_open_pseudo : 2,
                        id : id
                    },
                    dataType: "json",
                    success: function(responseData){
                        console.log(data);
                        if (responseData.code == 1) {
                            layer.msg(responseData.msg,{icon:"6",time:responseData.wait*1000});
                        } else {
                            layer.msg(responseData.msg,{icon:"6",time:responseData.wait*1000});
                        }
                    }
                });
            }
        });
        $('.skin-minimal input[name=picCheck]').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        //全选与反选
        var checkAll = $('#checkboxAll');
        var checkboxes = $('input[name=picCheck]');
        checkAll.on('ifChecked ifUnchecked', function(event) {
            if (event.type == 'ifChecked') {
                checkboxes.iCheck('check');
            } else {
                checkboxes.iCheck('uncheck');
            }
        });
        checkboxes.on('ifChanged', function(event){
            if(checkboxes.filter(':checked').length == checkboxes.length) {
                checkAll.prop('checked', 'checked');
            } else {
                checkAll.removeProp('checked');
            }
            checkAll.iCheck('update');
        });

        $('.table-sort').dataTable({
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,3]}// 不参与排序的列
            ]
        });
    });

    /*资讯-添加*/
    function article_add(title,url,w,h){
        var index = layer.open({
            type: 2,
            area: [w+'px', h +'px'],
            title: title,
            content: url
        });
//        layer.full(index);
    }

    /*资讯-编辑*/
    function article_edit(title,url,w,h){
        var index = layer.open({
            type: 2,
            area: [w+'px', h +'px'],
            title: title,
            content: url
        });
//        layer.full(index);
    }

    /*单条删除*/
    function del(dataId) {
        var postUrl = '{{url('admin/externalLinksWeb/del')}}/'+dataId;
        layer.confirm('你确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            //model为数据模型类名
            $.post(postUrl,{'_method':'delete', '_token':'{{csrf_token()}}'},function(responseData){
                if (responseData.code == 1) {
                    layer.msg(responseData.msg,{icon:"6",time:responseData.wait*1000});
                    setTimeout(function(){
                        window.location.href = responseData.url;
                    },1000)
                } else {
                    layer.msg(responseData.msg,{icon:"6",time:responseData.wait*1000});
                    setTimeout(function(){
                        window.location.href = responseData.url;
                    },1000)
                }
            });
        }, function(){
            layer.msg('取消成功', {icon:"6",time: 1000});
        });
    }
    /*多条删除*/
    function all_del(){
        var postUrl = "{{url('admin/externalLinksWeb/del_all')}}";
        var str = '';
        $(".zsort").each(function(){
            if($(this).find('input').prop('checked')){
                str += $(this).data('id')+',';
            }
        });
        if(!str){
            layer.msg('请先选中待删除数据', {icon:"6",time: 1000});
            return false;
        }
        layer.confirm('你确定要删除选中的多项吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            console.log(str);
            //model为数据模型类名
            $.post(postUrl,{
                'id':str,
                '_method':'delete',
                '_token':'{{csrf_token()}}'
            },function(responseData){
                if (responseData.code == 1) {
                    layer.msg(responseData.msg,{icon:"6",time:responseData.wait*1000});
                    setTimeout(function(){
                        window.location.href = responseData.url;
                    },1000)
                } else {
                    layer.msg(responseData.msg,{icon:"5",time:responseData.wait*1000});
                    setTimeout(function(){
                        window.location.href = responseData.url;
                    },1000)
                }
            });
        }, function(){
            layer.msg('取消成功', {icon:"6",time: 1000});
        });
    }
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>