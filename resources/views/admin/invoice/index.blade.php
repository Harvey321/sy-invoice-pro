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
                            <form action="/" method="get">
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="input-group date d-flex flex-row align-items-center col-3"
                                         id="reservationdate-month" data-date-format="yyyy-mm-dd">
                                        <label style="margin-right:20px;">开票公司:</label>
                                        <select name="invoice_company" id="invoice_company" class="form-control">
                                            <option value="10" {{$data['invoice_company'] == 10 ? 'selected':''}}>
                                                上海双于通信技术有限公司
                                            </option>
                                            <option value="20" {{$data['invoice_company'] == 20 ? 'selected':''}}>
                                                深圳是方科技有限公司
                                            </option>
                                            <option value="30" {{$data['invoice_company'] == 30 ? 'selected':''}}>
                                                江西双格科技有限公司
                                            </option>
                                        </select>
                                    </div>
                                    <div class="input-group date d-flex flex-row align-items-center col-3 offset-1"
                                         id="reservationdate-month" data-date-format="yyyy-mm-dd">
                                        <label style="margin-right:20px;">CrmId:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" id="crm_id" name="crm_id"
                                               value="{{isset($data['crm_id'])? $data['crm_id']:''}}"
                                               class="form-control" placeholder="请输入crmID" maxlength="100"
                                               onkeyup="this.value=this.value.trim()">
                                    </div>
                                    <div class="input-group date d-flex flex-row align-items-center col-3 offset-1"
                                         id="reservationdate-month" data-date-format="yyyy-mm-dd">
                                        <label style="margin-right:20px;">税&nbsp;&nbsp;号:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" id="tax_num" name="tax_num"
                                               value="{{isset($data['tax_num'])? $data['tax_num']:''}}"
                                               class="form-control" placeholder="请输入税号" maxlength="100"
                                               onkeyup="this.value=this.value.trim()">
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-7">
                                        <div class="input-group date d-flex flex-row align-items-center"
                                             id="reservationdate-month" data-date-format="yyyy-mm-dd">
                                            <label style="margin-right:20px;">查询范围:</label>
                                            <input class='input-group date form-control datetimepicker-input input-group-append'
                                                   placeholder="请输入开票月份" style="width: 250px!important;"
                                                   type="month" name="month_old" id="month_old"
                                                   value="{{isset($data['month_old']) == true ? date('Y-m',$data['month_old']) : date('Y-m',strtotime('-1 month'))}}"/>
                                            <input class='input-group date form-control datetimepicker-input input-group-append'
                                                   placeholder="请输入开票月份" style="width: 250px"
                                                   type="month" name="month_new" id="month_new"
                                                   value="{{isset($data['month_new']) == true ? date('Y-m',$data['month_new']) : date('Y-m',strtotime('0 month'))}}"/>

                                            <a class="btn btn-default button-left-margin"
                                               onclick="setMonth({{'\''.date('Y-m') .'\''.',' . '\''. date('Y-m').'\''}})">当前月</a>
                                            <a class="btn btn-default button-left-margin"
                                               onclick="setMonth({{'\''.date('Y-m', strtotime("-2 month")) .'\''. ',' . '\''.date('Y-m').'\''}})">近三月</a>
                                            <a class="btn btn-default button-left-margin"
                                               onclick="setMonth({{'\''.date('Y-m', strtotime("-5 month")) .'\''. ',' . '\''. date('Y-m').'\''}})">近半年</a>
                                            <a class="btn btn-default button-left-margin"
                                               onclick="setMonth({{'\''.date('Y-m', strtotime("-11 month")) .'\''. ',' . '\''. date('Y-m').'\''}})">近一年</a>
                                        </div>
                                    </div>
                                    <div class="col-4 offset-1 d-flex flex-row justify-content-start">
                                        <button class="btn btn-primary button-left-margin"
                                                style="width: 130px;margin-right:30px;height: 38px;">搜&nbsp;&nbsp;索
                                        </button>
                                        <a class="btn btn-dark" style="width: 130px;color:white;height: 38px;" onclick="getUrl()">导出列表</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            {{--                            style="overflow: scroll;"--}}
                            <table id="example1" class="table table-bordered table-striped  ">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>crmID</th>
                                    <th class="none">开票公司</th>
                                    <th >业务员名</th>
                                    <th>公司名</th>
                                    <th>开票名</th>
                                    <th >税号</th>
                                    <th>地址/电话</th>
                                    <th>开户行/账户</th>
                                    <th>金额</th>
                                    <th class="none">发票类型</th>
                                    <th class="none">快递信息</th>
                                    <th class="none">快递单号</th>
                                    <th>开票月份</th>
                                    <th class="none">到期提醒日</th>
                                    <th class="none">状态</th>
                                    <th>备注</th>
                                    {{--                                    <th>创建时间</th>--}}
                                    <th class="none">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!--                                --><?php //dd($dataList); ?>
                                @foreach($data['dataList'] as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->crm_id}}</td>
                                        <td>
                                            {{$item->invoice_company == '10'?'上海双于通信技术有限公司':''}}
                                            {{$item->invoice_company == '20'?'深圳是方科技有限公司':''}}
                                            {{$item->invoice_company == '30'?'江西双格科技有限公司':''}}
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
                                        <td class="description" onclick="edit_description(this)">
                                            <span class="description_span">{{$item->description}}</span>
                                            <input style="display:none;" type="text"
                                                   id="description_{{$item->id}}_{{$item->crm_id}}"
                                                   class="description_input" name="description"
                                                   value="" onblur="sub_description(this)"/>
                                        </td>



