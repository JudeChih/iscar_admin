<?php

namespace App\Repositories;

use App\Models\ICR_SystemParameter;
use DB;
use App\Library\CommonTools;

class ICR_SystemParameterRepository {

   public  function InsertData($arraydata){
      try {
             if (!CommonTools::CheckArrayValue($arraydata, "sp_fitmodule") || !CommonTools::CheckArrayValue($arraydata, "sp_modulename")
              || !CommonTools::CheckArrayValue($arraydata, "sp_fitfunction")  || !CommonTools::CheckArrayValue($arraydata, "sp_functionname")
              || !CommonTools::CheckArrayValue($arraydata, "sp_parameterkey")  || !CommonTools::CheckArrayValue($arraydata, "sp_paramatervalue")
              || !CommonTools::CheckArrayValue($arraydata, "sp_paramatertype")  || !CommonTools::CheckArrayValue($arraydata, "sp_paramaterdescribe")) {
                return false;
              }
              $savadata['sp_fitmodule'] = $arraydata['sp_fitmodule'];
              $savadata['sp_modulename'] = $arraydata['sp_modulename'];
              $savadata['sp_fitfunction'] = $arraydata['sp_fitfunction'];
              $savadata['sp_functionname'] = $arraydata['sp_functionname'];
              $savadata['sp_parameterkey'] = $arraydata['sp_parameterkey'];
              $savadata['sp_paramatervalue'] = $arraydata['sp_paramatervalue'];
              $savadata['sp_paramatertype'] = $arraydata['sp_paramatertype'];
              $savadata['sp_paramaterdescribe'] = $arraydata['sp_paramaterdescribe'];
            
              if (CommonTools::CheckArrayValue($arraydata, "isflag")) {
                $savadata['isflag'] = $arraydata['isflag'];
              } else {
                $savadata['isflag'] = '1';
              }
              $savadata['create_user'] = 'webapi';
              $savadata['last_update_user'] = 'webapi';
              DB::table('icr_systemparameter')->insert($savadata);
              return true;
       } catch(Exception $e) {
            CommonTools::writeErrorLogByException($e);
            return false;
       }
    }


  
    /**
     * 修改資料
     * @param array $arraydata 要更新的資料
     * @return boolean
     */
    public  function UpdateData(array $arraydata) {
        try {
            if (!CommonTools::CheckArrayValue($arraydata, 'sp_serno')) {
                return false;
            }

            $savedata['sp_serno'] = $arraydata['sp_serno'];

            if (CommonTools::CheckArrayValue($arraydata, 'sp_fitmodule')) {
                $savedata['sp_fitmodule'] = $arraydata['sp_fitmodule'];
            }
            if (CommonTools::CheckArrayValue($arraydata, 'sp_modulename')) {
                $savedata['sp_modulename'] = $arraydata['sp_modulename'];
            }
            if (CommonTools::CheckArrayValue($arraydata, 'sp_fitfunction')) {
                $savedata['sp_fitfunction'] = $arraydata['sp_fitfunction'];
            }
            if (CommonTools::CheckArrayValue($arraydata, 'sp_functionname')) {
                $savedata['sp_functionname'] = $arraydata['sp_functionname'];
            }
            if (CommonTools::CheckArrayValue($arraydata, 'sp_parameterkey')) {
                $savedata['sp_parameterkey'] = $arraydata['sp_parameterkey'];
            }
            if (CommonTools::CheckArrayValue($arraydata, 'sp_paramatervalue')) {
                $savedata['sp_paramatervalue'] = $arraydata['sp_paramatervalue'];
            }
            if (CommonTools::CheckArrayValue($arraydata, 'sp_paramatertype')) {
                $savedata['sp_paramatertype'] = $arraydata['sp_paramatertype'];
            }
            if (CommonTools::CheckArrayValue($arraydata, 'sp_paramaterdescribe')) {
                $savedata['sp_paramaterdescribe'] = $arraydata['sp_paramaterdescribe'];
            }
           
            if (CommonTools::CheckArrayValue($arraydata, "isflag")) {
                $savedata['isflag'] = $arraydata['isflag'];
            }

            $savedata['last_update_user'] = 'webapi';


            DB::table('icr_systemparameter')
                    ->where('sapd_serno', $savedata['sapd_serno'])
                    ->update($savedata);
            return true;
        } catch (Exception $ex) {
            CommonTools::writeErrorLogByException($ex);
            return false;
        }
    }
    

   public  function getEcpayEinvoice() {
    try {
            $result = ICR_SystemParameter::whereRaw("icr_systemparameter.sp_parameterkey like '%ecpay_einvoice%' ")
                                           ->where('icr_systemparameter.isflag','=','1')
                                           ->get()->toArray();
             return $result;
        } catch(\Exception $e) {
           ErrorLog::InsertData($e);
           return false;
        }
   }

  


}
