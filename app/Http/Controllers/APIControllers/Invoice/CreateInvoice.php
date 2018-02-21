<?php

namespace App\Http\Controllers\APIControllers\Invoice;
use Illuminate\Support\Facades\Input;
use App\Library\CommonTools;
define('Ecpay_Einvoice', config('global.ecpay_einvoice'));

/**  createInvoice   建立發票**/
class CreateInvoice {
   function createInvoice() {
        $functionName = 'createInvoice';
        $inputString = Input::All();
        $inputData = CommonTools::ConvertStringToArray($inputString);
        if(!is_null($inputString) && count($inputString) != 0 && is_array($inputString)){
           $inputString = $inputString[0];
        }
        $resultData = array();
        $messageCode = null;
        $response =null;
        $postdata = null;
        try{
             //檢查輸入值
            if(!$this->CheckInput($inputData, $messageCode)){
               if (is_null( $messageCode) )  {
                    $messageCode = '999999995';
               }
               throw new \Exception($messageCode);
            }
             //檢查身份模組驗證
            $memService = new \App\Services\MemberService;
            if ( !$memService->checkModuleAccount($inputData['modacc'], $inputData['modvrf'], $messageCode)) {
              //模組身份驗證失敗
              $messageCode = '999999961';
              throw new \Exception($messageCode);
            }
            //建立電子發票
            if (!$this->ecpayEinvoice($inputData,$messageCode,$response, $postdata)) {
                //電子發票，建立失敗
                $messageCode = '011601001';
            }
            $resultData['ecpay_return'] = $response;
            //不論失敗與否，建立紀錄資料
            if (!$this->insertRilData($postdata, $inputData, $response) ) {
               throw new \Exception($messageCode);
            }
            if (is_null($messageCode)) {
                 $messageCode ='000000000';   
            }
         } catch(\Exception $e) {
           if (is_null($messageCode)) {
                $messageCode = '999999999';
                CommonTools::writeErrorLogByException($e);
            }
        }
        //$resultArray = CommonTools::ResultProcess($messageCode, $resultData);
        $resultArray = CommonTools::UrlEncodeArray(array_merge(array("message_no" => $messageCode, "content01" =>'', "content02" => '', "content03" => ''),$resultData));
        CommonTools::WriteExecuteLog($functionName, $inputString, json_encode($resultArray), $messageCode);
        $result = [$functionName . 'result' => $resultArray];
        return $result;
   }
   
