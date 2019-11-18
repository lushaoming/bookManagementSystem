<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/lib/respond.min.js"></script>
    <![endif]-->
    <link href="/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
    <link href="/static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>后台登录 - {{get_config('basic.website_name')}}</title>
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header">{{get_config('basic.website_name')}}</div>
<div class="loginWraper" id="app">
    <div id="loginform" class="loginBox">
        <form class="form form-horizontal" id="login-form">
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-xs-8">
                    <input type="text" name="username" placeholder="账户" class="input-text size-L" v-model="username" required>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-xs-8">
                    <input type="password" name="password" placeholder="密码" class="input-text size-L" v-model="password" required>
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input name="verifyCode" class="input-text size-L" type="text" placeholder="验证码" required onclick="if(this.value=='验证码:'){this.value='';}" style="width:150px;" v-model="verifyCode">
                    <img src="{{captcha_src()}}" id="captcha_img"> <a href="javascript:;" onclick="resetCaptcha()">看不清，换一张</a> </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <label for="online">
                        <input type="checkbox" value="1" v-model="remember">
                        使我保持登录状态</label>
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <button type="submit" class="btn btn-success radius size-L">&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;</button>
                    <button type="reset" class="btn btn-default radius size-L">&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="footer">Copyright {{get_config('basic.company_name')}}</div>
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/lib/vue.js"></script>
<script type="text/javascript" src="/js/{{\App\Libs\ASSETS_FILE['js']['global']}}"></script>

<script>
    var vm = new Vue({
        el: '#app',
        data: {
            username: '',
            password: '',
            verifyCode: '',
            remember: 0,
        }
    })

    $('#login-form').submit(function () {
        var postData = {
            username: vm.username,
            password: vm.password,
            captcha: vm.verifyCode,
            remember:vm.remember,
        }
        httpRequest('POST', '/login', postData, function (res) {
            if (res.code === 0) {
                showSuccessMessageAndDo('登录成功', function () {
                    location.href = '/';
                })
            }
        }, function (e) {
            if (e.captcha !== undefined) {
                showErrorMessage('验证码错误');
            }
        })
        return false;
    });

    function resetCaptcha() {
        $('#captcha_img').attr('src', '{{captcha_src()}}');
    }
</script>
</body>
</html>