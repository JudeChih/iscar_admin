<?php

namespace App\models;
use Illuminate\Database\Eloquent\Model;
use DB;

class ICR_ShopCouponData_g extends Model {

    protected $connection = 'pm_mysql';
    public $table = 'icr_shopcoupondata_g';
    public $primaryKey = 'scg_id';
    public $timestamps = false;
    public $incrementing = false;

}
