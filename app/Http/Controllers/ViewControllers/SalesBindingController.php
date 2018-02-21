<?php

namespace App\Http\Controllers\ViewControllers;

use Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use DB;

class SalesBindingController extends Controller {

    /**
     * 導到[業務綁定]頁面
     * @param string $regiestmobile [手機號碼]
     * @param string $contactmail   [電子信箱]
     */
    public function salesBinding() {
        $ms_s = new \App\Services\MemberService;
        $userdata = Request::all();
        try {
            if(isset($userdata['regiestmobile']) || isset($userdata['contactmail'])){
                // 判斷有無值傳入
                if($userdata['regiestmobile'] == null || strlen($userdata['regiestmobile']) == 0 || $userdata['contactmail'] == null || strlen($userdata['contactmail']) == 0){
                    return redirect('/sales/sales-binding')->withInput()->withErrors(['請輸入手機號碼以及電子信箱！']);
                }
                // Call Member模組底下的API ['QueryMember']
                $request = $ms_s->callApiQueryMember($userdata['regiestmobile'],$userdata['contactmail']);

                // 判斷API有沒有成功的回吐值
                if($request['message_no'] != 000000000){
                    return redirect('/sales/sales-binding')->withInput()->withErrors(['查無此會員！']);
                }
                // 檢查md_clienttype是否等於0
                if($request['md_clienttype'] != 0){
                    return redirect('/sales/sales-binding')->withInput()->withErrors(['此會員不符合要求！']);
                }
                // 將加碼過的符號解碼恢復正常
                foreach ($request as $key => $value) {
                    $salesdata[$key] = urldecode($value);
                }
            }

            if(isset($salesdata)){
                // 將API回吐的值傳到前端
                $query_mobile = $salesdata['md_regiestmobile'];
                $query_contactmail = $salesdata['md_contactmail'];
                return View::make('sales/salesbinding',compact('salesdata','query_mobile','query_contactmail'));
            }
            return View::make('sales/salesbinding');
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }



    /**
     * 綁定業務
     * @param string $mobile      [手機號碼]
     * @param string $contactmail [電子信箱]
     */
    public function bindSalesAction(){
        $md_r = new \App\Repositories\MemberDataRepository;
        $mssd_r = new \App\Repositories\AdmSlsSalesdataRepository;
        $asms_r = new \App\Repositories\AdmSlsModifySalesRepository;
        $ms_s = new \App\Services\MemberService;
        $userdata = Request::all();
        try {
            DB::beginTransaction();
            // call API要該會員資料
            $request = $ms_s->callApiQueryMember($userdata['regiestmobile'],$userdata['contactmail']);
            if($request['message_no'] != 000000000){
                return redirect('/sales/sales-binding')->withInput()->withErrors(['查無此會員！']);
            }
            // 將加碼過的符號解碼恢復正常
            foreach ($request as $key => $value) {
                $salesdata[$key] = urldecode($value);
            }

            // 拼出雜湊值
            $date = \Carbon\Carbon::now();
            $year = sprintf("%04d",$date->year);
            $month = sprintf("%02d",$date->month);
            $day = sprintf("%02d",$date->day);
            $hour = sprintf("%02d",$date->hour);
            $minute = sprintf("%02d",$date->minute);
            $second = sprintf("%02d",$date->second);
            $sls_hash = $salesdata['md_id'].$year.$month.$day.$hour.$minute.$second;

            // 創建新的業務
            $arraysales['md_id'] = $salesdata['md_id'];
            $arraysales['sls_status'] = 0; // 預設為待驗證
            $arraysales['sls_hash'] = hash('sha256',$sls_hash);
            $arraysales['sls_hash_expired'] = \Carbon\Carbon::now()->addDay()->toDateTimeString(); ; // 預設為現在時間加一天
            $arraysales['sls_hash_use'] = 0; // 預設為0

            if(!$result = $mssd_r->create($arraysales)){
                DB::rollback();
                return redirect('/sales/sales-binding')->withInput()->withErrors(['創建失敗！']);
            }

            // 同步會員資料
            $arraymember['md_id'] = $salesdata['md_id'];
            $arraymember['md_account'] = $salesdata['md_account'];
            $arraymember['md_logintype'] = $salesdata['md_logintype'];
            $arraymember['md_clienttype'] = $salesdata['md_clienttype'];
            $arraymember['md_cname'] = $salesdata['md_cname'];
            $arraymember['md_ename'] = $salesdata['md_ename'];
            $arraymember['md_tel'] = $salesdata['md_tel'];
            $arraymember['md_mobile'] = $salesdata['md_regiestmobile'];
            $arraymember['md_addr'] = $salesdata['md_addr'];
            $arraymember['md_contactmail'] = $salesdata['md_contactmail'];

            if(!$result = $md_r->create($arraymember)){
                DB::rollback();
                return redirect('/sales/sales-binding')->withInput()->withErrors(['創建失敗！']);
            }
            // 寄出驗證信
            $email_result = \App\Services\EMailService::send_sales_verify($userdata['contactmail'],$arraysales['sls_hash']);

            if(!$email_result){
                DB::rollback();
                return redirect('/sales/sales-binding')->withInput()->withErrors(['驗證信寄出失敗！']);
            }
            // 綁定寫進紀錄裡
            if(!$result = $mssd_r->getDataByMdID($salesdata['md_id'])){
                DB::rollback();
                return redirect('/sales/sales-binding')->withInput()->withErrors(['創建失敗！']);
            }
            if(count($result) ==0 || count($result) >1){
                DB::rollback();
                return redirect('/sales/sales-binding')->withInput()->withErrors(['創建失敗！']);
            }
            if(count($result) ==1){
                $result = $result[0];
            }
            if(!$result = $asms_r->modifySales($result['sls_serno'])){
                DB::rollback();
                return redirect('/sales/sales-binding')->withInput()->withErrors(['創建失敗！']);
            }
            DB::commit();
            return redirect('/sales/sales-binding')->withInput()->withErrors(['業務綁定驗證信，已成功寄出，請到會員信箱查收並驗證。']);
        } catch (Exception $e) {
            DB::rollback();
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

}
