@extends('reception.layout')
@section('content-wrapper')
    <div class="row">
        <ol class="breadcrumb float-sm-left" style="padding:0 0 0 20px;background: none!important;">
            <li class="breadcrumb-item">
                <a href="#">
                    <span style="vertical-align: inherit;">
                        <span style="vertical-align: inherit;">
                            {{empty(request()->get('belong'))?'全部地区11':request()->get('belong') =='all'?'全部地区':request()->get('belong')}}
                        </span>
                    </span>
                </a>
            </li>
            <li class="breadcrumb-item active">
                    <span style="vertical-align: inherit;">
                        <span style="vertical-align: inherit;">
                            光盒
                        </span>
                    </span>
            </li>
        </ol>
    </div>

    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xs-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                           href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                           aria-selected="true">光盒</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                           href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                           aria-selected="false">全局配置管理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill"
                           href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages"
                           aria-selected="false">申请光盒</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-home"
                         role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card" style="box-shadow:none;">
                                        <div class="card-body p-0">

                                            <!--  表格上方内容 -->
                                            <div class="mailbox-controls" id="mailbox-controls"
                                                 style="margin-bottom: 10px;">


                                                <!-- 刷新 -->
                                                <a href="{{url('/customer/product')}}">
                                                    <button type="button" class="btn btn-default btn-sm"
                                                            style="background: rgb(62, 82, 101); color: white;height: 35px;width: 42px;">
                                                        <i class="fas fa-sync-alt" style="font-size: 13px;"></i>
                                                    </button>
                                                </a>
                                                <a class="btn btn-default" href="/customer/product?belong=all">全部</a>

                                                @foreach($belong_areas as $item)
                                                    <a class="btn btn-default"
                                                       href="/customer/product?belong={{$item}}">{{$item}}</a>
                                                @endforeach
                                            <!-- 删除 -->
                                                {{--                                                <button type="button" class="btn btn-default btn-sm"--}}
                                                {{--                                                        onclick="deleteProduct()"--}}
                                                {{--                                                        style="background: rgb(62, 82, 101); color: white;height: 35px;width: 42px;">--}}
                                                {{--                                                    <i class="far fa-trash-alt" style="font-size: 15px;"></i>--}}
                                                {{--                                                </button>--}}

                                            <!-- 创建接入点 -->
                                                {{--                                                <a href="{{url('/customer/product/add')}}" style="float:right">--}}
                                                {{--                                                    <button type="button" class="btn btn-default btn-sm"--}}
                                                {{--                                                            style="background: rgb(0,170,114); color: white;height: 35px;">--}}
                                                {{--                                                        <i class="fas fa-plus">--}}
                                                {{--                                                        <span style="font-weight:bold;font-size: 11px;">--}}
                                                {{--                                                            &nbsp;创建接入点--}}
                                                {{--                                                        </span>--}}
                                                {{--                                                        </i>--}}
                                                {{--                                                    </button>--}}
                                                {{--                                                </a>--}}

                                                {{--                                                <!-- 搜索框 -->--}}
                                                {{--                                                <button style="margin: 0;padding: 0;font-size: 100%;border:none;outline: none;">--}}
                                                {{--                                                    <div class="input-group input-group-sm" style="height: 35px;">--}}
                                                {{--                                                        <input type="text" id="serch_name" class="form-control" style="height: 35px;"--}}
                                                {{--                                                               placeholder="请输入查询设备的序列号">--}}
                                                {{--                                                        <div class="input-group-append" onclick="search_product()">--}}
                                                {{--                                                            <div class="btn btn-primary">--}}
                                                {{--                                                                <i class="fas fa-search"></i>--}}
                                                {{--                                                            </div>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </button>--}}

                                            <!--  分页 -->
                                                {{--                                                <div class="float-right">--}}
                                                {{--                                                    1-50/200--}}
                                                {{--                                                    <div class="btn-group">--}}
                                                {{--                                                        <button type="button" class="btn btn-default btn-sm">--}}
                                                {{--                                                            <i class="fas fa-chevron-left"></i>--}}
                                                {{--                                                        </button>--}}
                                                {{--                                                        <button type="button" class="btn btn-default btn-sm">--}}
                                                {{--                                                            <i class="fas fa-chevron-right"></i>--}}
                                                {{--                                                        </button>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                            </div>

                                            <!-- 表格内容 -->
                                            <div class="table-responsive mailbox-messages">


                                                <table id="example1"
                                                       class="table table-hover table-striped table-bordered "
                                                       style="font-size:14px;">
                                                    <thead>
                                                    <tr>
                                                    {{--                                                        <th>--}}
                                                    {{--                                                            <div class="icheck-primary">--}}
                                                    {{--                                                                <input type="checkbox" value="" id="check1">--}}
                                                    {{--                                                                <label for="check1"></label>--}}
                                                    {{--                                                            </div>--}}
                                                    <!-- 选中全部 -->
                                                        {{--              <button type="button" class="btn btn-default btn-sm checkbox-toggle">--}}
                                                        {{--             <i class="far fa-square"></i>--}}
                                                        {{--             </button>--}}
                                                        {{--                                                        </th>--}}
                                                        <th>产品id/序列号</th>
                                                        <th>设备名称</th>
                                                        <th>状态</th>
                                                        <th>服务模式</th>
                                                        <th>组网状态</th>
                                                        <th>型号</th>
                                                        <th>双机</th>
                                                        <th>URL</th>
                                                        <th>带宽</th>
                                                        <th>连接状态</th>
                                                        {{--      <th>备注</th>--}}
                                                        <th>创建时间</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    {{csrf_field()}}
                                                    {{--  service_mode服务模式  service_mode组网状态 machine_status双机 url路由 rate带宽
                                                    connection_status连接状态 这六个应该是设备给的接口给出的实时数据   --}}
                                                    @foreach($productList as $item)
                                                        <tr>
                                                            {{--                                                            <td>--}}
                                                            {{--                                                                <div class="icheck-primary">--}}
                                                            {{--                                                                    <input type="checkbox" value="" class="checkbox"--}}
                                                            {{--                                                                           id="{{$item->pivot->id}}">--}}
                                                            {{--                                                                    <label for="{{$item->pivot->id}}"></label>--}}
                                                            {{--                                                                </div>--}}
                                                            {{--                                                            </td>--}}
                                                            {{--    <td>{{$item->pivot->id}}</td>--}}
                                                            <td>
                                                                <a href="{{url('/customer/product/details?id='.$item->pivot->id)}}">
                                                                    {{$item->serial_num}}
                                                                </a>
                                                            </td>

                                                            <td class="product_name" onclick="edit_product_name(this)">
                                                                <span class="product_name_span">{{$item->pivot->name}}</span>
                                                                <input style="display:none;" type="text"
                                                                       id="product_name_{{$item->pivot->id}}"
                                                                       class="product_name_input" name="product_name"
                                                                       value="" onblur="sub_product_name(this)"/>
                                                            </td>

                                                            <td>
                                                                @if( $item->pivot->device_status == '10')
                                                                    <span style="color:rgb(0,170,114)">正常使用</span>
                                                                @else
                                                                    <span style="color:red;">
                                                                        <i class="fas fa-circle"
                                                                           style="font-size: 11px;"></i>
                                                                        已停止(欠费)&nbsp;
                                                                    </span>
                                                                    <a href="">[ 恢复 ]</a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <i class="fas fa-project-diagram"
                                                                   style="border: 3px solid rgb(0,170,114);background:rgb(0,170,114);color: white;"></i>
                                                                {{$item->pivot->service_mode}}
                                                            </td>
                                                            <td>
                                                                @if($item->pivot->network_status == 10)
                                                                    <span style='color:rgb(0,170,114)'>已组网</span>
                                                                @else
                                                                    <span>未组网</span>
                                                                @endif
                                                            </td>
                                                            <td>{{$item->model}}</td>
                                                            <td>未启用</td>{{-- {{$item->pivot->rate}} --}}
                                                            <td>{{$item->pivot->url}}</td>
                                                            <td>{{$item->pivot->machine_status}}Mbps</td>
                                                            <td>
                                                                <span class="bg-green"
                                                                      style="background:rgb(0,170,114)!important;display: inline-block; width: 100%;line-height:24px;text-align:center;border-radius: 4px;">
                                                                    {{$item->pivot->connection_status}}ms
                                                                </span>
                                                            </td>
                                                            {{--                                                            <td>{{$item->pivot->description}}</td>--}}
                                                            <td>{{ abs(ceil((time() - strtotime($item->pivot->created_at))/86400)) }}
                                                                天前
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                         aria-labelledby="custom-tabs-four-profile-tab">
                        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut
                        ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                        Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus
                        ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc
                        euismod pellentesque diam.
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel"
                         aria-labelledby="custom-tabs-four-messages-tab">
                        Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue
                        id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac
                        tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit
                        condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus
                        tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet
                        sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum
                        gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend
                        ac ornare magna.
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel"
                         aria-labelledby="custom-tabs-four-settings-tab">
                        Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis
                        ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate.
                        Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec
                        interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at
                        consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst.
                        Praesent imperdiet accumsan ex sit amet facilisis.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "bLengthChange": true, //开关，是否显示每页显示多少条数据的下拉框
                "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "所有"]],//设置每页显示数据条数的下拉选项
                'iDisplayLength': 5, //每页初始显示5条记录
                'bFilter': true,  //是否使用内置的过滤功能（是否去掉搜索框）
                "bPaginate": true, //开关，是否显示分页器
                "bSort": true, //是否可排序 
                // "pagingType": "full_numbers",  //显示尾页和首页
                "language": {
                    search: "搜索："
                },
                "oLanguage": {  //语言转换
                    "sInfo": "显示第 _START_ - _END_ 项，共 _TOTAL_ 项",
                    "sLengthMenu": "每页显示 _MENU_ 项结果",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "前一页",
                        "sNext": "后一页",
                        "sLast": "尾页"
                    }

                }
            });

        });


        //全选
        $('#check1').change(function () {
            let obj = $('.checkbox');
            if ($(this).prop('checked') == true) {
                for (let i = 0; i < obj.length; i++) {
                    $(obj[i]).prop('checked', true)
                }
            } else {
                for (let i = 0; i < obj.length; i++) {
                    $(obj[i]).prop('checked', false)
                }
            }
        });

        //删除设备
        function deleteProduct() {
            let obj = $('.checkbox');
            let count = 0; //计数有没有选中条目
            for (let i = 0; i < obj.length; i++) {
                if ($(obj[i]).prop('checked') == true) {
                    count++;
                }
            }

            if (count > 0) {
                if (confirm('确定要删除吗') == true) {
                    let obj = $('.checkbox');
                    for (let i = 0; i < obj.length; i++) {
                        if ($(obj[i]).prop('checked') == true) {
                            $.ajax({
                                type: "post",
                                url: "/customer/product/delete",
                                dataType: 'json',
                                data: {
                                    'id': obj[i].id,
                                    "_token": $("[name='_token']").val()
                                },
                                success: function (data) {
                                    if (data.status == 1) {
                                        toastr.success(data.message)
                                        setTimeout(function () {
                                            window.location = '/customer/product';
                                        }, 1000)
                                    }
                                    if (data.status == 0) {
                                        toastr.error(data.message)
                                    }
                                },
                                error: function (data) {
                                    console.log(data)
                                }
                            })
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            }

        }

        //点击名称 表格变表单
        function edit_product_name(obj) {
            $(obj).children('span').css('display', 'none');//span消失
            $(obj).children('input').css('display', 'block');//换成表单
            $(obj).children('input').val($(obj).children('span').html()); //span内容赋值给表单
            $(obj).children('input').focus();

            // $(obj).children('input').change(function () {//表单改变事件
            // $(obj).children('span').html(this.value)//每次表单输入内容重新赋值给span
            // });
            //** 修改产品名
            $(obj).children('input').unbind('keypress').bind('keypress', function (e) {//表单回车事件
                let id = $(obj).children('input').attr('id').split("_")[2]; //获取产品id

                if (e.which == 13) {
                    $(obj).children('span').html($(obj).children('input').val());//表单值赋值给span
                    $(obj).children('input').css('display', 'none');//表单消失
                    $(obj).children('span').css('display', 'block');//span出现
                    $.ajax({
                        type: "get",
                        url: "/customer/product/update",
                        dataType: 'json',
                        data: {
                            'id': id,
                            'name': $(obj).children('input').val()
                        },
                        success: function (data) {
                            if (data.status == 1) {
                                toastr.success(data.message)
                                // setTimeout(function () {
                                //     window.location = '/customer/product';
                                // }, 1000)
                            }
                            if (data.status == 0) {
                                toastr.error(data.message)
                            }
                        },
                        error: function (data) {
                            console.log(data)
                        }
                    })
                }
            })


            // $(obj).children('input').keypress(function (e) {//表单回车事件
            //     let id = $(obj).children('input').attr('id').split("_")[2]; //获取产品id
            //
            //     if(e.which == 13){
            //         console.log(123)
            //         $(obj).children('span').html($(obj).children('input').val());//表单值赋值给span
            //         $(obj).children('input').css('display', 'none');//表单消失
            //         $(obj).children('span').css('display', 'block');//span出现
            //         $.ajax({
            //             type: "get",
            //             url: "/customer/product/update",
            //             dataType: 'json',
            //             data: {
            //                 'id': id,
            //             },
            //             success: function (data) {
            //                 if (data.status == 1) {
            //                     toastr.success(data.message)
            //                     setTimeout(function () {
            //                         window.location = '/customer/product';
            //                     }, 1000)
            //                 }
            //                 if (data.status == 0) {
            //                     toastr.error(data.message)
            //                 }
            //             },
            //             error: function (data) {
            //                 console.log(data)
            //             }
            //         })
            //     }
            // })
        }

        //表单失焦 提交产品名
        function sub_product_name(object) {
            let obj = $(object).parent();//获取td单元格 表单的父级元素
            // $(obj).children('span').html($(object).val());//表单失焦时 表单值赋值给span
            $(obj).children('input').css('display', 'none');//表单消失
            $(obj).children('span').css('display', 'block');//span出现
        }

        //根据输入内容查询用户名下产品
        function search_product() {
            let search_name = $('#serch_name').val()


        }

        //查询标签产品地址
        function query_address(obj) {
            console.log($("input"))

            $.ajax({
                type: "get",
                url: "/customer/product",
                dataType: 'json',
                data: {
                    'belong': obj.innerHTML,
                },
                success: function (data) {
                    // if (data.status == 1) {
                    //     toastr.success(data.message)
                    //     setTimeout(function () {
                    //         window.location = '/customer/product';
                    //     }, 1000)
                    // }
                    // if (data.status == 0) {
                    //     toastr.error(data.message)
                    // }
                },
                error: function (data) {
                    // console.log(data)
                }
            })
        }
    </script>


@endsection