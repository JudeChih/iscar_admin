<?php

namespace App\Repositories;

use App\Models\adm_receiptissue_log;
use DB;

class AdmReceiptissueLogRepository {

    /**
     * 取得所有資料
     * @return type
     */
    public function getAllData() {
        return null;
    }

    /**
     * 使用「$primarykey」查詢資料表的主鍵值
     * @param type $primarykey 要查詢的值
     * @return type
     */
    public function getData($primarykey) {
        return null;
    }

   //新增資料
    public function InsertData($arraydata) {
     try {
        /*if (
                !\App\Library\CommonTools::CheckArrayValue($arraydata, 'mapr_moduleaccount') || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_shopid')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_ordernumber') || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_orderpaydate')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_issueresult')  || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_invoicedate') 
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_randomnumber')|| !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_returncode') 
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_issuerequest')  || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_issueresponse')
             || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_ordercreatedate') || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_customeraddr') 
              || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_customerphone') || !\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_customeremail') 
        ) {
            return false;
        }*/
        $savedata['mapr_moduleaccount'] = $arraydata['mapr_moduleaccount'];
        $savedata['ril_shopid'] = $arraydata['ril_shopid'];
        $savedata['ril_ordernumber'] = $arraydata['ril_ordernumber'];
        $savedata['ril_orderpaydate'] = $arraydata['ril_orderpaydate'];
        $savedata['ril_issueresult'] = $arraydata['ril_issueresult'];
        //$savedata['ril_invoicedate'] = $arraydata['ril_invoicedate'];
        $savedata['ril_randomnumber'] = $arraydata['ril_randomnumber'];
        $savedata['ril_returncode'] = $arraydata['ril_returncode'];
        $savedata['ril_issuerequest'] = $arraydata['ril_issuerequest'];
        $savedata['ril_issueresponse'] = $arraydata['ril_issueresponse'];
        $savedata['ril_ordercreatedate'] = $arraydata['ril_ordercreatedate'];
        $savedata['ril_customeraddr'] = $arraydata['ril_customeraddr'];
        $savedata['ril_customerphone'] = $arraydata['ril_customerphone'];
        $savedata['ril_customeremail'] = $arraydata['ril_customeremail'];
        
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_customeridentifier")) {
                $savedata['ril_customeridentifier'] = $arraydata['ril_customeridentifier'];
        } 
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_receiptnumber")) {
                $savedata['ril_receiptnumber'] = $arraydata['ril_receiptnumber'];
        } 
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_invoicedate")) {
                $savedata['ril_invoicedate'] = $arraydata['ril_invoicedate'];
        } 
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voidrequest")) {
                $savedata['ril_voidrequest'] = $arraydata['ril_voidrequest'];
         }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voidresponse")) {
                $savedata['ril_voidresponse'] = $arraydata['ril_voidresponse'];
         }
         if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voiddatetime")) {
                $savedata['ril_voiddatetime'] = $arraydata['ril_voiddatetime'];
         }
         if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voidreason")) {
                $savedata['ril_voidreason'] = $arraydata['ril_voidreason'];
         }
         if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voidrtncode")) {
                $savedata['ril_voidrtncode'] = $arraydata['ril_voidrtncode'];
         }
         if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voidrtnmsg")) {
                $savedata['ril_voidrtnmsg'] = $arraydata['ril_voidrtnmsg'];
         }
         if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_receiptstatus")) {
                $savedata['ril_receiptstatus'] = $arraydata['ril_receiptstatus'];
         } else {
                $savedata['ril_receiptstatus'] = '1';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "isflag")) {
                $savedata['isflag'] = $arraydata['isflag'];
            } else {
                $savedata['isflag'] = '1';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "create_user")) {
                $savedata['create_user'] = $arraydata['create_user'];
            } else {
                $savedata['create_user'] = 'admim_api';
        }
        if (\App\Library\CommonTools::CheckArrayValue($arraydata, "last_update_user")) {
                $savedata['last_update_user'] = $arraydata['last_update_user'];
            } else {
                $savedata['last_update_user'] = 'admim_api';
        }
        $savedata['create_date'] = date('Y-m-d H:i:s');
        $savedata['last_update_date'] = date('Y-m-d H:i:s');

        //新增資料並回傳「自動遞增KEY值」
         if (DB::table('adm_receiptissue_log')->insert($savedata)) {
            return true;
        } else {
            return false;
        }
     } catch (\Exception $e) {
              \App\Library\CommonTools::writeErrorLogByException($e);
               return false;
     }
    }

      /**
     * 修改資料
     * @param array $arraydata 要更新的資料
     * @return boolean
     */
    public function UpdateData($arraydata) {
        try {

            if (!\App\Library\CommonTools::CheckArrayValue($arraydata, 'ril_serno')) {
                return false;
            }

            $savedata['ril_serno'] = $arraydata['ril_serno'];

            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "mapr_moduleaccount")) {
                $savedata['mapr_moduleaccount'] = $arraydata['mapr_moduleaccount'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_shopid")) {
                 $savedata['ril_shopid'] = $arraydata['ril_shopid'];
            }
             if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_ordernumber")) {
                $savedata['ril_ordernumber'] = $arraydata['ril_ordernumber'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_orderpaydate")) {
                $savedata['ril_orderpaydate'] = $arraydata['ril_orderpaydate'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_issueresult")) {
                 $savedata['ril_issueresult'] = $arraydata['ril_issueresult'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_invoicedate")) {
                $savedata['ril_invoicedate'] = $arraydata['ril_invoicedate'];
            }
             if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_randomnumber")) {
                 $savedata['ril_randomnumber'] = $arraydata['ril_randomnumber'];
            }
             if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_returncode")) {
                $savedata['ril_returncode'] = $arraydata['ril_returncode'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_issuerequest")) {
                $savedata['ril_issuerequest'] = $arraydata['ril_issuerequest'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_issueresponse")) {
                 $savedata['ril_issueresponse'] = $arraydata['ril_issueresponse'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_ordercreatedate")) {
                $savedata['ril_ordercreatedate'] = $arraydata['ril_ordercreatedate'];
            }     
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_customeridentifier")) {
                $savedata['ril_customeridentifier'] = $arraydata['ril_customeridentifier'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_customeraddr")) {
                $savedata['ril_customeraddr'] = $arraydata['ril_customeraddr'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_customerphone")) {
                 $savedata['ril_customerphone'] = $arraydata['ril_customerphone'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_customeremail")) {
                $savedata['ril_customeremail'] = $arraydata['ril_customeremail'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voidrequest")) {
                $savedata['ril_voidrequest'] = $arraydata['ril_voidrequest'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voidresponse")) {
                $savedata['ril_voidresponse'] = $arraydata['ril_voidresponse'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voiddatetime")) {
                $savedata['ril_voiddatetime'] = $arraydata['ril_voiddatetime'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voidreason")) {
                $savedata['ril_voidreason'] = $arraydata['ril_voidreason'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voidrtncode")) {
                $savedata['ril_voidrtncode'] = $arraydata['ril_voidrtncode'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_voidrtnmsg")) {
                $savedata['ril_voidrtnmsg'] = $arraydata['ril_voidrtnmsg'];
            }
            if (\App\Library\CommonTools::CheckArrayValue($arraydata, "ril_receiptstatus")) {
                $savedata['ril_receiptstatus'] = $arraydata['ril_receiptstatus'];
            }
            
            $savedata['last_update_date'] = date('Y-m-d H:i:s');

            DB::table('adm_receiptissue_log')
                    ->where('ril_serno', $savedata['ril_serno'])
                    ->update($savedata);
            return true;
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }
    
    
    public function getDataByshopid_ordernumber($shopid, $ordernumber) {
        $query = adm_receiptissue_log::where('adm_receiptissue_log.ril_shopid','=',$shopid)
                ->where('adm_receiptissue_log.ril_ordernumber','=',$ordernumber)
                ->get()->toArray();       
             return $query;
    }

}
