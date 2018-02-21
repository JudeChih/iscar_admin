<?php

namespace App\Repositories;

use App\Models\ICR_ShopSettlementRec_m;
use App\Library\CommonTools;
use DB;

class ICR_ShopSettlementRec_mRepository  {

    /**
     * 只抓10筆
     * 透過查詢條件，抓取符合的結算日資料，只抓10筆
     * @param  [string] $ssrm_settledate   [結算日期時間]
     * @param  [string] $skip_page         [跳過幾頁作查詢(一頁有10筆)]
     * @param  [string] $sort              [排序根據]
     * @param  [string] $order             [排序方式 DESC(倒序) ASC(正序)]
     */
    public function getDataByQueryConditions($searchdata){
        return ICR_ShopSettlementRec_m::where('isflag',1)
						            ->select('ssrm_settledate')
						        	->groupBy('ssrm_settledate')
						            ->orderBy($searchdata['sort'],$searchdata['order'])
						            ->take(10)
						            ->skip($searchdata['skip_page']*10)
						            ->get();
    }

    /**
     * 透過sd_id、ssrm_settledate抓取詳細的scg.scm資料
     */
    public function getOrderDataBySdidSettledate($searchdata){
        \App\Library\CommonTools::writeErrorLogByMessage(json_encode($searchdata));
        $string = ICR_ShopSettlementRec_m::leftJoin('icr_shopsettlementrec_d','icr_shopsettlementrec_m.ssrm_id','icr_shopsettlementrec_d.ssrm_id')
                                    ->leftJoin('icr_shopcoupondata_g','icr_shopsettlementrec_d.scg_id','icr_shopcoupondata_g.scg_id')
                                    ->leftJoin('icr_shopcoupondata_m','icr_shopcoupondata_g.scm_id','icr_shopcoupondata_m.scm_id')
                                    ->where('icr_shopsettlementrec_m.sd_id',$searchdata['sd_id'])
                                    ->where('icr_shopsettlementrec_m.ssrm_settledate',$searchdata['ssrm_settledate']);

        if($searchdata['ssrd_billingtype'] != 0){
            $string->where('icr_shopsettlementrec_d.ssrd_billingtype',$searchdata['ssrd_billingtype']);
        }

        
        return $string->where('icr_shopsettlementrec_m.isflag',1)
                      ->where('icr_shopsettlementrec_d.isflag',1)
                      ->orderBy($searchdata['a_sort'],$searchdata['order'])
                      ->take(10)
                      ->skip($searchdata['skip_page']*10)
                      ->get();
    }

    public function getAllScgDataByQueryConditions($searchdata){
        return ICR_ShopSettlementRec_m::leftJoin('icr_shopsettlementrec_d','icr_shopsettlementrec_m.ssrm_id','icr_shopsettlementrec_d.ssrm_id')
                                    ->leftJoin('icr_shopcoupondata_g','icr_shopsettlementrec_d.scg_id','icr_shopcoupondata_g.scg_id')
                                    ->leftJoin('icr_shopcoupondata_m','icr_shopcoupondata_g.scm_id','icr_shopcoupondata_m.scm_id')
                                    ->where('icr_shopsettlementrec_m.sd_id',$searchdata['sd_id'])
                                    ->where('icr_shopsettlementrec_m.ssrm_settledate',$searchdata['ssrm_settledate'])
                                    ->where('icr_shopsettlementrec_m.isflag',1)
                                    ->where('icr_shopsettlementrec_d.isflag',1)
                                    ->get();
    }

    /**
     * @return [type] [description]
     */
    public function getSettlleDateData(){
    	return ICR_ShopSettlementRec_m::where('isflag',1)
    								->select('ssrm_settledate')
    								->groupBy('ssrm_settledate')
    								->get();
    }

    /**
     * 根據結算日期抓取店家列表
     * @param  [string] $ssrm_settledate [結算日期]
     */
    public function getDataBySettleDate($ssrm_settledate){
    	return ICR_ShopSettlementRec_m::where('isflag',1)
    								->where('ssrm_settledate',$ssrm_settledate)
    								->get();
    }

