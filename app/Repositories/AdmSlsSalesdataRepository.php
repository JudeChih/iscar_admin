<?php

namespace App\Repositories;

use App\Models\adm_sls_salesdata;
use DB;

class AdmSlsSalesdataRepository {

    /**
     * 取得十筆資料
     * @return type
     */
    public function getTenData() {
        try {
            $result = adm_sls_salesdata::join('iscarmemberdata','iscarmemberdata.md_id','adm_sls_salesdata.md_id')->where('adm_sls_salesdata.isflag',1)->paginate(10);
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 藉由sls_serno取得資料
     * @param  [type] $sls_serno [業務流水號]
     */
    public function getDataBySlsSerno($sls_serno){
        try {
            $result = adm_sls_salesdata::where("sls_serno",$sls_serno)->where('isflag',1)->get();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 藉由md_id取得資料
     * @param  [type] $md_id [會員代碼]
     */
    public function getDataByMdID($md_id){
        try {
            $result = adm_sls_salesdata::where("md_id",$md_id)->where('isflag',1)->get();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 透過傳入的變數，抓取業務資料
     * @param  [type] $sls_hash       [雜湊值]
     * @param  [type] $md_mobile      [手機號碼]
     * @param  [type] $md_contactmail [電子信箱]
     */
    public function getDataByHashMobileContactmail($sls_hash,$md_mobile,$md_contactmail){
        try {
            $result = adm_sls_salesdata::join('iscarmemberdata','iscarmemberdata.md_id','adm_sls_salesdata.md_id')->where("sls_hash",$sls_hash)->where("md_mobile",$md_mobile)->where("md_contactmail",$md_contactmail)->where('adm_sls_salesdata.isflag',1)->get();
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 變更業務的狀態
     * @param  array  $arraydata [description]
     * @return [type]            [description]
     */
    public function updateSlsStatus(array $arraydata){
        try {
            DB::beginTransaction();
            if(!\App\Library\CommonTools::CheckArrayValue($arraydata, "sls_serno") || !\App\Library\CommonTools::CheckArrayValue($arraydata, "sls_status")){
                return false;
            }
            $savedata['sls_status'] = $arraydata['sls_status'];
            $savedata['last_update_date'] = \Carbon\Carbon::now();
            $result = adm_sls_salesdata::where('sls_serno',$arraydata['sls_serno'])->update($savedata);
            if($result){
                DB::commit();
                return true;
            }
            DB::rollback();
            return false;
        } catch (Exception $e) {
            DB::rollback();
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }

    /**
     * 使用「$primarykey」查詢資料表的主鍵值
     * @param type $primarykey 要查詢的值
     * @return type
     */
    public function getData($primarykey) {
        return null;
    }

    /**
     * 建立一筆新的資料
     * @param array $arraydata 要新增的資料
     * @return type
     */
    public function create(array $arraydata) {
        try {
            DB::beginTransaction();
            //檢查必填欄位
            if (!isset($arraydata['md_id']) || !isset($arraydata['sls_status']) || !isset($arraydata['sls_hash']) || !isset($arraydata['sls_hash_expired']) || !isset($arraydata['sls_hash_use'])) {
                return false;
            }
            $savedata['md_id'] = $arraydata['md_id'];
            $savedata['sls_status'] = $arraydata['sls_status'];
            $savedata['sls_hash'] = $arraydata['sls_hash'];
            $savedata['sls_hash_expired'] = $arraydata['sls_hash_expired'];
            $savedata['sls_hash_use'] = $arraydata['sls_hash_use'];

            if (isset($arraydata['isflag'])) {
                $savedata['isflag'] = $arraydata['isflag'];
            }
            if (isset($arraydata['create_user'])) {
                $savedata['create_user'] = $arraydata['create_user'];
            }
            if (isset($arraydata['create_date'])) {
                $savedata['create_date'] = $arraydata['create_date'];
            }else{
                $savedata['create_date'] = \Carbon\Carbon::now();
            }
            if (isset($arraydata['last_update_user'])) {
                $savedata['last_update_user'] = $arraydata['last_update_user'];
            }
            if (isset($arraydata['last_update_date'])) {
                $savedata['last_update_date'] = $arraydata['last_update_date'];
            }else{
                $savedata['last_update_date'] = \Carbon\Carbon::now();
            }
            $result = adm_sls_salesdata::insert($savedata);
            if($result){
                DB::commit();
                return true;
            }
            DB::rollback();
            return false;
        } catch (\Exception $ex) {
            DB::rollback();
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }

    /**
     * 更新該「$primarykey」的資料
     * @param array $arraydata 要更新的資料
     * @param type $primarykey
     * @return type
     */
    public function update(array $arraydata, $primarykey) {
        return null;
    }

    /**
     * 刪除該「$primarykey」的資料
     * @param type $primarykey 主鍵值
     */
    public function delete($primarykey) {
        return null;
    }

}
