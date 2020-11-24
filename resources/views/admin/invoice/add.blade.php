@extends('admin.user.layout')
@section('content-wrapper')

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
                                   class="form-control" placeholder="请输入crmID" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">业务员:</label>
                            <input type="text" id="business_name" name="business_name" value=""
                                   class="form-control" placeholder="请输入业务员" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">客户名:</label>
                            <input type="text" id="customer_name" name="customer_name" value=""
                                   class="form-control" placeholder="请输入客户名" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开票名:</label>
                            <input type="text" id="ticket_name" name="ticket_name" value=""
                                   class="form-control" placeholder="请输入开票名" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">税号:</label>
                            <input type="text" id="tax_num" name="tax_num" value=""
                                   class="form-control" placeholder="请输入税号" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">地址:</label>
                            <input type="text" id="address" name="address" value=""
                                   class="form-control" placeholder="请输入地址" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">电话:</label>
                            <input type="text" id="mobile" name="mobile" value=""
                                   class="form-control" placeholder="请输入电话" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">金额:</label>
                            <input type="text" id="money" name="money" value=""
                                   class="form-control" placeholder="请输入金额" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开票月份:</label>
                            <input type="text" id="ticket_month" name="ticket_month" value=""
                                   class="form-control" placeholder="请输入开票月份" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">开始日:</label>
                            <input type="text" id="ticket_day" name="ticket_day" value=""
                                   class="form-control" placeholder="请输入开始日" maxlength="100" onkeyup="this.value=this.value.trim()">
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
            //表单验证
            // let res = formVerification()
            // if (res == false) {
            //     return false;
            // }

            let data = $('form').serializeArray();

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

    </script>

@endsection