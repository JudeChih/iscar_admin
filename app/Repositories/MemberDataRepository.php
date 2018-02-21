<?php

namespace App\Repositories;

use App\Models\isCarMemberData;
use DB;

class MemberDataRepository {

    /**
     * 取得資料，依「MD_ID」取得
     * @param type $md_id
     * @return type
     */
    public function GetMemberData($md_id) {
        if ($md_id == null || strlen($md_id) == 0) {
            return null;
        }

        $results = isCarMemberData::where('isflag', '1')
                ->where('md_id', $md_id)
                ->get();
        return $results;
    }

    /**
     * 依「$accountid」取得資料
     * @param type $accountid
     * @return type
     */
    public function GetDataByAccountID($accountid) {
        if ($accountid == null || strlen($accountid) == 0) {
            return null;
        }

        $results = isCarMemberData::where('isflag', '1')
                ->where('ssd_accountid', $accountid)
                ->get()
                ->toArray();

        return $results;
    }

    /**
     * 透過md_mobile抓取會員資料
     * @param  [string] $md_mobile [手機號碼]
     */
    public function getDataByMd_Mobile($md_mobile){
        try {
            return isCarMemberData::where('md_mobile', '=', $md_mobile)
                            ->where('isflag', '=', '1')
                            ->get();
        } catch (\Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return null;
        }
    }

    /**
     * 取得所有資料
     * @return type
     */
    public function getAllData() {
        try {
            return isCarMemberData::get();
        } catch (\Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return null;
        }
    }

    /**
     * 使用「$primarykey」查詢資料表的主鍵值
     * @param type $primarykey 要查詢的值
     * @return type
     */
    public function getData($primarykey) {
        try {
            return isCarMemberData::find($primarykey);
        } catch (\Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return null;
        }
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
            if (!isset($arraydata['md_id']) || !isset($arraydata['md_account']) || !isset($arraydata['md_logintype']) 
                    || !isset($arraydata['md_clienttype']) || !isset($arraydata['md_cname']) || !isset($arraydata['md_ename']) 
                    || !isset($arraydata['md_tel']) || !isset($arraydata['md_mobile']) || !isset($arraydata['md_addr']) 
                    || !isset($arraydata['md_contactmail'])) {
                return false;
            }
            $savedata['md_id'] = $arraydata['md_id'];
            $savedata['md_logintype'] = $arraydata['md_logintype'];
            $savedata['md_account'] = $arraydata['md_account'];
            $savedata['md_cname'] = $arraydata['md_cname'];
            $savedata['md_ename'] = $arraydata['md_ename'];
            $savedata['md_mobile'] = $arraydata['md_mobile'];
            $savedata['md_clienttype'] = $arraydata['md_clienttype'];
            $savedata['md_tel'] = $arraydata['md_tel'];
            $savedata['md_addr'] = $arraydata['md_addr'];
            $savedata['md_contactmail'] = $arraydata['md_contactmail'];


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
            $result = isCarMemberData::insert($savedata);
            if($result){
                DB::commit();
                return true;
            }
            DB::rollback();
            return false;
        } catch (\Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            DB::rollback();
            return false;
        }
    }

    /**
     * 更新會員資料
     */
    public function updateMemberData(Array $arraydata){
        try {

            if(isset($arraydata['md_logintype'])){
                $savedate['md_logintype'] = $arraydata['md_logintype'];
            }
            if(isset($arraydata['md_account'])){
                $savedate['md_account'] = $arraydata['md_account'];
            }
            if(isset($arraydata['md_clienttype'])){
                $savedate['md_clienttype'] = $arraydata['md_clienttype'];
            }
            if(isset($arraydata['md_cname'])){
                $savedate['md_cname'] = $arraydata['md_cname'];
            }
            if(isset($arraydata['md_ename'])){
                $savedate['md_ename'] = $arraydata['md_ename'];
            }
            if(isset($arraydata['md_tel'])){
                $savedate['md_tel'] = $arraydata['md_tel'];
            }
            if(isset($arraydata['md_mobile'])){
                $savedate['md_mobile'] = $arraydata['md_mobile'];
            }
            if(isset($arraydata['md_addr'])){
                $savedate['md_addr'] = $arraydata['md_addr'];
            }
            if(isset($arraydata['md_contactmail'])){
                $savedate['md_contactmail'] = $arraydata['md_contactmail'];
            }
            if(isset($arraydata['create_user'])){
                $savedate['create_user'] = $arraydata['create_user'];
            }
            if(isset($arraydata['create_date'])){
                $savedate['create_date'] = $arraydata['create_date'];
            }
            if(isset($arraydata['last_update_user'])){
                $savedate['last_update_user'] = $arraydata['last_update_user'];
            }
            if(isset($arraydata['last_update_date'])){
                $savedate['last_update_date'] = $arraydata['last_update_date'];
            }

            isCarMemberData::where('md_id',$arraydata['md_id'])->update($savedate);
            return true;
        } catch (\Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }

}
