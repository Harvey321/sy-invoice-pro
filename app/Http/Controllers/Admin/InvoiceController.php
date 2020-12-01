<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Invoice;
use Illuminate\Http\Request;
//use Maatwebsite\Excel\Excel;
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


//        if (request()->isMethod('POST')) {
//            //搜索提交处理
//            //高级搜索
//            $data = request()->all();
//            $query = CMSCI::where('id', '<>', NULL);
//            if (isset(request()->querywords)) {
//                $query = CMSCI::where(
//                    'name',
//                    'like',
//                    '%' . Input::get('querywords') . '%'
//                )->orWhere('code', 'like', '%'.Input::get('querywords').'%');
//            }
//            if (isset($data['owner_org'])) {
//                $query = $query->where('owner_org', $data['owner_org']);
//            }

//        dd(strtotime('2020-10'));


        $query = Invoice::orderBy('id', 'DESC');

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
        return view('admin.invoice.add');
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
            $obj->business_name = $formData['business_name'];
            $obj->customer_name = $formData['customer_name'];
            $obj->ticket_name = $formData['ticket_name'];
            $obj->tax_num = $formData['tax_num'];
            $obj->address = $formData['address'];
            $obj->mobile = $formData['mobile'];
            $obj->money = $formData['money'];
            $obj->ticket_day = $formData['ticket_day'];
            $obj->ticket_month = strtotime($formData['yearMonth'][$i]);
            $obj->save();
        }
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

        return view('admin.invoice.edit', ['data' => $data]);
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
     * @param $width
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
            $month_old = strtotime('-1 month');
            $month_new = strtotime('0 month');
        }

        $dataList = $query
            ->whereBetween('ticket_month', [$month_old, $month_new])
            ->get();

        $dataList = json_decode(json_encode($dataList), true);

        foreach ($dataList as $key => $value) {
            foreach ($value as $k => $v) {
                $value[$k] = "\t" . $v . "\t";
            }
            $dataList[$key] = $value;
        }

        $arr = Invoice::$field;

        array_unshift($dataList, $arr);

        $title = date('Y-m', $month_old) . '-' . date('Y-m', $month_new) . '订单数据表';

        self::exportExcel($title, $dataList);
    }


    function planTask()
    {
        $obj = new Invoice();
        $obj->crm_id = '1111111111111111111';
        $obj->business_name = '1111111111111111111';
        $obj->customer_name = '1111111111111111111';
        $obj->ticket_name = '1111111111111111111';
        $obj->tax_num = '1111111111111111111';
        $obj->address = '1111111111111111111';
        $obj->mobile = '1111111111111111111';
        $obj->money = '1111111111111111111';
        $obj->ticket_day = '1111111111111111111';
        $obj->ticket_month = '1601510400';
        $obj->save();
    }


}
