<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Invoice;
use Illuminate\Http\Request;


class InvoiceController extends Controller
{
    /**
     * 发票列表
     */
    public function index(Request $request)
    {
        if (!isset(session()->get('user')->id)) {
            return redirect('admin/login')->with('errors', '请先登录');
        }

        $dataList = Invoice::orderBy('id', 'DESC')->get();

        return view(
            'admin.invoice.index',
            [
                'title' => '发票列表',
                'dataList' => $dataList,
            ]
        );
    }

    /**
     * 发票添加页面
     */
    public function add()
    {
        return view('admin.invoice.add');
    }

    /**
     * 发票添加方法
     */
    public function create()
    {
        $formData = request()->except(['_token', 's']);

        //保存发票信息
        $obj = new Invoice();
        $obj->crm_id = $formData['crm_id'];
        $obj->business_name = $formData['business_name'];
        $obj->customer_name = $formData['customer_name'];
        $obj->ticket_name = $formData['ticket_name'];
        $obj->tax_num = $formData['tax_num'];
        $obj->address = $formData['address'];
        $obj->mobile = $formData['mobile'];
        $obj->money = $formData['money'];
        $obj->ticket_month = $formData['ticket_month'];
        $obj->ticket_day = $formData['ticket_day'];
        $res = $obj->save();

        if ($res) {
            $data = ['status' => 1, 'message' => '发票添加成功'];
        } else {
            $data = ['status' => 0, 'message' => '发票添加失败'];
        }
        return $data;
    }

    /**
     * 发票删除方法
     */
    public function delete()
    {
        //获取id
        $id = request()->get('id');

        //查询发票是否存在
        $data = Invoice::find($id);

        if ($data == null) {
            return ['status' => 0, 'message' => '未找到此发票或已被删除'];
        }

        //执行软删除 修改状态90
        $res = Invoice::where('id', $id)->update(['status' => '90']);

        if ($res == 1) {
            $data = ['status' => 1, 'message' => '发票已删除'];
        } else {
            $data = ['status' => 0, 'message' => '删除未成功'];
        }

        return $data;

    }

    /**
     * 发票修改页面
     */
    public function edit()
    {
        //获取id
        $id = request()->get('id');

        //查询此发票是否存在
        $data = Invoice::find($id);

        return view('admin.invoice.edit', ['data' => $data]);
    }

    /**
     * 发票修改方法
     */
    public function update()
    {
        $formData = request()->except('_token', 's');

        $res = Invoice::where('id', $formData['id'])->update($formData);

        if ($res) {
            $data = ['status' => 1, 'message' => '发票修改成功'];
        } else {
            $data = ['status' => 0, 'message' => '发票修改失败'];
        }

        return $data;
    }

}
