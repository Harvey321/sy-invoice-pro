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
                            <label for="exampleInputEmail1">发票id/序列号:</label>
                            <input type="text" id="sn" name="sn" value="{{$data->sn}}"
                                   class="form-control" placeholder="请输入发票序列号" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">发票名:</label>
                            <input type="text" id="invoice_name" name="invoice_name" value="{{$data->invoice_name}}"
                                   class="form-control" placeholder="请输入发票名称" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">设备型号:</label>
                            <input type="text" id="model" name="model" value="{{$data->model}}"
                                   class="form-control" placeholder="请输入设备型号" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">安装地:</label>
                            <input type="text" id="address" name="address" value="{{$data->address}}"
                                   class="form-control" placeholder="请输入安装地" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">带宽:</label>
                            <input type="text" id="rate" name="rate" value="{{$data->rate}}"
                                   class="form-control" placeholder="请输入带宽" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">ip:</label>
                            <input type="text" id="ip" name="ip" value="{{$data->ip}}"
                                   class="form-control" placeholder="例:eth0:192.168.0.1,eth3:192.168.1.1" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">备注:</label>
                            <input type="text" id="description" name="description" value="{{$data->description}}"
                                   class="form-control" placeholder="请输入备注信息" maxlength="240" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">状态</label>
                            <select name="status" id="status" class="form-control">
                                <option value="10" {{$data->status == 10 ? 'selected' : ''}}>正常使用</option>
                                <option value="90" {{$data->status == 90 ? 'selected' : ''}}>已注销</option>
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

            //表单验证
            let res = formVerification()
            if (res == false) {
                return false;
            }

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