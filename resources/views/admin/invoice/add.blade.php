@extends('admin.user.layout')
@section('content-wrapper')
    <style>
        .box-card {
            margin-right: 10px;
        }

        .card-header {
            border-radius: .25rem;
        }
    </style>
    <!-- 标题栏 -->
    <section class="content-header"></section>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">新增发票</h3>
                </div>
                <form role="form">
                    <div class="card-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">crmID:</label>
                            <input type="text" id="crm_id" name="crm_id" value=""
                                   class="form-control" placeholder="请输入crmID" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开票公司:</label>
                            <select name="invoice_company" id="invoice_company" class="form-control">
                                <option value="10">上海双于通信技术有限公司</option>
                                <option value="20">深圳是方科技有限公司</option>
                                <option value="30">江西双格科技有限公司</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">业务员:</label>
                            <select name="uid" id="uid" class="form-control">
                                @foreach($user as $item)
                                    <option value="{{$item->id}}">{{$item->username}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">公司名:</label>
                            <input type="text" id="company_name" name="company_name" value=""
                                   class="form-control" placeholder="请输入公司名" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开票名:</label>
                            <input type="text" id="ticket_name" name="ticket_name" value=""
                                   class="form-control" placeholder="请输入开票名" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">税号:</label>
                            <input type="text" id="tax_num" name="tax_num" value=""
                                   class="form-control" placeholder="请输入税号" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">地址/电话:</label>
                            <input type="text" id="address_mobile" name="address_mobile" value=""
                                   class="form-control" placeholder="请输入地址/电话" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开户行/账户:</label>
                            <input type="text" id="bank_account" name="bank_account" value=""
                                   class="form-control" placeholder="请输入开户行/账户" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">金额:</label>
                            <input type="text" id="money" name="money" value=""
                                   class="form-control" placeholder="请输入金额" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">发票类型:</label>
                            <select name="invoice_type" id="invoice_type" class="form-control">
                                <option value="10">普票</option>
                                <option value="20">专票</option>
                                <option value="30">收据</option>
                            </select>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleInputEmail1">快递信息:</label>--}}
{{--                            <input type="text" id="express" name="express" value=""--}}
{{--                                   class="form-control" placeholder="请输入快递信息" maxlength="180"--}}
{{--                                   onkeyup="this.value=this.value.trim()">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleInputEmail1">快递单号:</label>--}}
{{--                            <input type="text" id="express_num" name="express_num" value=""--}}
{{--                                   class="form-control" placeholder="请输入快递单号" maxlength="100"--}}
{{--                                   onkeyup="this.value=this.value.trim()">--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label>开票月份:</label>
                            <div class="row" id="myTime">

                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <select class="custom-select" id="myYear" name="year"></select>
                                </div>
                                <div class="col-4">
                                    <select class="custom-select" id="myMonth" name="month"></select>
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-info" href="javascript:;" onclick="add_month()"
                                       style="width:100px;">添加</a>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">到期提醒日:</label>
                            <div class="input-group date" id="reservationdate" data-date-format="yyyy-mm">
                                <input class='input-group date form-control datetimepicker-input input-group-append'
                                       placeholder="请输入到期提醒日"
                                       type="date" name="ticket_day" id="ticket_day" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer"
                         style="display: flex;flex-direction: row;justify-content: space-around">
                        <div id="getDate" class="btn btn-block btn-primary">提交</div>
                        <button type="reset" class="btn btn-block btn-outline-secondary" style="margin-top:0;">
                            重置
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $("#getDate").click(function () {

            let tmp = getYearMonth();//返回开票年月数组

            let data = $('form').serializeArray();

            data.push({'name': 'yearMonth', 'value': tmp})

            console.log(data);

            $.ajax({
                type: "post",
                url: "/admin/invoice/create",
                dataType: 'json',
                data: data,
                success: function (data) {
                    if (data.status == 1) {
                        toastr.success(data.message)
                        $("button[type=reset]").trigger("click");//触发清空表单
                        timeOut('/admin/invoice')
                    }
                    if (data.status == 0) {
                        toastr.error(data.message)
                    }
                },
                error: function (data) {
                    console.log(data)
                }
            })
        })

        function formVerification() {

            //表单验证
            if ($('#sn').val() == '') {
                toastr.error('请输入产品id/序列号')
                return false;
            }
            if ($('#invoice_name').val() == '') {
                toastr.error('请输入产品名称')
                return false;
            }
            if ($('#model').val() == '') {
                toastr.error('请输入产品型号')
                return false;
            }
            if ($('#address').val() == '') {
                toastr.error('请输入安装地')
                return false;
            }
            if ($('#rate').val() == '') {
                toastr.error('请输入带宽')
                return false;
            }
            return true;
        }

        window.onload = function () {
            //设置年份的选择
            var myDate = new Date();
            var startYear = myDate.getFullYear() - 20;//起始年份
            var endYear = myDate.getFullYear() + 50;//结束年份
            var obj = document.getElementById('myYear');
            for (var i = startYear; i <= endYear; i++) {
                obj.options.add(new Option(i, i));
            }
            obj.options[obj.options.length - 51].selected = 1;

            //设置月份的选择
            var startMonth = 1;//起始月
            var endMonth = 12;//结束月
            var tmp = document.getElementById('myMonth');
            for (var y = startMonth; y <= endMonth; y++) {
                tmp.options.add(new Option(y, y));
            }
        };

        // 添加月份框可删除自动排列 + 绑定删除时清理box
        function add_month() {
            let tmp = getYearMonth();//返回开票年月数组
            let myTime = $('#myTime');//获取准备插入的div
            myTime.empty();//先清空该div下所有子元素节点
            for (let i = 0; tmp.length > i; i++) {//遍历添加开票月份排列框
                myTime.append(
                    '<div class="card card-info box-card">' +
                    '<div class="card-header">' +
                    '<p class="card-title YearMonth">' + tmp[i] + '</p>' +
                    '<div class="card-tools">' +
                    '<button type="button" class="btn btn-tool" data-card-widget="remove">' +
                    '<i class="fas fa-times"></i>' +
                    '</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                );
            }
            //清理月份框
            let boxList = $('.box-card');//获取所有的月份框
            for (let x = 0; boxList.length > x; x++) {
                $(boxList[x]).bind('click', function () {//绑定点击移除事件
                    this.remove()
                })
            }
        }

        //返回开票年月数组
        function getYearMonth() {
            let myYear = document.getElementById('myYear').value;//添加的年份
            let myMonth = document.getElementById('myMonth').value;//添加的月份
            if (myMonth < 10) {
                myMonth = '0' + myMonth;//达不到10前方补零
            }
            let addYearMonth = myYear + '-' + myMonth; //添加的年月日

            let yearMonthList = $('.YearMonth');//获取所有添加的开票月份框
            let tmp = [];
            for (let i = 0; yearMonthList.length > i; i++) {
                tmp.push(yearMonthList[i].innerHTML);//形成临时数组
            }
            tmp.push(addYearMonth);//追进新内容
            tmp = Array.from(new Set(tmp));//数组去重
            return tmp;
        }
    </script>

@endsection