@extends('admin.user.layout')
@section('content-wrapper')
    <style>
        .button-left-margin {
            margin-left: 10px;
        }
    </style>
    <!-- 标题栏 -->
    <section class="content-header">

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
                                            <option value="10">上海双于通信技术有限公司</option>
                                            <option value="20">深圳是方通信技术有限公司</option>
                                            <option value="30">江西双格通信技术有限公司</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="input-group date d-flex flex-row align-items-center col-3"
                                         id="reservationdate-month" data-date-format="yyyy-mm-dd">
                                        <label style="margin-right:20px;">CrmId:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" id="crm_id" name="crm_id" value=""
                                               class="form-control" placeholder="请输入crmID" maxlength="100"
                                               onkeyup="this.value=this.value.trim()">
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="input-group date d-flex flex-row align-items-center col-3"
                                         id="reservationdate-month" data-date-format="yyyy-mm-dd">
                                        <label style="margin-right:20px;">税&nbsp;&nbsp;号:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" id="tax_num" name="tax_num" value=""
                                               class="form-control" placeholder="请输入税号" maxlength="100"
                                               onkeyup="this.value=this.value.trim()">
                                    </div>
                                </div>
{{--                                <div class="row" style="margin-bottom: 20px;">--}}
{{--                                    <div class="input-group date d-flex flex-row align-items-center col-3"--}}
{{--                                         id="reservationdate-month" data-date-format="yyyy-mm-dd">--}}
{{--                                        <label style="margin-right:20px;">发票类型:</label>--}}
{{--                                        <select name="invoice_type" id="invoice_type" class="form-control"  >--}}
{{--                                            <option value="10">普票</option>--}}
{{--                                            <option value="20">专票</option>--}}
{{--                                            <option value="30">收据</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="input-group date d-flex flex-row align-items-center col-6"
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
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 20px;margin-top:50px">
                                    <div class="offset-1 col-4 d-flex flex-row align-items-center justify-content-start">
                                        <button class="btn btn-default" href="/" style="width: 120px;margin-right:50px;">查&nbsp;&nbsp;询</button>
                                        <button class="btn btn-info" style="width: 120px;" type="reset">重&nbsp;&nbsp;置</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="card-body">
                            {{--                            style="overflow: scroll;"--}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        function getUrl() {
            let href = '/admin/invoice/ExcelGet' + window.location.search;
            // window.location = href;
            console.log(href)
            return false;
        }

        function setDelUrl(id) {
            let url = '/admin/invoice/delete?id=' + id;
            $('#url').val(url);  //给会话中的隐藏属性URL赋值
            $('#modal-sm').modal();
        }

    </script>


@endsection