<?php

namespace App\Repositories;

use App\Models\ICR_ShopDataModifyRecord;
use App\Library\CommonTools;
use DB;

class ICR_ShopDataModifyRecordRepository  {

    /**
     * 新增特店異動資料
     * @param  [type] $arraydata [description]
     * @return [type]            [description]
     */
    public function insertData($arraydata){
        try {
            if ( !CommonTools::CheckArrayValue($arraydata, "sd_id") || !CommonTools::CheckArrayValue($arraydata, "sdmr_operationtype") || !CommonTools::CheckArrayValue($arraydata, "sdmr_modifyitem")) {
                return false;
            }
            $savedata['sd_id'] = $arraydata['sd_id'];
            $savedata['sdmr_operationtype'] = $arraydata['sdmr_operationtype'];
            $savedata['sdmr_modifyitem'] = $arraydata['sdmr_modifyitem'];
            if (CommonTools::CheckArrayValue($arraydata, "scm_id")) {
                $savedata['scm_id'] = $arraydata['scm_id'];
            }
            if (CommonTools::CheckArrayValue($arraydata, "sdmr_modifyuser")) {
                $savedata['sdmr_modifyuser'] = $arraydata['sdmr_modifyuser'];
            }
            if (CommonTools::CheckArrayValue($arraydata, "sdmr_modifyreason")) {
                $savedata['sdmr_modifyreason'] = $arraydata['sdmr_modifyreason'];
            }
            $savedata['create_user'] = 'webapi';
            $savedata['last_update_user'] = 'webapi';
            $savedata['create_date'] = \Carbon\Carbon::now();
            $savedata['last_update_date'] = \Carbon\Carbon::now();
            DB::table('icr_shopdatamodifyrecord')->insert($savedata);
            return true;
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

}
