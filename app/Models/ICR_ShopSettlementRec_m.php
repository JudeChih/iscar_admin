<?php

namespace App\models;
use Illuminate\Database\Eloquent\Model;
use DB;

class ICR_ShopSettlementRec_m extends Model {

    protected $connection = 'pm_mysql';
    public $table = 'icr_shopsettlementrec_m';
    public $primaryKey = 'ssrm_id';
    public $timestamps = false;
    public $incrementing = false;

}