{{--                                        <td class="product_name" onclick="edit_product_name(this)">--}}

{{--                                            <span class="product_name_span">{{$item->pivot->name}}</span>--}}
{{--                                            <input style="display:none;" type="text"--}}
{{--                                                   id="product_name_{{$item->pivot->id}}"--}}
{{--                                                   class="product_name_input" name="product_name"--}}
{{--                                                   value="" onblur="sub_product_name(this)"/>--}}

{{--                                        </td>--}}


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

        function setMonth(month_old, month_new) {
            $('#month_old').val(month_old);
            $('#month_new').val(month_new);
        }

        function getUrl() {
            let href = '/admin/invoice/ExcelGet' + window.location.search;
            // console.log(href)
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
                    'search': "全表搜索：",
                    'infoEmpty': "",
                    "emptyTable": "该范围内暂无数据",
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

        //点击名称 表格变表单
        function edit_description(obj) {
            $(obj).children('span').css('display', 'none');//span消失
            $(obj).children('input').css('display', 'block');//换成表单
            $(obj).children('input').val($(obj).children('span').html()); //span内容赋值给表单
            $(obj).children('input').focus();

            // $(obj).children('input').change(function () {//表单改变事件
            // $(obj).children('span').html(this.value)//每次表单输入内容重新赋值给span
            // });
            //** 修改产品名
            $(obj).children('input').unbind('keypress').bind('keypress', function (e) {//表单回车事件
                let id = $(obj).children('input').attr('id').split("_")[1]; //获取发票id
                // let crm_id = $(obj).children('input').attr('id').split("_")[2];

                if (e.which == 13) {
                    $(obj).children('span').html($(obj).children('input').val());//表单值赋值给span
                    $(obj).children('input').css('display', 'none');//表单消失
                    $(obj).children('span').css('display', 'block');//span出现
                    $.ajax({
                        type: "get",
                        url: "/admin/invoice/update",
                        dataType: 'json',
                        data: {
                            'id': id,
                            // 'crm_id': crm_id,
                            'description': $(obj).children('input').val()
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
        function sub_description(object) {
            let obj = $(object).parent();//获取td单元格 表单的父级元素
            // $(obj).children('span').html($(object).val());//表单失焦时 表单值赋值给span
            $(obj).children('input').css('display', 'none');//表单消失
            $(obj).children('span').css('display', 'block');//span出现
        }


    </script>


@endsection