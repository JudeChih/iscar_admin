<?php

namespace App\Http\Controllers\ViewControllers;

use Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use DB;

class SalesdataController extends Controller {

    /**
     * 導到[業務管理]頁面
     */
    public function salesManagement() {
        $mssd_r = new \App\Repositories\AdmSlsSalesdataRepository;
        try {
            // 獲取業務資料，一個頁面顯示10個
            $salesdata = $mssd_r->getTenData();
            // 無業務就不傳值
            if(count($salesdata) == 0){
                return View::make('sales/salesmanagement');
            }

            return View::make('sales/salesmanagement',compact('salesdata'));
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 更改業務狀態
     * @param string $sls_serno  [業務流水號]
     * @param string $sls_status [會員狀態]
     */
    public function changeStatus(){
        $mssd_r = new \App\Repositories\AdmSlsSalesdataRepository;
        $md_r = new \App\Repositories\MemberDataRepository;
        $ms_s = new \App\Services\MemberService;
        $asms_r = new \App\Repositories\AdmSlsModifySalesRepository;
        $salesdata = Request::all();
        try {
            DB::beginTransaction();
            // 透過回傳的sls_serno抓取該業務資料
            $data = $mssd_r->getDataBySlsSerno($salesdata['sls_serno']);
            if(count($data) >1 || count($data) ==0){
                return redirect('/sales/sales-management')->withInput()->withErrors(['查無此會員！']);
            }
            if(count($data) == 1){
                $data = $data[0];
            }
            // 啟用該業務
            if($salesdata['sls_status'] == 1){

                // 更改client_type為100(admin模組的)
                $arraymember['md_id'] = $data['md_id'];
                $arraymember['md_clienttype'] = 100;
                $result = $md_r->updateMemberData($arraymember);
                if(!$result){
                    return redirect('/sales/sales-management')->withInput()->withErrors(['啟用失敗！']);
                }
                // 更改client_type為100(member模組的)
                $request = $ms_s->callApiModifyMember($data['md_id'],100);
                if($request['message_no'] != 000000000){
                    DB::rollback();
                    return redirect('/sales/sales-management')->withInput()->withErrors(['啟用失敗！']);
                }
                // 更改sls_status
                if(!$this->updateSlsStatus($salesdata['sls_serno'],$salesdata['sls_status'])){
                    DB::rollback();
                    return redirect('/sales/sales-management')->withInput()->withErrors(['啟用失敗！']);
                }
                // 新增一筆異動紀錄
                if(!$asms_r->modifySales($salesdata['sls_serno'])){
                    DB::rollback();
                    return redirect('/sales/sales-management')->withInput()->withErrors(['啟用失敗！']);
                }
                DB::commit();
                return redirect('/sales/sales-management')->withInput()->withErrors(['啟用成功！']);
            }
            // 停用該業務
            if($salesdata['sls_status'] == 2){
                // 更改client_type為1(admin模組的)
                $arraymember['md_id'] = $data['md_id'];
                $arraymember['md_clienttype'] = 1;
                $result = $md_r->updateMemberData($arraymember);
                if(!$result){
                    DB::rollback();
                    return redirect('/sales/sales-management')->withInput()->withErrors(['停用失敗！']);
                }
                // 更改client_type為1(member模組的)
                $request = $ms_s->callApiModifyMember($data['md_id'],1);
                if($request['message_no'] != 000000000){
                    DB::rollback();
                    return redirect('/sales/sales-management')->withInput()->withErrors(['停用失敗！']);
                }
                // 更改sls_status
                if(!$this->updateSlsStatus($salesdata['sls_serno'],$salesdata['sls_status'])){
                    DB::rollback();
                    return redirect('/sales/sales-management')->withInput()->withErrors(['停用失敗！']);
                }
                // 新增一筆異動紀錄
                if(!$asms_r->modifySales($salesdata['sls_serno'])){
                    DB::rollback();
                    return redirect('/sales/sales-management')->withInput()->withErrors(['停用失敗！']);
                }
                DB::commit();
                return redirect('/sales/sales-management')->withInput()->withErrors(['停用成功！']);
            }
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 修改會員狀態
     * @param string $sls_serno  [業務流水號]
     * @param string $sls_status [會員狀態]
     */
    public function updateSlsStatus($sls_serno,$sls_status){
        $mssd_r = new \App\Repositories\AdmSlsSalesdataRepository;
        try {
            $arraydata['sls_serno'] = $sls_serno;
            $arraydata['sls_status'] = $sls_status;
            return $mssd_r->updateSlsStatus($arraydata);
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

}
