@extends('admin.user.layout')
@section('content-wrapper')

    <!-- 标题栏 -->
    <section class="content-header"></section>
    
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">编辑发票</h3>
                </div>
                <form role="form" >
                    <div class="card-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">crmID:</label>
                            <input type="text" id="crm_id" name="crm_id" value="{{$data->crm_id}}"
                                   class="form-control" placeholder="请输入crmID" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">业务员:</label>
                            <input type="text" id="business_name" name="business_name" value="{{$data->business_name}}"
                                   class="form-control" placeholder="请输入业务员" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">客户名:</label>
                            <input type="text" id="customer_name" name="customer_name" value="{{$data->customer_name}}"
                                   class="form-control" placeholder="请输入客户名" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开票名:</label>
                            <input type="text" id="ticket_name" name="ticket_name" value="{{$data->ticket_name}}"
                                   class="form-control" placeholder="请输入开票名" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">税号:</label>
                            <input type="text" id="tax_num" name="tax_num" value="{{$data->tax_num}}"
                                   class="form-control" placeholder="请输入税号" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">地址:</label>
                            <input type="text" id="address" name="address" value="{{$data->address}}"
                                   class="form-control" placeholder="请输入地址" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">电话:</label>
                            <input type="text" id="mobile" name="mobile" value="{{$data->mobile}}"
                                   class="form-control" placeholder="请输入电话" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">金额:</label>
                            <input type="text" id="money" name="money" value="{{$data->money}}"
                                   class="form-control" placeholder="请输入金额" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开票月份:</label>
                            <div class="input-group date" id="reservationdate-month" data-date-format="yyyy-mm">
                                <input class='input-group date form-control datetimepicker-input input-group-append'
                                       placeholder="请输入开票月份"
                                       type="month" name="ticket_month" id="ticket_month" value="{{$data->ticket_month}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开始日:</label>
                            <div class="input-group date" id="reservationdate" data-date-format="yyyy-mm-dd">
                                <input class='input-group date form-control datetimepicker-input input-group-append'
                                       placeholder="请输入开始日"
                                       type="date" name="ticket_day" id="ticket_day" value="{{$data->ticket_day}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">状态</label>
                            <select name="status" id="status" class="form-control">
                                <option value="10" {{$data->status == 10 ? 'selected' : ''}}>正常使用</option>
                                <option value="90" {{$data->status == 90 ? 'selected' : ''}}>已作废</option>
                            </select>
                        </div>

                        <input type="hidden" name="id" value="{{$data->id}}">
                    </div>

                    <div class="card-footer"
                         style="display: flex;flex-direction: row;justify-content: space-around">
                        <div type="submit" id="getDate" onclick="dataUpdate({{$data->id}})" class="btn btn-block btn-primary">提交</div>
                        <button type="reset" onclick="resetForm()" class="btn btn-block btn-outline-secondary" style="margin-top:0;">
                            重置
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script>
        function dataUpdate(id){
            let data = $('form').serializeArray();

            // //表单验证
            // let res = formVerification()
            // if (res == false) {
            //     return false;
            // }

            $.ajax({
                type: "post",
                url: "/admin/invoice/update",
                dataType: 'json',
                data: data,
                success: function (data) {
                    if (data.status == 1) {
                        toastr.success(data.message)
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
        }

        function formVerification() {
            //表单验证
            if ($('#sn').val() == '') {
                toastr.error('请输入发票id/序列号')
                return false;
            }
            if ($('#invoice_name').val() == '') {
                toastr.error('请输入发票名称')
                return false;
            }
            if ($('#model').val() == '') {
                toastr.error('请输入发票型号')
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