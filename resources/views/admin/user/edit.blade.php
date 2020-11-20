@extends('admin.user.layout')
@section('content-wrapper')

    <!-- 标题栏 -->
    <section class="content-header"></section>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">编辑用户</h3>
                </div>
                <form role="form" >
                    <div class="card-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">用户名称:</label>
                            <input type="text" id="username" name="username" value="{{$user->username}}"
                                   class="form-control"
                                   placeholder="请输入用户名" maxlength="20"
                                   onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">输入密码:</label>
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="请输入密码" onkeyup="this.value=this.value.trim()"
                                   maxlength="20" value="{{ $user->password }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">公司名称:</label>
                            <input type="text" id="company" name="company" class="form-control" placeholder="请输入公司名称"
                                  value="{{$user->company}}" maxlength="100" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">公司地址:</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="请输入公司地址"
                                   value="{{$user->address}}" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">邮箱地址</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="输入邮箱"
                                   value="{{$user->email}}" onkeyup="this.value=this.value.trim()">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">手机号码</label>
                            <input type="text" id="mobile" name="mobile" class="form-control" placeholder="输入手机号码"
                                   value="{{$user->mobile}}" maxlength="11" onkeyup="this.value=this.value.trim()">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">状态</label>
                            <select name="status" id="status" class="form-control">
                                <option value="10" {{$user->status == 10 ? 'selected' : ''}}>正常使用</option>
                                <option value="90" {{$user->status == 90 ? 'selected' : ''}}>已注销</option>
                            </select>
                        </div>

                        <input type="hidden" name="id" value="{{$user->id}}">
                    </div>

                    <div class="card-footer"
                         style="display: flex;flex-direction: row;justify-content: space-around">
                        <div type="submit" id="getDate" onclick="dataUpdate({{$user->id}})" class="btn btn-block btn-primary">提交</div>
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

            let res = formVerification()
            if (res == false) {
                return false;
            }

            $.ajax({
                type: "post",
                url: "/admin/user/update",
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
        }

        function formVerification() {
            //表单验证
            if ($('#username').val() == '') {
                toastr.error('请输入用户名')
                return false;
            }

            if ($('#password').val() == '') {
                toastr.error('请输入密码')
                return false;
            }

            if ($('#company').val() == '') {
                toastr.error('请输入公司名称')
                return false;
            }
            if ($('#address').val() == '') {
                toastr.error('请输入公司地址')
                return false;
            }
            if ($('#email').val() == '') {
                toastr.error('请输入邮箱地址')
                return false;
            }
            if ($('#mobile').val() == '') {
                toastr.error('手机号码')
                return false;
            }
            return true;
        }
        
    </script>

@endsection