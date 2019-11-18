var taskId = setInterval("verifyUserLoginStatus()", 10000);

function verifyUserLoginStatus() {
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        url: '/ajax',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'heartbeat',
            interval: 60,
        },
        success: function (res) {
            if (res.auth_check === false) {
                clearInterval(taskId);
                if (res.logout === 1) $('#logout1').show();
                else $('#logout2').show();
                showLogoutDialog();
            }
        },
        error:function (e) {
            clearInterval(taskId);
            $('#logout3').show();
            showLogoutDialog();
        },
        finally: function (e) {

        }
    })
}

function showLogoutDialog() {
    layer.open({
        type: 1,
        shade: 0.6,
        title: false,
        area: ['300px', '150px'],
        offset: '100px',
        content: $('#logoutDialog'),
        cancel: function () {
           location.href = '/login';
        }
    });
}