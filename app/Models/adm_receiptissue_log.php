<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class adm_receiptissue_log extends Model {

    /**
     * 資料表名稱
     * @var string
     */
    protected $table = 'adm_receiptissue_log';

    /**
     * 主鍵值
     * @var string
     */
    protected $primaryKey = 'ril_serno';

    /**
     * 是否自動遞增
     * @var string
     */
    public $incrementing = true;

    /**
     * 是否自動插入現在時間
     *
     * @var bool
     */
    public $timestamps = false;

}