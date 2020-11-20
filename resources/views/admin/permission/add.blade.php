@extends('admin.user.layout')
@section('content-wrapper')

    <!-- 标题栏 -->
    <section class="content-header"></section>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">新增权限</h3>
                </div>
                <form role="form">
                    <div class="card-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">权限名称:</label>
                            <input type="text" id="per_name" name="per_name" value="{{old('per_name')}}"
                                   class="form-control" onkeyup="this.value=this.value.trim()"
                                   placeholder="请输入权限名" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">权限路由:</label>
                            <input type="text" id="per_url" name="per_url" value="{{old('per_url')}}"
                                   class="form-control" onkeyup="this.value=this.value.trim()"
                                   placeholder="请输入权限标识" maxlength="100">
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
            let res = formVerification()
            if (res == false) {
                return false;
            }

            let data = $('form').serializeArray();

            $.ajax({
                type: "post",
                url: "/admin/permission/create",
                dataType: 'json',
                data: data,
                success: function (data) {
                    if (data.status == 1) {
                        toastr.success(data.message)
                        $("button[type=reset]").trigger("click");//触发清空表单
                        timeOut('/admin/permission')
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
            if ($('#per_name').val() == '') {
                toastr.error('请输入权限名')
                return false;
            }
            if ($('#per_url').val() == '') {
                toastr.error('请输入权限URL')
                return false;
            }
            return true;
        }

    </script>

@endsection