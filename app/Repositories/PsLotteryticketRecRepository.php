<?php

namespace App\Repositories;

use App\Models\PsLotteryticketRec;
use DB;

class PsLotteryticketRecRepository  {

    //新增資料
    public function InsertData($arraydata) {
     try {
       /* if (
                !\App\Library\Commontools::CheckArrayValue($arraydata, 'paj_id') || !\App\Library\Commontools::CheckArrayValue($arraydata, 'pai_id')
             || !\App\Library\Commontools::CheckArrayValue($arraydata, 'md_id') || !\App\Library\Commontools::CheckArrayValue($arraydata, 'ltr_getdate')
        ) {
            return false;
        }*/
        $savedata['pa_id'] = $arraydata['pa_id'];
        $savedata['paj_id'] = $arraydata['paj_id'];
        $savedata['pai_id'] = $arraydata['pai_id'];
        $savedata['md_id'] = $arraydata['md_id'];
        $savedata['ltr_getdate'] = $arraydata['ltr_getdate'];
        
        
        $paiRepo = new \App\Repositories\PsPlatformactivityItemRepository;
        $paiData=  $paiRepo->getDataByPaiId($arraydata['pai_id']);
        //$paRepo = new \App\Repositories\PsPlatformannouncementRepository;
        //$paData = $paRepo->getDataByPaId($paiData[0]['pa_id']);
        $savedata['ltr_lotterynumber'] = $paiData[0]['pa_shortcode']. str_pad(( ($this->getDataCountByPaId($arraydata['pa_id'])) + 1 ), 7, "0", STR_PAD_LEFT);
        
        if (\App\Library\Commontools::CheckArrayValue($arraydata, "ltr_usestatus")) {
                $savedata['ltr_usestatus'] = $arraydata['ltr_usestatus'];
            } else {
                $savedata['ltr_usestatus'] = '0';
        }
        if (\App\Library\Commontools::CheckArrayValue($arraydata, "ltr_winstatus")) {
                $savedata['ltr_winstatus'] = $arraydata['ltr_winstatus'];
            } else {
                $savedata['ltr_winstatus'] = '0';
        }
        if (\App\Library\Commontools::CheckArrayValue($arraydata, "ltr_prizeitem")) {
                $savedata['ltr_prizeitem'] = $arraydata['ltr_prizeitem'];
            } else {
                $savedata['ltr_prizeitem'] = '0';
        }
        if (\App\Library\Commontools::CheckArrayValue($arraydata, "ltr_remark")) {
                $savedata['ltr_remark'] = $arraydata['ltr_remark'];
        } 
            
        if (\App\Library\Commontools::CheckArrayValue($arraydata, "isflag")) {
                $savedata['isflag'] = $arraydata['isflag'];
            } else {
                $savedata['isflag'] = '1';
        }
        if (\App\Library\Commontools::CheckArrayValue($arraydata, "create_user")) {
                $savedata['create_user'] = $arraydata['create_user'];
            } else {
                $savedata['create_user'] = 'Serviceapi';
        }
        if (\App\Library\Commontools::CheckArrayValue($arraydata, "last_update_user")) {
                $savedata['last_update_user'] = $arraydata['last_update_user'];
            } else {
                $savedata['last_update_user'] = 'Serviceapi';
        }
        $savedata['create_date'] = date('Y-m-d H:i:s');
        $savedata['last_update_date'] = date('Y-m-d H:i:s');

        //新增資料並回傳「自動遞增KEY值」
         if (DB::table('ps_lotteryticket_rec')->insert($savedata)) {
            return true;
        } else {
            return false;
        }
     } catch (\Exception $e) {
               //DB::rollBack();
               \App\Models\ErrorLog::InsertLog($e);
               return false;
     }
    }

      /**
     * 修改資料
     * @param array $arraydata 要更新的資料
     * @return boolean
     */
    public function UpdateData($arraydata) {
        try {

            if (!\App\Library\Commontools::CheckArrayValue($arraydata, 'ltr_serno') ) {
                return false;
            }
            $savedata['ltr_serno'] = $arraydata['ltr_serno'];
             if (\App\Library\Commontools::CheckArrayValue($arraydata, "pai_id")) {
                $savedata['pai_id'] = $arraydata['pai_id'];
            } 
             if (\App\Library\Commontools::CheckArrayValue($arraydata, "paj_id")) {
                $savedata['paj_id'] = $arraydata['paj_id'];
            } 
            if (\App\Library\Commontools::CheckArrayValue($arraydata, "pa_id")) {
                $savedata['pa_id'] = $arraydata['pa_id'];
            } 
            if (\App\Library\Commontools::CheckArrayValue($arraydata, "md_id")) {
                $savedata['md_id'] = $arraydata['md_id'];
            } 
            if (\App\Library\Commontools::CheckArrayValue($arraydata, "ltr_getdate")) {
                $savedata['ltr_getdate'] = $arraydata['ltr_getdate'];
            } 
             if (\App\Library\Commontools::CheckArrayValue($arraydata, "ltr_usestatus")) {
                $savedata['ltr_usestatus'] = $arraydata['ltr_usestatus'];
            } 
            if (\App\Library\Commontools::CheckArrayValue($arraydata, "ltr_winstatus")) {
                $savedata['ltr_winstatus'] = $arraydata['ltr_winstatus'];
            } 
            if (\App\Library\Commontools::CheckArrayValue($arraydata, "ltr_prizeitem")) {
                $savedata['ltr_prizeitem'] = $arraydata['ltr_prizeitem'];
            } 
             if (\App\Library\Commontools::CheckArrayValue($arraydata, "ltr_remark")) {
                $savedata['ltr_remark'] = $arraydata['ltr_remark'];
            } 
            
            
            $savedata['last_update_date'] = date('Y-m-d H:i:s');

            DB::table('ps_lotteryticket_rec')
                    ->where('paj_id', $savedata['paj_id'])
                    ->update($savedata);
            return true;
        } catch (Exception $ex) {
            ErrorLog::InsertData($ex);
            return false;
        }
    }

     /**
     * 刪除資料
     * @param $cmsg_serno 要刪除的資料
     * @return boolean
     */
    public function DeleteData($ltr_serno) {
       try {
            if ($ltr_serno == null || strlen($ltr_serno) == 0) {
              return false;
            }
            DB::table('ps_lotteryticket_rec')
                   ->where('ltr_serno', $ltr_serno)
                   ->delete();
           return true;
       } catch (Exception $ex) {
            ErrorLog::InsertData($ex);
            return false;
       }
    }
    
    public function  getDataCountByPaId ($pa_id) {
        if ($pa_id == null || strlen($pa_id) == 0) {
              return false;
        }
        $result  = PsLotteryticketRec::where('isflag', '1')
                                                    ->where('pa_id',$pa_id)
                                                    ->get()->toArray();
        return  count($result);
    }

}