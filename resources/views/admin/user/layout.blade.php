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
    <!-- 弹框js -->
    <script src="/admin/plugins/toastr/toastr.min.js"></script>

{{--    <!-- 日期范围选择器 -->--}}
{{--    <script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>--}}
{{--    <script src="/admin/plugins/daterangepicker/bootstrap-datetimepicker.js"></script>--}}
{{--    <script src="/admin/plugins/daterangepicker/bootstrap-datetimepicker.zh-CN.js"></script>--}}

<!-- daterangepicker -->
    <script src="/admin/plugins/moment/moment.min.js"></script>
    <!-- 日期范围选取器 -->
    <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- 笔记 -->
    {{--    <link rel="stylesheet" href="/admin/plugins/summernote/summernote-bs4.css">--}}
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


    <!-- 警报 -->
    {{--    <link rel="stylesheet" href="/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">--}}

<!-- iCheck -->
    {{--    <link rel="stylesheet" href="/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">--}}
<!-- JQVMap -->
    {{--    <link rel="stylesheet" href="/admin/plugins/jqvmap/jqvmap.min.css">--}}
</head>
<style>
    .custom-file-label:after {
        content: '上传文件' !important;
    }

    .yuandian {
        margin-left: 10px;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background-color: red;
        display: block
    }

    .notices {
        position: relative;
        height: 30px;
        width: 50px;
    }

    .notice-box {
        color: white;
        width: 500px;
        max-height: 280px;
        min-height: 0;
        border: 2px solid #17a2b8;
        border-radius: 8px;
        overflow: hidden;
        position: absolute;
        top: 30px;
        right: 10px;
        opacity: 0;
        transition: all 0.5s;
        transition-timing-function: ease-in;
        visibility: hidden;
    }

    .notice-box-list-title {
        width: 500px;
        height: 30px;
        padding-left: 10px;
        padding-right: 10px;
        background-color: darkgrey;
        font-size: 16px;
        font-weight: 600;
    }

    .notices:hover .notice-box {
        opacity: 1 !important;
        visibility: visible;

    }

    .notice-box-lists {
        width: 500px;
        min-height: 0;
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .notice-box-list {
        background-color: #17a2b8;
        width: 500px;
        height: 49px;
        border-top: 1px solid white;
        font-size: 12px;
        padding-left: 10px;
    }

    .notice-box-list:hover {
        background-color: rgb(60, 182, 204);
    }


    .a-read {
        color: white;
    }

    .a-read:hover {
        color: black;
    }


</style>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">
    <!-- 右侧上放菜单收缩按钮 以及退出按钮 -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto" style="align-items: center;cursor: pointer;">
            @if(isset($data['noticeListSign']))
                <li class="nav-item dropdown d-flex flex-column justify-content-center  align-items-center notices">
                    @if( $data['noticeListSign'] == 1 ? false : true)
                        <i class="yuandian"></i>
                    @endif
                    <i class="far fa-bell notices-sign"></i>

                    <div class="notice-box">
                        <div class="notice-box-list-title d-flex flex-row justify-content-between align-items-center "
                             style="background-color: #17a2b8!important;">
                            <div>
                                消息通知
                            </div>
                            @if( $data['noticeListSign'] == 1 ? false : true)
                                <div style="font-weight: 100;font-size: 13px;">
                                    <a class="a-read" href="javascript:;" onclick="signRead()">标为已读</a>
                                </div>
                            @endif

                        </div>
                        <div class="notice-box-lists">
                            @foreach($data['noticeList'] as $item)
                                <div class="notice-box-list d-flex flex-column justify-content-center align-items-start">
                                    <div style="font-size: 14px;">
                                        {{$item->money}}
                                    </div>
                                    <div style="font-size: 9px;">
                                        {{$item->created_at}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </li>
            @endif


            <li class="nav-item dropdown">
                <a href="/admin/loginOut" class=" btn btn-default  btn-sm">
                    登出
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-in-up-right"
                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M14.5 3A1.5 1.5 0 0 0 13 1.5H3A1.5 1.5 0 0 0 1.5 3v5a.5.5 0 0 0 1 0V3a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H9a.5.5 0 0 0 0 1h4a1.5 1.5 0 0 0 1.5-1.5V3z"/>
                        <path fill-rule="evenodd"
                              d="M4.5 6a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V6.5H5a.5.5 0 0 1-.5-.5z"/>
                        <path fill-rule="evenodd"
                              d="M10.354 5.646a.5.5 0 0 1 0 .708l-8 8a.5.5 0 0 1-.708-.708l8-8a.5.5 0 0 1 .708 0z"/>
                    </svg>
                </a>
            </li>
        </ul>
    </nav>

    <!-- 左侧菜单 -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">您好！{{session()->get('user')->username}}</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy" data-widget="treeview"
                    role="menu"
                    data-accordion="false">
                    @if(in_array('App\Http\Controllers\Admin\UserController@index',session()->get('permission')))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    用户管理
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/user" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>查看用户</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/user/add" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>添加用户</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endif

                    @if(in_array('App\Http\Controllers\Admin\RoleController@index',session()->get('permission')))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>
                                    角色管理
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/role" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>查看角色</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/role/add" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>添加角色</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if(in_array('App\Http\Controllers\Admin\PermissionController@index',session()->get('permission')))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-project-diagram"></i>
                                <p>
                                    权限管理
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/permission" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>查看权限</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/permission/add" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>添加权限</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                @endif

                <!-- <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                客户管理
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/customer" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>查看客户</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/customer/add" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>添加客户</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-dolly-flatbed"></i>
                            <p>
                                产品管理
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/product" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>查看产品</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/product/add" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>添加产品</p>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-dolly-flatbed"></i>
                            <p>
                                发票管理
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    {{--                                    <i class="far fa-circle nav-icon"></i>--}}
                                    <i class="fas fa-circle nav-icon"></i>
                                    <p>
                                        查看发票
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                {{--                                <a href="/admin/invoice" class="nav-link">--}}
                                {{--                                    <i class="far fa-circle nav-icon"></i>--}}
                                {{--                                    <p>查看发票</p>--}}
                                {{--                                </a>--}}
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/admin/invoice?invoice_company=10" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>上海双于</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/admin/invoice?invoice_company=20" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>深圳是方</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/admin/invoice?invoice_company=30" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>江西双格</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @if(in_array('App\Http\Controllers\Admin\InvoiceController@add',session()->get('permission')))
                                <li class="nav-item">
                                    <a href="/admin/invoice/add" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>添加发票</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- 右侧主内容 -->
    <div class="content-wrapper">
        @section('content-wrapper')@show
    </div>

    <!-- 网址注释 -->
    <footer class="main-footer" style="font-size:0.5em;">
        <strong>Copyright &copy; 2020 <a href="http://adminlte.io">
                上海双于通信技术有限公司</a>.</strong>All Right Reserved.
    </footer>
</div>


{{--<!-- AdminLTE App -->--}}
<script src="/admin/dist/js/adminlte.js"></script>
<!-- 数据表 -->
<script src="/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
{{--<script src="/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>--}}




<!-- AdminLTE for demo purposes -->
<script src="/admin/dist/js/demo.js"></script>
<!-- jQuery UI 1.11.4 -->
{{--<script src="/plugins/jquery-ui/jquery-ui.min.js"></script>--}}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{--<script>--}}
{{--    $.widget.bridge('uibutton', $.ui.button)--}}
{{--</script>--}}
<!-- Bootstrap 4 -->
<script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


{{--<!-- ChartJS -->--}}
{{--<script src="/admin/plugins/chart.js/Chart.min.js"></script>--}}
<!-- Sparkline -->
{{--<script src="/admin/plugins/sparklines/sparkline.js"></script>--}}
<!-- JQVMap -->
{{--<script src="/admin/plugins/jqvmap/jquery.vmap.min.js"></script>   //报错元凶--}}
{{--<script src="/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>--}}
<!-- jQuery Knob Chart -->
{{--<script src="/admin/plugins/jquery-knob/jquery.knob.min.js"></script>--}}


<!-- Summernote -->
{{--<script src="/admin/plugins/summernote/summernote-bs4.min.js"></script>--}}
<!-- overlayScrollbars -->
{{--<script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>--}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="/dist/js/pages/dashboard.js"></script>  //报错元凶  --}}
<!-- AdminLTE for demo purposes -->
<script src="/admin/dist/js/demo.js"></script>
{{--<script src="/admin/dist/js/adminlte.min.js"></script>   //阻碍菜单页弹出--}}
{{--<script src="/admin/plugins/sweetalert2/sweetalert2.min.js"></script>--}}

<script>
    function timeOut(url) {
        setTimeout(function () {
            window.location = url;
        }, 1000);
    }

    $(document).ready(function () {
        bsCustomFileInput.init();
    });

    function signRead() {

        $.ajax({
            type: "get",
            url: "/admin/invoice/signRead",
            dataType: 'json',
            success: function (data) {
                if (data.status == 1) {
                    toastr.info(data.message)
                    timeOut(window.location);
                }
                if (data.status == 0) {
                    toastr.error(data.message)
                    timeOut(window.location);
                }
            },
            error: function (data) {
                console.log(data)
            }
        })
    }

</script>
</body>
</html>