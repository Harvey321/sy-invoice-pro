<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * 与模型关联的数据表
     */
    protected $table = 'product';

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
        'serial_num',
        'product_name',
        'status',
        'model',
        'created_at',
        'updated_at'
    ];


    /**
     * 模型属性验证信息
     */
    public $messages = [
//        'username.required' => '请填写您的姓名',
//        'mobile.required'         => '请填写手机号码',
//        'corporate_name.required' => '请填写公司名称',
//        'phone.required'         => '请填写联系电话',
//        'theme_content.max'         => '内容请勿超过240字数'
    ];


}
