<?php

namespace App\models;
use Illuminate\Database\Eloquent\Model;
use DB;

class ICR_ShopSettlementRec_d extends Model {

    protected $connection = 'pm_mysql';
    public $table = 'icr_shopsettlementrec_d';
    public $primaryKey = 'ssrd_serno';
    public $timestamps = false;
    public $incrementing = false;

}
