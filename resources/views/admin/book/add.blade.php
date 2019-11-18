<!DOCTYPE HTML>
<html>
<head>
    @include('layouts/admin_common_header')
    <title>新增书籍</title>
    <link href="/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page-container" id="app">
    <form class="form form-horizontal" id="form-book-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>书籍名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="" v-model="book_name" required>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>书籍编号：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="" v-model="book_number" required>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">书籍分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
				<span class="select-box" style="width: 200px;">
				<select id="first_cat" class="select" v-model="first_cat_selected" onchange="getSecondCats()">
					<option v-for="item in firstCats" :value="item.id">@{{ item.name }}</option>
				</select>
				</span>

                <span class="select-box" style="width: 200px;">
				<select id="second_cat" class="select" v-model="second_cat_selected" onchange="getThirdCats()">
					<option v-for="item in secondCats" :value="item.id">@{{ item.name }}</option>
				</select>
				</span>

                <span class="select-box" style="width: 200px;">
				<select id="third_cat" class="select" v-model="third_cat_selected" onchange="getFourthCats()">
					<option v-for="item in thirdCats" :value="item.id">@{{ item.name }}</option>
				</select>
				</span>

                <span class="select-box" style="width: 200px;">
				<select id="fourth_cat" class="select" v-model="fourth_cat_selected">
					<option v-for="item in fourthCats" :value="item.id">@{{ item.name }}</option>
				</select>
				</span>
            </div>
        </div><div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>出版社：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" v-model="publish_house" required>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>出版日期：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" id="publish_date" onfocus="WdatePicker({skin:'whyGreen',maxDate:'%y-%M-%d'})" class="input-text Wdate" onchange="changeDate()" required>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>作者：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" v-model="author" required>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>页数：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" v-model="book_page" required>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>书籍数量：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" v-model="quantity" required>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">允许借阅：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="pretty success">
                    <input type="checkbox" v-model="allow_borrow"/>
                    <label><i class="mdi mdi-check"></i> &nbsp;</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">允许评论：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="pretty success">
                    <input type="checkbox" v-model="allow_comment"/>
                    <label><i class="mdi mdi-check"></i> &nbsp;</label>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>书籍摘要：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="" cols="" rows="" maxlength="500" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-500" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="inputIntroduction(this,500)" v-model="introduction" required></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/500</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">书籍封面（最多5张）：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    <div id="fileList" class="uploader-list"></div>
                    <div id="filePicker">选择图片</div>
                    <button id="btn-star" class="btn btn-default btn-uploadstar radius ml-10" type="button">开始上传</button>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">书籍状态：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="pretty circle success">
                    <input type="radio" name="book_status" value="1" v-model="book_status"/>
                    <label><i class="mdi mdi-check"></i> 保存并上架&nbsp;</label>
                </div>
                <div class="pretty circle success">
                    <input type="radio" name="book_status" value="2" v-model="book_status"/>
                    <label><i class="mdi mdi-check"></i> 保存草稿&nbsp;</label>
                </div>
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并上架</button>
                <button class="btn btn-secondary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
                <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>


