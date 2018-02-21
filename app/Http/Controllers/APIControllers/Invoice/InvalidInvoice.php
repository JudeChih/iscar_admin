<?php

namespace App\Http\Controllers\APIControllers\Invoice;
use Illuminate\Support\Facades\Input;
use App\Library\CommonTools;
define('Ecpay_Invalid_Einvoice', config('global.ecpay_invalid_einvoice'));


class InvalidInvoice {
   function invalidInvoice() {
        $functionName = 'invalidInvoice';
        $inputString = Input::All();
        $inputData = CommonTools::ConvertStringToArray($inputString);
        if(!is_null($inputString) && count($inputString) != 0 && is_array($inputString)){
           $inputString = $inputString[0];
        }
        $resultData = null;
        $messageCode = null;
        $expiredDate = null;
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
            $Rilrepo = new \App\Repositories\AdmReceiptissueLogRepository;
            $rilData = $Rilrepo->getDataByshopid_ordernumber($inputData['ril_shopid'], $inputData['ril_ordernumber']);
            if ($rilData[0]['ril_receiptnumber'] != $inputData['ril_receiptnumber']) {
                $messageCode = '999999999';
                throw new \Exception($messageCode);
            }
            //計算此發票的過期日
            do{
                if (is_null($expiredDate)) {
                   $expiredDate =  date("Y-m-13 23:59:59",strtotime($rilData[0]['ril_invoicedate']." +1 month")); 
                } else {
                    $expiredDate =  date("Y-m-d H:i:s ",strtotime("$expiredDate +1 month"));
                }
               (int)$expired_month = date('m',strtotime("$expiredDate"));
            } while($expired_month %2 == 0 );
            if (date("Y-m-d H:i:s") > $expiredDate) {
                 //此發漂已過作廢最後日期
              $messageCode = '999999999';
              throw new \Exception($messageCode);
            }
            
            if ($this->ecpayInvalidEinvoice($inputData, $rilData,$messageCode, $response, $postdata)) {
                $response['ril_voiddatetime'] = date('Y-m-d H:i:s');
                $this->updateRilData($rilData, $postdata, $inputData, $response);
               
            }
            $resultData['ecpay_return'] = $response;
            $messageCode ='000000000';
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
        if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'ril_ordernumber', 0, false, false)) {
            return false;
        }
        if (!\App\Library\CommonTools::CheckRequestArrayValue($value, 'ril_voidreason', 0, false, false)) {
            return false;
        }
        return true;
    }
    
    
    function ecpayInvalidEinvoice($inputData,$rilData,&$messageCode, &$response, &$postdata) {
        $messageCode = null;
        $merchantid = null;  
        $hashkey = null;
        $hashiv = null;
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
          
           $postdata = array(
              "CheckMacValue" => "",
              "MerchantID" => $merchantid,//"2000132",
              "Reason" => $inputData['ril_voidreason'],
              "InvoiceNumber" =>  $rilData[0]['ril_receiptnumber'],//"T" . time(),
              "TimeStamp" => time(),
            );                 
            ksort($postdata);
            $CheckMacValue = "HashKey=".$hashkey;
            foreach ($postdata as $key => $value) {
                if ($key == 'Reason' || $key == 'CheckMacValue' ) {
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
            $postdata["CheckMacValue"] = $CheckMacValue;
              
            $curl = curl_init();
             curl_setopt_array($curl, array(
                    CURLOPT_URL => Ecpay_Invalid_Einvoice,
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
               throw new \Exception($messageCode);
          } 
          CommonTools::writeErrorLogByMessage(($response));
         $array =  explode("&",$response);
         $array3 = array();
         foreach ($array as $value) { 
               $array2 = explode("=",$value);
               $array3 = array_add($array3, $array2[0], $array2[1]);
         }
         $response = $array3;
         return true;
         } catch (\Exception $e) {
            CommonTools::writeErrorLogByException($e);
            $messageCode = '999999999';
            return false;
        }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
    }
   
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
    
    public function updateRilData($rilData, $postData, $inputData, $responseData) {
        try {
             $saveData = [
                 'ril_serno' =>$rilData[0]['ril_serno'],
                 'ril_voidrequest' => json_encode($postData),
                 'ril_voidresponse' => json_encode($responseData),
                 'ril_voiddatetime' => $responseData['ril_voiddatetime'],
                 'ril_voidreason' => $inputData['ril_voidreason'],
                 'ril_voidrtncode' => $responseData['RtnCode'],
                "ril_voidrtnmsg" => $responseData['RtnMsg'],
                "ril_receiptstatus" => ($responseData['RtnCode'] == 1) ? 2 : 1,
             ];
             
             $RilRepo = new \App\Repositories\AdmReceiptissueLogRepository;
             return $RilRepo->UpdateData($saveData);
        } catch(\Exception $e) {
            CommonTools::writeErrorLogByException($e);
            return false;
        }
    }
    
    

    

}