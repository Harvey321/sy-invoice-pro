@extends('admin.user.layout')
@section('content-wrapper')

    <!-- 标题栏 -->
    <section class="content-header"></section>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">分配权限</h3>
                </div>
                <form role="form" action="{{url('/admin/role/doAuth')}}" method="post">
                    <div class="card-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">角色名称: </label>
                            <input type="hidden" name="role_id" value="{{$role->id}}">
                            <input type="hidden" name="rolename" value="{{$role->rolename}}">
                            <input type="hidden" name="sign" value="{{$role->sign}}">
                            <input type="text" id="rolename" name="rolename" value="{{$role->rolename}}"
                                   class="form-control" disabled
                                   placeholder="请输入角色名 ( 二十位以内 )" maxlength="20"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">角色标识:</label>
                            <input type="text" id="sign" name="sign" value="{{$role->sign}}"
                                   class="form-control" disabled
                                   placeholder="请输入角色标识 ( 二十位以内 )" maxlength="20"
                                   onkeyup="this.value=this.value.trim()">
                        </div>

                        <div class="row">
                            <label for="exampleInputEmail1">权限名称:</label>
                        </div>
                        <div class="row">
                            @foreach($perms as $v)
                                <?php
                                ?>
                                <div class="custom-control custom-checkbox col-6 col-md-4 col-sm-4 col-xs-4 col-lg-4 col-xl-4 ">
                                    @if(in_array($v->id,$list))

                                        <input class="custom-control-input" type="checkbox" name="pid[]"
                                               value="{{$v->id}}" checked
                                               id="customCheckbox{{$v->id}}">
                                        <label for="customCheckbox{{$v->id}}"
                                               class="custom-control-label">{{$v->per_name}}</label>
                                    @else

                                        <input class="custom-control-input" type="checkbox" name="pid[]"
                                               value="{{$v->id}}"
                                               id="customCheckbox{{$v->id}}">
                                        <label for="customCheckbox{{$v->id}}"
                                               class="custom-control-label">{{$v->per_name}}</label>
                                    @endif
                                </div>
                            @endforeach

                        </div>


                    </div>

                    <div class="card-footer" style="display: flex;flex-direction: row;justify-content: space-around">
                        <button type="submit" id="getDate" class="btn btn-block btn-primary">提交</button>
                        <button type="reset" class="btn btn-block btn-outline-secondary" style="margin-top:0;">重置
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        $("#getDate").click(function () {

            let data = $('form').serializeArray();

            // $.ajax({
            //     type: "post",
            //     url: "/admin/role/doauth",
            //     dataType: 'json',
            //     data: data,
            //     success: function (data) {
            //         if (data.status == 1) {
            //             toastr.success(data.message)
            //             $("button[type=reset]").trigger("click");//触发清空表单
            //             timeOut('/admin/role')
            //         }
            //         if (data.status == 0) {
            //             toastr.error(data.message)
            //         }
            //     },
            //     error: function (data) {
            //         console.log(data)
            //     }
            // })
        })


    </script>

@endsection