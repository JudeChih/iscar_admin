<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PsPlatformannouncement extends Model {

//
		protected $connection = 'service_mysql';
    public $table = 'ps_platformannouncement';
    public $primaryKey = 'pa_id';
    public $timestamps = false;
   // public $incrementing = false;

}
