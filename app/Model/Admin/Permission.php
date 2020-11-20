<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * 与模型关联的数据表
     */
    public $table = 'permission';

    /**
     * 主键
     */
    public $primaryKey = 'id';

    //开启白名单
    protected $guarded = [
        'per_name',
        'per_url',
        'status',
    ];

    /**
     * 该模型是否被自动维护时间戳
     */
    public $timestamps = false;


}
