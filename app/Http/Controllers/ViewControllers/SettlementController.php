<?php

namespace App\Http\Controllers\ViewControllers;

use Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;
use DB;
use Excel;

class SettlementController extends Controller {

    /**
     * 導到[結算日列表]頁面
     */
    public function settlementList() {
        $sl_r = new \App\Repositories\ICR_ShopSettlementRec_mRepository;
        $searchdata = Request::all();
        try {
            //跳過幾頁作查詢
            if(!isset($searchdata['skip_page'])){
                $searchdata['skip_page'] = 0;
            }
            //排序根據
            if(!isset($searchdata['sort'])){
                $searchdata['sort'] = "ssrm_settledate";
            }
            //排序方式
            if(!isset($searchdata['order'])){
                $searchdata['order'] = "DESC";
            }
            // 抓取10筆活動
            $settledata = $sl_r->getDataByQueryConditions($searchdata);
            // 抓取活動總筆數
            $countdata = $sl_r->getSettlleDateData();
            $total_page = ceil(count($countdata)/10);
            $searchdata['total_page'] = $total_page;
            foreach ($settledata as $key => $val) {
                $data = $sl_r->getDataBySettleDate($val['ssrm_settledate']);
                $sr0 = 0;
                $sr1 = 0;
                $sr2 = 0;
                // 計算出當前結算日的店家覆核狀態
                foreach ($data as $val) {
                    switch ($val['ssrm_settlementreview']) {
                        case 0:
                            // 未覆核
                            $sr0 = $sr0 + 1;
                            break;
                        case 1:
                            // 已覆核
                            $sr1 = $sr1 + 1;
                            break;
                        case 2:
                            // 帳務有誤
                            $sr2 = $sr2 + 1;
                            break;
                        case 3:
                            // 帳務有誤
                            $sr1 = $sr1 + 1;
                            break;
                    }
                }
                $settledata[$key]['settlementreview_0'] = $sr0;
                $settledata[$key]['settlementreview_1'] = $sr1;
                $settledata[$key]['settlementreview_2'] = $sr2;
            }
            return View::make('/settle/settlementlist',compact('settledata','searchdata'));
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 導到[結算日特店列表]頁面
     */
    public function settlementShopList() {
        $sl_r = new \App\Repositories\ICR_ShopSettlementRec_mRepository;
        $searchdata = Request::all();
        try {
            if(isset($_COOKIE['settledata'])){
                $settledata = json_decode($_COOKIE['settledata'],true);
                if(isset($settledata['ssrm_settledate'])){
                    $searchdata['ssrm_settledate'] = $settledata['ssrm_settledate'];
                }
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
            //搜索的店家名稱
            if(!isset($searchdata['query_name'])){
                $searchdata['query_name'] = '';
            }
            //店家覆核狀態
            if(!isset($searchdata['ssrm_settlementreview'])){
                $searchdata['ssrm_settlementreview'] = 0;
            }
            //抓取10筆該結算日的店家資訊
            if(!$shopdata = $sl_r->getShopdataByQueryConditions($searchdata)){
                return redirect('/settle/settlementlist')->withInput()->withErrors(['查無任何資料']);
            }
            $countdata = $sl_r->getAllShopdataByQueryConditions($searchdata);
            $total_page = ceil(count($countdata)/10);
            $searchdata['total_page'] = $total_page;
            return View::make('/settle/settlementshoplist',compact('shopdata','searchdata'));
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 導到[某特店某結算日詳細資訊]頁面
     */
    public function settlementContent() {
        $sm_r = new \App\Repositories\ICR_ShopSettlementRec_mRepository;
        $sd_r = new \App\Repositories\ICR_ShopSettlementRec_dRepository;
        $searchdata = Request::all();
        $type1 = 0;
        $type2 = 0;
        $type3 = 0;
        try {
            if(isset($_COOKIE['settledata'])){
                $settledata = json_decode($_COOKIE['settledata'],true);
                if(isset($settledata['ssrm_settledate']) && isset($settledata['sd_id'])){
                    $searchdata['ssrm_settledate'] = $settledata['ssrm_settledate'];
                    $searchdata['sd_id'] = $settledata['sd_id'];
                }elseif(isset($settledata['ssrm_settledate']) && !isset($settledata['sd_id'])){
                    $searchdata['ssrm_settledate'] = $settledata['ssrm_settledate'];
                }else{
                    return redirect('/settle/settlementlist')->withInput()->withErrors(['查無任何資料']);
                }
            }
            if(!$settledata_m = $sm_r->getMDataBySdidSettledate($searchdata['sd_id'],$searchdata['ssrm_settledate'])){
                return redirect('/settle/settlementlist')->withInput()->withErrors(['查無任何資料']);
            }
            if(count($settledata_m) == 1){
                $settledata_m = $settledata_m[0];
            }else{
                return redirect('/settle/settlementlist')->withInput()->withErrors(['查無任何資料']);
            }

            return View::make('/settle/settlementcontent',compact('settledata_m'));
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 導到[某訂單詳細資訊]頁面
     */
    public function settlementOrderContent() {
        $sm_r = new \App\Repositories\ICR_ShopSettlementRec_mRepository;
        $sd_r = new \App\Repositories\ICR_ShopSettlementRec_dRepository;
        $searchdata = Request::all();
        try {
            //跳過幾頁作查詢
            if(!isset($searchdata['skip_page'])){
                $searchdata['skip_page'] = 0;
            }
            if(!isset($searchdata['ssrd_billingtype'])){
                $searchdata['ssrd_billingtype'] = 0;
            }
            //排序根據
            if(!isset($searchdata['sort'])){
                $searchdata['sort'] = 'scg_id';
                $searchdata['a_sort'] = "icr_shopcoupondata_g.scg_id";
            }else{
                switch ($searchdata['sort']) {
                    case 'scg_id':
                        $searchdata['a_sort'] = 'icr_shopcoupondata_g.scg_id';
                        $searchdata['sort'] = 'scg_id';
                        break;
                    case 'ssrd_billingtype':
                        $searchdata['a_sort'] = 'icr_shopsettlementrec_d.ssrd_billingtype';
                        $searchdata['sort'] = 'ssrd_billingtype';
                        break;
                    case 'scg_paid_time':
                        $searchdata['a_sort'] = 'icr_shopcoupondata_g.scg_paid_time';
                        $searchdata['sort'] = 'scg_paid_time';
                        break;
                    case 'ssrm_spconsume':
                        $searchdata['a_sort'] = 'icr_shopsettlementrec_d.ssrm_spconsume';
                        $searchdata['sort'] = 'ssrm_spconsume';
                        break;
                    case 'ssrm_totalgpexchangetomoney':
                        $searchdata['a_sort'] = 'icr_shopsettlementrec_d.ssrm_totalgpexchangetomoney';
                        $searchdata['sort'] = 'ssrm_totalgpexchangetomoney';
                        break;
                    case 'ssrm_amountafterdiscount':
                        $searchdata['a_sort'] = 'icr_shopsettlementrec_d.ssrm_amountafterdiscount';
                        $searchdata['sort'] = 'ssrm_amountafterdiscount';
                        break;
                }
            }
            //排序方式
            if(!isset($searchdata['order'])){
                $searchdata['order'] = "DESC";
            }

            if(!$orderdata = $sm_r->getOrderDataBySdidSettledate($searchdata)){
                return redirect('/settle/settlementcontent')->withInput()->withErrors(['查無任何資料']);
            }
            $countdata = $sm_r->getAllScgDataByQueryConditions($searchdata);
            $total_page = ceil(count($countdata)/10);
            $searchdata['total_page'] = $total_page;


            return View::make('/settle/settlementordercontent',compact('orderdata','searchdata'));
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 針對特店做覆核的動作
     */
    public function settlementReview(){
        $sm_r = new \App\Repositories\ICR_ShopSettlementRec_mRepository;
        $searchdata = Request::all();
        try {
            $ssrm_id = json_decode($searchdata['ssrm_id']);
            if(count($ssrm_id) > 0){
                DB::beginTransaction();
                foreach ($ssrm_id as $val) {
                    if(!$sm_r->updateReviewStatus($val)){
                        DB::rollback();
                        return redirect('/settle/settlementshoplist')->withInput()->withErrors(['覆核失敗']);
                    }
                }
                DB::commit();
                return redirect('/settle/settlementshoplist')->withInput()->withErrors(['覆核成功']);
            }
            return redirect('/settle/settlementshoplist')->withInput()->withErrors(['沒有特店可以覆核']);
        } catch (Exception $e) {
            DB::rollback();
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 匯出出款，將所有特店的結算明細列在excel匯出
     */
    public function settlementOutPayment(){
        $sm_r = new \App\Repositories\ICR_ShopSettlementRec_mRepository;
        $searchdata = Request::all();
        try {
            $data1['ssrm_id'] = '紀錄ID';
            $data1['sd_shopname'] = '特店名稱';
            $data1['sd_bankaccount'] = '特店銀行帳戶';
            $data1['sd_bankcode'] = '特店銀行代號';
            $data1['ssrm_settledate'] = '結算日期';
            $data1['ssrm_totaltransatctioncount'] = '總計交易筆數';
            $data1['ssrm_salewithoutdiscount'] = '一般交易筆數';
            $data1['ssrm_salewithgp'] = '禮點折抵筆數';
            $data1['ssrm_salebypp'] = '特點交易筆數';
            $data1['ssrm_saleamountnodiscount'] = '未折扣的交易總額';
            $data1['ssrm_totalppconsume'] = '總計特點消費數額';
            $data1['ssrm_amountafterdiscount'] = '折扣後總計金額';
            $data1['ssrm_totalgpconsume'] = '總計禮點使用數額';
            $data1['ssrm_totalgpexchangetomoney'] = '總計禮點折抵金額';
            $data1['ssrm_totaliscarplatformfee'] = '本期iscar平台手續費';
            $data1['ssrm_totalpaymentflowfee'] = '本期金流平台手續費';
            $data1['ssrm_settlementpayamount'] = '本期iscar結算應付金額';

            $data2['ssrm_id'] = 'ex:結算單號';
            $data2['sd_shopname'] = 'ex:特店店名';
            $data2['sd_bankaccount'] = 'ex:特店銀行帳戶';
            $data2['sd_bankcode'] = 'ex:特店銀行代號';
            $data2['ssrm_settledate'] = 'ex:2018-01-01';
            $data2['ssrm_totaltransatctioncount'] = 'ex:該特店這期結算日所交易的總筆數';
            $data2['ssrm_salewithoutdiscount'] = 'ex:未使用特點及禮點之交易筆數';
            $data2['ssrm_salewithgp'] = 'ex:使用禮點折抵價金的交易筆數';
            $data2['ssrm_salebypp'] = 'ex:使用特點交換商品的交易筆數';
            $data2['ssrm_saleamountnodiscount'] = 'ex:記錄該週期內未經折扣之交易總金額';
            $data2['ssrm_totalppconsume'] = 'ex:pp = pm point 特點 記錄該週期內消特點總數';
            $data2['ssrm_amountafterdiscount'] = 'ex:記錄該週期內經禮點或其他折扣後總計金額';
            $data2['ssrm_totalgpconsume'] = 'ex:gp = gift point 禮點';
            $data2['ssrm_totalgpexchangetomoney'] = 'ex:禮點換算成金額';
            $data2['ssrm_totaliscarplatformfee'] = 'ex:本期iscar平台手續費';
            $data2['ssrm_totalpaymentflowfee'] = 'ex:本期金流平台手續費';
            $data2['ssrm_settlementpayamount'] = 'ex:本期iscar結算應付金額';

            $data3['ssrm_id'] = 'ssrm_id';
            $data3['sd_shopname'] = 'sd_shopname';
            $data3['sd_bankaccount'] = 'sd_bankaccount';
            $data3['sd_bankcode'] = 'sd_bankcode';
            $data3['ssrm_settledate'] = 'ssrm_settledate';
            $data3['ssrm_totaltransatctioncount'] = 'ssrm_totaltransatctioncount';
            $data3['ssrm_salewithoutdiscount'] = 'ssrm_salewithoutdiscount';
            $data3['ssrm_salewithgp'] = 'ssrm_salewithgp';
            $data3['ssrm_salebypp'] = 'ssrm_salebypp';
            $data3['ssrm_saleamountnodiscount'] = 'ssrm_saleamountnodiscount';
            $data3['ssrm_totalppconsume'] = 'ssrm_totalppconsume';
            $data3['ssrm_amountafterdiscount'] = 'ssrm_amountafterdiscount';
            $data3['ssrm_totalgpconsume'] = 'ssrm_totalgpconsume';
            $data3['ssrm_totalgpexchangetomoney'] = 'ssrm_totalgpexchangetomoney';
            $data3['ssrm_totaliscarplatformfee'] = 'ssrm_totaliscarplatformfee';
            $data3['ssrm_totalpaymentflowfee'] = 'ssrm_totalpaymentflowfee';
            $data3['ssrm_settlementpayamount'] = 'ssrm_settlementpayamount';

            $result[0] = $data1;
            $result[1] = $data2;
            $result[2] = $data3;

            // 開始抓取相關特店的資料並且塞入excel裡
            $ssrm_id = json_decode($searchdata['ssrm_id']);
            if(count($ssrm_id) > 0){
                foreach ($ssrm_id as $val) {
                    if($data = $sm_r->getDataBySsrmId($val)){
                        $data = $data[0];
                        $arraydata['ssrm_id'] = $data['ssrm_id'];
                        $arraydata['sd_shopname'] = $data['sd_shopname'];
                        $arraydata['sd_bankaccount'] = $data['sd_bankaccount'];
                        $arraydata['sd_bankcode'] = $data['sd_bankcode'];
                        $arraydata['ssrm_settledate'] = $data['ssrm_settledate'];
                        $arraydata['ssrm_totaltransatctioncount'] = $data['ssrm_totaltransatctioncount'];
                        $arraydata['ssrm_salewithoutdiscount'] = $data['ssrm_salewithoutdiscount'];
                        $arraydata['ssrm_salewithgp'] = $data['ssrm_salewithgp'];
                        $arraydata['ssrm_salebypp'] = $data['ssrm_salebypp'];
                        $arraydata['ssrm_saleamountnodiscount'] = $data['ssrm_saleamountnodiscount'];
                        $arraydata['ssrm_totalppconsume'] = $data['ssrm_totalppconsume'];
                        $arraydata['ssrm_amountafterdiscount'] = $data['ssrm_amountafterdiscount'];
                        $arraydata['ssrm_totalgpconsume'] = $data['ssrm_totalgpconsume'];
                        $arraydata['ssrm_totalgpexchangetomoney'] = $data['ssrm_totalgpexchangetomoney'];
                        $arraydata['ssrm_totaliscarplatformfee'] = $data['ssrm_totaliscarplatformfee'];
                        $arraydata['ssrm_totalpaymentflowfee'] = $data['ssrm_totalpaymentflowfee'];
                        $arraydata['ssrm_settlementpayamount'] = $data['ssrm_settlementpayamount'];
                        array_push($result,$arraydata);
                    }
                }
            }

            return Excel::create('template', function($excel) use ($result) {
                $excel->sheet('結算特店列表', function($sheet) use ($result)
                {
                    $sheet->fromArray($result);
                });
            })->download('xlsx');
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 匯入出款，將excel檔裡的特店都改為已出款
     */
    public function settlementInPayment(){
        $sm_r = new \App\Repositories\ICR_ShopSettlementRec_mRepository;
        $searchdata = Request::all();
        try {
            if(Request::hasFile('import_file')){
                $path = Request::file('import_file')->getRealPath();
                $data = Excel::selectSheetsByIndex(0)->load($path, function($reader) {})->get();
                if(!empty($data) && $data->count()){
                    DB::beginTransaction();
                    foreach ($data as $key => $qqq) {
                        if(!empty($qqq)){
                            $int_key = (int)$key;
                            if($qqq['ssrm_id'] == null && $qqq['sd_shopname'] == null && $qqq['sd_bankaccount'] == null && $qqq['sd_bankcode'] == null && $qqq['ssrm_settledate'] == null && $qqq['ssrm_totaltransatctioncount'] == null && $qqq['ssrm_salewithoutdiscount'] == null && $qqq['ssrm_salewithgp'] == null && $qqq['ssrm_salebypp'] == null && $qqq['ssrm_saleamountnodiscount'] == null && $qqq['ssrm_totalppconsume'] == null && $qqq['ssrm_amountafterdiscount'] == null && $qqq['ssrm_totalgpconsume'] == null && $qqq['ssrm_totalgpexchangetomoney'] == null && $qqq['ssrm_totaliscarplatformfee'] == null && $qqq['ssrm_totalpaymentflowfee'] == null && $qqq['ssrm_settlementpayamount'] == null){
                                DB::rollback();
                                break;
                            }
                            // 這邊就是你資料庫裡面所有的欄位設定
                            if($qqq['ssrm_id'] == ''){
                                DB::rollback();
                                return redirect('/settle/settlementshoplist')->withInput()->withErrors(['匯入失敗，請檢查"結算紀錄ID"是否填寫']);
                            }
                            $arraydata['ssrm_actualbillpaymentday'] = \Carbon\Carbon::now()->toDateString();
                            $arraydata['ssrm_id'] = $qqq['ssrm_id'];
                            if($searchdata['ssrm_settlementreview'] == 0){
                                $arraydata['ssrm_settlementreview'] = 3;
                            }
                            $arraydata['ssrm_settlementpayment'] = 1;
                            if(!$sm_r->updatePaymentStatus($arraydata)){
                                DB::rollback();
                                return redirect('/settle/settlementshoplist')->withInput()->withErrors(['匯入失敗，請重新匯入']);
                            }
                        }
                    }
                    DB::commit();
                    return redirect('/settle/settlementshoplist')->withInput()->withErrors(['匯入成功']);
                }

            }
            return redirect('/settle/settlementshoplist')->withInput()->withErrors(['匯入失敗，請檢查你匯入的檔案']);
        } catch (Exception $e) {
            DB::rollback();
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }
}
