<?php

namespace App\Http\Controllers\ViewControllers;

use Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;
use DB;

define('FTP_UPLOAD_HOST', config('global.FTP_UPLOAD_HOST'));
define('APP_FTP_ACC', config('global.app_ftp_acc'));
define('APP_FTP_PWD', config('global.app_ftp_pwd'));

class ServiceAnnouncementController extends Controller {

    /**
     * 導到[公告列表]頁面
     */
    public function serviceAnnouncement() {
        $pa_r = new \App\Repositories\PsPlatformannouncementRepository;
        $searchdata = Request::all();
        try {
            //跳過幾頁作查詢
            if(!isset($searchdata['skip_page'])){
                $searchdata['skip_page'] = 0;
            }
            //排序根據
            if(!isset($searchdata['sort'])){
                $searchdata['sort'] = "pa_id";
            }
            //排序方式
            if(!isset($searchdata['order'])){
                $searchdata['order'] = "DESC";
            }
            // 抓取10筆活動
            $servicedata = $pa_r->getTenData($searchdata);
            // 抓取活動總筆數
            $countdata = $pa_r->getData();
            $total_page = ceil(count($countdata)/10);
            $searchdata['total_page'] = $total_page;
            return View::make('/service/serviceannouncementlist',compact('servicedata','searchdata'));
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 導到[公告修改]頁面
     */
    public function serviceModify(){
        $pa_r = new \App\Repositories\PsPlatformannouncementRepository;
        $searchdata = Request::all();
        $searchdata['modifytype'] = 'modify';
        try {
            if(isset($searchdata['upload_back'])){
                if(isset($_COOKIE['pa_servicedata'])){
                    $servicedata = json_decode($_COOKIE['pa_servicedata'],true);
                    if(isset($_COOKIE['pa_mainpic'])){
                        $servicedata['pa_mainpic'] = $_COOKIE['pa_mainpic'];
                        setcookie('pa_mainpic','',time()-3600,'/');
                    }
                    if(isset($servicedata['pa_advancedescribe'])){
                        $servicedata['pa_advancedescribe'] = json_decode($servicedata['pa_advancedescribe'],true);
                    }
                    if($searchdata['upload_back']){
                        setcookie('pa_servicedata','',time()-3600,'/');
                        return View::make('/service/serviceannouncementmodify',compact('servicedata','searchdata'));
                    }else{
                        $searchdata['error'] = '圖片上傳失敗';
                        setcookie('pa_servicedata','',time()-3600,'/');
                        return View::make('/service/serviceannouncementmodify',compact('servicedata','searchdata'));
                    }
                }
                // if($searchdata['upload_back']){
                //     return View::make('/service/serviceannouncementmodify',compact('searchdata'));
                // }else{
                //     $searchdata['error'] = '圖片上傳失敗';
                //     return View::make('/service/serviceannouncementmodify',compact('servicedata','searchdata'));
                // }
            }else{
                if(!isset($searchdata['pa_id'])){
                    return redirect('/service/announcement')->withInput()->withErrors(['請重新選擇一個活動公告']);
                }
                $servicedata = $pa_r->getDataByPaId($searchdata['pa_id']);
                if(count($servicedata) == 1){
                    $servicedata = $servicedata[0];
                }else{
                    return redirect('/service/announcement')->withInput()->withErrors(['請重新選擇一個活動公告']);
                }
                if(isset($servicedata['pa_advancedescribe'])){
                    $servicedata['pa_advancedescribe'] = json_decode($servicedata['pa_advancedescribe'],true);
                }
                return View::make('/service/serviceannouncementmodify',compact('servicedata','searchdata'));
            }
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 導到[公告新增]頁面
     */
    public function serviceCreate(){
        $pa_r = new \App\Repositories\PsPlatformannouncementRepository;
        $searchdata = Request::all();
        $searchdata['modifytype'] = 'create';
        $result = DB::connection('service_mysql')->select(DB::raw("SELECT UUID_SHORT() as UUID from ps_platformannouncement;"));
        $pa_id = $result[0]->UUID;
        try {
            if(isset($searchdata['upload_back'])){
                if(isset($_COOKIE['pa_servicedata'])){
                    $servicedata = json_decode($_COOKIE['pa_servicedata'],true);
                    if(isset($_COOKIE['pa_mainpic'])){
                        $servicedata['pa_mainpic'] = $_COOKIE['pa_mainpic'];
                        setcookie('pa_mainpic','',time()-3600,'/');
                    }
                    if(isset($servicedata['pa_advancedescribe'])){
                        $servicedata['pa_advancedescribe'] = json_decode($servicedata['pa_advancedescribe'],true);
                    }
                    if(isset($servicedata['pa_id'])){
                        $pa_id = $servicedata['pa_id'];
                    }
                    // $rr = $servicedata['pa_advancedescribe'];
                    // \App\Library\CommonTools::writeErrorLogByMessage($rr[0]['content_img']);
                    if($searchdata['upload_back']){
                        setcookie('pa_servicedata','',time()-3600,'/');
                        return View::make('/service/serviceannouncementmodify',compact('pa_id','servicedata','searchdata'));
                    }else{
                        $searchdata['error'] = '圖片上傳失敗';
                        setcookie('pa_servicedata','',time()-3600,'/');
                        return View::make('/service/serviceannouncementmodify',compact('pa_id','servicedata','searchdata'));
                    }
                }
                if($searchdata['upload_back']){
                    return View::make('/service/serviceannouncementmodify',compact('pa_id','searchdata'));
                }else{
                    $searchdata['error'] = '圖片上傳失敗';
                    return View::make('/service/serviceannouncementmodify',compact('pa_id','servicedata','searchdata'));
                }
            }else{
                return View::make('/service/serviceannouncementmodify',compact('pa_id','searchdata'));
            }
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 執行[公告刪除]動作
     */
    public function serviceDelete(){
        $pa_r = new \App\Repositories\PsPlatformannouncementRepository;
        $searchdata = Request::all();
        try {
            if($pa_r->delete($searchdata['pa_id'])){
                return redirect('/service/announcement')->withInput()->withErrors(['刪除成功']);
            }else{
                return redirect('/service/announcement')->withInput()->withErrors(['刪除失敗']);
            }
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 將新增或修改的資料存進DB
     */
    public function serviceSave(){
        $searchdata = Request::all();
        $pa_r = new \App\Repositories\PsPlatformannouncementRepository;
        $as_s = new \App\Services\AuthService;
        try {
            if($searchdata['modifytype'] == 'create'){
                $searchdata['pa_approver'] = $as_s->userName();
                $data = $pa_r->getDataByPaShortCode($searchdata['pa_shortcode']);
                if(count($data) > 0){
                    return redirect('/service/announcement')->withInput()->withErrors(['公告代號重複']);
                }
                if($pa_r->InsertData($searchdata)){
                    return redirect('/service/announcement')->withInput()->withErrors(['新增成功']);
                }else{
                    return redirect('/service/announcement')->withInput()->withErrors(['新增失敗']);
                }
            }elseif($searchdata['modifytype'] == 'modify'){
                $searchdata['pa_approver'] = $as_s->userName();
                $data = $pa_r->getDataByPaShortCodePaId($searchdata['pa_shortcode'],$searchdata['pa_id']);
                if(count($data) > 0){
                    return redirect('/service/announcement')->withInput()->withErrors(['公告代號重複']);
                }
                if($pa_r->UpdateData($searchdata)){
                    return redirect('/service/announcement')->withInput()->withErrors(['修改成功']);
                }else{
                    return redirect('/service/announcement')->withInput()->withErrors(['修改失敗']);
                }
            }
            // $arraydata['pa_title'] = '酷酷der';
            // $arraydata['pa_fulldescript'] = '測試測試測試測試';
            // $arraydata['pa_mainpic'] = 'sesesese';
            // $arraydata['pa_announcementtype'] = '1';
            // $arraydata['pa_startdate'] = '2018-01-26';
            // $arraydata['pa_enddate'] = '2018-01-30';
            // $arraydata['pa_poststatus'] = '1';
            // $arraydata['pa_nextpage'] = '1';
            // $arraydata['pa_buttonname'] = '酷喔';
            // $arraydata['pa_point_url'] = 'yahoo.com.tw';
            // $arraydata['pa_approver'] = '就是我';
            // $arraydata['pa_shortcode'] = 'RRR';
            // if($pa_r->InsertData($arraydata)){
            //     echo '成功';
            // }else{
            //     echo '失敗';
            // }
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
                return false;
        }
    }

    /**
     * 上傳圖片到FTP
     */
    public function uploadImage(){
        $searchdata = Request::all();
        try {
            $conn_id = ftp_connect(FTP_UPLOAD_HOST, 21);
            $login_result = ftp_login($conn_id, APP_FTP_ACC, APP_FTP_PWD);
            $upload_src = 'service/announcement/'.$searchdata['pa_id'].'/'.$searchdata['folder'];
            ftp_pasv($conn_id, true);
            //切換目錄
            if(!@ftp_chdir($conn_id, 'shopdata/'.$upload_src)){
                $parts = explode('/','shopdata/'.$upload_src);
                //新建資料夾
                foreach($parts as $part){
                  if(!@ftp_chdir($conn_id, $part)){
                    ftp_mkdir($conn_id, $part);
                    ftp_chdir($conn_id, $part);
                  }
               }
            }
            $datetime = date ("YmdHis");
            $file = $datetime.'.jpg';
            //讀取已選擇檔案
            if(isset($_POST['pa_mainpic'])){
                $fp = fopen($_POST['pa_mainpic'], 'r');
                $img_url_string = 'pa_mainpic';
            }elseif(isset($_POST['pa_advancedescribe'])){
                $fp = fopen($_POST['pa_advancedescribe'], 'r');
                $img_url_string = 'pa_advancedescribe';
            }
            // elseif(){

            // }elseif(){

            // }

            if (ftp_fput($conn_id, $file, $fp, FTP_BINARY)) {//FTP_ASCII  FTP_BINARY
                //檔案上傳成功

                switch($img_url_string){
                    case 'pa_mainpic':
                        setcookie($img_url_string,$upload_src.'/'.$file,time()+3600,'/');
                        break;
                    case 'pa_advancedescribe':
                        $servicedata = json_decode($_COOKIE['pa_servicedata'],true);
                        if(isset($servicedata['pa_advancedescribe'])){
                            $array = json_decode($servicedata['pa_advancedescribe'],true);
                            if(is_null($array)){
                                $array = array();
                            }
                            if(isset($searchdata['index'])){
                                $aa['content_img'] = $upload_src.'/'.$file;
                                $array[$searchdata['index']] = $aa;
                            }else{
                                $aa['content_img'] = $upload_src.'/'.$file;
                                array_push($array,$aa);
                            }
                            $servicedata['pa_advancedescribe'] = json_encode($array);
                            setcookie('pa_servicedata',json_encode($servicedata),time()+3600,'/');
                        }else{
                            $array = array();
                            $aa['content_img'] = $upload_src.'/'.$file;
                            array_push($array,$aa);
                            $servicedata['pa_advancedescribe'] = json_encode($array);
                            setcookie('pa_servicedata',json_encode($servicedata),time()+3600,'/');
                        }

                        // setcookie($img_url_string,$upload_src.'/'.$file,time()+3600,'/');
                        break;
                }

                fclose($fp); // 關閉檔案
                ftp_close($conn_id); //關閉連線
                if($searchdata['position'] == 'create'){
                    return redirect('/service/announcement/create?upload_back=true');
                }elseif($searchdata['position'] == 'modify'){
                    return redirect('/service/announcement/modify?upload_back=true');
                }
            } else {
                //檔案上傳失敗
                fclose($fp); // 關閉檔案
                ftp_close($conn_id); //關閉連線
                if($searchdata['position'] == 'create'){
                    return redirect('/service/announcement/create?upload_back=false');
                }elseif($searchdata['position'] == 'modify'){
                    return redirect('/service/announcement/modify?upload_back=false');
                }
            }
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }
}
