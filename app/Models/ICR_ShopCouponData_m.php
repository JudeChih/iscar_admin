<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * 商家基本資料
 */
class ICR_ShopCouponData_m extends Model {

    protected $connection = 'pm_mysql';
    public $table = 'icr_shopcoupondata_m';
    public $primaryKey = 'scm_id';
    public $timestamps = false;
    public $incrementing = false;

}