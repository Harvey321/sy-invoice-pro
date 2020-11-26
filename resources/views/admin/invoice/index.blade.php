@extends('admin.user.layout')
@section('content-wrapper')

    <!-- 标题栏 -->
    <section class="content-header">
        <!-- 模态框  -->
        <div class="modal fade" id="modal-sm" data-orderId>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        {{--                        <h4 class="modal-title">确认框</h4>--}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>请问您确认要删除此记录吗？</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" id="url"/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" onclick="urlSubmit()">确认删除</button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- 新表格 -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">发票列表</h3>
                            <div>

                            </div>
                        </div>
                        <div class="card-header">
                            {{--                            <div class="input-group">--}}
                            {{--                                <div class="input-group-prepend">--}}
                            {{--                                  <span class="input-group-text">--}}
                            {{--                                    <i class="far fa-calendar-alt"></i>--}}
                            {{--                                  </span>--}}
                            {{--                                </div>--}}
                            {{--                                <input type="text" class="form-control float-right" id="reservation">--}}
                            {{--                            </div>--}}

                            <div class="row">
                                <div class="col-1 d-flex flex-row justify-content-center align-items-center">
                                    <b>查询日期范围:</b>
                                </div>
                                <div class="col-4">

                                    <form action="/" method="get">
                                        <div class="input-group date" id="reservationdate-month"
                                             data-date-format="yyyy-mm-dd">
                                            <input class='input-group date form-control datetimepicker-input input-group-append'
                                                   placeholder="请输入开票月份" style="width: 250px!important;"
                                                   type="month" name="month_old" id="month_old"
                                                   value="{{isset($month_old) == true ? date('Y-m',$month_old) : date('Y-m',strtotime('-1 month'))}}"/>
                                            <input class='input-group date form-control datetimepicker-input input-group-append'
                                                   placeholder="请输入开票月份" style="width: 250px"
                                                   type="month" name="month_new" id="month_new"
                                                   value="{{isset($month_new) == true ? date('Y-m',$month_new) : date('Y-m',strtotime('0 month'))}}"/>
                                            <button class="btn btn-default" href="/">搜索</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-7 d-flex flex-row justify-content-end">
                                    <button class="btn btn-info"><a onclick="getUrl()">导出当前票据</a></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped  ">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>crmID</th>
                                    <th>业务员名</th>
                                    <th>客户名</th>
                                    <th>开票名</th>
                                    <th>税号</th>
                                    <th>地址</th>
                                    <th>电话</th>
                                    <th>金额</th>
                                    <th>开票月份</th>
                                    <th>终止日</th>
                                    <th>状态</th>
                                    <th>创建时间</th>
                                    @if(in_array('App\Http\Controllers\Admin\InvoiceController@edit',session()->get('permission')))
                                        <th class="none">操作</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataList as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->crm_id}}</td>
                                        <td>{{$item->business_name}}</td>
                                        <td>{{$item->customer_name}}</td>
                                        <td>{{$item->ticket_name}}</td>
                                        <td>{{$item->tax_num}}</td>
                                        <td>{{$item->address}}</td>
                                        <td>{{$item->mobile}}</td>
                                        <td>{{$item->money}}</td>
                                        <td>{{ date('Y-m',$item->ticket_month) }}</td>
                                        {{--                                        <td>{{$item->ticket_month}}</td>--}}
                                        <td>{{$item->ticket_day}}</td>
                                        <td>
                                            {{$item->status == 10? '状态正常': '发票作废'}}
                                        </td>
                                        <td>{{$item->created_at}}</td>
                                        @if(in_array('App\Http\Controllers\Admin\InvoiceController@edit',session()->get('permission')))
                                            <td>
                                                <a href="/admin/invoice/edit?id={{$item->id}}"
                                                   class="btn btn-block bg-gradient-primary btn-xs"
                                                   style="margin-right:4px;margin-top:5px;max-width: 100px;min-width: 80px;">编辑
                                                </a>
                                                <a href="" onclick="setDelUrl({{$item->id}})"
                                                   class="btn btn-block bg-gradient-danger btn-xs"
                                                   data-toggle="modal" data-target="#modal-sm"
                                                   data-orderId="{{$item->id}}"
                                                   style="margin-top:5px;max-width: 100px;min-width: 80px;">删除
                                                </a>
                                            </td>
                                        @endif
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

    <script>
        function getUrl(){
            let href = '/admin/invoice/ExcelGet' + window.location.search;
            window.location = href;
        }


        $(function () {
            $("#example1").DataTable({
                "responsive": false,
                // "autoWidth": true,
                // "scrollX": true,
                "bLengthChange": true, //开关，是否显示每页显示多少条数据的下拉框
                "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "所有"]],//设置每页显示数据条数的下拉选项
                'iDisplayLength': 10, //每页初始显示5条记录
                'bFilter': true,  //是否使用内置的过滤功能（是否去掉搜索框）
                "bPaginate": true, //开关，是否显示分页器
                "bSort": true, //是否可排序 
                // "pagingType": "full_numbers",  //显示尾页和首页
                "language": {
                    search: "搜索："
                },
                // "columnDefs": [
                //     { "width": "5%", "targets": 0 },
                //     { "width": "10%", "targets": 1 },
                //     { "width": "6%", "targets": 2 },
                //     { "width": "6%", "targets": 3 },
                //     { "width": "15%", "targets": 4 },
                //     { "width": "10%", "targets": 5 },
                //     { "width": "15%", "targets": 6 },
                //     { "width": "10%", "targets": 7 },
                //     { "width": "10%", "targets": 8 },
                //     { "width": "15%", "targets": 9 },
                //     { "width": "10%", "targets": 10 },
                //     { "width": "10%", "targets": 11 },
                //     { "width": "10%", "targets": 12 },
                //     { "width": "10%", "targets": 13 },
                // ],
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


        function setDelUrl(id) {
            let url = '/admin/invoice/delete?id=' + id;
            $('#url').val(url);  //给会话中的隐藏属性URL赋值
            $('#modal-sm').modal();
        }

        function urlSubmit() {
            let url = $.trim($("#url").val());//获取会话中的隐藏属性URL
            $.ajax({
                type: "get",
                url: url,
                dataType: 'json',
                data: {},
                success: function (data) {
                    //隐藏模态确认框
                    $('#modal-sm').modal('hide');
                    //显示模态提示框
                    if (data.status == 1) {
                        toastr.success(data.message);
                        timeOut('/admin/invoice')
                    }
                    if (data.status == 0) {
                        toastr.error(data.message);
                        timeOut('/admin/invoice')
                    }
                },
                error: function (data) {
                    console.log(data)
                }
            })
        }

        function timeOut() {
            setTimeout(function () {
                location.reload();
            }, 2000);
        }

    </script>


@endsection