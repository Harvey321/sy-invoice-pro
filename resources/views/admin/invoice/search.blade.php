@extends('admin.user.layout')
@section('content-wrapper')
    <style>
        .button-left-margin {
            margin-left: 10px;
        }
    </style>
    <!-- 标题栏 -->
    <section class="content-header">

    </section>

    <!-- 新表格 -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">请选择开票公司:</h3>
                        </div>
                        <div class="card-header">
                                <div class="row" style="margin-bottom: 20px;margin-top:20px">
                                    <div class="col-12 d-flex flex-row align-items-center justify-content-center">
                                        <a class="btn btn-info" href="/admin/invoice?invoice_company=10" style="width: 250px;margin-right:50px;">上海双于通信技术有限公司</a>
                                        <a class="btn btn-info" href="/admin/invoice?invoice_company=20" style="width: 250px;margin-right:50px;">深圳是方科技有限公司</a>
                                        <a class="btn btn-info" href="/admin/invoice?invoice_company=30" style="width: 250px;margin-right:50px;">江西双格科技有限公司</a>
                                    </div>
                                </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        function getUrl() {
            let href = '/admin/invoice/ExcelGet' + window.location.search;
            // window.location = href;
            console.log(href)
            return false;
        }

        function setDelUrl(id) {
            let url = '/admin/invoice/delete?id=' + id;
            $('#url').val(url);  //给会话中的隐藏属性URL赋值
            $('#modal-sm').modal();
        }

    </script>


@endsection