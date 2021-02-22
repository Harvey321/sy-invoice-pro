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
                <form role="form">
                    <div class="card-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">crmID:</label>
                            <input type="text" id="crm_id" name="crm_id" value="{{$data->crm_id}}"
                                   class="form-control" placeholder="请输入crmID" maxlength="100"
                                   onkeyup="this.value=this.value.trim()" disabled>
{{--                            in_array('App\Http\Controllers\Admin\RoleController@delete',session()->get('permission'))?'':'disabled'--}}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开票公司:</label>
                            <select name="invoice_company" id="invoice_company" class="form-control" disabled>
                                <option value="10" {{$data->invoice_company == 10 ? 'selected' : ''}}>上海双于通信技术有限公司</option>
                                <option value="20" {{$data->invoice_company == 20 ? 'selected' : ''}}>深圳是方科技有限公司</option>
                                <option value="30" {{$data->invoice_company == 30 ? 'selected' : ''}}>江西双格科技有限公司</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">业务员:</label>
                            <select name="uid" id="uid"
                                    class="form-control" {{in_array('App\Http\Controllers\Admin\RoleController@delete',session()->get('permission'))?'':'disabled'}}>
                                @foreach($user as $item)
                                    <option value="{{$item->id}}"{{$item->id == $data->uid ?'selected':''}}>
                                        {{$item->username}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">公司名:</label>
                            <input type="text" id="company_name" name="company_name" value="{{$data->company_name}}"
                                   class="form-control" placeholder="请输入公司名" maxlength="100"
                                   onkeyup="this.value=this.value.trim()" {{in_array('App\Http\Controllers\Admin\RoleController@delete',session()->get('permission'))?'':'disabled'}}>
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
                            <label for="exampleInputEmail1">地址/电话:</label>
                            <input type="text" id="address_mobile" name="address_mobile" value="{{$data->address_mobile}}"
                                   class="form-control" placeholder="请输入地址/电话" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开户行/账户:</label>
                            <input type="text" id="bank_account" name="bank_account" value="{{$data->bank_account}}"
                                   class="form-control" placeholder="请输入开户行/账户" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">金额:</label>
                            <input type="text" id="money" name="money" value="{{$data->money}}"
                                   class="form-control" placeholder="请输入金额" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">发票类型:</label>
                            <select name="invoice_type" id="invoice_type" class="form-control">
                                <option value="10" {{$data->invoice_type == 10 ? 'selected' : ''}}>普票</option>
                                <option value="20" {{$data->invoice_type == 20 ? 'selected' : ''}}>专票</option>
                                <option value="30" {{$data->invoice_type == 30 ? 'selected' : ''}}>收据</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">快递信息:</label>
                            <input type="text" id="express" name="express" value="{{$data->express}}"
                                   class="form-control" placeholder="请输入快递信息" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">快递单号:</label>
                            <input type="text" id="express_num" name="express_num" value="{{$data->express_num}}"
                                   class="form-control" placeholder="请输入快递单号" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">开票月份:</label>
                            <div class="input-group date" id="reservationdate-month" data-date-format="yyyy-mm">
                                <input class='input-group date form-control datetimepicker-input input-group-append'
                                       placeholder="请输入开票月份"
                                       type="month" name="ticket_month" id="ticket_month"
                                       value="{{ date('Y-m',$data->ticket_month) }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">到期日:</label>
                            <div class="input-group date" id="reservationdate" data-date-format="yyyy-mm-dd">
                                <input class='input-group date form-control datetimepicker-input input-group-append'
                                       placeholder="请输入开始日"
                                       type="date" name="ticket_day" id="ticket_day" value="{{$data->ticket_day}}"/>
                            </div>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleInputEmail1">备注:</label>--}}
{{--                            <input type="text" id="description" name="description" value="{{$data->description}}"--}}
{{--                                   class="form-control" placeholder="" maxlength="100"--}}
{{--                                   onkeyup="this.value=this.value.trim()">--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <label for="exampleInputEmail1">状态</label>
                            <select name="status" id="status" class="form-control">
                                <option value="10" {{$data->status == 10 ? 'selected' : ''}}>未开票</option>
                                <option value="20" {{$data->status == 20 ? 'selected' : ''}}>已开票</option>
                                <option value="90" {{$data->status == 90 ? 'selected' : ''}}>发票作废</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">收款金额:</label>
                            <input type="text" id="collection" name="collection" value="{{$data->collection}}"
                                   class="form-control" placeholder="请输入收款金额" maxlength="100"
                                   onkeyup="this.value=this.value.trim()">
                        </div>

                        <input type="hidden" name="id" value="{{$data->id}}">
                    </div>

                    <div class="card-footer"
                         style="display: flex;flex-direction: row;justify-content: space-around">
                        <div id="getDate" onclick="dataUpdate({{$data->id}})"
                             class="btn btn-block btn-primary">提交
                        </div>
                        <button type="reset" class="btn btn-block btn-outline-secondary"
                                style="margin-top:0;">
                            重置
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script>
        function dataUpdate(id) {
            let data = $('form').serializeArray();
            data.push({name:'crm_id',value:$('#crm_id').val()})

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

    </script>

@endsection