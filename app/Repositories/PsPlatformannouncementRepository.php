<?php

namespace App\Repositories;

use App\Models\PsPlatformannouncement;
use DB;

class PsPlatformannouncementRepository  {

    //新增資料
    public function InsertData($arraydata) {
     try {
        if (
                !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_title') || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_fulldescript')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_mainpic') || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_startdate')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_enddate') || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_buttonname')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_point_url') || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_shortcode')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_id')
        ) {
            return false;
        }
        $savedata['pa_id'] = $arraydata['pa_id'];
        $savedata['pa_title'] = $arraydata['pa_title'];
        $savedata['pa_point_url'] = $arraydata['pa_fulldescript'];
        $savedata['pa_mainpic'] = $arraydata['pa_mainpic'];
        $savedata['pa_startdate'] = $arraydata['pa_startdate'];
        $savedata['pa_enddate'] = $arraydata['pa_enddate'];
        $savedata['pa_buttonname'] = $arraydata['pa_buttonname'];
        $savedata['pa_point_url'] = $arraydata['pa_point_url'];
        $savedata['pa_shortcode'] = $arraydata['pa_shortcode'];
        $savedata['pa_fulldescript'] = $arraydata['pa_fulldescript'];

        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_announcementtype")) {
                $savedata['pa_announcementtype'] = $arraydata['pa_announcementtype'];
            } else {
                $savedata['pa_announcementtype'] = '0';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_poststatus")) {
                $savedata['pa_poststatus'] = $arraydata['pa_poststatus'];
            } else {
                $savedata['pa_poststatus'] = '0';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_advancedescribe")) {
                $savedata['pa_advancedescribe'] = $arraydata['pa_advancedescribe'];
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_nextpage")) {
                $savedata['pa_nextpage'] = $arraydata['pa_nextpage'];
            } else {
                $savedata['pa_nextpage'] = '1';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_approver")) {
                $savedata['pa_approver'] = $arraydata['pa_approver'];
        }

        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "isflag")) {
                $savedata['isflag'] = $arraydata['isflag'];
            } else {
                $savedata['isflag'] = '1';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "create_user")) {
                $savedata['create_user'] = $arraydata['create_user'];
            } else {
                $savedata['create_user'] = 'Serviceapi';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "last_update_user")) {
                $savedata['last_update_user'] = $arraydata['last_update_user'];
            } else {
                $savedata['last_update_user'] = 'Serviceapi';
        }
        $savedata['create_date'] = date('Y-m-d H:i:s');
        $savedata['last_update_date'] = date('Y-m-d H:i:s');

        //新增資料並回傳「自動遞增KEY值」
         if (PsPlatformannouncement::insert($savedata)) {
            return true;
        } else {
            \App\Library\CommonTools::writeErrorLogByMessage('row-75');
            return false;
        }
     } catch (\Exception $e) {
               //DB::rollBack();
               \App\Library\CommonTools::writeErrorLogByException($e);
               \App\Library\CommonTools::writeErrorLogByMessage('row-81');
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

            if (!\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_id')) {
                return false;
            }
            $savedata['pa_id'] = $arraydata['pa_id'];
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_shortcode")) {
                $savedata['pa_shortcode'] = $arraydata['pa_shortcode'];
            }
             if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_title")) {
                $savedata['pa_title'] = $arraydata['pa_title'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_fulldescript")) {
                $savedata['pa_fulldescript'] = $arraydata['pa_fulldescript'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_mainpic")) {
                $savedata['pa_mainpic'] = $arraydata['pa_mainpic'];
            }
             if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_announcementtype")) {
                $savedata['pa_announcementtype'] = $arraydata['pa_announcementtype'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_startdate")) {
                $savedata['pa_startdate'] = $arraydata['pa_startdate'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_enddate")) {
                $savedata['pa_enddate'] = $arraydata['pa_enddate'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_poststatus")) {
                $savedata['pa_poststatus'] = $arraydata['pa_poststatus'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_advancedescribe")) {
                $savedata['pa_advancedescribe'] = $arraydata['pa_advancedescribe'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_nextpage")) {
                $savedata['pa_nextpage'] = $arraydata['pa_nextpage'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_buttonname")) {
                $savedata['pa_buttonname'] = $arraydata['pa_buttonname'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_point_url")) {
                $savedata['pa_point_url'] = $arraydata['pa_point_url'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_approver")) {
                $savedata['pa_approver'] = $arraydata['pa_approver'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "isflag")) {
                $savedata['isflag'] = $arraydata['isflag'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "last_update_user")) {
                $savedata['last_update_user'] = $arraydata['last_update_user'];
            }

            $savedata['last_update_date'] = date('Y-m-d H:i:s');

            PsPlatformannouncement::where('pa_id', $savedata['pa_id'])
                    ->update($savedata);
            return true;
        } catch (Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }

     /**
     * 刪除資料
     * @param $cmsg_serno 要刪除的資料
     * @return boolean
     */
    public function DeleteData($pa_id) {
       try {
            if ($pa_id == null || strlen($pa_id) == 0) {
              return false;
            }
            PsPlatformannouncement::where('pa_id', $pa_id)
                   ->delete();
           return true;
       } catch (Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return false;
       }
    }

    /**
     * 刪除資料 isflag = 0
     */
    public function delete($pa_id){
        try {
            if ($pa_id == null || strlen($pa_id) == 0) {
              return false;
            }
            $arraydata['isflag'] = 0;
            PsPlatformannouncement::where('pa_id', $pa_id)
                   ->update($arraydata);
           return true;
       } catch (Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return false;
       }
    }


    public function  getData () {

        $result = PsPlatformannouncement::where('isflag','1')
                                                          ->orderBy('ps_platformannouncement.create_date', 'desc')
                                                           ->where('ps_platformannouncement.pa_startdate','<=',date('Y-m-d'))
                                                           ->where('ps_platformannouncement.pa_enddate','>=',date('Y-m-d'))
                                                          ->get()->toArray();
        return $result;
    }

    public function getDataByPaShortCodePaId($pa_shortcode,$pa_id){
        $result = PsPlatformannouncement::where('pa_shortcode',$pa_shortcode)->where('pa_id','!=',$pa_id)->get()->toArray();
            return $result;
    }

    public function getDataByPaShortCode($pa_shortcode){
        $result = PsPlatformannouncement::where('pa_shortcode',$pa_shortcode)->get()->toArray();
        return $result;
    }

    public function  getDataByPaId ($pa_id) {
        if ($pa_id == null || strlen($pa_id) == 0)
            return null;

        $result = PsPlatformannouncement::where('pa_id', $pa_id)
                                                          ->where('isflag','1')
                                                          ->orderBy('ps_platformannouncement.create_date', 'desc')
                                                          ->get()->toArray();
        return $result;
    }

    public function getTenData($searchdata){

        $string = PsPlatformannouncement::where('isflag','1')
                    ->where('pa_startdate','<=',date('Y-m-d'))
                    ->where('pa_enddate','>=',date('Y-m-d'))
                    ->orderBy($searchdata['sort'],$searchdata['order']);
        return $string->take(10)->skip($searchdata['skip_page']*10)->get();
    }

}