<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * 商家基本資料
 */
class PsPlatformactivityItem extends Model {

		protected $connection = 'service_mysql';
    public $table = 'ps_platformactivity_item';
    public $primaryKey = 'pai_id';
    public $timestamps = false;
    //public $timestamps = false;
   // public $incrementing = false;

}
