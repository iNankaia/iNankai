$(document).ready(function(){  
    var img = $("#qr_code");  
	var h = $("#foot_words").outerHeight(); 	
	var w = 70;
    img.css({height:h},{width:w}); 
    var fh = $('#foot').outerHeight();
});


var regUsername = /^[a-zA-Z_][a-zA-Z0-9_]{4,19}$/;
var regPasswordSpecial = /[~!@#%&=;':",./<>_\}\]\-\$\(\)\*\+\.\[\?\\\^\{\|]/;
var regPasswordAlpha = /[a-zA-Z]/;
var regPasswordNum = /[0-9]/;
var regEmail = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
var password;
var check = [false, false, false, false];

//校验成功函数
function success(Obj, counter) {
    Obj.parent().parent().removeClass('has-error').addClass('has-success');
    $('.tips').eq(counter).hide();
    $('.glyphicon-ok').eq(counter).show();
    $('.glyphicon-remove').eq(counter).hide();
    check[counter] = true;

}

// 校验失败函数
function fail(Obj, counter, msg) {
    Obj.parent().parent().removeClass('has-success').addClass('has-error');
    $('.glyphicon-remove').eq(counter).show();
    $('.glyphicon-ok').eq(counter).hide();
    $('.tips').eq(counter).text(msg).show();
    check[counter] = false;
}


$('.container').find('input').eq(0).change(function() {
    if (regUsername.test($(this).val())) {
        success($(this), 0);
    } else if ($(this).val().length < 5) {
        fail($(this), 0, '用户名太短，不能少于5个字符');
    } else {
        fail($(this), 0, '用户名只能为英文数字和下划线,且不能以数字开头');
    }
});


function atLeastTwo(password) {
    var a = regPasswordSpecial.test(password) ? 1 : 0;
    var b = regPasswordAlpha.test(password) ? 1 : 0;
    var c = regPasswordNum.test(password) ? 1 : 0;
    return a + b + c;

}

$('.container').find('input').eq(1).change(function() {
    password = $(this).val();
    if ($(this).val().length < 8) {
        fail($(this), 1, '密码太短，不能少于8个字符');
    } else {
        if (atLeastTwo($(this).val()) < 2) {
            fail($(this), 1, '密码中至少包含字母、数字、特殊字符的两种');
        } else {
            success($(this), 1);
        }
    }
});

// 再次输入密码校验
$('.container').find('input').eq(2).change(function() {
    if ($(this).val() == password) {
        success($(this), 2);
    } else {
        fail($(this), 2, '两次输入的密码不一致');
    }
});

// 邮箱校验
$('.container').find('input').eq(3).change(function(){  
    if (regEmail.test($(this).val())){
    	success($(this), 3);
    }else{
    	fail($(this), 3, '邮箱格式错误');
    }
});

var username = '';
var password = '';
var repassword = '';
var email = '';
var get_json = '';
var flag = -3;

//验证与提交表单
$('#submit').click(function(e) {
    if (!check.every(function(value) {
            return value == true
        })) {
        e.preventDefault();
        for (key in check) {
            if (!check[key]) {
                $('.container').find('input').eq(key).parent().parent().removeClass('has-success').addClass('has-error')
            }
        }
    }
    else{
        /* //提交表单
        username = $('#username').val();
        password = $('#password').val();
        email = $('#email').val();
        $.post(
            "<?php echo site_url('user/signup') ?>",
            {
                'username':username,
                'password':password,
                'email':email
            },
            function (data){
                get_json = json_encode(data);
                flag = get_json->flag;
                if(flag == 100){
                    alert("注册成功，请到邮箱确认！");
                    window.location.href="<?php echo site_url('') ?>"; //返回主页
                }
                else{
                    alert(get_json->content);
                }
            },
            "json"
            );*/
        }

});