<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoicePro extends Model
{
    /**
     * 与模型关联的数据表
     */
    protected $table = 'invoice_pro';

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
        'num',  //序号
        'invoice_company',  //开票公司 10上海双于/20深圳是方/30江西双格
        'u_name',  //业务员名
        'company_name',  //公司名
        'ticket_name',  //开票名
        'tax_num',  //税号
        'address_mobile',  //地址/电话
        'bank_account',  //开户行/账户
        'money',  //金额
        'invoice_type',  //发票类型 10普票/20专票/30收据
        'express',  //快递信息
        'express_num',  //快递单号
        'ticket_month',  //开票月份
        'ticket_day',  //到期提醒日
        'description',  //备注
        'collection',  //收款金额
        'status',  //10未开票/20已开票/90发票作废
        'created_at',
        'updated_at'
    ];


    //字段名
    public static $field = [
        'ID',
        '序号',
        '开票公司',
        '业务员名',
        '公司名',
        '开票名',
        '税号',
        '地址/电话',
        '开户行/账户',
        '金额',
        '发票类型',
        '快递信息',
        '快递单号',
        '开票月份',
        '到期提醒日',
        '备注',
        '收款金额',
        '状态',
    ];


}