     /**
     * 檢查輸入值是否正確
     * @param type $value
     * @return boolean
     */
    function CheckInput(&$value, &$messageCode) {
        if ($value == null) {
            return false;
        }
        if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'modacc', 0, false, false)) {
            return false;
        }
        if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'modvrf', 0, false, false)) {
            return false;
        }

        if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'ril_shopid', 0, false, false)) {
            return false;
        }
        if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'md_id', 32, false, false)) {
            return false;
        }
         if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'ril_ordernumber', 0, false, false)) {
            return false;
        }
        if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'ril_ordercreatedate', 0, false, true)) {
            return false;
        }
         if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'ril_orderpaydate', 0, false, true)) {
            return false;
        }
        if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'ril_customeridentifier', 0, true, true)) {
            return false;
        }
        if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'ril_customeraddr', 0, false, false)) {
            return false;
        }
         if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'ril_customerphone', 0, false, true)) {
            return false;
        }
         if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'ril_customeremail', 0, false, true)) {
            return false;
        }/**/
        return true;
    }
    
    /**
     * 呼叫綠界，建立發票。
     * @param type array $inputData
     * @param type string $messageCode
     * @param type array $response 綠界回傳資料
     * @param type array $postdata 呼叫綠界API欄位參數
     * @return boolean
     */
    function ecpayEinvoice($inputData,&$messageCode, &$response, &$postdata) {
       $messageCode = null;
       $merchantid = null;  
       $hashkey = null;
       $hashiv = null;
       try {
         $this->getEcpaySystemData($merchantid, $hashkey , $hashiv);
         $postdata = $inputData['ril_issuerequest'];
         $postdata["MerchantID"] = $merchantid;
         $postdata["CustomerAddr"] = $this->UrlEncode($postdata["CustomerAddr"] );
         $postdata["CustomerEmail"] = $this->UrlEncode($postdata["CustomerEmail"] );
         $postdata["CustomerName"] = $this->UrlEncode($postdata["CustomerName"] );
         
         if ( ! is_null($inputData['ril_customeridentifier']) && mb_strlen($inputData['ril_customeridentifier']) > 0 ) {
             $postdata = array_add($postdata, 'CustomerIdentifier', $inputData['ril_customeridentifier']);
             $postdata['Print'] = '1';
         }
         ksort($postdata);
         $postdata['CheckMacValue']=$this->createChkValues($postdata, $hashkey, $hashiv);
        
         //客戶名字
         $postdata["CustomerName"] = urldecode($postdata["CustomerName"]);
         //客戶地址
         $postdata["CustomerAddr"] = urldecode($postdata["CustomerAddr"] );
         //客戶電子信箱
         $postdata["CustomerEmail"] = urldecode($postdata["CustomerEmail"]);
             
         $responseSting = $this->curlModels($postdata);
         $stingToArray =  explode("&",$responseSting);
         $arrayFinall = array();
         foreach ($stingToArray as $value) { 
               $array2 = explode("=",$value);
              $arrayFinall["$array2[0]"] =  $array2[1];
          }
          $response = $arrayFinall;
 //CommonTools::writeErrorLogByMessage(json_encode($response));
          if ($response['RtnCode'] != 1 ) {
              return false;
          }
          return true;
       } catch (\Exception $e) {
           CommonTools::writeErrorLogByException($e);
           $messageCode = '999999999';
            return false;
        }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
    }
    
     /**
     * php curl，模組。
     * @param type array $postdata 呼叫綠界API欄位參數
     * @return boolean
     */
    public function curlModels($postdata){
        try {
            $curl = curl_init();
             curl_setopt_array($curl, array(
                CURLOPT_URL => Ecpay_Einvoice,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => ($postdata),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER => array(
                  "cache-control: no-cache",
                  "content-type: multipart/form-data;",
                ),
            )); 
           $response = curl_exec($curl);    
           $err = curl_error($curl);
           curl_close($curl);
           if ($err) {
                $messageCode =  "cURL Error #:" . $err;
                  CommonTools::writeErrorLogByMessage($messageCode);
                throw new \Exception();
           } 
           return $response;
        } catch(\Exception $e) {
            CommonTools::writeErrorLogByException($e);
            return null;
        }
    }
    
     /**
     * 取得資料庫，綠界系統參數
     * @param type array $merchantid
     * @param type string $hashkey 
     * @param type string $hashiv 
     * @return boolean
     */
    private function getEcpaySystemData(&$merchantid, &$hashkey , &$hashiv){
        try {
             $systemRepo = new \App\Repositories\ICR_SystemParameterRepository;
             $systemData = $systemRepo->getEcpayEinvoice();
            foreach($systemData as $values) {
                if ($values['sp_parameterkey'] == 'ecpay_einvoice_merchantid'){
                    $merchantid = $values['sp_paramatervalue'];
                    continue;
                } else if ($values['sp_parameterkey'] == 'ecpay_einvoice_hashkey') {
                    $hashkey = $values['sp_paramatervalue'];
                    continue;
                } else if ($values['sp_parameterkey'] == 'ecpay_einvoice_hashiv') {
                    $hashiv = $values['sp_paramatervalue'];
                    continue;
                }
            }
            return true;
        } catch (\Exception $e) {
            CommonTools::writeErrorLogByException($e);
            return false;
        }
    }
    
    /**
     * 建立綠界檢查碼
     * @param type array $postdata
     * @param type string $hashkey 
     * @param type string $hashiv 
     * @return $CheckMacValue or null
     */
    private function createChkValues($postdata, $hashkey, $hashiv) {
        try {
             $CheckMacValue = "HashKey=".$hashkey;
             foreach ($postdata as $key => $value) {
                  if ($key == 'ItemName' || $key == 'ItemWord'||$key == 'InvoiceRemark' || $key == 'CheckMacValue' ) {
                      continue;
                   }
                   if (strlen($CheckMacValue) != 0) {
                      $CheckMacValue.="&";
                   }
                   $CheckMacValue.=$key . "=" . $value;
              }
              $CheckMacValue.="&HashIV=".$hashiv;
              $CheckMacValue = $this->UrlEncode($CheckMacValue);
              $CheckMacValue = strtolower($CheckMacValue);
              $CheckMacValue = hash('md5', $CheckMacValue);
              $CheckMacValue = strtoupper($CheckMacValue);
              return $CheckMacValue;
        } catch(\Exception $e) {
            CommonTools::writeErrorLogByException($e);
            return null;
        }
    }
    
   /**
     * 綠界參數urlencode，並replace
     * @param type string  $value
     * @return string $result
     */
     public function UrlEncode($value) {       
        $result = urlencode($value);
        $result = str_replace('%2D', '-', $result);
        $result = str_replace('%2d', '-', $result);
        $result = str_replace('%5F', '_', $result);
        $result = str_replace('%5f', '_', $result);
        $result = str_replace('%2E', '.', $result);
        $result = str_replace('%2e', '.', $result);
        $result = str_replace('%21', '!', $result);
        $result = str_replace('%2A', '*', $result);
        $result = str_replace('%2a', '*', $result);
        $result = str_replace('%28', '(', $result);
        $result = str_replace('%29', ')', $result);
        return $result;
    }
    
     /**
     * 建立AdmReceiptissueLog資料
     * @param type array $postData
     * @param type array $inputData 
     * @param type array $responseData 
     * @return boolean
     */
    public function insertRilData($postData, $inputData, $responseData) {
        try {
             $saveData = [
                 'mapr_moduleaccount' => $inputData['modacc'],
                 'ril_shopid' => $inputData['ril_shopid'],
                 'ril_ordernumber' => $inputData['ril_ordernumber'],
                 'ril_ordercreatedate' => $inputData['ril_ordercreatedate'],
                 'ril_orderpaydate' => $inputData['ril_orderpaydate'],
                "ril_customeraddr" => $inputData['ril_customeraddr'],
                "ril_customeremail" => $inputData['ril_customeremail'],
                "ril_customeridentifier" => $inputData['ril_customeridentifier'],
                "ril_customerphone" => $inputData['ril_customerphone'],
                 'ril_issueresult' =>($responseData['RtnCode'] == 1) ? 1 : 2 ,
                 'ril_receiptnumber' =>$responseData['InvoiceNumber'] ,
                 'ril_invoicedate' =>(is_null($responseData['InvoiceDate'])) ? null : $responseData['InvoiceDate'],
                 'ril_randomnumber' => $responseData['RandomNumber'],
                 'ril_returncode' => $responseData['RtnCode'],
                 'ril_issuerequest' => json_encode($postData),
                 'ril_issueresponse' =>json_encode($responseData) ,
                 'ril_receiptstatus' =>($responseData['RtnCode'] == 1) ? 1 : 0 ,
             ];
             
             $RilRepo = new \App\Repositories\AdmReceiptissueLogRepository;
             return $RilRepo->InsertData($saveData);
        } catch(\Exception $e) {
            CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    

}