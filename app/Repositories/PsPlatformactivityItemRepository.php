<?php

namespace App\Repositories;

use App\Models\PsPlatformactivityItem;
use DB;

class PsPlatformactivityItemRepository  {

    //新增資料
    public function InsertData($arraydata) {
     try {
        if (
                !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_title')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_shortcode')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_id')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pa_id')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_fulldescript')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_mainpic')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_activepics')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_startdate')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_enddate')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_eventtarget_url')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_giftcontent')
        ) {
            return false;
        }
        $savedata['pai_id'] = $arraydata['pai_id'];
        $savedata['pa_id'] = $arraydata['pa_id'];
        $savedata['pai_shortcode'] = $arraydata['pai_shortcode'];
        $savedata['pai_title'] = $arraydata['pai_title'];
        $savedata['pai_fulldescript'] = $arraydata['pai_fulldescript'];
        $savedata['pai_mainpic'] = $arraydata['pai_mainpic'];
        $savedata['pai_activepics'] = $arraydata['pai_activepics'];
        $savedata['pai_startdate'] = $arraydata['pai_startdate'];
        $savedata['pai_enddate'] = $arraydata['pai_enddate'];
        $savedata['pai_eventtarget_url'] = $arraydata['pai_eventtarget_url'];
        $savedata['pai_giftcontent'] = $arraydata['pai_giftcontent'];


        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_gifttype")) {
            $savedata['pai_gifttype'] = $arraydata['pai_gifttype'];
        } else {
            $savedata['pai_gifttype'] = '0';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_giftcontent")) {
            $savedata['pai_giftcontent'] = $arraydata['pai_giftcontent'];
        } else {
            $savedata['pai_giftcontent'] = '';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_giftamount")) {
            $savedata['pai_giftamount'] = $arraydata['pai_giftamount'];
        } else {
            $savedata['pai_giftamount'] = '0';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_condition")) {
            $savedata['pai_condition'] = $arraydata['pai_condition'];
        } else {
            $savedata['pai_condition'] = '';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_poststatus")) {
            $savedata['pai_poststatus'] = $arraydata['pai_poststatus'];
        } else {
            $savedata['pai_poststatus'] = '0';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_advancedescribe")) {
            $savedata['pai_advancedescribe'] = $arraydata['pai_advancedescribe'];
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "isflag")) {
            $savedata['isflag'] = $arraydata['isflag'];
        } else {
            $savedata['isflag'] = '1';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_approver")) {
            $savedata['pai_approver'] = $arraydata['pai_approver'];
        } else {
            $savedata['pai_approver'] = 'admin';
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
         if (PsPlatformactivityItem::insert($savedata)) {
            return true;
        } else {
            return false;
        }
     } catch (\Exception $e) {
               //DB::rollBack();
               \App\Library\CommonTools::writeErrorLogByException($e);
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

            if (!\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_id')) {
                return false;
            }

            $savedata['pai_id'] = $arraydata['pai_id'];
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_shortcode")) {
                $savedata['pai_shortcode'] = $arraydata['pai_shortcode'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pa_id")) {
                $savedata['pa_id'] = $arraydata['pa_id'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_title")) {
                $savedata['pai_title'] = $arraydata['pai_title'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_fulldescript")) {
                $savedata['pai_fulldescript'] = $arraydata['pai_fulldescript'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_mainpic")) {
                $savedata['pai_mainpic'] = $arraydata['pai_mainpic'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_activepics")) {
                $savedata['pai_activepics'] = $arraydata['pai_activepics'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_gifttype")) {
                $savedata['pai_gifttype'] = $arraydata['pai_gifttype'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_giftcontent")) {
                $savedata['pai_giftcontent'] = $arraydata['pai_giftcontent'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_giftamount")) {
                $savedata['pai_giftamount'] = $arraydata['pai_giftamount'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_startdate")) {
                $savedata['pai_startdate'] = $arraydata['pai_startdate'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_enddate")) {
                $savedata['pai_enddate'] = $arraydata['pai_enddate'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_poststatus")) {
                $savedata['pai_poststatus'] = $arraydata['pai_poststatus'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_advancedescribe")) {
                $savedata['pai_advancedescribe'] = $arraydata['pai_advancedescribe'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_condition")) {
                $savedata['pai_condition'] = $arraydata['pai_condition'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_eventtarget_url")) {
                $savedata['pai_eventtarget_url'] = $arraydata['pai_eventtarget_url'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_approver")) {
                $savedata['pai_approver'] = $arraydata['pai_approver'];
            }
            $savedata['last_update_date'] = date('Y-m-d H:i:s');

            PsPlatformactivityItem::where('pai_id', $savedata['pai_id'])
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
    public function DeleteData($pai_id) {
       try {
            if ($pai_id == null || strlen($pai_id) == 0) {
              return false;
            }
            PsPlatformactivityItem::where('pai_id', $pai_id)
                   ->delete();
           return true;
       } catch (Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return false;
       }
    }



    public function  getData () {
        $result  = PsPlatformactivityItem::where('isflag', '1')
                 ->where('ps_platformactivity_item.pai_startdate','<=',date('Y-m-d'))
                 ->where('ps_platformactivity_item.pai_enddate','>=',date('Y-m-d'))
                ->get()->toArray();
        return $result;
    }

    public function  getDataByPaiId ($pai_id) {
        if ($pai_id == null || strlen($pai_id) == 0) {
              return false;
        }
        $result  = PsPlatformactivityItem::where('ps_platformactivity_item.isflag', '1')
                                                             ->where('pai_id',$pai_id)
                                                            ->leftjoin('ps_platformannouncement','ps_platformactivity_item.pa_id','ps_platformannouncement.pa_id')
                                                             ->orderBy('ps_platformactivity_item.create_date', 'desc')
                                                             ->get()->toArray();
        return  $result;
    }


    public function  getDataByMdId ($md_id) {
        $query  = PsPlatformactivityItem::where('ps_platformactivity_item.isflag', '1')
                                                            ->where('ps_platformactivity_item.pai_startdate','<=',date('Y-m-d'))
                                                            ->where('ps_platformactivity_item.pai_enddate','>=',date('Y-m-d'))
                                                           ->leftjoin('ps_platformactivity_join', function($query) use ($md_id) {
                                                                 $query->on('ps_platformactivity_item.pai_id', '=', 'ps_platformactivity_join.pai_id')
                                                                            ->where('ps_platformactivity_join.md_id', '=', $md_id);
                                                           }) ;
        $result  = $query ->select('ps_platformactivity_item.pai_id',
                                                    'ps_platformactivity_item.pai_title',
                                                    'ps_platformactivity_item.pai_fulldescript',
                                                    'ps_platformactivity_item.pai_mainpic',
                                                    'ps_platformactivity_item.pai_activepics',
                                                    'ps_platformactivity_item.pai_gifttype',
                                                    'ps_platformactivity_item.pai_giftamount',
                                                    'ps_platformactivity_item.pai_startdate',
                                                    'ps_platformactivity_item.pai_enddate',
                                                    'ps_platformactivity_item.pai_poststatus',
                                                    'ps_platformactivity_item.pai_advancedescribe',
                                                    'ps_platformactivity_item.pai_eventtarget_url',
                                                    DB::raw("(case when ps_platformactivity_join.md_id is null then 'false' else 'true' end )as 'boolean_activity'") )
                                     ->orderBy('ps_platformactivity_item.create_date', 'desc')
                                     ->get()->toArray();
        return  $result;
    }

    public function  getDataByMdId_PaiId ($md_id, $pai_id) {
        $query  = PsPlatformactivityItem::where('ps_platformactivity_item.isflag', '1')
                                                           ->leftjoin('ps_platformactivity_join', function($query) use ($md_id) {
                                                                 $query->on('ps_platformactivity_item.pai_id', '=', 'ps_platformactivity_join.pai_id')
                                                                            ->where('ps_platformactivity_join.md_id', '=', $md_id);
                                                           })->where("ps_platformactivity_item.pai_id",$pai_id) ;
        $result  = $query ->select('ps_platformactivity_item.*',
                                                    DB::raw("(case when ps_platformactivity_join.md_id is null then 'false' else 'true' end )as 'boolean_activity'") )
                                     ->orderBy('ps_platformactivity_item.create_date', 'desc')->get()->toArray();
        return  $result;
    }

    public function getTenData($searchdata){
        $string  = PsPlatformactivityItem::where('isflag', '1')
                 ->where('ps_platformactivity_item.pai_startdate','<=',date('Y-m-d'))
                 ->where('ps_platformactivity_item.pai_enddate','>=',date('Y-m-d'))
                 ->orderBy($searchdata['sort'],$searchdata['order']);

        return $string->take(10)->skip($searchdata['skip_page']*10)->get();
    }
}