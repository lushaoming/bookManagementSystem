<!DOCTYPE HTML>
<html>
<head>
    @include('layouts/admin_common_header')
    <title>图片列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 图书管理 <span class="c-gray en">&gt;</span> 图书列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container" id="app" v-cloak>
    <div class="text-c">
        <input type="text" placeholder="图书编号/图书名称" style="width:250px" class="input-text" v-model="keyword">
        <button class="btn btn-success" type="button" onclick="searchBook()"><i class="Hui-iconfont">&#xe665;</i> 搜图书</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" onclick="picture_add('/book/add')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加书籍</a></span> <span class="r">共有数据：<strong>@{{ total }}</strong> 条</span> </div>
    <div class="mt-20">
        <div class="dataTables_wrapper no-footer">
            @include('layouts.admin_common_list_header')
            <table class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <th width="20"><input name="allCheck" type="checkbox" value=""></th>
                    <th width="60">编号</th>
                    <th width="70">图书名称</th>
                    <th width="60">分类</th>
                    <th width="60">封面</th>
                    <th width="70">出版社</th>
                    <th width="50">出版日期</th>
                    <th width="50">总数量</th>
                    <th width="50">正在借阅数量</th>
                    <th width="50">总借阅次数</th>
                    <th width="60">图书状态</th>
                    <th width="60">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-c" v-for="item in list">
                    <td><input name="itemCheck" type="checkbox" :value="item.id"></td>
                    <td>@{{ item.book_number }}</td>
                    <td class="text-c"><a href="#" class="normal-link">@{{ item.book_name }}</a></td>
                    <td>@{{ item.cat_name }}</td>
                    <td><a href="javascript:;" @click="showPicture(item.book_cover[0].full_path)"><img width="120" class="picture-thumb" :src="item.book_cover[0].file_path"></a></td>
                    <td>@{{ item.publish_house }}</td>
                    <td>@{{ item.publish_date }}</td>
                    <td>@{{ item.quantity }}</td>
                    <td>@{{ item.borrowed_quantity }}</td>
                    <td>@{{ item.borrowing_quantity }}</td>
                    <td class="td-status">
                        <span class="label label-success radius" v-if="item.status==1">@{{ item.status_text }}</span>
                        <span class="label label-secondary radius" v-else-if="item.status==2">@{{ item.status_text }}</span>
                        <span class="label label-danger radius" v-else-if="item.status==3">@{{ item.status_text }}</span>
                        <span class="label label-warning radius" v-else="item.status==4">@{{ item.status_text }}</span>
                    </td>
                    <td class="td-manage"><a style="text-decoration:none" onClick="picture_stop(this,'10001')" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a> <a style="text-decoration:none" class="ml-5" onClick="picture_edit('图库编辑','picture-add.html','10001')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="picture_del(this,'10001')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                </tr>
                </tbody>
            </table>
            @include('layouts.admin_common_list_footer')
        </div>

    </div>
</div>

@include('layouts/admin_common_js')

<script type="text/javascript" src="/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript" src="/lib/book_categories.js"></script>
<script type="text/javascript">
    var vm = new Vue({
        el: '#app',
        data: {
            list: [],
            page: 1,
            limit: 10,
            total: 0,
            last_page: 0,
            list_start: 0,
            list_end: 0,
            keyword: '',
        },
        methods: {
            showPicture: function (url) {
                picture_show(url);
;            }
        }
    });

    /*图片-添加*/
    function picture_add(url){
        var index = layer.open({
            type: 2,
            title: '添加图书',
            content: url
        });
        layer.full(index);
    }

    /*图片-查看*/
    function picture_show(url){
        var index = layer.open({
            type: 2,
            title: '图片查看',
            content: url
        });
        layer.full(index);
    }

    /*图片-审核*/
    function picture_shenhe(obj,id){
        layer.confirm('审核文章？', {
                btn: ['通过','不通过'],
                shade: false
            },
            function(){
                $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="picture_start(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                $(obj).remove();
                layer.msg('已发布', {icon:6,time:1000});
            },
            function(){
                $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="picture_shenqing(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未通过</span>');
                $(obj).remove();
                layer.msg('未通过', {icon:5,time:1000});
            });
    }

    /*图片-下架*/
    function picture_stop(obj,id){
        layer.confirm('确认要下架吗？',function(index){
            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_start(this,id)" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
            $(obj).remove();
            layer.msg('已下架!',{icon: 5,time:1000});
        });
    }

    /*图片-发布*/
    function picture_start(obj,id){
        layer.confirm('确认要发布吗？',function(index){
            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="picture_stop(this,id)" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
            $(obj).remove();
            layer.msg('已发布!',{icon: 6,time:1000});
        });
    }

    /*图片-申请上线*/
    function picture_shenqing(obj,id){
        $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">待审核</span>');
        $(obj).parents("tr").find(".td-manage").html("");
        layer.msg('已提交申请，耐心等待审核!', {icon: 1,time:2000});
    }

    /*图片-编辑*/
    function picture_edit(title,url,id){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*删除*/
    function picture_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    function get_list() {
        var requestParam = {
            page: vm.page,
            limit: vm.limit,
            keyword: vm.keyword
        };
        httpRequest('GET', '/book', requestParam, function (res) {
            if (res.code === 0) {
                var data = res.data.data;
                for (var i = 0; i < data.length; i++) {
                    data[i].cat_name = getBookCategory(data[i].cat_id);
                }
                vm.page = res.data.current_page;
                vm.limit = res.data.per_page;
                vm.total = res.data.total;
                vm.list_start = res.data.total > 0 ? (res.data.current_page - 1) * res.data.per_page + 1 : 0;
                vm.list_end = (res.data.current_page * res.data.per_page) >= res.data.total ? res.data.total : (res.data.current_page * res.data.per_page);
                vm.list = data;
                vm.last_page = res.data.last_page;
            }

        })
    }
    get_list();

    function changeListLength() {
        vm.limit = $('#list_length').val();
        vm.page = 1;
        get_list();
    }

    function searchBook() {
        vm.page = 1;
        get_list();
    }
</script>
</body>
</html>