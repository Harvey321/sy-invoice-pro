<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Invoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{

    public function planTask()
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
