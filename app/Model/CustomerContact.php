<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    /**
     * 与模型关联的数据表
     */
    protected $table = 'customer_contact';

    /**
     * 模型日期列的存储格式
     */
//    protected $dateFormat = 'U';

    /**
     * 该模型是否被自动维护时间戳
     */
    public $timestamps = true;

    /**
     * 模型属性验证信息
     */
    public $messages = [
        'username.required' => '请填写您的姓名',
        'mobile.required'         => '请填写手机号码',
        'corporate_name.required' => '请填写公司名称',
        'phone.required'         => '请填写联系电话',
        'theme_content.max'         => '内容请勿超过240字数'
    ];


}
