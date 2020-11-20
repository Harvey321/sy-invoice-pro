@extends('admin.user.layout')
@section('content-wrapper')

    <!-- 标题栏 -->
    <section class="content-header"></section>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">新增角色</h3>
                </div>
                <form role="form">
                    <div class="card-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">角色名称:</label>
                            <input type="text" id="rolename" name="rolename" value="{{old('rolename')}}"
                                   class="form-control"
                                   placeholder="请输入角色名 ( 二十位以内 )" maxlength="20"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">角色标识:</label>
                            <input type="text" id="sign" name="sign" value="{{old('sign')}}"
                                   class="form-control"
                                   placeholder="请输入角色标识 ( 二十位以内 )" maxlength="20"
                                   onkeyup="this.value=this.value.trim()">
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
                url: "/admin/role/create",
                dataType: 'json',
                data: data,
                success: function (data) {
                    if (data.status == 1) {
                        toastr.success(data.message)
                        $("button[type=reset]").trigger("click");//触发清空表单
                        timeOut('/admin/role')
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
            if ($('#rolename').val() == '') {
                toastr.error('请输入角色名')
                return false;
            }
            if ($('#sign').val() == '') {
                toastr.error('请输入角色标识')
                return false;
            }
            return true;
        }

    </script>

@endsection