<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * 与模型关联的数据表
     */
    protected $table = 'role';

    /**
     * 主键
     */
    public $primaryKey = 'id';

    //开启白名单
    protected $guarded = [
        'rolename',
        'sign',
        'status',
    ];

    /**
     * 该模型是否被自动维护时间戳
     */
    public $timestamps = false;

    public $messages = [
        'rolename.required' => '请填写角色名称',
    ];

    //添加动态属性关联权限模型
    public function permission()
    {
        return $this->belongsToMany('App\Model\Admin\Permission','role_permission','rid','pid')
            ->where('permission.status',10);
    }

}
