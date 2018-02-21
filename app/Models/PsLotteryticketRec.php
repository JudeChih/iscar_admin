<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * 商家基本資料
 */
class PsLotteryticketRec extends Model {

		protected $connection = 'service_mysql';
    public $table = 'ps_lotteryticket_rec';
    public $primaryKey = 'ltr_serno';
    public $timestamps = false;
   // public $incrementing = false;

}
