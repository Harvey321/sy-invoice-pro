<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>登录login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--    login页样式--}}
    <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
    {{--    验证码弹框css--}}
    <link rel="stylesheet" href="/admin/plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box" style="width:400px;">
    <div class="login-logo">
        <a href="/admin/login">SY<b>双于控制系统</b></a>
    </div>
    <div class="card" style="margin-bottom: 10rem;">
        <div class="card-body">
            <div class="callout callout-danger" style="background:none;border:none;box-shadow: none">
                欢迎登录双于控制系统！
            </div>
            <form name="myForm">
                {{csrf_field()}}
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="请输入用户名"
                           onkeyup="this.value=this.value.trim()">
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="请输入密码"
                           onkeyup="this.value=this.value.trim()">
                </div>
                <div class="row" style="margin-bottom:16px;">
                    <div class="col-5">
                        <input type="text" id="code" name="code" class="form-control" placeholder="请输入验证码"
                               onkeyup="this.value=this.value.trim()">
                    </div>
                    <div class="col-4 offset-3" onclick="re_captcha()">
                        <img src="{{URL('/code/captcha/1')}}" id="127ddf0de5a04167a9e427d883690ff6">
                    </div>
                </div>
                <div class="row" style="margin-bottom:16px;">

                    <div class="col-6">
                        <button type="button" id="submit_login" onclick="submitDate()"
                                class="btn btn-block btn-primary btn-lg">登录
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="reset" class="btn btn-block btn-default btn-lg">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{--jquery--}}
<script src="/admin/plugins/jquery/jquery.min.js"></script>
{{--弹框js--}}
<script src="/admin/plugins/toastr/toastr.min.js"></script>
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

    function submitDate() {
        if ($('#username').val() == '') {
            toastr.error('请输入用户名')
            return false;
        }

        if ($('#password').val() == '') {
            toastr.error('请输入密码')
            return false;
        }
        if ($('#code').val() == '') {
            toastr.error('请输入验证码')
            return false;
        }

        $.ajax({
            type: "post",
            url: "/admin/doLogin",
            dataType: 'json',
            data: $("form").serializeArray(),
            success: function (data) {
                if (data.status == 'success') {
                    toastr.success(data.message);
                    // console.log(window.location.pathname + "/admin/user")
                    window.location.href = "/admin/user";
                }
                if (data.status == 'error') {
                    toastr.error(data.message);
                    self.re_captcha();
                }
            },
            error: function (data) {
                console.log(data)
            }
        })
        // myForm.submit();
    }
</script>
{{--    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">--}}
{{--    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
{{--    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">--}}
{{--<script src="/plugins/bootstr/bootstrap.bundle.min.js"></script>--}}
{{--<script src="/di/adminlte.min.js"></script>--}}
</body>
</html>