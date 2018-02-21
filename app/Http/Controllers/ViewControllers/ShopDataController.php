<?php

namespace App\Http\Controllers\ViewControllers;

use Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;
use DB;

class ShopDataController extends Controller {

    /**
     * 導到[特店統計表]頁面
     */
    public function shopType() {
        $pm_s = new \App\Services\PMService;
        try {
            $result = $pm_s->callApiQueryShopType();
            //判斷回傳代碼，根據錯誤代碼傳不同的錯誤訊息
            if($result['message_no'] != '000000000'){
                return View::make('/shop/shoptype');
            }
            if(is_array($result['shoptype'])){
                foreach ($result['shoptype'] as $key => $value) {
                    $shoptype[$key] = array();
                    if(is_array($value)){
                        foreach ($value as $v) {
                            array_push($shoptype[$key],rawurldecode($v));
                        }
                    }else{
                        $shoptype[$key] = rawurldecode($value);
                    }
                }
            }
            return View::make('/shop/shoptype',compact('shoptype'));
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 導到[特店管理]頁面
     */
    public function shopDataList() {
        $pm_s = new \App\Services\PMService;
        $searchdata = Request::all();
        try {
            //判斷搜尋類別，設定相對欄位的值
            if(!isset($searchdata['search_type'])){
                $searchdata['sd_shopname'] = null;
                $searchdata['sd_contact_person'] = null;
            }else{
                switch ($searchdata['search_type']) {
                    case 'sd_shopname':
                        if($searchdata['query_name'] != ''){
                            $searchdata['sd_shopname'] = $searchdata['query_name'];
                        }else{
                            $searchdata['sd_contact_person'] = null;
                        }
                        break;
                    case 'sd_contact_person':
                        if($searchdata['query_name'] != ''){
                            $searchdata['sd_contact_person'] = $searchdata['query_name'];
                        }
                        $searchdata['sd_shopname'] = null;
                        break;
                }
            }
            //商家類別
            if(!isset($searchdata['sd_type']) || $searchdata['sd_type'] == "-1"){
                $searchdata['sd_type'] = null;
            }
            //商家郵遞區號
            if(!isset($searchdata['sd_zipcode']) || $searchdata['sd_zipcode'] == "0"){
                $searchdata['sd_zipcode'] = null;
            }
            //跳過幾頁作查詢
            if(!isset($searchdata['skip_page'])){
                $searchdata['skip_page'] = 0;
            }
            //綁定狀態
            if(!isset($searchdata['sd_havebind']) || $searchdata['sd_havebind'] == "-1"){
                $searchdata['sd_havebind'] = null;
            }
            //商家有效狀態
            if(!isset($searchdata['sd_activestatus'])){
                $searchdata['sd_activestatus'] = 1;
            }
            //排序根據
            if(!isset($searchdata['sort'])){
                $searchdata['sort'] = "sd_shopname";
            }
            //排序方式
            if(!isset($searchdata['order'])){
                $searchdata['order'] = "DESC";
            }


            $result = $pm_s->callApiQueryShopList($searchdata);

            //判斷回傳代碼，根據錯誤代碼傳不同的錯誤訊息
            if($result['message_no'] != '000000000'){
                if($result['message_no'] == '101702001'){
                    return redirect('/shop/shopdata-list')->withInput()->withErrors(['撈取資料出現問題！']);
                }elseif($result['message_no'] == '101702002'){
                    $searchdata['total_page'] = 0;
                    return View::make('/shop/shopdatalist',compact('searchdata'))->withErrors(['查無任何資料！']);
                }else{
                    return redirect('/shop/shopdata-list')->withInput()->withErrors(['未知的錯誤！']);
                }
            }
            $shopdata_result = rawurldecode($result['shoplistarray']);
            $shopdata = json_decode($shopdata_result,true);
            $page_result = rawurldecode($result['page']);
            $searchdata['total_page'] = $page_result;

            return View::make('/shop/shopdatalist',compact('shopdata','searchdata'));
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 導到[特店細節]頁面
     */
    public function shopDataDetail(){
        $pm_s = new \App\Services\PMService;
        $searchdata = Request::all();
        try {
            $result = $pm_s->callApiQueryShopContent($searchdata['sd_id']);

            //判斷回傳代碼，根據錯誤代碼傳不同的錯誤訊息
            if($result['message_no'] != '000000000'){
                if($result['message_no'] == '101702001'){
                    return redirect('/shop/shopdata-list')->withInput()->withErrors(['撈取資料出現問題！']);
                }elseif($result['message_no'] == '101702002'){
                    $searchdata['total_page'] = 0;
                    return View::make('/shop/shopdatalist',compact('searchdata'))->withErrors(['查無任何資料！']);
                }else{
                    return redirect('/shop/shopdata-list')->withInput()->withErrors(['未知的錯誤！']);
                }
            }

            // 針對從pm來的值進行轉碼
            if(is_array($result['shopdata'])){
                foreach ($result['shopdata'] as $key => $value) {
                    $shopdata[$key] = rawurldecode($value);
                }
            }else{
                $shopdata_result = rawurldecode($result['shopdata']);
                $shopdata = json_decode($shopdata_result,true);
            }
            $shopcoupon_result = rawurldecode($result['shopcoupon']);
            $shopcoupon = json_decode($shopcoupon_result,true);

            return View::make('/shop/shopdata',compact('shopdata','shopcoupon'));
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 異動特店[停用、啟用、刪除、綁定、解綁、設置代號]
     * @param array  $shopdata  [要做異動的店家代號以及異動欄位的陣列]
     */
    public function modifyShopData(){
        $pm_s = new \App\Services\PMService;
        $searchdata = Request::all();
        // \App\Library\CommonTools::writeErrorLogByMessage(json_encode($searchdata));
        try {
            $result = $pm_s->callApiModifyShopData($searchdata,$arraydata);
            if($result['message_no'] != '000000000'){
                if($result['message_no'] == '101701001'){
                    return '停/啟用失敗';
                }elseif($result['message_no'] == '101701002'){
                    return '刪除失敗';
                }elseif($result['message_no'] == '101701004'){
                    return '綁定/解綁失敗';
                }elseif($result['message_no'] == '101701005'){
                    return '設置失敗';
                }elseif($result['message_no'] == '101701006'){
                    return '此代號已被綁定在其他特店';
                }else{
                    return $result['message_no'];
                }
            }
            if(!$this->createModifyRecord($arraydata)){
                return '修改成功，但是異動紀錄存取失敗。';
            }
            return '修改成功';
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return '修改失敗';
        }
    }

    /**
     * 建立特店異動的紀錄
     * @param  [type] $inputData  [description]
     */
    public function createModifyRecord($inputData){
        $sdmr_r = new \App\Repositories\ICR_ShopDataModifyRecordRepository;
        try {
            DB::beginTransaction();
            if(is_array($inputData['sd_id'])){
                foreach ($inputData['sd_id'] as $val) {
                    $arraydata['sd_id'] = $val;
                    $arraydata['sdmr_operationtype'] = $inputData['sdmr_operationtype'];
                    $arraydata['sdmr_modifyitem'] = 1;
                    $arraydata['sdmr_modifyuser'] = $inputData['modacc'];
                    if(isset($inputData['sdmr_modifyreason'])){
                        $arraydata['sdmr_modifyreason'] = $inputData['sdmr_modifyreason'];
                    }
                    if(!$sdmr_r->insertData($arraydata)){
                        DB::rollback();
                        return false;
                    }
                }
            }else{
                $arraydata['sd_id'] = $inputData['sd_id'];
                $arraydata['sdmr_operationtype'] = $inputData['sdmr_operationtype'];
                $arraydata['sdmr_modifyitem'] = 1;
                $arraydata['sdmr_modifyuser'] = $inputData['modacc'];
                if(isset($inputData['sdmr_modifyreason'])){
                    $arraydata['sdmr_modifyreason'] = $inputData['sdmr_modifyreason'];
                }
                if(!$sdmr_r->insertData($arraydata)){
                    DB::rollback();
                    return false;
                }
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }
}
