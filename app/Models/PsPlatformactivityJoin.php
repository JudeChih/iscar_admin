<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * 商家基本資料
 */
class PsPlatformactivityJoin extends Model {

		protected $connection = 'service_mysql';
    public $table = 'ps_platformactivity_join';
    public $primaryKey = 'paj_id';
    public $timestamps = false;
   // public $incrementing = false;

}
