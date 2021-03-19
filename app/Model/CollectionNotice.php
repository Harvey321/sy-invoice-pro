<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CollectionNotice extends Model
{
    /**
     * 与模型关联的数据表
     */
    protected $table = 'collection_notice';

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
        'iid',  //发票表id
        'collection',  //收款金额
        'status',  //10已读/20未读
        'created_at',
        'updated_at'
    ];



}
