<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Model\Admin\Role;
use App\Model\Admin\User;
use App\Model\Invoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        $query = Invoice::orderBy('id', 'DESC');

        //查询登录用户的信息
        $user = User::where('id', session()->get('user')->id)->first();

//        if (!empty($user->role[0]['sign'] == 'business')) {
//            $query->where('business_name', $user->username);
//        }

        if (isset($request->all()['month_old']) && isset($request->all()['month_new'])) {
            $month_old = strtotime($request->all()['month_old']);
            $month_new = strtotime($request->all()['month_new']);
        } else {
            $month_old = strtotime('-1 month');
            $month_new = strtotime('0 month');
        }

        $dataList = $query
            ->whereBetween('ticket_month', [$month_old, $month_new])
            ->get();

        return view(
            'admin.invoice.index',
            [
                'title' => '发票列表',
                'dataList' => $dataList,
                'month_old' => $month_old,
                'month_new' => $month_new,
            ]
        );
    }

    /**
     * 发票添加页面
     */
    public function add()
    {
        $user = User::all();
        return view('admin.invoice.add', ['user' => $user]);
    }

    /**
     * 发票添加方法
     */
    public function create()
    {
        $formData = request()->except(['_token', 's', 'year', 'month']);
        $formData['yearMonth'] = explode(',', $formData['yearMonth']);

        for ($i = 0; count($formData['yearMonth']) > $i; $i++) {
            //保存发票信息
            $obj = new Invoice();
            $obj->crm_id = $formData['crm_id'];
            $obj->invoice_company = $formData['invoice_company'];
            $obj->uid = $formData['uid'];
            $obj->company_name = $formData['company_name'];
            $obj->ticket_name = $formData['ticket_name'];
            $obj->tax_num = $formData['tax_num'];
            $obj->address_mobile = $formData['address_mobile'];
            $obj->bank_account = $formData['bank_account'];
            $obj->money = $formData['money'];
            $obj->invoice_type = $formData['invoice_type'];
            $obj->express = $formData['express'];
            $obj->express_num = $formData['express_num'];
            $obj->ticket_month = strtotime($formData['yearMonth'][$i]);
            $obj->ticket_day = $formData['ticket_day'];
            $obj->save();
        }

        $bussiness_name = User::find($formData['uid'])->first()->username;
        $mail = new MailController();
        $mail->newInvoiceSend('新加入合同发票信息', '604666621@qq.com', '上海双于通信技术有限公司', $bussiness_name, $formData['crm_id'], $formData['company_name']);

        return ['status' => 1, 'message' => '发票添加成功'];
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

        $user = User::all();


        return view('admin.invoice.edit', ['data' => $data, 'user' => $user]);
    }

    /**
     * 发票修改方法
     */
    public function update()
    {
        $formData = request()->except('_token', 's');
        $formData['ticket_month'] = strtotime($formData['ticket_month']);

        $res = Invoice::where('id', $formData['id'])->update($formData);

        if ($res) {
            $data = ['status' => 1, 'message' => '发票修改成功'];
        } else {
            $data = ['status' => 0, 'message' => '发票修改失败'];
        }

        return $data;
    }

    /**
     * 导出excel数据
     * @param $title
     * @param $list
     */
    public function exportExcel($title, $list)
    {
        Excel::create(iconv('UTF-8', 'GBK', $title), function ($excel) use ($list) {
            $excel->sheet('score', function ($sheet) use ($list) {
                $sheet->rows($list);
            });
        })->export('xls');
    }

    public function ExcelGet(Request $request)
    {
        $query = Invoice::orderBy('id', 'DESC');

        if (isset($request->all()['month_old']) && isset($request->all()['month_new'])) {
            $month_old = strtotime($request->all()['month_old']);
            $month_new = strtotime($request->all()['month_new']);
        } else {
            $month_old = strtotime(' - 1 month');
            $month_new = strtotime('0 month');
        }

        $dataList = $query
            ->whereBetween('ticket_month', [$month_old, $month_new])
            ->get();

        $dataList = json_decode(json_encode($dataList), true);

        foreach ($dataList as $key => $value) {
            unset($value['blank']);//空白字段留后
            unset($value['created_at']);//导出不需要
            unset($value['updated_at']);//导出不需要

            foreach ($value as $k => $v) {
//                if ($value['invoice_company']== )
                $value[$k] = "\t" . $v . "\t";
            }

            $dataList[$key] = $value;


        }

        $arr = Invoice::$field;

        array_unshift($dataList, $arr);

        $title = date('Y.m', $month_old) . '-' . date('Y.m', $month_new) . '订单数据表';
//        dump($title);
//        dd($dataList);

        self::exportExcel($title, $dataList);
    }

}
