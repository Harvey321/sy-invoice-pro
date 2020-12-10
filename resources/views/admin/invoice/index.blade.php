@extends('admin.user.layout')
@section('content-wrapper')
    <style>
        .button-left-margin {
            margin-left: 10px;
        }
    </style>
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
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-10">
                                    <form action="/" method="get">
                                        <div class="input-group date d-flex flex-row align-items-center"
                                             id="reservationdate-month" data-date-format="yyyy-mm-dd">
                                            <label style="margin-right:20px;">查询范围:</label>
                                            <input class='input-group date form-control datetimepicker-input input-group-append'
                                                   placeholder="请输入开票月份" style="width: 250px!important;"
                                                   type="month" name="month_old" id="month_old"
                                                   value="{{isset($month_old) == true ? date('Y-m',$month_old) : date('Y-m',strtotime('-1 month'))}}"/>
                                            <input class='input-group date form-control datetimepicker-input input-group-append'
                                                   placeholder="请输入开票月份" style="width: 250px"
                                                   type="month" name="month_new" id="month_new"
                                                   value="{{isset($month_new) == true ? date('Y-m',$month_new) : date('Y-m',strtotime('0 month'))}}"/>

                                            <button class="btn btn-default button-left-margin" href="/">搜索</button>
                                            <a class="btn btn-info button-left-margin"
                                               href="{{'/?month_old='.date('Y-m').'&month_new='.date('Y-m')}}">当前月</a>
                                            <a class="btn btn-info button-left-margin"
                                               href="{{'/?month_old='.date('Y-m', strtotime("-2 month")).'&month_new='.date('Y-m')}}">近三月</a>
                                            <a class="btn btn-info button-left-margin"
                                               href="{{'/?month_old='.date('Y-m', strtotime("-5 month")).'&month_new='.date('Y-m')}}">近半年</a>
                                            <a class="btn btn-info button-left-margin"
                                               href="{{'/?month_old='.date('Y-m', strtotime("-11 month")).'&month_new='.date('Y-m')}}">近一年</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-2 d-flex flex-row justify-content-end">
                                    <button class="btn btn-info"><a onclick="getUrl()">导出当前票据</a></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
{{--                            style="overflow: scroll;"--}}
                            <table id="example1" class="table table-bordered table-striped  ">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>crmID</th>
                                    <th>开票公司</th>
                                    <th class="none">业务员名</th>
                                    <th>公司名</th>
                                    <th>开票名</th>
                                    <th>税号</th>
                                    <th>地址/电话</th>
                                    <th>开户行/账户</th>
                                    <th>金额</th>
                                    <th>发票类型</th>
                                    <th class="none">快递信息</th>
                                    <th class="none">快递单号</th>
                                    <th>开票月份</th>
                                    <th class="none">到期提醒日</th>
                                    <th>状态</th>
                                    <th>备注</th>
                                    {{--                                    <th>创建时间</th>--}}
                                    <th class="none">操作</th>
                                </tr>
                                </thead>
                                <tbody>
<!--                                --><?php //dd($dataList); ?>
                                @foreach($dataList as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->crm_id}}</td>
                                        <td>
                                            {{$item->invoice_company == '10'?'上海双于通信技术有限公司':''}}
                                            {{$item->invoice_company == '20'?'深圳是方通信技术有限公司':''}}
                                            {{$item->invoice_company == '30'?'江西双格通信技术有限公司':''}}
                                        </td>
                                        <td>
                                            {{$item->invoiceUid->first()->username}}
{{--                                            {{$item->uid}}--}}
                                        </td>
                                        <td>{{$item->company_name}}</td>
                                        <td>{{$item->ticket_name}}</td>
                                        <td>{{$item->tax_num}}</td>
                                        <td>{{$item->address_mobile}}</td>
                                        <td>{{$item->bank_account}}</td>
                                        <td>{{$item->money}}</td>
                                        <td>
                                            {{$item->invoice_type == '10'?'普票':''}}
                                            {{$item->invoice_type == '20'?'专票':''}}
                                            {{$item->invoice_type == '30'?'收据':''}}
                                        </td>
                                        <td>{{$item->express}}</td>
                                        <td>{{$item->express_num}}</td>
                                        <td>{{ date('Y-m',$item->ticket_month) }}</td>
                                        <td>{{$item->ticket_day}}</td>
                                        <td>
                                            {{$item->status == '10'?'未开票':''}}
                                            {{$item->status == '20'?'已开票':''}}
                                            {{$item->status == '90'?'发票作废':''}}
                                        </td>
                                        <td>{{$item->description}}</td>
                                        {{--                                        <td>{{$item->created_at}}</td>--}}
                                        <td>
                                            <a href="/admin/invoice/edit?id={{$item->id}}"
                                               class="btn btn-block bg-gradient-primary btn-xs"
                                               style="margin-right:4px;margin-top:5px;max-width: 100px;min-width: 80px;">编辑
                                            </a>
                                            @if(in_array('App\Http\Controllers\Admin\RoleController@delete',session()->get('permission')))
                                                <a href="" onclick="setDelUrl({{$item->id}})"
                                                   class="btn btn-block bg-gradient-danger btn-xs"
                                                   data-toggle="modal" data-target="#modal-sm"
                                                   data-orderId="{{$item->id}}"
                                                   style="margin-top:5px;max-width: 100px;min-width: 80px;">删除
                                                </a>
                                            @endif

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

    <script>
        function getUrl() {
            let href = '/admin/invoice/ExcelGet' + window.location.search;
            window.location = href;
        }

        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "scrollX": true,
                "bLengthChange": true, //开关，是否显示每页显示多少条数据的下拉框
                "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "所有"]],//设置每页显示数据条数的下拉选项
                'iDisplayLength': 10, //每页初始显示5条记录
                'bFilter': true,  //是否使用内置的过滤功能（是否去掉搜索框）
                "bPaginate": true, //开关，是否显示分页器
                "bSort": true, //是否可排序 
                // "pagingType": "full_numbers",  //显示尾页和首页
                "language": {
                    'search': "搜索：",
                    'infoEmpty': "",
                    "emptyTable":"该范围内暂无数据",
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