@extends('admin.user.layout')
@section('content-wrapper')

    <!-- 标题栏 -->
    <section class="content-header">
        <!-- 模态框  -->
        <div class="modal fade" id="modal-sm" data-orderId>
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        {{--                        <h4 class="modal-title">确认框</h4>--}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>请问您确认要删除此记录吗？</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" id="url"/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" onclick="urlSubmit()">确认删除</button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- 新表格 -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">产品列表</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped" style="overflow: hidden">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>设备序列号sn码</th>
                                    <th>产品名称</th>
                                    <th>设备型号</th>
                                    <th>安装地址</th>
                                    <th>带宽</th>
                                    <th class="none">ip</th>
                                    <th class="none">备注</th>
                                    <th class="none">状态</th>
                                    <th class="none">创建时间</th>
                                    <th class="none">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataList as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->sn}}</td>
                                        <td>{{$item->product_name}}</td>
                                        <td>{{$item->model}}</td>
                                        <td>{{$item->address}}</td>
                                        <td>{{$item->rate}}</td>
                                        <td>
                                            @foreach($item->ip as $value)
                                                @foreach($value as $k => $y)
                                                    {{$k}} : {{$y}} &nbsp;&nbsp;&nbsp;
                                                @endforeach
                                            @endforeach
                                        </td>
                                        <td>{{$item->description}}</td>
                                        <td>
                                            {{$item->status == 10? '正常使用': ''}}
                                            {{$item->status == 20? '备份': ''}}
                                            {{$item->status == 90? '测试': ''}}
                                        </td>
                                        <td>{{$item->created_at}}</td>
                                        <td style="display: flex;flex-direction: row;justify-content: center;align-items: center;">
                                            <a href="/admin/product/edit?id={{$item->id}}"
                                               class="btn btn-block bg-gradient-primary btn-xs"
                                               style="margin-right:4px;margin-top:5px;max-width: 100px;min-width: 80px;">编辑
                                            </a>
                                            <a href="" onclick="setDelUrl({{$item->id}})"
                                               class="btn btn-block bg-gradient-danger btn-xs"
                                               data-toggle="modal" data-target="#modal-sm"
                                               data-orderId="{{$item->id}}"
                                               style="margin-top:5px;max-width: 100px;min-width: 80px;">删除
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "bLengthChange": true, //开关，是否显示每页显示多少条数据的下拉框
                "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "所有"]],//设置每页显示数据条数的下拉选项
                'iDisplayLength': 5, //每页初始显示5条记录
                'bFilter': true,  //是否使用内置的过滤功能（是否去掉搜索框）
                "bPaginate": true, //开关，是否显示分页器
                "bSort": true, //是否可排序 
                // "pagingType": "full_numbers",  //显示尾页和首页
                "language": {
                    search: "搜索："
                },
                "oLanguage": {  //语言转换
                    "sInfo": "显示第 _START_ - _END_ 项，共 _TOTAL_ 项",
                    "sLengthMenu": "每页显示 _MENU_ 项结果",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "前一页",
                        "sNext": "后一页",
                        "sLast": "尾页"
                    }

                }
            });

        });


        function setDelUrl(id) {
            let url = '/admin/product/delete?id=' + id;
            $('#url').val(url);  //给会话中的隐藏属性URL赋值
            $('#modal-sm').modal();
        }

        function urlSubmit() {
            let url = $.trim($("#url").val());//获取会话中的隐藏属性URL
            $.ajax({
                type: "get",
                url: url,
                dataType: 'json',
                data: {},
                success: function (data) {
                    //隐藏模态确认框
                    $('#modal-sm').modal('hide');
                    //显示模态提示框
                    if (data.status == 1) {
                        toastr.success(data.message);
                        timeOut('/admin/product')
                    }
                    if (data.status == 0) {
                        toastr.error(data.message);
                        timeOut('/admin/product')
                    }
                },
                error: function (data) {
                    console.log(data)
                }
            })
        }

        function timeOut() {
            setTimeout(function () {
                location.reload();
            }, 2000);
        }

    </script>


@endsection