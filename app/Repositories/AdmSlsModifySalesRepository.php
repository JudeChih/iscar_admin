<?php

namespace App\Repositories;

use App\Models\adm_sls_modifysales_r;
use DB;

class AdmSlsModifySalesRepository {

    /**
     * 取得所有資料
     * @return type
     */
    public function getAllData() {
        return null;
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
     * 新增一筆異動紀錄
     * @param string $sls_serno [業務流水號]
     */
    public function modifySales($sls_serno){
        $mssd_r = new \App\Repositories\AdmSlsSalesdataRepository;
        $maud_r = new \App\Repositories\AdmUserdataRepository;
        try {
            // 透過sls_serno抓取該業務資料
            $salesdata = $mssd_r->getDataBySlsSerno($sls_serno);
            if(count($salesdata) == 1){
                $salesdata = $salesdata[0];
            }else{
                return false;
            }
            // 透過session裡面預存的登入後台的使用者名稱抓取該使用者的資料
            $userdata = $maud_r->getDataByName(\App\Services\AuthService::userName());
            if(count($userdata) == 1){
                $userdata = $userdata[0];
            }else{
                return false;
            }
            // 建立異動紀錄所需存檔的資料
            $arraydata['sls_serno'] = $salesdata['sls_serno'];
            $arraydata['usd_serno'] = $userdata['usd_serno'];
            $arraydata['md_id'] = $salesdata['md_id'];
            if($salesdata['sls_status'] == 0){
                $arraydata['mdfr_type'] = 1;
            }elseif($salesdata['sls_status'] == 1){
                $arraydata['mdfr_type'] = 2;
            }elseif($salesdata['sls_status'] == 2){
                $arraydata['mdfr_type'] = 3;
            }
            $result = AdmSlsModifySalesRepository::create($arraydata);
            if($result){
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 建立一筆新的資料
     * @param array $arraydata 要新增的資料
     * @return type
     */
    public function create(array $arraydata) {
        try {
            if(!\App\Library\CommonTools::CheckArrayValue($arraydata, "usd_serno") || !\App\Library\CommonTools::CheckArrayValue($arraydata, "md_id") || !\App\Library\CommonTools::CheckArrayValue($arraydata, "mdfr_type") || !\App\Library\CommonTools::CheckArrayValue($arraydata, "sls_serno")){
                return false;
            }
            $savedata['sls_serno'] = $arraydata['sls_serno'];
            $savedata['usd_serno'] = $arraydata['usd_serno'];
            $savedata['md_id'] = $arraydata['md_id'];
            $savedata['mdfr_type'] = $arraydata['mdfr_type'];
            $savedata['isflag'] = 1;
            if(isset($arraydata['create_user'])){
                $savedata['create_user'] = $arraydata['create_user'];
            }
            if(isset($arraydata['last_update_user'])){
                $savedata['last_update_user'] = $arraydata['last_update_user'];
            }
            $savedata['mdfr_datetime'] = \Carbon\Carbon::now();
            $savedata['create_date'] = \Carbon\Carbon::now();
            $savedata['last_update_date'] = \Carbon\Carbon::now();
            return adm_sls_modifysales_r::insert($savedata);
        } catch (Exception $e) {
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
