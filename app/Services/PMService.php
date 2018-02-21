<?php
namespace App\Services;

define('CreateShopData', config('global.create_shopdata'));
define('QueryShopList', config('global.query_shoplist'));
define('QueryShopContent', config('global.query_shopcontent'));
define('ModifyShopData', config('global.modify_shopdata'));
define('QueryShopType', config('global.query_shoptype'));
define('QueryShopCouponList', config('global.query_shopcouponlist'));
define('QueryShopCouponContent', config('global.query_shopcouponcontent'));
define('ModifyShopCoupon', config('global.modify_shopcoupon'));
define('Modacc', config('global.modacc'));
define('Modvrf', config('global.modvrf'));

class PMService {

    /**
     * call pm模組的API [CreateShopData]
     * @param  array  $arraydata      [多筆特店資料]
     * @global route  CreateShopData  [pm模組的API]
     * @global string Modacc          [模組帳號]
     * @global string Modvrf          [模組驗證碼]
     */
    public function callApiCreateShopData($data){
        // 編輯要call API所需要傳入的值
        $arraydata['shopdata'] = $data;
        $arraydata['modacc'] = Modacc;
        $arraydata['modvrf'] = Modvrf;
        $url = CreateShopData;
        // call API
        $request = \App\Library\CommonTools::curlModule($arraydata,$url);
        $result = $request['createshopdataresult'];
        return $result;
    }

    /**
     * call pm模組的API [queryshoplist]
     * @global route   queryshoplist   [pm模組的API]
     * @param  string  sd_type         [商家類別]
     * @param  string  sd_zipcode      [商家所在區域]
     * @param  string  sd_shopname     [商家名稱]
     * @param  string  bindstatus      [綁定狀態 0:未綁定 1:已綁定]
     * @param  string  sd_activestatus [商家有效狀態 0:停用 1:啟用]
     * @param  string  skip_page       [跳過幾頁作查詢，一頁有10筆]
     * @param  string  sort            [排序根據]
     * @param  string  order           [排序方式 DESC(倒序) ASC(正序)]
     */
    public function callApiQueryShopList(Array $data){
        //編輯要call API所需要傳入的值
        $data['modacc'] = Modacc;
        $data['modvrf'] = Modvrf;

        $url = QueryShopList;
        // call API
        $request = \App\Library\CommonTools::curlModule($data,$url);
        $request = $request['queryshoplistresult'];

        return $request;
    }

    /**
     * call pm模組的API [queryshopcouponlist]
     * @global route   queryshopcouponlist [pm模組的API]
     * @param  string  sd_shopname         [商家名稱]
     * @param  string  scm_title           [商品標題]
     * @param  string  scm_category        [商品類別]
     * @param  string  scm_poststatus      [刊登狀態 0:停用 1:啟用]
     * @param  string  skip_page           [跳過幾頁作查詢，一頁有10筆]
     * @param  string  sort                [排序根據]
     * @param  string  order               [排序方式 DESC(倒序) ASC(正序)]
     */
    public function callApiQueryShopCouponList(Array $data){
        //編輯要call API所需要傳入的值
        $data['modacc'] = Modacc;
        $data['modvrf'] = Modvrf;

        $url = QueryShopCouponList;
        // call API
        $request = \App\Library\CommonTools::curlModule($data,$url);
        $result = $request['queryshopcouponlistresult'];

        return $result;
    }

    /**
     * call pm模組的API [QueryShopContent]
     * @param  string $sd_id           [店家代碼]
     * @global route  QueryShopContent [pm模組的API]
     * @global string Modacc           [模組帳號]
     * @global string Modvrf           [模組驗證碼]
     */
    public function callApiQueryShopContent($sd_id){
        // 編輯要call API所需要傳入的值
        $arraydata['sd_id'] = $sd_id;
        $arraydata['modacc'] = Modacc;
        $arraydata['modvrf'] = Modvrf;
        $url = QueryShopContent;
        // call API
        $request = \App\Library\CommonTools::curlModule($arraydata,$url);
        $result = $request['queryshopcontentresult'];

        return $result;
    }

    /**
     * call pm模組的API [QueryShopContent]
     * @param  string $scm_id                [優惠卷編號]
     * @global route  QueryShopCouponContent [pm模組的API]
     * @global string Modacc                 [模組帳號]
     * @global string Modvrf                 [模組驗證碼]
     */
    public function callApiQueryShopCouponContent($scm_id){
        // 編輯要call API所需要傳入的值
        $arraydata['scm_id'] = $scm_id;
        $arraydata['modacc'] = Modacc;
        $arraydata['modvrf'] = Modvrf;
        $url = QueryShopCouponContent;
        // call API
        $request = \App\Library\CommonTools::curlModule($arraydata,$url);
        $result = $request['queryshopcouponcontentresult'];

        return $result;
    }

