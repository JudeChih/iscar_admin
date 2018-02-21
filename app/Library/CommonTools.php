<?php

namespace App\Library;

use Illuminate\Http\Request;

define('AndroidApiKey', config('global.android_api_key'));

class CommonTools {

    /**
     * 參數解碼，並轉為陣列格式
     * @param type $parameter base64_encode和urlencode後的參數
     * @return boolean
     */
    public static function decodeAndConvertToArray($parameter) {
        try {
            if (!isset($parameter) || mb_strlen($parameter) == 0) {
                return false;
            }
            $paraDecode = urldecode($parameter);
            $paraDecode = base64_decode($paraDecode);
            $paraArray = json_decode($paraDecode, true);

            return $paraArray;
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * 檢查參數值
     * @param type $paraArray 參數陣列
     * @return boolean 檢查結果
     */
    public static function checkParameter($paraArray) {
        try {
            if (!is_array($paraArray)) {
                return false;
            }
            if (!array_key_exists('mur', $paraArray) || !array_key_exists('modacc', $paraArray) || !array_key_exists('modvrf', $paraArray) || !array_key_exists('redirect_uri', $paraArray)) {
                return false;
            }
            //檢查 mur 是否存在
            $murRepo = new \App\Repositories\MobileUnitRecRepository();
            $murData = $murRepo->getDataByMurID($paraArray['mur']);
            if (!isset($murData) || count($murData) != 1) {
                return false;
            }
            // 檢查 modacc 是否存在
            $mapr_r = new \App\Repositories\ModuleAccPass_rRepository;
            $maprData = $mapr_r->getDataByAccount($paraArray['modacc']);
            if(count($maprData) == 0 || is_null($maprData)){
                return false;
            }
            if(count($maprData) == 1 ){
                $maprData = $maprData[0];
            }
            // 檢查 modvrf 是否正確
            $str = $maprData['mapr_moduleaccount'].$maprData['mapr_modulepassword'];
            $vry = hash('sha256',$str);
            if($vry != $paraArray['modvrf']){
                return false;
            }
            //檢查 redirect_uri 是否正確
            if ($paraArray['redirect_uri'] != $maprData['mapr_redirect_uri']) {
                return false;
            }
            return true;
        } catch (\Exception $ex) {
            CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }

    /**
     * 參數解碼並檢查值
     * @param type $parameter
     * @return boolean
     */
    public static function decodeAndCheckParameter($parameter) {
        try{
            //轉換格式，並檢查回傳是否為陣列格式
            if ((!$paraArray = CommonTools::decodeAndConvertToArray($parameter)) || !is_array($paraArray)) {
                return false;
            }

            //檢查陣列內的值是否符合條件
            if (!CommonTools::checkParameter($paraArray)) {
                return false;
            }

            return $paraArray;
        } catch (\Exception $e){
            CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 檢查值的格式是否正確
     * @param type $value 要檢查的值
     * @param type $maxLength 限制長度，若為「０」則不限制
     * @param type $canEmpty 可否〔不填值〕或〔空值〕
     * @param type $canSpace 可否包含〔空白〕
     * @return boolean 檢查結果
     */
    public static function checkValueFormat($value, $maxLength, $canEmpty, $canSpace) {
        try {
            if (mb_strlen($value) == 0 && $canempty) {
                return true;
            }
            if (mb_strlen($value) == 0) {
                return false;
            }

            if ($maxLength != 0 && mb_strlen($value) > $maxLength) {
                //長度太長
                return false;
            }
            if (!$canSpace && preg_match('/\s/', $value)) {
                //檢查是否可包含空白
                return false;
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 取得隨機GUID字串, 依「$havedash」決定是否包含Dash
     * @param type $havedash 是否包含Dash
     * @return type GUID字串
     */
    public static function generateGUID($havedash = true) {

        if ($havedash) {
            $formatstring = '%04x%04x-%04x-%04x-%04x-%04x%04x%04x';
        } else {
            $formatstring = '%04x%04x%04x%04x%04x%04x%04x%04x';
        }

        return sprintf($formatstring,
                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,
                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * 產生「密碼重置」用的Hash Code
     * @param type $rpv_serno 重設密碼驗證碼序號
     * @param type $rpv_hash 雜湊值
     * @return type
     */
    public static function encodeResetPwdHashParameter($rpv_serno, $rpv_hash) {
        return $rpv_hash . hash('md5', 'sunwai') . $rpv_serno;
    }

    /**
     * 分解「密碼重置」Hash Code成陣列格式
     * @param type $hashcode 「密碼重置」用的Hash Code
     * @return boolean
     */
    public static function decodeResetPwdHashParameter($hashcode) {
        try {
            $arr = explode(hash('md5', 'sunwai'), $hashcode);

            if (count($arr) !== 2) {
                return false;
            }
            $return['rpv_serno'] = $arr[1];
            $return['rpv_hash'] = $arr[0];
            return $return;
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * 在網址上加上「Query String」
     * @param type $uri 網址
     * @param type $queryString
     * @return string
     */
    public static function appendQueryStringInUri($uri, $queryString) {

        $parsedUrl = parse_url($uri);
        if (!isset($parsedUrl['path']) || $parsedUrl['path'] == null) {
            $uri .= '/';
        }
        $separator = (!isset($parsedUrl['query'])) ? '?' : '&';
        $uri .= $separator . $queryString;

        return $uri;
    }

    /**
     * 建立「ServiceAccessToken」、「MemberMobileLink」
     * @param type $md_id 會員代碼
     * @param type $mur_id 設備代碼
     * @return boolean
     */
    public static function createServiceAccessToken($md_id, $mur_id) {
        try {
            //資料庫 開始交易
            \Illuminate\Support\Facades\DB::beginTransaction();

            $satRepo = new \App\Repositories\ServiceAccessTokenRepository();
            $mmlRepo = new \App\Repositories\MemberMobileLinkRepository();
            //把同「md_id」、「mur_id」的SAT刪除
            if (!$satRepo->updateIsFlagToZeroByMdIDMurID($md_id, $mur_id)) {
                //資料庫 回復交易
                \Illuminate\Support\Facades\DB::rollback();
                return false;
            }
            //把同「md_id」的MML刪除
            if (!$mmlRepo->updateIsFlagToZeroByMdID($md_id)) {
                //資料庫 回復交易
                \Illuminate\Support\Facades\DB::rollback();
                return false;
            }
            //建立SAT
            $satData['sat_apptype'] = '0';
            $satData['md_id'] = $md_id;
            $satData['mur_id'] = $mur_id;

            $jwtSvc = new \App\Services\JWTService();
            $satData['sat_token'] = $jwtSvc->generateJWT(['md_id' => $md_id,'mur_id' => $mur_id]);
            //$satData['sat_token'] = CommonTools::generateGUID(false);
            $satData['sat_expiredate'] = \Carbon\Carbon::now()->addMonths(1);
            $sat_serno = $satRepo->createGetId($satData);
            if (!isset($sat_serno)) {
                //資料庫 回復交易
                //\Illuminate\Support\Facades\DB::rollback();
                return false;
            }
            //建立MML
            $mmlData['mml_apptype'] = '0';
            $mmlData['md_id'] = $md_id;
            $mmlData['mur_id'] = $mur_id;
            $mml_serno = $mmlRepo->createGetId($mmlData);

            if (!isset($mml_serno)) {
                //資料庫 回復交易
                \Illuminate\Support\Facades\DB::rollback();
                return false;
            }
            $satData = $satRepo->getData($sat_serno);
            if (!isset($satData) || count($satData) != 1) {
                //資料庫 回復交易
                \Illuminate\Support\Facades\DB::rollback();
                return false;
            }
            //資料庫 認可交易
            \Illuminate\Support\Facades\DB::commit();
            return $satData->sat_token;
        } catch (\Exception $ex) {
            //資料庫 回復交易
            \Illuminate\Support\Facades\DB::rollback();

            CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }

    /**
     * 產生亂數數字字串
     * @param type $length 字串長度
     * @return string
     */
    public static function generateRandomNumberString($length) {
        $characters = '0123456789';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

    /**
     * 建立「Exception」記錄
     * @param type $ex
     * @return boolean 執行結果
     */
    public static function writeErrorLogByException($ex) {
        try {
            $arraydata['log_type'] = '2';
            $arraydata['log_code'] = $ex->getCode();
            $arraydata['log_message'] = $ex->getMessage();
            $arraydata['log_previous'] = $ex->getPrevious();
            $arraydata['log_file'] = $ex->getFile();
            $arraydata['log_line'] = $ex->getLine();
            //$arraydata['log_trace'] = $ex->getTrace();
            $arraydata['log_traceasstring'] = $ex->getTraceAsString();

            $errRepo = new \App\Repositories\ErrorLogRepository();
            return $errRepo->create($arraydata);
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * 建立「Message」記錄
     * @param type $message 訊息
     * @param type $code 代碼
     * @param type $file 檔案
     * @param type $line 行數
     * @return boolean 執行結果
     */
    public static function writeErrorLogByMessage($message, $code = null, $file = null, $line = null) {
        try {
            $arraydata['log_type'] = '1';
            $arraydata['log_message'] = $message;
            if (isset($code)) {
                $arraydata['log_code'] = $code;
            }
            if (isset($file)) {
                $arraydata['log_file'] = $file;
            }
            if (isset($line)) {
                $arraydata['log_line'] = $line;
            }

            $errRepo = new \App\Repositories\ErrorLogRepository();
            return $errRepo->create($arraydata);
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * 建立會員帳號異動記錄
     * @param type $md_id 會員代碼
     * @param type $mur_id 設備代碼
     * @param type $operationType 異動類別 １：登入、２：註冊、３：變更密碼、
     * @param type $accountType 異動類別 １：isCar帳號、２：FaceBook、３：Google、４：WeChat、
     * @param type $sso_serno 第三方認證記錄編號
     * @param type $snc_serno 簡訊註冊代碼
     * @return boolean 執行結果
     */
    public static function writeAccountModifyRecode($md_id, $mur_id, $operationType, $accountType, $sso_serno = null, $snc_serno = null) {
        try {
            if (!isset($md_id) || !isset($mur_id) || !isset($operationType) || !isset($accountType)) {
                return false;
            }

            $arrayData['md_id'] = $md_id;
            $arrayData['uamr_operationtype'] = $operationType . $accountType;
            $arrayData['mur_id'] = $mur_id;
            if (isset($sso_serno)) {
                $arrayData['sso_serno'] = $sso_serno;
            }
            if (isset($snc_serno)) {
                $arrayData['snc_serno'] = $snc_serno;
            }

            $uamrRepo = new \App\Repositories\UserAccountModifyRecordRepository();
            if (!$uamrRepo->create($arrayData)) {
                return false;
            }
            return true;
        } catch (\Exception $ex) {
            CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }
/////阿志新增2017/05/23////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    
      
    /**
     * 檢查陣列中指定Key是否存在，並檢查Vaule格式是否正確
     * @param  [array]   $arrayData [資料陣列]
     * @param  [string]  $key       [要檢查的key]
     * @param  [int]     $maxLength [限制長度，若為0則不限制]
     * @param  [boolean] $canEmpty  [可否〔不填值〕或〔空值〕]
     * @param  [boolean] $canSpace  [可否包含〔空白〕]
     * @return [boolean]            [檢查結果]
     */
    public static function checkArrayValueFormat($arrayData,$key,$maxLength=0,$canEmpty=false,$canSpace=false){
        if(!is_array($arrayData)){
            return false;
        }
        if(array_key_exists($key,$arrayData) && is_null($arrayData[$key])){
            if(!$canEmpty){
                return false;
            }else{
                return true;
            }
        }
        if($maxLength != 0){
            if(strlen($arrayData[$key]) > $maxLength){
                return false;
            }
        }
        if(!$canSpace){
            if(preg_replace('/\s(?=)/', '', $arrayData[$key]) != $arrayData[$key]){
                return false;
            }
        }
        return true;
    }

    /**
     * Curl模組化使用
     * @param type array $post 傳送資料
     * @param type string $route 傳送route
     * @return array or null
     */
    public static function curlModule ($post, $route){
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $route,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode(json_encode($post)),
                CURLOPT_HTTPHEADER => array(
                  "cache-control: no-cache",
                  "content-type: application/json",
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                throw new \Exception($err);
            } else {
                return \App\library\CommonTools::ConvertStringToArray($response);
            }
        } catch(\Exception $ex) {
            CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }


/////阿駿的commonTools/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

      /**
     * 建立「WebAPI 執行記錄」到資料庫中
     * @param type $functionname 執行的功能名稱
     * @param type $input 接收到的值
     * @param type $result 回傳的值
     * @param type $messagecode 訊息代碼
     * @return boolean 執行結果
     */
    public static function WriteExecuteLog($functionname, $input, $result, $messagecode) {
        $arraydata = array("jio_receive" => json_encode($input), "jio_return" => $result, "jio_wcffunction" => $functionname, "ps_id" => $messagecode);
        if (\App\Models\IsCarJsonioRec::InsertData($arraydata)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * 使用Google API 查詢〔地理編碼〕
     * @param type $address 地址
     * @param type $longitude 經度
     * @param type $latitude 緯度
     * @return boolean
     */
    public static function Query_GeoCodeByGoogle($address, &$longitude, &$latitude) {
        try {
            if (is_null($address) || strlen($address) == 0) {
                return false;
            }

            $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=" . urlencode($address) . "&sensor=false&language=zh-TW");
            $json = json_decode($json);

            if (is_null($json) || count($json) == 0) {
                return false;
            }

            if (strtolower($json->status) != 'ok') {
                return false;
            }

            $latitude  = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $longitude = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

            return true;
        } catch (Exception $ex) {
            CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }
    /**
     * 將Json格式的字串 轉換為 PHP Array
     * @param type $inputstring WebAPI接收到的「JSON」格式字串
     * @return type PHP陣列
     */
    public static function ConvertStringToArray($inputstring) {
        try {
            $input = str_replace("'", '"', $inputstring);

            if (is_array($input)) {
                $inputjson = json_decode($input[0], true);
            } else {
                $inputjson = json_decode($input, true);
            }
            return $inputjson;
        } catch (\Exception $e) {
            CommonTools::writeErrorLogByException($e);
            return null;
        }
    }

    /**
     * 對〔$data〕陣列中所有值作「rawurlencode」
     * @param type $data 陣列值
     * @return type 「rawurlencode」後的資料
     */
    public static function UrlEncodeArray($data) {

        //若不為〔陣列〕則直接作「rawurlencode」後回傳
        if (!is_array($data)) {
            //return $data;
            return rawurlencode($data);
        }
        //迴圈：「rawurlencode」所有$value
        foreach ($data as $name => $value) {
            //遞迴：呼叫原本 Function 以跑遍所有「陣列」中的「陣列」
            $data[$name] = CommonTools::UrlEncodeArray($value);
        }

        return $data;
    }

    /**
     * 檢查「$keyname」是否存在於「$arraydata」中，並檢查其他條件
     * @param type $arraydata   要檢查的陣列
     * @param type $keyname    要檢查的參數名稱
     * @param type $maxlength 最大長度限制，若輸入「0」則為不限制
     * @param type $canempty 是否可為「空值」
     * @param type $canspace 是否可包含「空白」
     * @return boolean 是否符合條件
     */
    public static function CheckRequestArrayValue($arraydata, $keyname, $maxlength, $canempty, $canspace) {
        try {

            if (array_key_exists($keyname, $arraydata)) {
                $QQ = $arraydata[$keyname];
                if (is_array($QQ)) {
                    $QQ = implode(" ", $QQ);
                }
            } else {
                $QQ = null;
            }

            if ((!array_key_exists($keyname, $arraydata) || ( mb_strlen($QQ) == 0)) && $canempty) {
                return true;
            }
            if (!array_key_exists($keyname, $arraydata) || ( mb_strlen($QQ) == 0)) {
                //不存在
                return false;
            }

            if ($maxlength != 0 && mb_strlen($QQ) > $maxlength) {
                //長度太長
                return false;
            }
            if (!$canspace) {
                //檢查是否可包含空白
                if (preg_match('/\s/', $QQ) === 1) {
                    return false;
                }
            }
            return true;
        } catch (\Exception $e) {
            CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 依AccessToken 取得FaceBook Account ID
     * @param type $accessToken
     * @return type
     */
    public static function GetFacebookAccountID($accessToken) {
        try {
            //初始化 Facebook 元件
            $facebook = CommonTools::GetFacebook();
            if ($facebook == null) {
                return null;
            }
            //使用「$accountToken」取得使用者資料
            $response = $facebook->get('/me?fields=id,name', $accessToken);

            $user = $response->getGraphUser();

            return $user['id'];
        } catch (\Exception $e) {
            return null;
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            return null;
        }
    }

    /**
     * 取得並初始化FaceBook 元件
     * @return \Facebook\Facebook Facebook元件
     */
    private static function GetFacebook() {
        try {
            $facebook = new \Facebook\Facebook([ 'app_id' => CommonTools::$FB_AppID, 'app_secret' => CommonTools::$FB_AppSecret,]);

            return $facebook;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * 驗證「Token」和「UserDeviceCode」，若正確回傳「Token」對應的「MD_ID會員代碼」
     * @param type $token
     * @param type $devicecode
     * @param type $md_id
     * @param string $messageCode
     * @return boolean
     */
    public static function CheckAccessTokenDeviceCode($token, $devicecode, &$md_id, &$messageCode) {

        //return   Commontools::CheckServiceAccessTokenOlder($token, $md_id, $messageCode);
        if (!CommonTools::CheckServiceAccessTokenOlderOlder($token, $md_id, $messageCode)) {
            return false;
        }

        if (!CommonTools::CheckUserDeviceCode($token, $devicecode)) {
            $messageCode = '999999994';
            return false;
        }

        return true;
    }

    /**
     * 檢查「keyname」是否存在於「arraydata」中，並檢查是否有填值
     * @param type $arraydata
     * @param type $keyname
     * @return boolean
     */
    public static function CheckArrayValue($arraydata, $keyname) {
        try {
            /*
              if(!array_key_exists($keyname, $arraydata)) {
              return 1;
              }
              if( ($arraydata[$keyname] === null)){
              return 2;
              }
              if(strlen($arraydata[$keyname]) === 0){
              return 3;
              }
             */
            if (
                    !array_key_exists($keyname, $arraydata) || is_null($arraydata[$keyname]) || mb_strlen($arraydata[$keyname]) == 0
            ) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 取得隨機GUID字串不包含Dash
     * @return type GUID字串﹙不包含Dash﹚
     */
    public static function NewGUIDWithoutDash() {
        return CommonTools::CreateGUID(false);
    }

    /**
     * 取得隨機GUID字串, 依「$havedash」決定是否包含Dash
     * @param type $havedash 是否包含Dash
     * @return type GUID字串
     */
    private static function CreateGUID($havedash) {

        if ($havedash) {
            $formatstring = '%04x%04x-%04x-%04x-%04x-%04x%04x%04x';
        } else {
            $formatstring = '%04x%04x%04x%04x%04x%04x%04x%04x';
        }

        return sprintf($formatstring,
                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,
                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

}
