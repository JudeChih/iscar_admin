<?php

namespace App\Http\Controllers\ViewControllers;

use Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use DB;

class SalesVerifyController extends Controller {

    /**
     * 業務驗證的頁面
     * @param  [type] $hash [雜湊值]
     */
    public function saleVerify($hash){
        try {
            $hash = $hash;

            return View::make('sales/salesverify',compact('hash'));
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 驗證手機信箱是否跟hash相符
     * @param string $hash        [雜湊值]
     * @param string $mobile      [手機號碼]
     * @param string $contactmail [電子信箱]
     */
    public function saleVerifyAction(){
        $salesdata = Request::all();
        $mssd_r = new \App\Repositories\AdmSlsSalesdataRepository;
        $md_r = new \App\Repositories\MemberDataRepository;
        $ms_s = new \App\Services\MemberService;
        try {
            DB::beginTransaction();
            // 透過$hash $mobile $contactmail查詢是否有無這業務
            $data = $mssd_r->getDataByHashMobileContactmail($salesdata['hash'],$salesdata['mobile'],$salesdata['contactmail']);
            if(count($data) >1 || count($data) == 0){
                return redirect()->back()->withInput()->withErrors(['資料輸入錯誤！']);
            }
            if(count($data) == 1){
                $data = $data[0];
            }
            if($data['sls_status'] == 1){
                return redirect()->back()->withInput()->withErrors(['此業務已做綁定！']);
            }
            // 更新該業務的狀態為啟用
            $arraysales['sls_serno'] = $data['sls_serno'];
            $arraysales['sls_status'] = 1;
            $result = $mssd_r->updateSlsStatus($arraysales);
            // 判斷是否成功
            if(!$result){
                DB::rollback();
                return redirect()->back()->withInput()->withErrors(['資料錯誤！']);
            }
            // 修改該業務在admin模組的會員資料，將md_clienttype改為100
            $arraymember['md_id'] = $data['md_id'];
            $arraymember['md_clienttype'] = 100;
            $result = $md_r->updateMemberData($arraymember);
            if(!$result){
                DB::rollback();
                return redirect()->back()->withInput()->withErrors(['綁定失敗！']);
            }
            // call API 修改該業務在mamber模組的會員資料，將md_clienttype改為100
            $request = $ms_s->callApiModifyMember($data['md_id'],100);
            if($request['message_no'] != 000000000){
                DB::rollback();
                return redirect()->back()->withInput()->withErrors(['綁定失敗！']);
            }

            DB::commit();
            $message = '業務綁定成功並啟用！';
            return View::make('sales/sales_success',compact('message'));
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            DB::rollback();
            return false;
        }
    }

}
