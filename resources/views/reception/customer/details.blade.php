@extends('reception.layout')
@section('content-wrapper')
    {{--
          数据展示
             +"id": 1001
              +"uid": 1001
              +"pid": 1001
              +"name": "产品123"
              +"service_mode": "高级服务"
              +"network_status": "已组网"
              +"machine_status": "10"
              +"url": "http://xxxxxx"
              +"rate": "3"
              +"connection_status": "7"
              +"description": ""
              +"device_status": 10
              +"end_at": null
              +"created_at": "2020-08-06 14:40:06"
              +"updated_at": null
              +"serial_num": "guh-fdb9631"
              +"product_name": "产品1111"
              +"model": "型号1号"
            --}}
    <style>
        .header-top {
            font-weight: 700;
            color: rgba(0, 0, 0, 0.6);
        }

        .header-title {
            color: rgba(0, 0, 0, 0.5);
        }

        .table.table-head-fixed thead tr:nth-child(1) th {
            background: rgba(245, 247, 250, 1);
            box-shadow: none;
        }
    </style>
    {{--  导航  --}}
    <div class="row">
        <ol class="breadcrumb float-sm-left" style="padding:0 0 0 20px;background: none!important;">
            <li class="breadcrumb-item">
                <a href="/customer/product?belong={{$customerProduct->belong_area}}">
                    {{$customerProduct->belong_area}}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="/customer/product">
                    <span>光盒</span>
                </a>
            </li>
            <li class="breadcrumb-item active">
                <span>详情</span>
            </li>
        </ol>
    </div>

    <!--  上层产品介绍  -->
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xs-12">
        <div class="card card-primary card-outline card-outline-tabs" style=" padding-left: 30px;">
            <div class="row" style="height:80px;display: flex;justify-content: space-between;">
                <div class="col-md-10" style="line-height: 80px;">
                    <span style="font-size: 20px;font-weight: bolder;">名称：{{$customerProduct->name}} (ID: {{$customerProduct->serial_num}})</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @if( $customerProduct->device_status == '10')
                        <span style="color:rgb(0,170,114);font-size: 12px;">
                            <i class="fas fa-circle" style="font-size: 11px;"></i>&nbsp;&nbsp;活跃&nbsp;
                        </span>
                    @else
                        <span style="color:red;font-size: 12px;">
                            <i class="fas fa-circle" style="font-size: 11px;"></i>&nbsp;&nbsp;已停止(欠费)&nbsp;
                        </span>
                        <a href="">[ 恢复 ]</a>
                    @endif
                </div>
                <div class="col-md-2">
                    <!-- 暂无-保留位置 -->
                </div>
            </div>


            <div class="row header-top" style="height: 140px;">
                <div class="col-md-4" style="line-height:40px;display: flex;flex-direction: column;">
                    <div>
                        <span class="header-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;序列号：&nbsp;&nbsp;</span>
                        <span>{{$customerProduct->serial_num}}</span>
                    </div>
                    <div>
                        <span class="header-title">组网状态：&nbsp;&nbsp;</span>
                        @if($customerProduct->network_status == 10)
                            <span style='color:rgb(0,170,114)'>已组网</span>
                        @else
                            <span style='color:rgba(255,0,0,0.8)'>未组网</span>
                        @endif
                    </div>
                    <div>
                        <span class="header-title">创建时间：&nbsp;&nbsp;</span>
                        <span>{{$customerProduct->created_at}}</span>
                    </div>
                </div>
                <div class="col-md-4" style="line-height:40px;">
                    <div>
                        <span class="header-title">型号：&nbsp;&nbsp;</span>
                        <span>{{$customerProduct->model}}</span>
                    </div>
                    <div>
                        <span class="header-title">带宽：&nbsp;&nbsp;</span>
                        <span>{{$customerProduct->machine_status}} Mbps</span>
                    </div>
                    <div>
                        <span class="header-title">到期时间：&nbsp;&nbsp;</span>
                        <span>{{$customerProduct->end_at}}</span>
                    </div>
                </div>
                <div class="col-md-4" style="line-height:40px;">
                    <div>
                        <span class="header-title">服务模式：&nbsp;&nbsp;</span>
                        <span>
                            <i class="fas fa-project-diagram"
                               style="border: 3px solid rgb(0,170,114);background:rgb(0,170,114);color: white;"></i>
                            {{$customerProduct->service_mode}}
                        </span>
                    </div>
                    <div>
                        <span class="header-title">URL：&nbsp;&nbsp;</span>
                        <span>
                            {{$customerProduct->url}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xs-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <!-- 下层顶部导航 列：管理配置 操作日志 监控  -->
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                           href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                           aria-selected="true">
                            <i class="fas fa-cogs"></i>&nbsp;&nbsp;管理配置</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                           href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                           aria-selected="false"><i class="far fa-clock"></i>&nbsp;&nbsp;操作日志</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill"
                           href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages"
                           aria-selected="false"><i class="fas fa-chart-area"></i>&nbsp;&nbsp;监控</a>
                    </li>

                </ul>
            </div>
            <!-- 对应的显示区域  -->
            <div class="card-body" style="padding:0;">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <!-- 对应的显示区域  管理配置 -->
                    <div class="tab-pane fade show active" id="custom-tabs-four-home"
                         role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <div class="row">
                            <!-- 管理配置下左侧导航栏 例： 端口配置 路由配置 安全配置 设备配置 -->
                            <div class="col-3 col-sm-2">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                     aria-orientation="vertical">
                                    <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill"
                                       href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home"
                                       aria-selected="true">端口配置</a>
                                    <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill"
                                       href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile"
                                       aria-selected="false">路由配置</a>
{{--                                    <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill"--}}
{{--                                       href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages"--}}
{{--                                       aria-selected="false">安全配置</a>--}}
{{--                                    <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill"--}}
{{--                                       href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings"--}}
{{--                                       aria-selected="false">设备配置</a>--}}
                                </div>
                            </div>
                            <!-- 管理配置下 右侧 各分层配置 -->
                            <div class="col-9 col-sm-10">
                                <div class="tab-content" id="vert-tabs-tabContent">
                                    <!-- 端口配置 -->
                                    <div class="tab-pane text-left fade show active" id="vert-tabs-home"
                                         role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card" style="box-shadow: none;">
{{--                                                    <div class="card-header" style="border:none;">--}}
                                                        <!-- 搜索input框 按钮 -->
                                                        {{--                                                        <div class="card-tools">--}}
                                                        {{--                                                            <div class="input-group input-group-sm"--}}
                                                        {{--                                                                 style="width: 150px;">--}}
                                                        {{--                                                                <input type="text" name="table_search"--}}
                                                        {{--                                                                       class="form-control float-right"--}}
                                                        {{--                                                                       placeholder="Search">--}}
                                                        {{--                                                                <div class="input-group-append">--}}
                                                        {{--                                                                    <button type="submit" class="btn btn-default"><i--}}
                                                        {{--                                                                                class="fas fa-search"></i></button>--}}
                                                        {{--                                                                </div>--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                    <div class="card-body table-responsive p-0">
                                                        <table class="table table-head-fixed text-nowrap">
                                                            <thead>
                                                            <tr>
                                                                <th>接口名称</th>
                                                                <th>端口名称</th>
                                                                <th>IP地址</th>
                                                                <th>类型</th>
{{--                                                                <th>操作</th>--}}
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>App\Http\Controllers\Product</td>
                                                                <td>产品端口</td>
                                                                <td>192.168.60.162</td>
                                                                <td>Approved</td>
{{--                                                                <td><a href="">修改</a></td>--}}
                                                            </tr>
                                                            <tr>
                                                                <td>App\Http\Controllers\Product</td>
                                                                <td>产品端口</td>
                                                                <td>192.168.60.162</td>
                                                                <td>Approved</td>
{{--                                                                <td><a href="">修改</a></td>--}}
                                                            </tr>
                                                            <tr>
                                                                <td>App\Http\Controllers\Product</td>
                                                                <td>产品端口</td>
                                                                <td>192.168.60.162</td>
                                                                <td>Denied</td>
{{--                                                                <td><a href="">修改</a></td>--}}
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 路由配置 -->
                                    <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel"
                                         aria-labelledby="vert-tabs-profile-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card" style="box-shadow: none;">
                                                    <div class="card-body table-responsive p-0">
                                                        <table class="table table-head-fixed text-nowrap">
                                                            <thead>
                                                            <tr>
                                                                <th>路由名称</th>
                                                                <th>路由地址</th>
                                                                {{--                                                                <th>操作</th>--}}
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>路由名称</td>
                                                                <td>192.168.60.162</td>
                                                            </tr>
                                                            <tr>
                                                                <td>路由名称</td>
                                                                <td>192.168.60.162</td>                                                            </tr>
                                                            <tr>
                                                                <td>路由名称</td>
                                                                <td>192.168.60.162</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 安全配置 -->
                                    <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel"
                                         aria-labelledby="vert-tabs-messages-tab">
                                        暂无内容
                                    </div>
                                    <!-- 设备配置 -->
                                    <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel"
                                         aria-labelledby="vert-tabs-settings-tab">
                                        暂无内容
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 对应的显示区域  操作日志 -->
                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                         aria-labelledby="custom-tabs-four-profile-tab">
                        <section class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h1>操作日志</h1>
                                    </div>
                                    {{--                                    <div class="col-sm-6">--}}
                                    {{--                                        <div style=""><input type="text" placeholder="相关资源id"></div>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                        </section>
                        <section class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="timeline">
                                            <div class="time-label">
                                                <span class="bg-red">2020年</span>
                                            </div>

                                            <div>
                                                <i class="fas fa-user bg-green"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> 2020-07-06 18:13:08</span>
                                                    <h3 class="timeline-header">
                                                        <a href="">应用光盒</a>
                                                    </h3>
                                                    <div class="timeline-body">
                                                        任务状态: 成功
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-user bg-green"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> 2020-07-06 20:13:08</span>
                                                    <h3 class="timeline-header">
                                                        <a href="">应用光盒</a>
                                                    </h3>
                                                    <div class="timeline-body">
                                                        任务状态: 成功
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-comments bg-yellow"></i>
                                                <div class="timeline-item">
                                                    <span class="time">
                                                        <i class="fas fa-clock"></i> 27 分钟以前
                                                    </span>
                                                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on
                                                        your post</h3>
                                                    <div class="timeline-body">
                                                        Take me to your leader!
                                                        Switzerland is small and neutral!
                                                        We are more like Germany, ambitious and misunderstood!
                                                    </div>
                                                    <div class="timeline-footer">
                                                        <a class="btn btn-warning btn-sm">View comment</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="time-label">
                                                <span class="bg-green">2019年</span>
                                            </div>
                                            <div>
                                                <i class="fas fa-user bg-green"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> 2019-07-06 18:13:08</span>
                                                    <h3 class="timeline-header">
                                                        <a href="">应用光盒</a>
                                                    </h3>
                                                    <div class="timeline-body">
                                                        任务状态: 成功
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <i class="fas fa-user bg-green"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> 2019-07-06 20:13:08</span>
                                                    <h3 class="timeline-header">
                                                        <a href="">应用光盒</a>
                                                    </h3>
                                                    <div class="timeline-body">
                                                        任务状态: 成功
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- 对应的显示区域  监控 -->
                    <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel"
                         aria-labelledby="custom-tabs-four-messages-tab">
                        <div class="row">
                            <div class="col-12">
                                <!-- interactive chart -->
                                <div class="card-header">
                                    <div class="container-fluid">
                                        <div class="row mb-2">
                                            <div class="col-sm-6"
                                                 style="display: flex;flex-direction: column; justify-content: center">
                                                <div class="form-group" style="padding:0;margin:0;">
                                                    <label for="inputStatus">监控对象&nbsp;&nbsp;<i
                                                                class="fas fa-info-circle"></i>&nbsp;&nbsp;&nbsp;</label>
                                                    <select class="form-control custom-select"
                                                            style="width: 200px;">
                                                        <option selected="" disabled="">外网 eth0</option>
                                                        <option>On Hold</option>
                                                        <option>Canceled</option>
                                                        <option>Success</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card-body table-responsive pad">
                                                    <div class="btn-group btn-group-toggle"
                                                         data-toggle="buttons">
                                                        <label class="btn bg-olive active">
                                                            <input type="radio" name="options" id="option1"
                                                                   autocomplete="off" checked>最近6小时
                                                        </label>
                                                        <label class="btn bg-olive">
                                                            <input type="radio" name="options" id="option2"
                                                                   autocomplete="off">最近一天
                                                        </label>
                                                        <label class="btn bg-olive">
                                                            <input type="radio" name="options" id="option3"
                                                                   autocomplete="off">最近两周
                                                        </label>
                                                        <label class="btn bg-olive">
                                                            <input type="radio" name="options" id="option3"
                                                                   autocomplete="off">最近一个月
                                                        </label>
                                                        <label class="btn bg-olive">
                                                            <input type="radio" name="options" id="option3"
                                                                   autocomplete="off">最近六个月
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="card-title">
                                        <i class="far fa-chart-bar"></i>
                                        Interactive Area Chart
                                    </h3>

                                    <div class="card-tools">
                                        Real time
                                        <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                                            <button type="button" class="btn btn-default btn-sm active"
                                                    data-toggle="on">On
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm"
                                                    data-toggle="off">Off
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="interactive" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 对应的显示区域  监控2 -->
                </div>
            </div>
        </div>
    </div>

    <!-- flot  -->
    <script>
        // 数据格式
        // let arr = [
        //     [0, 5.5068493670518],
        //     [1, 30.5068493670518],
        //     [2, 1.5068493670518],
        //     [3, 30.5068493670518],
        //     [4, 8.5068493670518],
        //     [5, 3.5068493670518],
        //     [6, 70.5068493670518],
        //     [7, 3.5068493670518],
        //     [8, 50.5068493670518],
        //     [9, 30.5068493670518],
        // ];


        $(function () {
            //我们在示例中使用了一个内联数据源，通常数据
            //从服务器获取
            let data = [];
            let totalPoints = 100;

            //随机获取
            function getRandomData() {

                if (data.length > 0) {
                    data = data.slice(1)
                }

                // 随便走走
                while (data.length < totalPoints) {

                    let prev = data.length > 0 ? data[data.length - 1] : 50;
                    let y = prev + Math.random() * 10 - 5;

                    if (y < 0) {
                        y = 0
                    } else if (y > 100) {
                        y = 100
                    }

                    data.push(y)
                }

                // 用x值压缩生成的y值
                let res = [];
                for (let i = 0; i < data.length; ++i) {
                    res.push([i, data[i]])
                }

                return res
            }


            let interactive_plot = $.plot('#interactive', [
                    {
                        data: getRandomData(),
                    }
                ],
                {
                    grid: {
                        borderColor: 'f3f3f3',//xy轴边框线
                        borderWidth: 1,//边框宽度
                        tickColor: '#f3f3f3'//网格线
                    },
                    series: {
                        color: '#3c8dbc', //图的颜色
                        lines: {
                            lineWidth: 2,//图上线的宽度
                            show: true, //是否显示
                            fill: true,//线下方是否显示
                        },
                    },
                    yaxis: {
                        min: 0,   //图表最小值
                        max: 100, //图表最大值
                        show: true //y轴是否显示数字
                    },
                    xaxis: {
                        show: true  //x轴数字是否显示
                    }
                }
            );

            let updateInterval = 500; ////每次取数x毫秒
            let realtime = 'on'; //如果==打开，则每隔x秒获取一次数据。否则别再拿了

            //每隔多少时间更新数据
            function update() {
                //设置数据
                interactive_plot.setData([getRandomData()])

                // 既然轴不变，我们就不用打电话了 plot.setupGrid()
                interactive_plot.draw();

                if (realtime === 'on') {
                    setTimeout(update, updateInterval)
                }
            }

            //初始化实时数据获取
            if (realtime === 'on') {
                update()
            }

            //实时切换 开关切换是否获取数据
            $('#realtime .btn').click(function () {
                if ($(this).data('toggle') === 'on') {
                    realtime = 'on'
                } else {
                    realtime = 'off'
                }
                update()
            });

        });

    </script>

@endsection