<!DOCTYPE HTML>
<html>
<head>
    @include('layouts/admin_common_header')

    <title>基本设置</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span>
    系统管理
    <span class="c-gray en">&gt;</span>
    基本设置
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container" id="app">

        <div id="tab-system" class="HuiTab">
            <div class="tabBar cl">
                <span>基本设置</span>
                <span>登录设置</span>
                <span>安全设置</span>
                <span>邮件设置</span>
                <span>其他设置</span>
            </div>
            <form class="form form-horizontal" id="form-setting-basic">
                <div class="tabCon">
                    @foreach($configs['basic'] as $config)
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">
                                @if($config->is_necessorry==1)<span class="c-red">*</span>@endif
                                {{$config->config_name}}：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                @if($config->element_type=='input')
                                    <input type="text" id="{{$config->config_key}}" placeholder="{{$config->place_holder}}" class="input-text" @if($config->is_can_edit==0) readonly @endif @if($config->is_necessorry==1) required @endif v-model="basic.{{$config->config_key}}">
                                @elseif($config->element_type=='textarea')
                                    <textarea class="textarea" id="{{$config->config_key}}" placeholder="{{$config->place_holder}}" @if($config->is_can_edit==0) readonly @endif @if($config->is_necessorry==1) required @endif v-model="basic.{{$config->config_key}}"></textarea>
                                @endif
                            </div>
                        </div>
                    @endforeach
                        <div class="row cl">
                            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                                <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                            </div>
                        </div>
                </div>


            </form>

            <form class="form form-horizontal" id="form-setting-login">
                <div class="tabCon">
                    @foreach($configs['login'] as $config)
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">
                                @if($config->is_necessorry==1)<span class="c-red">*</span>@endif
                                {{$config->config_name}}：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                @if($config->element_type=='input')
                                    <input type="text" id="{{$config->config_key}}" placeholder="{{$config->place_holder}}" class="input-text" @if($config->is_can_edit==0) readonly @endif @if($config->is_necessorry==1) required @endif v-model="login.{{$config->config_key}}">
                                @elseif($config->element_type=='textarea')
                                    <textarea class="textarea" id="{{$config->config_key}}" placeholder="{{$config->place_holder}}" @if($config->is_can_edit==0) readonly @endif @if($config->is_necessorry==1) required @endif v-model="login.{{$config->config_key}}"></textarea>
                                @elseif($config->element_type=='radio')
                                    @foreach($config->element_options as $key => $item)
                                        <div class="pretty circle success">
                                            <input name="{{$config->config_key}}" type="radio" id="{{$config->config_key}}{{$key+1}}" value="{{$item['value']}}" v-model="login.{{$config->config_key}}">
                                            <label><i class="mdi mdi-check"></i>{{$item['name']}}</label>
                                        </div>
                                    @endforeach

                                @endif
                            </div>
                        </div>
                    @endforeach
                        <div class="row cl">
                            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                                <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                            </div>
                        </div>
                </div>


            </form>

            <form class="form form-horizontal" id="form-setting-safe">
                <div class="tabCon">
                    @foreach($configs['safe'] as $config)
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">
                                @if($config->is_necessorry==1)<span class="c-red">*</span>@endif
                                {{$config->config_name}}：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                @if($config->element_type=='input')
                                    <input type="text" id="{{$config->config_key}}" placeholder="{{$config->place_holder}}" class="input-text" @if($config->is_can_edit==0) readonly @endif @if($config->is_necessorry==1) required @endif v-model="safe.{{$config->config_key}}">
                                @elseif($config->element_type=='textarea')
                                    <textarea class="textarea" id="{{$config->config_key}}" placeholder="{{$config->place_holder}}" @if($config->is_can_edit==0) readonly @endif @if($config->is_necessorry==1) required @endif v-model="safe.{{$config->config_key}}"></textarea>
                                @elseif($config->element_type=='radio')
                                    @foreach($config->element_options as $key => $item)
                                        <div class="pretty circle success">
                                            <input name="{{$config->config_key}}" type="radio" id="{{$config->config_key}}{{$key+1}}" value="{{$item['value']}}" v-model="safe.{{$config->config_key}}">
                                            <label><i class="mdi mdi-check"></i>{{$item['name']}}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                        <div class="row cl">
                            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                                <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                            </div>
                        </div>
                </div>


            </form>

            <form class="form form-horizontal" id="form-setting-email">
                <div class="tabCon">
                    @foreach($configs['email'] as $config)
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">
                                @if($config->is_necessorry==1)<span class="c-red">*</span>@endif
                                {{$config->config_name}}：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                @if($config->element_type=='input')
                                    <input type="text" id="{{$config->config_key}}" placeholder="{{$config->place_holder}}" class="input-text" @if($config->is_can_edit==0) readonly @endif @if($config->is_necessorry==1) required @endif v-model="email.{{$config->config_key}}">
                                @elseif($config->element_type=='textarea')
                                    <textarea class="textarea" id="{{$config->config_key}}" placeholder="{{$config->place_holder}}" @if($config->is_can_edit==0) readonly @endif @if($config->is_necessorry==1) required @endif v-model="email.{{$config->config_key}}"></textarea>
                                @elseif($config->element_type=='radio')
                                    @foreach($config->element_options as $key => $item)
                                        <div class="pretty circle success">
                                            <input name="{{$config->config_key}}" type="radio" id="{{$config->config_key}}{{$key+1}}" value="{{$item['value']}}" v-model="email.{{$config->config_key}}">
                                            <label><i class="mdi mdi-check"></i>{{$item['name']}}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                        <div class="row cl">
                            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                                <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                            </div>
                        </div>
                </div>

            </form>

            <form class="form form-horizontal" id="form-setting-other">
                <div class="tabCon">
                    @if (isset($configs['other']))
                    @foreach($configs['other'] as $config)
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">
                                @if($config->is_necessorry==1)<span class="c-red">*</span>@endif
                                {{$config->config_name}}：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                @if($config->element_type=='input')
                                    <input type="text" id="{{$config->config_key}}" placeholder="{{$config->place_holder}}" class="input-text" @if($config->is_can_edit==0) readonly @endif @if($config->is_necessorry==1) required @endif v-model="email.{{$config->config_key}}">
                                @elseif($config->element_type=='textarea')
                                    <textarea class="textarea" id="{{$config->config_key}}" placeholder="{{$config->place_holder}}" @if($config->is_can_edit==0) readonly @endif @if($config->is_necessorry==1) required @endif v-model="email.{{$config->config_key}}"></textarea>
                                @endif
                            </div>
                        </div>
                    @endforeach
                        <div class="row cl">
                            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                                <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                            </div>
                        </div>
                    @else
                        <div class="formControls col-xs-8 col-sm-9">暂无设置</div>
                    @endif
                </div>
            </form>
        </div>
</div>

@include('layouts/admin_common_js')

<script type="text/javascript" src="/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        $("#tab-system").Huitab({
            index:0
        });
    });

<?php
   $configsTemp = [];
   foreach ($configs as $key => $config) {
       foreach ($config as $item) {
           $configsTemp[$key][$item->config_key] = $item->config_value;
       }

   }
?>

    let vm = new Vue({
        el: '#app',
        data: <?php echo json_encode($configsTemp); ?>
    });
    
    $('#form-setting-basic').submit(function () {
        saveSetting(vm.basic);
        return false;
    });
    $('#form-setting-login').submit(function () {
        saveSetting(vm.login);
        return false;
    });
    $('#form-setting-email').submit(function () {
        saveSetting(vm.email);
        return false;
    });
    $('#form-setting-safe').submit(function () {
        saveSetting(vm.safe);
        return false;
    });
    $('#form-setting-other').submit(function () {
        saveSetting(vm.other);
        return false;
    });

    function saveSetting(data) {
        httpRequest('POST', '/system/setting', data, function (res) {
            showSuccessMessage('保存成功');
        })
    }
</script>
</body>
</html>
