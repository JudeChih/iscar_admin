<?php

namespace App\Repositories;

use App\Models\PsPlatformactivityJoin;
use DB;

class PsPlatformactivityJoinRepository  {

    //新增資料
    public function InsertData($arraydata, &$paj_id) {
     try {
       /* if (
                !\App\Library\CommonTools::CheckArrayValue($arraydata, 'pai_id') || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'md_id')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'paj_joindate')
        ) {
            return false;
        }*/ 
        $savedata['paj_id'] = $this->GetShotUuid();
        $savedata['pai_id'] = $arraydata['pai_id'];
        $savedata['md_id'] = $arraydata['md_id'];
        $savedata['paj_joindate'] = $arraydata['paj_joindate'];
        
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "paj_usestatus")) {
                $savedata['paj_usestatus'] = $arraydata['paj_usestatus'];
            } else {
                $savedata['paj_usestatus'] = '0';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "paj_prizegive")) {
                $savedata['paj_prizegive'] = $arraydata['paj_prizegive'];
            } else {
                $savedata['paj_prizegive'] = '0';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "paj_remark")) {
                $savedata['paj_remark'] = $arraydata['paj_remark'];
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
         if (PsPlatformactivityJoin::insert($savedata)) {
             //$pajData=$this->getDataByMdId_PaiId ($savedata['md_id'], $savedata['pai_id']);
             $paj_id = $savedata['paj_id'] ; 
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
    
    
    public  function GetShotUuid() {
        try {
            $query = "SELECT ";
            $query = $query . "UUID_SHORT() as paj_id  ";
            //$query = $query . "FROM ps_platformactivity_join limit 1 offset 0 ";
            $queryData = DB::connection('mysql')->select($query);
            $checkData = PsPlatformactivityJoin::where('ps_platformactivity_join.paj_id', '=',  $queryData[0]->paj_id)->get()->toArray();
            if (count($checkData) > 0) {
                $this->GetShotUuid();
            }
            return  $queryData[0]->paj_id;
        } catch (Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return null;
        }
    }

      /**
     * 修改資料
     * @param array $arraydata 要更新的資料
     * @return boolean
     */
    public function UpdateData($arraydata) {
        try {

            if (!\App\Library\CommonTools::CheckArrayValue($arraydata, 'paj_id')) {
                return false;
            }
            $savedata['paj_id'] = $arraydata['paj_id'];
             if (\App\Library\CommonTools::CheckArrayValue($arraydata, "pai_id")) {
                $savedata['pai_id'] = $arraydata['pai_id'];
            } 
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "md_id")) {
                $savedata['md_id'] = $arraydata['md_id'];
            } 
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "paj_joindate")) {
                $savedata['paj_joindate'] = $arraydata['paj_joindate'];
            } 
             if (\App\Library\CommonTools::CheckArrayValue($arraydata, "paj_usestatus")) {
                $savedata['paj_usestatus'] = $arraydata['paj_usestatus'];
            } 
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "paj_prizegive")) {
                $savedata['paj_prizegive'] = $arraydata['paj_prizegive'];
            } 
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "paj_remark")) {
                $savedata['paj_remark'] = $arraydata['paj_remark'];
            } 
            
            
            $savedata['last_update_date'] = date('Y-m-d H:i:s');

            PsPlatformactivityJoin::where('paj_id', $savedata['paj_id'])
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
    public function DeleteData($paj_id) {
       try {
            if ($paj_id == null || strlen($paj_id) == 0) {
              return false;
            }
            PsPlatformactivityJoin::where('paj_id', $paj_id)
                   ->delete();
           return true;
       } catch (Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return false;
       }
    }
    
    
    public function  getDataByMdId ($md_id) {
        if ($md_id == null || strlen($md_id) == 0)
            return null;

        $result = PsPlatformactivityJoin::where('md_id', $md_id)
                                                          ->where('ps_platformactivity_item.isflag','1')
                                                          ->leftjoin('ps_platformactivity_item', function($query) {
                                                                 $query->on('ps_platformactivity_join.pai_id', '=', 'ps_platformactivity_item.pai_id')
                                                                             ->where('ps_platformactivity_item.isflag', '1')
                                                                             ->where('ps_platformactivity_item.pai_startdate','<=',date('Y-m-d'))
                                                                             ->where('ps_platformactivity_item.pai_enddate','>=',date('Y-m-d'));
                                                           })
                                                          ->orderBy('ps_platformactivity_join.create_date', 'desc')
                                                          ->get()->toArray();
        return $result;
    }
    
    public function  getDataByMdId_PaiId ($md_id, $pai_id) {
        if ($md_id == null || strlen($md_id) == 0)
            return null;

        $result = PsPlatformactivityJoin::where('md_id', $md_id)
                                                          ->where('pai_id', $pai_id)
                                                          ->where('isflag','1')
                                                          ->orderBy('ps_platformactivity_join.create_date', 'desc')
                                                          ->get()->toArray();
        return $result;
    }
 
    
    public function  searchDataByMdId ($md_id) {
        $query  = PsPlatformactivityJoin::where('ps_platformactivity_join.isflag', '1')
                                                          ->where('ps_platformactivity_join.md_id',$md_id)
                                                         ->leftjoin('ps_lotteryticket_rec', function($query) {
                                                                 $query->on('ps_platformactivity_join.paj_id', '=', 'ps_lotteryticket_rec.paj_id')
                                                                             ->where('ps_lotteryticket_rec.isflag', '1');
                                                           })
                                                           ->leftjoin('ps_platformactivity_item', function($query) {
                                                                 $query->on('ps_platformactivity_join.pai_id', '=', 'ps_platformactivity_item.pai_id')
                                                                             ->where('ps_platformactivity_item.isflag', '1');
                                                           });
        $result  = $query ->select( 'ps_platformactivity_item.*',
                                                     'ps_platformactivity_join.*',
                                                    'ps_lotteryticket_rec.*',
                                                     DB::raw("(case  ps_platformactivity_join.paj_usestatus  when  '0'  then '未取用' else '已用畢' end )as 'Paj_usestatus'"),
                                                     DB::raw("(case ps_platformactivity_join.paj_prizegive   when  '0' then '未發出' else '已發出' end )as 'Paj_prizegive'")
                                                    ) 
                                      ->orderBy('ps_platformactivity_join.create_date', 'desc')
                                     ->get()->toArray();
        return  $result;
    }

}