<?php

namespace App\Http\Controllers\ViewControllers;

use Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;
use DB;

define('FTP_UPLOAD_HOST', config('global.FTP_UPLOAD_HOST'));
define('APP_FTP_ACC', config('global.app_ftp_acc'));
define('APP_FTP_PWD', config('global.app_ftp_pwd'));

class ServiceActivityController extends Controller {

    /**
     * 導到[活動列表]頁面
     */
    public function serviceActivity() {
        $pa_r = new \App\Repositories\PsPlatformactivityItemRepository;
        $searchdata = Request::all();
        try {
            //跳過幾頁作查詢
            if(!isset($searchdata['skip_page'])){
                $searchdata['skip_page'] = 0;
            }
            //排序根據
            if(!isset($searchdata['sort'])){
                $searchdata['sort'] = "pai_id";
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
            return View::make('/service/serviceactivitylist',compact('servicedata','searchdata'));
        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }


    /**
     * 導到[活動修改]頁面
     */
    public function serviceModify(){
        $pai_r = new \App\Repositories\PsPlatformactivityItemRepository;
        $pa_r = new \App\Repositories\PsPlatformannouncementRepository;
        $searchdata = Request::all();
        $searchdata['modifytype'] = 'modify';
        try {
            $announcementdata = $pa_r->getData();
            if(isset($searchdata['upload_back'])){
                if(isset($_COOKIE['pai_servicedata'])){
                    $servicedata = json_decode($_COOKIE['pai_servicedata'],true);
                    if(isset($_COOKIE['pai_mainpic'])){
                        $servicedata['pai_mainpic'] = $_COOKIE['pai_mainpic'];
                        setcookie('pai_mainpic','',time()-3600,'/');
                    }
                    if(isset($servicedata['pai_advancedescribe'])){
                        $servicedata['pai_advancedescribe'] = json_decode($servicedata['pai_advancedescribe'],true);
                    }
                    if(isset($servicedata['pai_activepics'])){
                        $servicedata['pai_activepics'] = json_decode($servicedata['pai_activepics'],true);
                    }
                    if($searchdata['upload_back']){
                        setcookie('pai_servicedata','',time()-3600,'/');
                        return View::make('/service/serviceactivitymodify',compact('servicedata','searchdata','announcementdata'));
                    }else{
                        $searchdata['error'] = '圖片上傳失敗';
                        setcookie('servicedata','',time()-3600,'/');
                        return View::make('/service/serviceactivitymodify',compact('servicedata','searchdata','announcementdata'));
                    }
                }
                // if($searchdata['upload_back']){
                //     return View::make('/service/serviceactivitymodify',compact('searchdata'));
                // }else{
                //     $searchdata['error'] = '圖片上傳失敗';
                //     return View::make('/service/serviceactivitymodify',compact('servicedata','searchdata'));
                // }
            }else{
                if(!isset($searchdata['pai_id'])){
                    return redirect('/service/activity')->withInput()->withErrors(['請重新選擇一個活動公告']);
                }
                $servicedata = $pai_r->getDataByPaiId($searchdata['pai_id']);
                if(count($servicedata) == 1){
                    $servicedata = $servicedata[0];
                }else{
                    return redirect('/service/announcement')->withInput()->withErrors(['請重新選擇一個活動公告']);
                }
                if(isset($servicedata['pai_advancedescribe'])){
                    $servicedata['pai_advancedescribe'] = json_decode($servicedata['pai_advancedescribe'],true);
                }
                if(isset($servicedata['pai_activepics'])){
                    $servicedata['pai_activepics'] = json_decode($servicedata['pai_activepics'],true);
                }
                return View::make('/service/serviceactivitymodify',compact('servicedata','searchdata','announcementdata'));
            }
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 導到[活動新增]頁面
     */
    public function serviceCreate(){
        $pai_r = new \App\Repositories\PsPlatformactivityItemRepository;
        $pa_r = new \App\Repositories\PsPlatformannouncementRepository;
        $searchdata = Request::all();
        $searchdata['modifytype'] = 'create';
        $result = DB::connection('service_mysql')->select(DB::raw("SELECT UUID_SHORT() as UUID from ps_platformactivity_item;"));
        $pai_id = $result[0]->UUID;
        try {
            // 去得所有正在進行的活動公告
            $announcementdata = $pa_r->getData();
            if(isset($searchdata['upload_back'])){
                if(isset($_COOKIE['pai_servicedata'])){
                    $servicedata = json_decode($_COOKIE['pai_servicedata'],true);
                    if(isset($_COOKIE['pai_mainpic'])){
                        $servicedata['pai_mainpic'] = $_COOKIE['pai_mainpic'];
                        setcookie('pai_mainpic','',time()-3600,'/');
                    }
                    if(isset($servicedata['pai_advancedescribe'])){
                        $servicedata['pai_advancedescribe'] = json_decode($servicedata['pai_advancedescribe'],true);
                    }
                    if(isset($servicedata['pai_activepics'])){
                        $servicedata['pai_activepics'] = json_decode($servicedata['pai_activepics'],true);
                    }
                    if(isset($servicedata['pai_id'])){
                        $pai_id = $servicedata['pai_id'];
                    }
                    if($searchdata['upload_back']){
                        setcookie('pai_servicedata','',time()-3600,'/');
                        return View::make('/service/serviceactivitymodify',compact('pai_id','servicedata','searchdata','announcementdata'));
                    }else{
                        $searchdata['error'] = '圖片上傳失敗';
                        setcookie('servicedata','',time()-3600,'/');
                        return View::make('/service/serviceactivitymodify',compact('pai_id','servicedata','searchdata','announcementdata'));
                    }
                }
                if($searchdata['upload_back']){
                    return View::make('/service/serviceactivitymodify',compact('pai_id','searchdata','announcementdata'));
                }else{
                    $searchdata['error'] = '圖片上傳失敗';
                    return View::make('/service/serviceactivitymodify',compact('pai_id','servicedata','searchdata','announcementdata'));
                }
            }else{
                return View::make('/service/serviceactivitymodify',compact('pai_id','searchdata','announcementdata'));
            }
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    /**
     * 執行[活動刪除]動作
     */
    public function serviceDelete(){
        $pai_r = new \App\Repositories\PsPlatformactivityItemRepository;
        $searchdata = Request::all();
        try {
            if($pai_r->delete($searchdata['pai_id'])){
                return redirect('/service/activity')->withInput()->withErrors(['刪除成功']);
            }else{
                return redirect('/service/activity')->withInput()->withErrors(['刪除失敗']);
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
        $pai_r = new \App\Repositories\PsPlatformactivityItemRepository;
        $as_s = new \App\Services\AuthService;
        try {
            if($searchdata['modifytype'] == 'create'){
                $searchdata['pai_approver'] = $as_s->userName();
                // 要判斷shortcode是否重複
                if($pai_r->InsertData($searchdata)){
                    return redirect('/service/activity')->withInput()->withErrors(['新增成功']);
                }else{
                    return redirect('/service/activity')->withInput()->withErrors(['新增失敗']);
                }
            }elseif($searchdata['modifytype'] == 'modify'){
                $searchdata['pai_approver'] = $as_s->userName();
                // 要判斷shortcode是否重複
                if($pai_r->UpdateData($searchdata)){
                    return redirect('/service/activity')->withInput()->withErrors(['修改成功']);
                }else{
                    return redirect('/service/activity')->withInput()->withErrors(['修改失敗']);
                }
            }
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
            $upload_src = 'service/activity/'.$searchdata['pai_id'].'/'.$searchdata['folder'];
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
            if(isset($_POST['pai_mainpic'])){
                $fp = fopen($_POST['pai_mainpic'], 'r');
                $img_url_string = 'pai_mainpic';
            }elseif(isset($_POST['pai_advancedescribe'])){
                $fp = fopen($_POST['pai_advancedescribe'], 'r');
                $img_url_string = 'pai_advancedescribe';
            }elseif(isset($_POST['pai_activepics'])){
                $fp = fopen($_POST['pai_activepics'], 'r');
                $img_url_string = 'pai_activepics';
            }
            // elseif(){

            // }elseif(){

            // }

            if (ftp_fput($conn_id, $file, $fp, FTP_BINARY)) {//FTP_ASCII  FTP_BINARY
                //檔案上傳成功
                switch($img_url_string){
                    case 'pai_mainpic':
                        setcookie($img_url_string,$upload_src.'/'.$file,time()+3600,'/');
                        break;
                    case 'pai_advancedescribe':
                        $servicedata = json_decode($_COOKIE['pai_servicedata'],true);
                        if(isset($servicedata['pai_advancedescribe'])){
                            $array = json_decode($servicedata['pai_advancedescribe'],true);
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
                            $servicedata['pai_advancedescribe'] = json_encode($array);
                            setcookie('pai_servicedata',json_encode($servicedata),time()+3600,'/');
                        }else{
                            $array = array();
                            $aa['content_img'] = $upload_src.'/'.$file;
                            array_push($array,$aa);
                            $servicedata['pai_advancedescribe'] = json_encode($array);
                            setcookie('pai_servicedata',json_encode($servicedata),time()+3600,'/');
                        }

                        // setcookie($img_url_string,$upload_src.'/'.$file,time()+3600,'/');
                        break;
                    case 'pai_activepics':
                        $servicedata = json_decode($_COOKIE['pai_servicedata'],true);
                        if(isset($servicedata['pai_activepics'])){
                            $array = json_decode($servicedata['pai_activepics'],true);
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
                            $servicedata['pai_activepics'] = json_encode($array);
                            setcookie('pai_servicedata',json_encode($servicedata),time()+3600,'/');
                        }else{
                            $array = array();
                            $aa['content_img'] = $upload_src.'/'.$file;
                            array_push($array,$aa);
                            $servicedata['pai_activepics'] = json_encode($array);
                            setcookie('pai_servicedata',json_encode($servicedata),time()+3600,'/');
                        }
                        break;
                }
                // setcookie($img_url_string,$upload_src.'/'.$file,time()+3600,'/');

                fclose($fp); // 關閉檔案
                ftp_close($conn_id); //關閉連線
                if($searchdata['position'] == 'create'){
                    return redirect('/service/activity/create?upload_back=true');
                }elseif($searchdata['position'] == 'modify'){
                    return redirect('/service/activity/modify?upload_back=true');
                }
            } else {
                //檔案上傳失敗
                fclose($fp); // 關閉檔案
                ftp_close($conn_id); //關閉連線
                if($searchdata['position'] == 'create'){
                    return redirect('/service/activity/create?upload_back=false');
                }elseif($searchdata['position'] == 'modify'){
                    return redirect('/service/activity/modify?upload_back=false');
                }
            }
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }




}
