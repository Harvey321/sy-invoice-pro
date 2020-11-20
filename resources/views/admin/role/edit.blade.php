@extends('admin.user.layout')
@section('content-wrapper')

    <!-- 标题栏 -->
    <section class="content-header"></section>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">编辑角色</h3>
                </div>
                <form role="form">
                    <div class="card-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">角色名称:</label>
                            <input type="text" id="rolename" name="rolename" value="{{$data->rolename}}"
                                   class="form-control"
                                   placeholder="请输入角色名" maxlength="20"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">角色标识:</label>
                            <input type="text" id="sign" name="sign" value="{{$data->sign}}"
                                   class="form-control"
                                   placeholder="请输入角色标识" maxlength="20"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label>角色状态:</label>
                            <select class="form-control" name="status">
                                <option value="10" {{$data->status==10?'selected':''}}>正常使用</option>
                                <option value="90" {{$data->status==90?'selected':''}}>已注销</option>
                            </select>
                        </div>

                        <input type="hidden" name="id" value="{{$data->id}}">
                    </div>

                    <div class="card-footer"
                         style="display: flex;flex-direction: row;justify-content: space-around">
                        <div type="submit" id="getDate" onclick="dataUpdate({{$data->id}})"
                             class="btn btn-block btn-primary">提交
                        </div>
                        <button type="reset" onclick="resetForm()" class="btn btn-block btn-outline-secondary"
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

            $.ajax({
                type: "post",
                url: "/admin/role/update",
                dataType: 'json',
                data: data,
                success: function (data) {
                    if (data.status == 1) {
                        toastr.success(data.message)
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
        }

    </script>

@endsection