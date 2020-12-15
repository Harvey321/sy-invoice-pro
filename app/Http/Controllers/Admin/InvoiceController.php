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

        //获取用户的角色id  当用户为业务员时  给定只显示业务绑定的合同
        if (session()->get('user')->role->first()->pivot->rid == 1003) {
            $query->where('uid', session()->get('user')->role->first()->pivot->uid);
        }

        if (isset($request->all()['invoice_company'])) {
            $query->where('invoice_company', $request->all()['invoice_company']);
            $data['invoice_company'] = $request->all()['invoice_company'];
        } else {
            $data['invoice_company'] = 10;
        }

        if (isset($request->all()['crm_id'])) {
            $query->where('crm_id', $request->all()['crm_id']);
            $data['crm_id'] = $request->all()['crm_id'];
        }

        if (isset($request->all()['tax_num'])) {
            $query->where('tax_num', $request->all()['tax_num']);
            $data['tax_num'] = $request->all()['tax_num'];
        }

        if (isset($request->all()['month_old']) && isset($request->all()['month_new'])) {
            $data['month_old'] = strtotime($request->all()['month_old']);
            $data['month_new'] = strtotime($request->all()['month_new']);
        } else {
            $data['month_old'] = strtotime('-1 month');
            $data['month_new'] = strtotime('0 month');
        }

        $data['dataList'] = $query
            ->whereBetween('ticket_month', [$data['month_old'], $data['month_new']])
            ->get();

        $data['title'] = '发票列表';

        return view('admin.invoice.index', ['data' => $data]);
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
            if (isset($formData['express'])) {
                $obj->express = $formData['express'];
            }
            if (isset($formData['express_num'])) {
                $obj->express_num = $formData['express_num'];
            }
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

        if (isset($formData['ticket_month'])) {
            $formData['ticket_month'] = strtotime($formData['ticket_month']);
        }

        //如果没有设置crmid 那就是修改对应id的单条的备注信息
        if (!isset($formData['crm_id'])) {
            $res = Invoice::where('id', $formData['id'])->update($formData);//更新单条
            if (!$res) {
                return ['status' => 0, 'message' => '发票修改失败'];
            }
            return ['status' => 1, 'message' => '发票修改成功'];
        }

        //如果设置了crm_id  修改一部分整体修改的信息  然后在修改一部分当条数据

        //获取所有相同crm_id的发票
        $dataList = Invoice::where('crm_id', $formData['crm_id'])->get();
        $dataList = json_decode(json_encode($dataList), true);//转为数组

        //需要整体修改的信息
        if (isset($formData['company_name'])) {
            $tmp['company_name'] = $formData['company_name']; //公司名
        }
        $tmp['invoice_type'] = $formData['invoice_type'];//发票类型
        $tmp['ticket_name'] = $formData['ticket_name']; //开票名
        $tmp['tax_num'] = $formData['tax_num'];//税号
        $tmp['address_mobile'] = $formData['address_mobile'];//地址/电话
        $tmp['bank_account'] = $formData['bank_account'];//开户行/账户
        $tmp['money'] = $formData['money'];//金额
        $tmp['ticket_day'] = $formData['ticket_day'];//到期提醒日

        //遍历所有比当前开票月份大的发票 对其进行整体修改
        foreach ($dataList as $item) {
            if ($item['ticket_month'] >= $formData['ticket_month']) {
                $res = Invoice::where('id', $item['id'])->update($tmp);
                if (!$res) {
                    return ['status' => 0, 'message' => '发票修改失败'];
                }
            }
        }

        Invoice::where('id', $formData['id'])->update($formData);
        return ['status' => 1, 'message' => '发票修改成功'];

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

        if (isset($request->all()['invoice_company'])) {
            $query->where('invoice_company', $request->all()['invoice_company']);
            $data['invoice_company'] = $request->all()['invoice_company'];
        } else {
            $data['invoice_company'] = 10;
        }

        if (isset($request->all()['crm_id'])) {
            $query->where('crm_id', $request->all()['crm_id']);
            $data['crm_id'] = $request->all()['crm_id'];
        }

        if (isset($request->all()['tax_num'])) {
            $query->where('tax_num', $request->all()['tax_num']);
            $data['tax_num'] = $request->all()['tax_num'];
        }

        if (isset($request->all()['month_old']) && isset($request->all()['month_new'])) {
            $data['month_old'] = strtotime($request->all()['month_old']);
            $data['month_new'] = strtotime($request->all()['month_new']);
        } else {
            $data['month_old'] = strtotime('-1 month');
            $data['month_new'] = strtotime('0 month');
        }

        $data['dataList'] = $query
            ->whereBetween('ticket_month', [$data['month_old'], $data['month_new']])
            ->get();


        foreach ($data['dataList'] as $key => $value) {
            unset($value['blank']);//空白字段留后
            unset($value['created_at']);//导出不需要
            unset($value['updated_at']);//导出不需要

            $username = $value->invoiceUid->first()->username;//获取业务员名字
            $value = json_decode(json_encode($value), true);//转为数组
            unset($value['invoice_uid']);//因上执行方法数据中增加一个数组
            $value['uid'] = $username;//直接用uid替换成业务员名字放到excl中显示

            $value['ticket_month'] = date('Y-m', $value['ticket_month']);

            switch ($value['status']) {
                case 10:
                    $value['status'] = '未开票';
                    break;
                case 20:
                    $value['status'] = '已开票';
                    break;
                case 90:
                    $value['status'] = '发票作废';
                    break;
            }

            switch ($value['invoice_company']) {
                case 10:
                    $value['invoice_company'] = '上海双于通信技术有限公司';
                    break;
                case 20:
                    $value['invoice_company'] = '深圳是方通信技术有限公司';
                    break;
                case 30:
                    $value['invoice_company'] = '江西双格通信技术有限公司';
                    break;
            }

            switch ($value['invoice_type']) {
                case 10:
                    $value['invoice_type'] = '普票';
                    break;
                case 20:
                    $value['invoice_type'] = '专票';
                    break;
                case 30:
                    $value['invoice_type'] = '收据';
                    break;
            }


            foreach ($value as $k => $v) {
                if ($k == 'money') {
                    continue;
                }
                $value[$k] = "\t" . $v . "\t";
            }

            $data['dataList'][$key] = $value;
        }

        $data['dataList'] = json_decode(json_encode($data['dataList']), true);

        $arr = Invoice::$field;

        array_unshift($data['dataList'], $arr);

        $title = date('Y.m', $data['month_old']) . '-' . date('Y.m', $data['month_new']) . '订单数据表';

        self::exportExcel($title, $data['dataList']);
    }


    public function search()
    {
        return view('admin.invoice.search');
    }

}
