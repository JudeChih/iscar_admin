<?php
namespace App\Services;

define('QueryMember', config('global.query_member'));
define('ModifyMember', config('global.modify_member'));
define('QuerySalt', config('global.query_salt'));
define('VerifyApifrom', config('global.verify_apifrom'));
define('Modacc', config('global.modacc'));
define('Modvrf', config('global.modvrf'));

class MemberService {

    /**
     * call member模組的API [QueryMember]
     * @param  [type] $md_regiestmobile [會員註冊用手機號碼]
     * @param  [type] $md_contactmail   [會員電子信箱]
     * @global route  QueryMember       [member模組的API]
     * @global string Modacc            [模組帳號]
     * @global string Modvrf            [模組驗證碼]
     */
    public function callApiQueryMember($md_regiestmobile,$md_contactmail){
        // 編輯要call API所需要傳入的值
        $arraydata['md_regiestmobile'] = $md_regiestmobile;
        $arraydata['md_contactmail'] = $md_contactmail;
        $arraydata['modacc'] = Modacc;
        $arraydata['modvrf'] = Modvrf;
        $url = QueryMember;
        // call API
        $request = \App\Library\CommonTools::curlModule($arraydata,$url);
        $request = $request['query_memberresult'];
        return $request;
    }

    /**
     * call member模組的API [ModifyMember]
     * @param  [type] $md_id          [會員代號]
     * @param  [type] $md_clienttype  [會員類型]
     * @global route  ModifyMember    [member模組的API]
     * @global string Modacc          [模組帳號]
     * @global string Modvrf          [模組驗證碼]
     */
    public function callApiModifyMember($md_id,$md_clienttype){
        // 編輯要call API所需要傳入的值
        $arraydata['md_id'] = $md_id;
        $arraydata['md_clienttype'] = $md_clienttype;
        $arraydata['modacc'] = Modacc;
        $arraydata['modvrf'] = Modvrf;
        $url = ModifyMember;
        // call API
        $request = \App\Library\CommonTools::curlModule($arraydata,$url);
        $request = $request['modify_memberresult'];
        return $request;
    }
    
     /**
     * 呼叫「MemberAPI」驗證模組身份，驗證跨模無SAT時,呼叫方有效性
     * @param type string $modacc 跨模組帳號
     * @param type string $modvrf 跨模組驗證碼
     * @param type string $messageCode 回傳 訊息代碼
     * @return boolean
     */
    public  function checkModuleAccount($modacc, $modvrf, &$messageCode) {
        try {
           /* if (!$this->query_salt($salt_no, $salt)) {
                 throw new \Exception($messageCode);
           }
           $this_modvrf = urlencode(base64_encode("$salt_no".'_'.hash('sha256', Modacc.Modvrf.$salt)));*/
           $post = [
                       'modacc'       => Modacc,
                       'modvrf'           => Modvrf ,
                       'from_modacc' => $modacc,
                       'from_modvrf'   => $modvrf
                    ];
            $route = VerifyApifrom;
            if (is_null($response = \App\Library\CommonTools::curlModule($post, $route))) {
                 $messageCode = '999999999';
                 throw new \Exception($messageCode);
            }
            $k = array_keys($response);
            if ($response[$k[0]]['message_no'] != '000000000') {
                $messageCode = $response[$k[0]]['message_no'];
                throw new \Exception($messageCode);
            }
            return true;
        } catch (\Exception $ex) {
            if ( is_null($messageCode) ) {
                \App\Library\CommonTools::writeErrorLogByException($ex);
                $messageCode = '999999999';
            }
            return false;
        }
    }
    
     /**
     * 呼叫「MemberAPI」取得salt的員資料
     * @param type string $salt_no 回傳 鹽值序號
     * @param type string $salt 回傳 鹽值序號
     * @return boolean
     */
    public  function  query_salt(&$salt_no, &$salt) {
        try {
           $post = [ 'modacc' => Modacc ];
           $route = QuerySalt;
           $response =  \App\Library\CommonTools::curlModule($post, $route);
           //\App\Models\ErrorLog::InsertLog(json_encode($response));
           if (is_null($response)) {
                $messageCode = '999999999';
                 throw new \Exception($messageCode);
           }
           $k = array_keys($response);
           if ($response[$k[0]]['message_no'] != '000000000') {
               $messageCode = $response[$k[0]]['message_no'];
               throw new \Exception($messageCode);
           }
           $saltData  = $response[$k[0]]['salt'] ;$stringSalt =  base64_decode(urldecode($saltData));
           $saltArray = explode("_",$stringSalt);
           $salt_no = $saltArray[0];
           $salt = $saltArray[1];
           return true;
        } catch (\Exception $ex) {
            \App\Library\CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }

}
