<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * 与模型关联的数据表
     */
    protected $table = 'user';

    /**
     * 主键
     */
    public $primaryKey = 'id';

    //开启白名单
    protected $guarded = [
        'username',
        'password',
        'company',
        'email',
        'mobile',
        'address',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * 该模型是否被自动维护时间戳
     */
    public $timestamps = true;

    public function messages(){
        return [
            'username.required' => '请填写用户名称',
            'password.required'         => '请填写密码',
            'company.required' => '请填写公司名称',
            'email.required'         => '请填写邮箱地址',
            'mobile.required'         => '请填写联系电话',
            'mobile.max'         => '请填写正确的手机号码',
            'address.required'         => '请填写联系地址',
        ];
    }

    public function role()
    {
        return $this->belongsToMany('App\Model\Admin\Role','user_role','uid','rid')
            ->where('role.status', 10);
    }


}
