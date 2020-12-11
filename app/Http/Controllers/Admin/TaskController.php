<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Model\Invoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class TaskController extends Controller
{
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
        })->store('xls', storage_path('excel/exports'));
    }

    //计划任务每日发送邮件 下月到期合同
    public function planTask()
    {
        //获取需要发送邮件的数据data
        $invoiceList = Invoice::all();
        $data = [];//符合条件的发票
        $new_date = time();

        ;//当前时间戳

        foreach ($invoiceList as $item) {
            $invoice_end = strtotime($item['ticket_day']);//当前发票截至时间

            $thirty_day = 2592000;//60*60*24*30 三十天的时间戳
            $three_day = 259200;//3天的时间戳

            $twenty_seven_day = $thirty_day - $three_day; //27天的差值

            //截至日期于当前的时间差    大于27天 小于30天
            $diff = $invoice_end - $new_date;

            if (($invoice_end > $new_date) && $diff > $twenty_seven_day && $diff < $thirty_day) {
                unset($item['blank']);//空白字段留后
                unset($item['created_at']);//导出不需要
                unset($item['updated_at']);//导出不需要

                $username = $item->invoiceUid->first()->username;//获取业务员名字
                $item = json_decode(json_encode($item), true);//转为数组
                unset($item['invoice_uid']);//因上执行方法数据中增加一个数组
                $item['uid'] = $username;//直接用uid替换成业务员名字放到excl中显示

                switch ($item['status']) {
                    case 10:
                        $item['status'] = '未开票';
                        break;
                    case 20:
                        $item['status'] = '已开票';
                        break;
                    case 90:
                        $item['status'] = '发票作废';
                        break;
                }

                switch ($item['invoice_company']) {
                    case 10:
                        $item['invoice_company'] = '上海双于通信技术有限公司';
                        break;
                    case 20:
                        $item['invoice_company'] = '深圳是方通信技术有限公司';
                        break;
                    case 30:
                        $item['invoice_company'] = '江西双格通信技术有限公司';
                        break;
                }

                switch ($item['invoice_type']) {
                    case 10:
                        $item['invoice_type'] = '普票';
                        break;
                    case 20:
                        $item['invoice_type'] = '专票';
                        break;
                    case 30:
                        $item['invoice_type'] = '收据';
                        break;
                }
                $data[] = $item;
            }

        }
        dd($data);
        $data = json_decode(json_encode($data), true);//查询对象转数组
        if (empty($data)) {
            return '未查询到内容';
        }

        //添加表头
        $arr = Invoice::$field;
        array_unshift($data, $arr);


        //使用数据生成xls     每日一次不用担心文件名重复问题
        $title = '次月合同期满客户Invoice-Email' . date('Y-m-d', time());

        //导出EXcel
        self::exportExcel($title, $data);

        //获取临时文件地址
        $temp_address = storage_path('excel/exports') . '/' . iconv('UTF-8', 'GBK', $title) . '.xls';

        //附件文件名
        $file_name = $title . '.xls';

        //发送邮件
        $mail = new MailController();
        $mail->send('次月合同期满客户Invoice-Email', '604666621@qq.com', '上海双于通信技术有限公司', $temp_address, $file_name);
    }

}
