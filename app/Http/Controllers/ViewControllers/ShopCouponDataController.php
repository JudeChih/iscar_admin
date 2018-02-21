<?php

namespace App\Http\Controllers\ViewControllers;

use Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;
use DB;

class ShopCouponDataController extends Controller {

    /**
     * 導到[商品列表]頁面
     */
    public function shopCouponDataList() {
        $pm_s = new \App\Services\PMService;
        $searchdata = Request::all();
        try {
            //判斷搜尋類別，設定相對欄位的值
            if(!isset($searchdata['search_type'])){
                $searchdata['sd_shopname'] = null;
                $searchdata['scm_title'] = null;
            }else{
                switch ($searchdata['search_type']) {
                    case 'sd_shopname':
                        if($searchdata['query_name'] != ''){
                            $searchdata['sd_shopname'] = $searchdata['query_name'];
                        }else{
                            $searchdata['scm_title'] = null;
                        }
                        break;
                    case 'scm_title':
                        if($searchdata['query_name'] != ''){
                            $searchdata['scm_title'] = $searchdata['query_name'];
                        }
                        $searchdata['sd_shopname'] = null;
                        break;
                }
            }
            //商品類別
            if(!isset($searchdata['scm_category']) || $searchdata['scm_category'] == "-1"){
                $searchdata['scm_category'] = null;
            }
            //商家有效狀態
            if(!isset($searchdata['scm_poststatus'])){
                $searchdata['scm_poststatus'] = 1;
            }
            //跳過幾頁作查詢
            if(!isset($searchdata['skip_page'])){
                $searchdata['skip_page'] = 0;
            }
            //排序根據
            if(!isset($searchdata['sort'])){
                $searchdata['sort'] = "sd_shopname";
            }
            //排序方式
            if(!isset($searchdata['order'])){
                $searchdata['order'] = "DESC";
            }
            //call API
            $result = $pm_s->callApiQueryShopCouponList($searchdata);

            //判斷回傳代碼，根據錯誤代碼傳不同的錯誤訊息
            if($result['message_no'] != '000000000'){
                if($result['message_no'] == '101705001'){
                    return redirect('/shop/shopcoupondata-list')->withInput()->withErrors(['有值未傳入！']);
                }elseif($result['message_no'] == '101705002'){
                    $searchdata['total_page'] = 0;
                    return View::make('/shop/shopcouponlist',compact('searchdata'))->withErrors(['查無任何資料！']);
                }else{
                    return redirect('/shop/shopcoupondata-list')->withInput()->withErrors(['未知的錯誤！']);
                }
            }
            //針對回傳的值，轉碼
            $shopdata_result = rawurldecode($result['shopcouponlist']);
            $shopdata = json_decode($shopdata_result,true);
            $page_result = rawurldecode($result['page']);
            $searchdata['total_page'] = $page_result;

            return View::make('/shop/shopcouponlist',compact('shopdata','searchdata'));
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 導到[商品細節]頁面
     */
    public function shopCouponDetail(){
        $pm_s = new \App\Services\PMService;
        $searchdata = Request::all();
        try {
            $result = $pm_s->callApiQueryShopCouponContent($searchdata['scm_id']);

            //判斷回傳代碼，根據錯誤代碼傳不同的錯誤訊息
            if($result['message_no'] != '000000000'){
                if($result['message_no'] == '101706001'){
                    return redirect('/shop/shopdata-list')->withInput()->withErrors(['撈取資料出現問題！']);
                }elseif($result['message_no'] == '101706002'){
                    $searchdata['total_page'] = 0;
                    return View::make('/shop/shopcouponlist',compact('searchdata'))->withErrors(['查無任何資料！']);
                }else{
                    return redirect('/shop/shopcoupondata-list')->withInput()->withErrors(['未知的錯誤！']);
                }
            }

            if(is_array($result['shopcoupon'])){
                foreach ($result['shopcoupon'] as $key => $value) {
                    if(is_array($value)){
                        foreach ($value as $k => $v) {
                            $data[$k] = rawurldecode($v);
                        }
                        $shopcoupon[$key] = $data;
                    }else{
                        $shopcoupon[$key] = rawurldecode($value);
                    }
                }
            }

            $shopcoupon['scm_advancedescribe'] = json_decode($shopcoupon['scm_advancedescribe'],true);

            return View::make('/shop/shopcoupon',compact('shopcoupon'));
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 異動商品[停用、啟用]
     */
    public function modifyShopCoupon(){
        $pm_s = new \App\Services\PMService;
        $searchdata = Request::all();
        try {
            $result = $pm_s->callApiModifyShopCoupon($searchdata,$arraydata);
            if($result['message_no'] != '000000000'){
                if($result['message_no'] == '101704001'){
                    return '停/啟用失敗';
                }elseif($result['message_no'] == '101704002'){
                    return '新增異動紀錄失敗';
                }else{
                    return '未知的錯誤';
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
     * 建立優惠卷異動的紀錄
     * @param  [type] $inputData    [description]
     */
    public function createModifyRecord($inputData){
        $sdmr_r = new \App\Repositories\ICR_ShopDataModifyRecordRepository;
        try {
            DB::beginTransaction();
            foreach ($inputData['sd_id'] as $key => $val) {
                $arraydata['sd_id'] = $val;
                $arraydata['scm_id'] = $inputData['scm_id'][$key];
                $arraydata['sdmr_operationtype'] = $inputData['sdmr_operationtype'];
                $arraydata['sdmr_modifyitem'] = 2;
                $arraydata['sdmr_modifyuser'] = $inputData['modacc'];
                $arraydata['sdmr_modifyreason'] = $inputData['sdmr_modifyreason'];
                if(!$sdmr_r->insertData($arraydata)){
                    DB::rollback();
                    return false;
                }
            }
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollback();
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }
}
