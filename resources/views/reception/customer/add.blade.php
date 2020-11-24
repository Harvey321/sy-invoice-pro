@extends('reception.layout')
@section('content-wrapper')
    <!-- 标题栏 -->
    <section class="content-header"></section>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">新增接入点</h3>
                </div>
                <form role="form">
                    <div class="card-body">
                        {{csrf_field()}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleInputEmail1">产品id/序列号:</label>--}}
{{--                            <input type="text" id="serial_num" name="serial_num" value=""--}}
{{--                                   class="form-control" placeholder="请输入产品序列号" maxlength="100" onkeyup="this.value=this.value.replace(/\s+/g,'')">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleInputEmail1">产品名:</label>--}}
{{--                            <input type="text" id="product_name" name="product_name" value=""--}}
{{--                                   class="form-control" placeholder="请输入产品名称" maxlength="100" onkeyup="this.value=this.value.replace(/\s+/g,'')">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleInputEmail1">型号:</label>--}}
{{--                            <input type="text" id="model" name="model" value=""--}}
{{--                                   class="form-control" placeholder="请输入产品型号" maxlength="100" onkeyup="this.value=this.value.replace(/\s+/g,'')">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleInputEmail1">URL:</label>--}}
{{--                            <input type="text" id="url" name="url" value=""--}}
{{--                                   class="form-control" placeholder="请输入路由地址" maxlength="100" onkeyup="this.value=this.value.replace(/\s+/g,'')">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleInputEmail1">带宽:</label>--}}
{{--                            <input type="text" id="machine_status" name="machine_status" value=""--}}
{{--                                   class="form-control" placeholder="请输入带宽" maxlength="100" onkeyup="this.value=this.value.replace(/\s+/g,'')">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleInputEmail1">备注:</label>--}}
{{--                            <input type="text" id="description" name="description" value=""--}}
{{--                                   class="form-control" placeholder="备注信息" maxlength="100" onkeyup="this.value=this.value.replace(/\s+/g,'')">--}}
{{--                        </div>--}}
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
            let res = formVerification()
            if (res == false) {
                return false;
            }

            let data = $('form').serializeArray();

            $.ajax({
                type: "post",
                url: "/admin/product/create",
                dataType: 'json',
                data: data,
                success: function (data) {
                    if (data.status == 1) {
                        toastr.success(data.message)
                        $("button[type=reset]").trigger("click");//触发清空表单
                        timeOut('/admin/product')
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
            if ($('#serial_num').val() == '') {
                toastr.error('请输入产品id/序列号')
                return false;
            }
            if ($('#product_name').val() == '') {
                toastr.error('请输入产品名称')
                return false;
            }
            if ($('#model').val() == '') {
                toastr.error('请输入产品型号')
                return false;
            }
            if ($('#url').val() == '') {
                toastr.error('请输入路由地址')
                return false;
            }
            if ($('#machine_status').val() == '') {
                toastr.error('请输入带宽')
                return false;
            }
            return true;
        }
    </script>
@endsection