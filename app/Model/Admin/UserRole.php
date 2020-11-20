<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * 与模型关联的数据表
     */
    protected $table = 'user_role';

    /**
     * 主键
     */
    public $primaryKey = 'id';

    //开启白名单
    protected $guarded = [
        'uid',
        'rid',
    ];

    /**
     * 该模型是否被自动维护时间戳
     */
    public $timestamps = false;


}
