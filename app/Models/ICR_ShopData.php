<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * 商家基本資料
 */
class ICR_ShopData extends Model {

    protected $connection = 'pm_mysql';
    public $table = 'icr_shopdata';
    public $primaryKey = 'sd_id';
    public $timestamps = false;
    public $incrementing = false;

}
