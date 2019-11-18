<?php
/**
 * Class ${NAME}
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/5
 */
function app_version()
{
    return \App\Libs\APP_VERSION;
}

function get_config($key = '')
{
    return \App\Http\Models\SystemConfigModel::getSystemConfig($key);
}

function md5_password($password)
{
    return md5($password . \App\Libs\KEY_SALT);
}

/**
 * 检查后台用户是否登录
 * @return bool
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/11/12
 */
function check_admin_user_is_logged_in()
{
    return session('admin_id') ? true : false;
}

function get_current_admin_user()
{
    return session('admin_id') ?: null;
}

function clear_login_session()
{
    session([
        'admin_id' => null,
        'admin_username' => null,
        'admin_nickname' => null,
    ]);
}

/**
 * 生成一个input框
 * @param $id
 * @param $value
 * @param array $extra
 * @return string
 */
function create_input_field($id, $value, $extra = [])
{
    if (empty($extra['type'])) $type = 'text';
    else $type = $extra['type'];

    $data = [];
    foreach ($extra as $k => $v) {
        $data[] = $k.'="'.$v.'"';
    }
    $data = ' '.implode(' ', $data);

    return '<input type="'.$type.'" id="'.$id.'" value="'.$value.'"'.$data.'>';
}

/**
 * 创建隐藏输入框
 * @param $id
 * @param $value
 * @param string $name
 * @return string
 */
function create_hidden_input_field($id, $value, $name = '')
{
    if (empty($name)) $name = $id;
    return '<input type="hidden" id="'.$id.'" name="'.$name.'" value="'.$value.'">';
}