    /**
     * call pm模組的API [ModifyShopData]
     * @param  array or string  $sd_id         [店家代碼]
     * @param  string $modify_type             [修改類別 1:停/啟用 2:刪除 3:綁定/解綁 4:設置代號 5:設置metatag 6:設置金流協議狀態]
     * @param  string $status                  [0:停用 1:啟用]
     * @param  string $have_bind               [0:解綁 1:綁定]
     * @param  string $sd_paymentflowagreement [1:已簽署 2:未簽署]
     * @param  string $sdmr_modifyreason       [異動原因]
     * @global route  ModifyShopData           [pm模組的API]
     * @global string Modacc                   [模組帳號]
     * @global string Modvrf                   [模組驗證碼]
     */
    public function callApiModifyShopData(Array $data,&$arraydata){
        // 編輯要call API所需要傳入的值
        $arraydata['sd_id'] = $data['sd_id'];
        $arraydata['modify_type'] = $data['modify_type'];
        if($data['modify_type'] == 1){
            $arraydata['sd_activestatus'] = $data['status'];
            if($data['status'] == 0){
                $arraydata['sdmr_operationtype'] = 1;//異動操作項目 1:停用
            }elseif($data['status'] == 1){
                $arraydata['sdmr_operationtype'] = 2;//異動操作項目 2:啟用
            }
        }elseif($data['modify_type'] == 2){
            $arraydata['sdmr_operationtype'] = 3;//異動操作項目 3:刪除
        }elseif($data['modify_type'] == 3){
            $arraydata['sd_havebind'] = $data['have_bind'];
            if($data['have_bind'] == 0){
                $arraydata['sdmr_operationtype'] = 4;//異動操作項目 4:解綁
            }elseif($data['have_bind'] == 1){
                $arraydata['sdmr_operationtype'] = 5;//異動操作項目 5:綁定
            }
        }elseif($data['modify_type'] == 4){
            $arraydata['sdmr_operationtype'] = 6;//異動操作項目 6:設置代號
            $arraydata['sd_salescode'] = $data['sd_salescode'];
            $arraydata['sd_salesbind'] = $data['sd_salesbind'];
        }elseif($data['modify_type'] == 5){
            $arraydata['sdmr_operationtype'] = 7;//異動操作項目 7:設置metatag
            $arraydata['sd_seo_keywords'] = $data['sd_seo_keywords'];
            $arraydata['sd_seo_description'] = $data['sd_seo_description'];
            $arraydata['sd_seo_title'] = $data['sd_seo_title'];
        }elseif($data['modify_type'] == 6){
            $arraydata['sdmr_operationtype'] = 8;//異動操作項目 8:設置金流協議狀態
            $arraydata['sd_paymentflowagreement'] = $data['sd_paymentflowagreement'];
        }

        // 異動原因
        if(isset($data['sdmr_modifyreason'])){
            $arraydata['sdmr_modifyreason'] = $data['sdmr_modifyreason'];
        }
        $arraydata['modacc'] = Modacc;
        $arraydata['modvrf'] = Modvrf;
        $url = ModifyShopData;
        // call API
        $request = \App\Library\CommonTools::curlModule($arraydata,$url);
        $result = $request['modifyshopdataresult'];

        return $result;
    }

    /**
     * call pm模組的API [ModifyShopCoupon]
     * @param  array  $sd_id             [特店代碼]
     * @param  array  $scm_id            [商品代碼]
     * @param  string $sdmr_modifyreason [異動原因]
     * @param  string $modify_type       [修改類別 1:停/啟用]
     * @param  string $status            [0:停用 1:啟用]
     * @global route  ModifyShopCoupon   [pm模組的API]
     * @global string Modacc             [模組帳號]
     * @global string Modvrf             [模組驗證碼]
     */
    public function callApiModifyShopCoupon(Array $data,&$arraydata){
        // 編輯要call API所需要傳入的值
        $arraydata['sd_id'] = $data['sd_id'];
        $arraydata['scm_id'] = $data['scm_id'];
        $arraydata['sdmr_modifyreason'] = $data['sdmr_modifyreason'];
        $arraydata['modify_type'] = $data['modify_type'];
        $arraydata['scm_poststatus'] = $data['status'];
        if($data['status'] == 0){
            $arraydata['sdmr_operationtype'] = 1;//異動操作項目 1:停用
        }elseif($data['status'] == 1){
            $arraydata['sdmr_operationtype'] = 2;//異動操作項目 2:啟用
        }
        $arraydata['modacc'] = Modacc;
        $arraydata['modvrf'] = Modvrf;
        $url = ModifyShopCoupon;
        // call API
        $request = \App\Library\CommonTools::curlModule($arraydata,$url);
        $result = $request['modifyshopcouponresult'];

        return $result;
    }

    /**
     * call pm模組的API [queryshoptype]
     * @global route  QueryShopType [pm模組的API]
     * @global string Modacc        [模組帳號]
     * @global string Modvrf        [模組驗證碼]
     */
    public function callApiQueryShopType(){
        //編輯要call API所需要傳入的值
        $data['modacc'] = Modacc;
        $data['modvrf'] = Modvrf;

        $url = QueryShopType;
        // call API
        $request = \App\Library\CommonTools::curlModule($data,$url);
        $request = $request['queryshoptyperesult'];

        return $request;
    }
}
