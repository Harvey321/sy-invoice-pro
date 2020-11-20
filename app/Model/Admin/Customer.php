<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * 与模型关联的数据表
     */
    protected $table = 'customer';

    /**
     * 主键
     */
    public $primaryKey = 'id';

    /**
     * 开启白名单
     **/
    protected $guarded = [
        'username',
        'password',
        'company',
        'contacts',
        'contacts_mobile',
        'contacts_email',
        'address',
        'mobile',
        'plan',
        'topology_url',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];


    /**
     * 该模型是否被自动维护时间戳
     */
    public $timestamps = true;

    /**
     * 表单验证返回错误信息
     **/
    public $messages = [
        'username.required' => '请填写客户名称',
        'password.required' => '请填写密码',
        'company.required' => '请填写公司名称',
        'contacts.required' => '请填写联系人',
        'contacts_mobile.required' => '请填写联系人手机',
        'contacts_email.required' => '请填写联系人邮箱',
        'address.required' => '请填写公司地址',
        'mobile.required' => '请填写总机号码',
        'plan.required' => '请填写方案名称',
        'mobile.max' => '请填写正确的手机号码',
    ];

    /**
     *  绑定多对多关系（以及可关联表可查询字段）
     */
    public function product()
    {
        return $this->belongsToMany('App\Model\Product', 'customer_product', 'uid', 'pid')
            ->withPivot(
                'id',
                'name',  //自定义的名字
                'delay',  //延迟
                'route',  //路由
                'flow',  //流量图url
                'description',  //备注
                'status',  //默认10正常使用/20备份/90测试
                'end_at',  //产品到期时间
                'created_at',
                'updated_at'
            )->withTimestamps();
    }

    public function reception_product()
    {
        return $this->belongsToMany('App\Model\Product', 'customer_product', 'uid', 'pid')
            ->where('customer_product.device_status', 10)
            ->withPivot(
                'id',
                'name',  //自定义的名字
                'delay',  //延迟
                'route',  //路由
                'flow',  //流量图url
                'description',  //备注
                'status',  //默认10正常使用/20备份/90测试
                'end_at',  //产品到期时间
                'created_at',
                'updated_at'
            )
            ->withTimestamps();
    }





}
