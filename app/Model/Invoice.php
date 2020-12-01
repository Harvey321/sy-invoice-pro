<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * 与模型关联的数据表
     */
    protected $table = 'invoice';

    /**
     * 主键
     */
    public $primaryKey = 'id';

    /**
     * 该模型是否被自动维护时间戳
     */
    public $timestamps = true;

    //开启白名单
    protected $guarded = [
        'crm_id',  //crmId
        'business_name',  //业务员
        'customer_name',  //客户名
        'ticket_name',  //开票名
        'tax_num',  //税号
        'address',  //地址
        'mobile',  //电话
        'money',  //金额
        'ticket_month',  //开票月份
        'ticket_day',  //开始日
        'status',  //10发票正常/90发票作废
        'created_at',
        'updated_at'
    ];

    //字段名
    public static $field = [
        'ID',
        'crdID',
        '业务员',
        '客户名',
        '开票名',
        '税号',
        '地址',
        '电话',
        '金额',
        '开票月份',
        '终止日',
        '状态',
        '创建时间',
        '更新时间'
    ];



}
