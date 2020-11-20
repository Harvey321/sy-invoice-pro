@extends('admin.user.layout')
@section('content-wrapper')
    <!-- 标题栏 -->
    <section class="content-header"></section>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary ">{{-- card-secondary灰色 --}}
                <div class="card-header">
                    <h3 class="card-title">分配角色</h3>
                </div>
                <form role="form">
                    <div class="card-body">
                        <div class="col-sm-12">

                            <div class="form-group form-inline">
                                <label for="exampleInputEmail1">用户名称:
                                    <input type="text" id="username" name="username" value="{{$userDate->username}}"
                                           class="form-control" disabled="true" style="margin-left:20px"
                                           placeholder="请输入用户名" maxlength="20">
                                    <input type="hidden" name="userId" id="userId" value="{{$userDate->id}}">
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">角色名称:</label>

                                @if($roleDate)

                                    @foreach($roleDate as $v)
                                        @if($v->status == 10)
                                            <div class="custom-control custom-checkbox">

                                                @if(in_array($v->id,$distributeDate))
                                                    <input class="custom-control-input" name="roleIds"
                                                           value="{{$v->id}}"
                                                           type="checkbox" id="customCheckbox{{$v->id}}" checked>
                                                @else
                                                    <input class="custom-control-input" name="roleIds"
                                                           value="{{$v->id}}"
                                                           type="checkbox" id="customCheckbox{{$v->id}}">
                                                @endif

                                                <label for="customCheckbox{{$v->id}}" class="custom-control-label">
                                        <span style="vertical-align: inherit;">
                                            <span style="vertical-align: inherit;">
                                                {{$v->rolename}}
                                            </span>
                                        </span>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
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
            let checkList = $('.custom-control-input');
            let roleIds = [];
            for (var i = 0; i < checkList.length; i++) {
                if (checkList[i].checked == true) {
                    roleIds.push(checkList[i].value)
                }
            }

            var data = {
                "_token": $('#_token').val(),
                "userId": $('#userId').val(),
                "roleIds": roleIds,
            };
            console.log(data)

            $.ajax({
                type: "post",
                url: "/admin/user/distribute",
                dataType: 'json',
                data: data,
                success: function (data) {
                    if (data.status == 1) {
                        toastr.success(data.message)
                        timeOut('/admin/user')
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


    </script>



@endsection