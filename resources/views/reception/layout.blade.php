<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>双于系统控制平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- icon图标 -->
    <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- 主要样式文件-->
    <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
    <!-- 弹框css-->
    <link rel="stylesheet" href="/admin/plugins/toastr/toastr.min.css">
    <!-- 数据表 -->
    <link rel="stylesheet" href="/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- 左侧覆盖条菜单样式 -->
    <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!--  jquery -->
    <script src="/admin/plugins/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    {{--  顶部导航栏  --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="margin:0;">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <div class="user-panel mt-1 pb-1 mb-1 d-flex nav-link" data-toggle="dropdown" href="#"
                     style="padding-top: 0;padding-bottom: 0;">
                    <div class="image">
                        <img src="/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#"
                           class="d-block">{{ isset( session()->get('customer')->username ) ? session()->get('customer')->username : '暂无用户名'}}</a>
                    </div>
                </div>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="/loginOut" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 退出
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- 具体内容 -->
    <div class="content-wrapper" style="margin:0;padding:20px;">
        @section('content-wrapper')
        @show
    </div>

    <!--  底部公司信息 -->
    <footer class="main-footer" style="margin:0;font-size:0.5em;">
        <strong>Copyright &copy; 2020 <a href="http://adminlte.io">
                上海双于通信技术有限公司</a>.</strong>All Right Reserved.
    </footer>
</div>

<!-- 弹框js -->
<script src="/admin/plugins/toastr/toastr.min.js"></script>
{{--<!-- AdminLTE App -->--}}
<script src="/admin/dist/js/adminlte.js"></script>
<!-- 数据表 -->
<script src="/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    function timeOut(url) {
        setTimeout(function () {
            window.location = url;
        }, 1000);
    }
</script>
</body>
</html>