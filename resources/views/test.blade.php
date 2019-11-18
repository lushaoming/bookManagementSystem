<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

</head>
<body>
<form>
    <input type="file" name="file" id="file">
    <input type="button" id="uploadBtn" value="上传">
</form>
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/ajaxfileupload.js"></script>
<script type="text/javascript" src="/js/global.js"></script>

<script>
    $("#file").bind("change",function(){
        var fileType = $(this).val().substring($(this).val().lastIndexOf(".") + 1);
        if(fileType != "jpg" &&　fileType != "jpeg" && fileType != "png" && fileType != "gif"){
            showWarningMsg('只能上传jpg,jpeg,png,gif的图片哦');
        }
    });

    $("#uploadBtn").click(function(){
        var fileType = $('#file').val().substring($(this).val().lastIndexOf(".") + 1);
        if(fileType != "jpg" &&　fileType != "jpeg" && fileType != "png" && fileType != "gif"){
            showWarningMsg('只能上传jpg,jpeg,png,gif的图片哦');
            return false;
        }

        var data = {
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        $.ajaxFileUpload({
            url:'/upload-image',//请求地址
            secureuri:false,//是否需要安全协议
            fileElementId:'file',//file的ID
            data: data,
            dataType: 'JSON',//返回值类型，一般为json
            success: function(img_data1)//成功后执行
            {
                console.log(img_data1)
            },
            error:function(img_data1,status,e){
                console.log(img_data1)
            }
        })
    })
</script>
</body>
</html>
