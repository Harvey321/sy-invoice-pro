<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <title>双于通信管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        .lyear-wrapper {
            position: relative;
        }

        .lyear-login {
            display: flex !important;
            min-height: 100vh;
            align-items: center !important;
            justify-content: center !important;
        }

        .login-center {
            background: #fff;
            min-width: 38.25rem;
            padding: 2.14286em 3.57143em;
            border-radius: 5px;
            margin: 2.85714em 0;
        }

        .login-center .has-feedback.feedback-left .form-control {
            padding-left: 38px;
            padding-right: 12px;
        }

        .login-center .has-feedback.feedback-left .form-control-feedback {
            left: 0;
            right: auto;
            width: 38px;
            height: 38px;
            line-height: 38px;
            z-index: 4;
            color: #dcdcdc;
        }

        .login-center .has-feedback.feedback-left.row .form-control-feedback {
            left: 15px;
        }
    </style>
</head>
<body>
<div class="row lyear-wrapper" style="background: rgb(250, 250, 250);margin:0;padding:0;">
    <div class="lyear-login" style="margin:0;padding:0;">
        <div class="login-center" style="background: white;">
            <div class="text-center">
                <img alt="light year admin" src="/assets/images/logo.jpeg" width="240">
            </div>
            <div style="width: 100%; height: 45px;">
                <div class="alert alert-danger alert-dismissible" id="alert-toastr" style="display: none;" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <strong>警告!</strong> <span class="danger-span" id="danger-span">123</span>
                </div>
            </div>
            <form><!--  action="/doLogin" method="post"   -->
                <div class="form-group input-group ">
                    <span class="input-group-addon" id="basic-addon1">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    </span>
                    <input type="text" id="username" name="username" value="" class="form-control"
                           placeholder="请输入您的用户名"
                           aria-describedby="basic-addon1"
                           style="height: 40px" onkeyup="this.value=this.value.replace(/\s+/g,'')">
                    {{csrf_field()}}
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon" id="basic-addon1">
                        <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                    </span>
                    <input type="password" id="password" name="password" value="" class="form-control"
                           placeholder="请输入密码"
                           aria-describedby="basic-addon1"
                           style="height: 40px" onkeyup="this.value=this.value.replace(/\s+/g,'')">
                </div>
                <div class="form-group input-group"
                     style="display: flex;justify-content: space-between">
                    <input type="text" id="code" name="code" class="form-control" placeholder="请输入验证码"
                           style="height: 40px;width: 100%" onkeyup="this.value=this.value.replace(/\s+/g,'')">
                    <div class="col-4" onclick="re_captcha()">
                        <img src="{{URL('/code/captcha/1')}}" id="127ddf0de5a04167a9e427d883690ff6">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-primary" id="submit_login" type="button" onclick="doLogin()"
                            style="height: 40px">立即登录
                    </button>
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-default" type="reset" style="height: 40px">重&nbsp;&nbsp;置</button>
                </div>
            </form>
            <hr>
            <footer class="col-sm-12 text-center">
                <strong>Copyright &copy; 2020
                    <a href="http://adminlte.io">上海双于通信技术有限公司</a>.
                </strong>
                All Right Reserved.
            </footer>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
    function re_captcha() {
        $url = "{{ URL('/code/captcha') }}";
        $url = $url + "/" + Math.random();
        document.getElementById('127ddf0de5a04167a9e427d883690ff6').src = $url;
    }

    $(document).keyup(function (event) {
        if (event.keyCode == 13) {
            $('#submit_login').click();
        }
    });

    function doLogin() {
        // 表单验证
        let res = formVerification()
        if (res == false) {
            return false;
        }

        let data = $('form').serializeArray();

        $.ajax({
            type: "post",
            url: "/doLogin",
            dataType: 'json',
            data: data,
            success: function (data) {
                if (data.status == 1) {
                    window.location = '/customer/product';
                }
                if (data.status == 0) {
                    $('#alert-toastr').css('display', 'block');
                    $('#danger-span').text(data.message);
                    re_captcha();
                    return false;
                }
            },
            error: function (data) {
                console.log(data)
            }
        })
    }


    function formVerification() {
        //表单验证
        if ($('#username').val() == '') {
            $('#alert-toastr').css('display', 'block');
            $('#danger-span').text('请输入用户名');
            re_captcha();
            return false;
        }
        if ($('#password').val() == '') {
            $('#alert-toastr').css('display', 'block');
            $('#danger-span').text('请输入密码');
            re_captcha();
            return false;
        }
        if ($('#code').val() == '') {
            $('#alert-toastr').css('display', 'block');
            $('#danger-span').text('请输入验证码');
            re_captcha();
            return false;
        }
        return true;
    }
</script>
</body>
</html>