var METHOD_POST = 'POST';
var METHOD_GET = 'GET';

function httpRequest(type, url, data, callback, errorCallback) {
    // 在Header添加X-CSRF-TOKEN
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    var loading = showLoading();
    $.ajax({
        url: url,
        type: type,
        dataType: 'json',
        data: data,
        success: function (res) {
            hideLoading(loading);
            if (res.code === 0) {
                callback(res);
            } else {
                showErrorMessage(res.msg);
            }
        },
        error: function (e) {
            hideLoading(loading);
            var errorMessage = JSON.parse(e.responseText);

            if (errorCallback !== undefined) {
                errorCallback(errorMessage.errors);
            }

        },
        finally: function (e) {
            hideLoading(loading);
        }
    })
}

function showErrorMessage(msg) {
    layer.msg(msg, {
        icon: 5,
        time: 5000,
        anim: 6,
        closeBtn: 1,
    })
}

function showSuccessMessage(msg) {
    layer.msg(msg, {
        icon: 1,
        time: 5000,
    });
}

function showMessageAndReload(msg) {
    layer.msg(msg);
    setTimeout(function(){
        location.reload();
    }, 2000);
}

function showSuccessMessageAndReload(msg) {
    layer.msg(msg, {
        icon: 1,
        time: 5000,
    });
    setTimeout(function(){
        location.reload();
    }, 2000);
}

function showSuccessMessageAndDo(msg, callback) {
    layer.msg(msg, {
        icon: 1,
        time: 5000,
    });
    setTimeout(callback, 2000);
}

function showLoading(type) {
    if (typeof type === "undefined") type = 1;
    return layer.load(1, {
        shade: [0.5,'#fff'] //0.1透明度的白色背景
    });
}

function hideLoading(index) {
    if (typeof index === "undefined") {
        layer.closeAll();
    }
    layer.close(index)
}

function  showWarningMsg(msg) {
    layer.msg(msg, {
        icon: 7,
        time: 5000,
        anim: 5,
        closeBtn: 1,
    })
}

function showConfirm(msg, callback) {
    //询问框
    layer.confirm(msg, {
        btn: ['确定','取消'] //按钮
    }, function(){
        callback();
    }, function(){
    });
}

function gotoPage(url, msg) {
    if (msg != '') {
        layer.msg(msg, {
            icon: 1,
            time: 5000,
        });
    }
    setTimeout(function(){
        location.href = url;
    }, 2000);
}

function randomWord(randomFlag, min, max){
    var str = "",
        range = min,
        arr = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    // 随机产生
    if(randomFlag){
        range = Math.round(Math.random() * (max-min)) + min;
    }
    for(var i=0; i<range; i++){
        pos = Math.round(Math.random() * (arr.length-1));
        str += arr[pos];
    }
    return str;
}

// 递归实现获取图书分类
function getBookCategory(catId) {
    var cats = '';
    for (var i = 0; i < book_categories.length; i++) {
        if (book_categories[i].id === catId) {
            if (book_categories[i].pid > 0) {
                cats = getBookCategory(book_categories[i].pid) + '-->' + book_categories[i].name;
            } else {
                return book_categories[i].name;
            }
            break;
        }
    }
    return cats;
}



