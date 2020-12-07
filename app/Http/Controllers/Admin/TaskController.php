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
        echo 4444;
        Excel::create(iconv('UTF-8', 'GBK', $title), function ($excel) use ($list) {
            $excel->sheet('score', function ($sheet) use ($list) {
                $sheet->rows($list);
            });
        })->store('xls', storage_path('excel/exports'));
        echo 5555;

    }

    //计划任务每月发送邮件 下月到期合同
    public function planTask()
    {

        //获取需要发送邮件的数据data
        $invoiceList = Invoice::all();
        $data = [];//符合条件的发票
        $new_date = strtotime('-1 day');//当前时间戳
        $month_end_data = strtotime('+1 month');//一个月后的时间戳
        foreach ($invoiceList as $item) {
            $invoice_end = strtotime($item['ticket_day']);//当前发票截至时间
            if ($invoice_end > $new_date && $invoice_end < $month_end_data) {
                $data[] = $item;
            }
        }
        $data = json_decode(json_encode($data), true);//查询对象转数组

        //添加表头
        $arr = Invoice::$field;
        array_unshift($data, $arr);

        //使用数据生成xls     每日一次不用担心文件名重复问题
        $title = '次月合同期满客户表' . date('Y-m-d', time());
        echo 222;

        //导出EXcel
        self::exportExcel($title, $data);

        echo 333;


        //获取临时文件地址
        $temp_address = storage_path('excel/exports') . '/' . $title . '.xls';

        //附件文件名
        $file_name = $title . '.xls';
        iconv("utf-8","gb2312",$file_name);
        //发送邮件
        $mail = new MailController();
echo 6666;
        $mail->send('次月合同期满客户表', '604666621@qq.com', '上海双于通信技术有限公司', $temp_address, $file_name);
    }

}