    /**
     * 只抓10筆
     * @param  [string] $ssrm_settledate        [結算日期時間]
     * @param  [string] $ssrm_settlementreview  [覆核狀態]
     * @param  [string] $sd_shopname            [特店名稱]
     * @param  [string] $skip_page              [跳過幾頁作查詢(一頁有10筆)]
     * @param  [string] $sort                   [排序根據]
     * @param  [string] $order                  [排序方式 DESC(倒序) ASC(正序)]
     */
    public function getShopdataByQueryConditions($searchdata){
    	$string = ICR_ShopSettlementRec_m::leftJoin('icr_shopdata','icr_shopsettlementrec_m.sd_id','icr_shopdata.sd_id');
    	if(isset($searchdata['query_name'])){
    		$string->where('icr_shopdata.sd_shopname', 'LIKE', '%'.$searchdata['query_name'].'%');
    	}
		return $string->where('icr_shopsettlementrec_m.isflag',1)
					  ->where('icr_shopsettlementrec_m.ssrm_settledate',$searchdata['ssrm_settledate'])
                      ->where('icr_shopsettlementrec_m.ssrm_settlementreview',$searchdata['ssrm_settlementreview'])
					  ->orderBy($searchdata['sort'],$searchdata['order'])
			          ->take(10)
			          ->skip($searchdata['skip_page']*10)
			          ->get();
    }

    /**
     * 抓取全部符合的資料
     * @param  [string] $ssrm_settledate   [結算日期時間]
     * @param  [string] $sd_shopname       [特店名稱]
     */
    public function getAllShopdataByQueryConditions($searchdata){
    	$string = ICR_ShopSettlementRec_m::leftJoin('icr_shopdata','icr_shopsettlementrec_m.sd_id','icr_shopdata.sd_id');
    	if(isset($searchdata['query_name'])){
    		$string->where('icr_shopdata.sd_shopname', 'LIKE', '%'.$searchdata['query_name'].'%');
    	}
		return $string->where('icr_shopsettlementrec_m.isflag',1)
					  ->where('icr_shopsettlementrec_m.ssrm_settledate',$searchdata['ssrm_settledate'])
			          ->get();
    }

    /**
     * 透過sd_id、ssrm_settledate取主表資料
     * @param  [string] $sd_id           [特店代碼]
     * @param  [string] $ssrm_settledate [結算日]
     */
    public function getMDataBySdidSettledate($sd_id,$ssrm_settledate){
    	return ICR_ShopSettlementRec_m::leftJoin('icr_shopdata','icr_shopsettlementrec_m.sd_id','icr_shopdata.sd_id')
    									->where('icr_shopsettlementrec_m.sd_id',$sd_id)
    									->where('ssrm_settledate',$ssrm_settledate)
    									->where('icr_shopsettlementrec_m.isflag',1)
    									->get();
    }

    /**
     * 透過sd_id、ssrm_settledate取子表資料
     * @param  [string] $sd_id           [特店代碼]
     * @param  [string] $ssrm_settledate [結算日]
     */
    public function getDDataBySdidSettledate($sd_id,$ssrm_settledate){
		return ICR_ShopSettlementRec_m::leftJoin('icr_shopsettlementrec_d','icr_shopsettlementrec_m.ssrm_id','icr_shopsettlementrec_d.ssrm_id')
										->where('sd_id',$sd_id)
										->where('ssrm_settledate',$ssrm_settledate)
										->where('icr_shopsettlementrec_m.isflag',1)
										->get();
    }

    /**
     * 透過ssrm_id抓取資料
     */
    public function getDataBySsrmId($ssrm_id){
        return ICR_ShopSettlementRec_m::leftJoin('icr_shopdata','icr_shopsettlementrec_m.sd_id','icr_shopdata.sd_id')
                                        ->where('icr_shopsettlementrec_m.ssrm_id',$ssrm_id)
                                        ->where('icr_shopsettlementrec_m.isflag',1)
                                        ->get();
    }

    /**
     * 對某結算資料做覆核的動作
     * @param  [string] $ssrm_id [紀錄ID]
     */
    public function updateReviewStatus($ssrm_id){
        try {
            $arraydata['ssrm_settlementreview'] = 1;
            $arraydata['last_update_user'] = \App\Services\AuthService::userName();
            return ICR_ShopSettlementRec_m::where('ssrm_id',$ssrm_id)->update($arraydata);
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    public function updatePaymentStatus($arraydata){
        try {
            $savedata['last_update_user'] = \App\Services\AuthService::userName();
            $savedata['ssrm_actualbillpaymentday'] = $arraydata['ssrm_actualbillpaymentday'];
            $savedata['ssrm_settlementpayment'] = $arraydata['ssrm_settlementpayment'];
            if(isset($arraydata['ssrm_settlementreview'])){
                $savedata['ssrm_settlementreview'] = $arraydata['ssrm_settlementreview'];
            }
            
            return ICR_ShopSettlementRec_m::where('ssrm_id',$arraydata['ssrm_id'])->update($savedata);
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }


}
