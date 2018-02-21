<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * 商家基本資料
 */
class ICR_SystemParameter extends Model {

//
    public $table = 'icr_systemparameter';
    public $primaryKey = 'sp_serno';
    public $timestamps = false;
    public $incrementing = false;
   
}