@include('layouts/admin_common_js')

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript" src="/lib/book_categories_tree.js"></script>
<script type="text/javascript" src="/js/category_cascade.js"></script>
<script type="text/javascript">
    var uploader;
    var vm = new Vue({
        el: '#app',
        data: {
            firstCats: [],
            secondCats: [],
            thirdCats: [],
            fourthCats: [],
            first_cat_selected: 0,
            second_cat_selected: 0,
            third_cat_selected: 0,
            fourth_cat_selected: 0,
            book_name: '',
            book_number: '',
            publish_house: '',
            publish_date: '',
            author: '',
            book_page: 0,
            introduction: '',
            allow_borrow: true,
            allow_comment: true,
            book_cover: [],
            book_status: 1,
            quantity: 0,
        },
        methods: {
        }
    })

    vm.firstCats = _getFirstCats();

    function getSecondCats() {
        vm.secondCats = _getSecondCats($('#first_cat').val());
        vm.thirdCats = [];
        vm.second_cat_selected = 0;
    }
    function getThirdCats() {
        vm.thirdCats = _getThirdCats(vm.first_cat_selected, $('#second_cat').val());
        vm.fourthCats = [];
        vm.third_cat_selected = 0;
    }
    function getFourthCats() {
        vm.fourthCats = _getFourthCats(vm.first_cat_selected, vm.second_cat_selected, $('#third_cat').val());
        vm.fourth_cat_selected = 0;
    }

    /**
     * 解决日期控件因为其他绑定的model被修改而清空的问题
     */
    function changeDate() {
        vm.publish_date = $('#publish_date').val();
    }


    $('#form-book-add').submit(function () {
        article_save();
        return false;
    });

    function article_save(){
        var postData = {
            first_cat_selected: vm.first_cat_selected,
            second_cat_selected: vm.second_cat_selected,
            third_cat_selected: vm.third_cat_selected,
            fourth_cat_selected: vm.fourth_cat_selected,
            book_name: vm.book_name,
            book_number: vm.book_number,
            publish_house: vm.publish_house,
            publish_date: vm.publish_date,
            author: vm.author,
            book_page: vm.book_page,
            book_introduction: vm.introduction,
            allow_borrow: vm.allow_borrow,
            allow_comment: vm.allow_comment,
            book_cover: vm.book_cover,
            quantity: vm.quantity,
            submit: vm.book_status,
        };
        httpRequest(
            METHOD_POST,
            '/book',
            postData,
            function (res) {
                console.log(res);
            },
            function (e) {
                var errmsg = '';
                for (var index in e) {
                    errmsg += '<p>'+e[index][0]+'</p>';
                }
                layer.msg(errmsg, {
                    time: 5000
                });
            }
        )
        // window.parent.location.reload();
    }

    function inputIntroduction(that, max) {
        var length = $(that).val().length;
        if (length > max) return false;
        $('.textarea-length').text(length);
    }

    var thumbnailWidth = 1;
    var thumbnailHeight = 1;
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $list = $("#fileList"),
            $btn = $("#btn-star"),
            state = "pending",

        uploader = WebUploader.create({
            auto: false,
            formData: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            fileNumLimit: 5,
            // 文件接收服务端。
            server: '/upload-image',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        uploader.on( 'fileQueued', function( file ) {
            var $li = $(
                '<div id="' + file.id + '" class="item preview-image-item">' +
                '<div class="pic-box"><img style="width: 120px; height: 120px;"></div>'+
                '<div class="info">' + file.name + '</div>' +
                '<p class="state">等待上传...</p>'+
                    '<p><a href="javascript:;" class="del-image-item" onclick="removeImageItem(\''+file.id+'\')">移除</a></p>'+
                '</div>'
                ),
                $img = $li.find('img');
            $list.append( $li );

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr( 'src', src );
            }, thumbnailWidth, thumbnailHeight );
        });
        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                $percent = $li.find('.progress-box .sr-only');

            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo( $li ).find('.sr-only');
            }
            $li.find(".state").text("上传中");
            $percent.css( 'width', percentage * 100 + '%' );
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file, response ) {
            console.log(response);
            if (response.code === 0) {
                response.data.file_id = file.id;
                vm.book_cover.push(response.data);
                $( '#'+file.id ).addClass('upload-state-success').find(".state").html("已上传");
            } else {
                $( '#'+file.id ).addClass('upload-state-error').find(".state").html("上传出错，请移除");
            }
        });

        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file ) {
            $( '#'+file.id ).addClass('upload-state-error').find(".state").text("上传出错");
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress-box').fadeOut();
        });
        uploader.on('all', function (type) {
            if (type === 'startUpload') {
                state = 'uploading';
            } else if (type === 'stopUpload') {
                state = 'paused';
            } else if (type === 'uploadFinished') {
                state = 'done';
            }

            if (state === 'uploading') {
                $btn.text('暂停上传');
            } else {
                $btn.text('开始上传');
            }
        });

        $btn.on('click', function () {
            if (state === 'uploading') {
                uploader.stop();
            } else {
                if (vm.book_cover.length >= 5) {
                    showWarningMsg('最多上传5张图片');
                    return false;
                }
                uploader.upload();
            }
        });

    });

    function removeImageItem(fileId) {
        for (var i = 0; i < vm.book_cover.length; i++) {
            if (vm.book_cover[i].file_id == fileId) {
                vm.book_cover.splice(i, 1);
                break;
            }
        }
        $('#'+fileId).remove();
        uploader.removeFile(fileId,true);
    }
</script>
</body>
</html>