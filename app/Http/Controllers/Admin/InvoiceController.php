<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Model\Admin\Role;
use App\Model\Admin\User;
use App\Model\CollectionNotice;
use App\Model\Invoice;
use App\Model\InvoicePro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        if (isset($request->all()['num'])) {
            $query->where('num', $request->all()['num']);
            $data['num'] = $request->all()['num'];
        }

        if (isset($request->all()['collection'])) {
            //已收款
            if ($request->all()['collection'] == 10) {
                $query->where('collection', '!=', '');
                $data['collection'] = $request->all()['collection'];
            }
            //未收款
            if ($request->all()['collection'] == 20) {
                $query->where('collection', '');
                $data['collection'] = $request->all()['collection'];
            }
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

        //发票通知
        $data['noticeList'] = CollectionNotice::all();
        $data['noticeListSign'] = 1;
        foreach ($data['noticeList'] as $item) {
            if ($item->status == 20) {
                $data['noticeListSign'] = 0;
            }
        }

        return view('admin.invoice.index', ['data' => $data]);
    }

    public function signRead()
    {
        $res = CollectionNotice::where(['status' => 20])->update(['status' => 10]);
        return ['status' => 1, 'message' => '您已阅读通知'];
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
            $users = explode("-", $formData['uid']);
            $obj->uid = $users[0];
            $obj->u_name = $users[1];
            $obj->num = $formData['num'];
            $obj->company_name = $formData['company_name'];
            $obj->ticket_name = $formData['ticket_name'];
            $obj->tax_num = $formData['tax_num'];
            $obj->address_mobile = $formData['address_mobile'];
            $obj->bank_account = $formData['bank_account'];
            $obj->money = $formData['money'];
            $obj->invoice_type = $formData['invoice_type'];
            $obj->collection = $formData['collection'];
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

        $invoiceList = Invoice::where('id', $formData['id'])->first();

        //如果修改的金额不等于空 并且与之前不同 则添加金额修改通知
        if ($formData['collection'] != $invoiceList->collection && $formData['collection'] != '') {
            $obj = new CollectionNotice();
            $obj->iid = $formData['id'];
            $obj->money = ($formData['num'] == null ? '记录id号为' . $formData['id'] : '序号:' . $formData['num']) .
                '&nbsp;&nbsp;' . $formData['company_name'] . '&nbsp;&nbsp;' .
                '收款金额:' . $formData['collection'] . '元'; //序号xxxx xxx公司 修改收款金额
            $obj->status = 20;
            $obj->save();
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

        if (isset($request->all()['num'])) {
            $query->where('num', $request->all()['num']);
            $data['num'] = $request->all()['num'];
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
            unset($value['created_at']);//导出不需要
            unset($value['updated_at']);//导出不需要

//            $username = $value->invoiceUid->first()->username;//获取业务员名字
            $value = json_decode(json_encode($value), true);//转为数组
//            unset($value['invoice_uid']);//因上执行方法数据中增加一个数组
//            $value['uid'] = $username;//直接用uid替换成业务员名字放到excl中显示


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

        $arr_one = Invoice::$field;
        $arr_two = Invoice::$fieldEnglish;

        array_unshift($data['dataList'], $arr_one);
        array_unshift($data['dataList'], $arr_two);

        $title = date('Y.m', $data['month_old']) . '-' . date('Y.m', $data['month_new']) . '订单数据表';
        self::exportExcel($title, $data['dataList']);
    }


    public function search()
    {
        return view('admin.invoice.search');
    }


    /**
     * 导入发票(number条)
     * @return bool&number  false失败 或 成功多少条
     */
    public function uploadFile()
    {
        $file = $_FILES['file'];
        //判断是否上传文件
        if ($file['error'] != 4) {
            // 允许上传的后缀
            $allowedExts = array("xlsx", "xls");

            //分割字符
            $temp = explode(".", $file["name"]);

            // 获取文件后缀名
            $extension = end($temp);

            //判断上传条件
            if (in_array($extension, $allowedExts)) {

                //判断上传的文件是否错误
                if ($file["error"] > 0) {
                    return false;
                } else {
                    $res = 0;
                    //导入excel
                    Excel::load(iconv('UTF-8', 'GBK', $file['tmp_name']), function ($reader) use (&$res) {
                        $data = $reader->all()->toArray();
                        array_shift($data);

                        foreach ($data as $item) {

                            //如查询到序号 则说明已经添加则返回false; 不让添加继续;直接跳过
                            $data = Invoice::where('num', trim($item['num'], "\t"))->first();
                            if ($data != null) {
                                continue;
                            }
                            $obj = new Invoice();
                            $obj->num = trim($item['num'], "\t");
//                            $obj->invoice_company = trim($item['invoice_company'], "\t");
                            switch (trim($item['invoice_company'], "\t")) {
                                case '上海双于通信技术有限公司':
                                    $obj->invoice_company = 10;
                                    break;
                                case '深圳是方科技有限公司':
                                    $obj->invoice_company = 20;
                                    break;
                                case '江西双格科技有限公司':
                                    $obj->invoice_company = 30;
                                    break;
                            }

                            $obj->uid = trim($item['uid'], "\t");
                            $obj->u_name = trim($item['u_name'], "\t");
                            $obj->company_name = trim($item['company_name'], "\t");
                            $obj->ticket_name = trim($item['ticket_name'], "\t");
                            $obj->tax_num = trim($item['tax_num'], "\t");
                            $obj->address_mobile = trim($item['address_mobile'], "\t");
                            $obj->bank_account = trim($item['bank_account'], "\t");
                            $obj->money = trim($item['money'], "\t");

                            switch (trim($item['invoice_type'], "\t")) {
                                case '普票':
                                    $obj->status = 10;
                                    break;
                                case '专票':
                                    $obj->status = 20;
                                    break;
                                case '收据':
                                    $obj->status = 30;
                                    break;
                            }

                            $obj->express = trim($item['express'], "\t");
                            $obj->express_num = trim($item['express_num'], "\t");
                            $obj->ticket_month = trim($item['ticket_month'], "\t");
                            $obj->ticket_day = trim($item['ticket_day'], "\t");
                            $obj->description = trim($item['description'], "\t");
                            $obj->collection = trim($item['collection'], "\t");

                            switch (trim($item['status'], "\t")) {
                                case '未开票':
                                    $obj->status = 10;
                                    break;
                                case '已开票':
                                    $obj->status = 20;
                                    break;
                                case '发票作废':
                                    $obj->status = 90;
                                    break;
                            }

                            $obj->save();
                            $res++;
                        }

                    });
                    return json_encode(['status' => 'success', 'data' => $res]);
                }

            } else {
                return false;
            }

        } else {
            return false;
        }


    }

    /**
     * 导入excel数据
     * @param $title
     * @param $list
     */
    public function importExcel($fileAddress)
    {
        Excel::load(iconv('UTF-8', 'GBK', $fileAddress), function ($reader) {
            $data = $reader->all()->toArray();
            foreach ($data as $item) {
                dump($item);
            }
        });
    }


}
