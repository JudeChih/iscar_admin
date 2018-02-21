<?php

namespace App\Http\Controllers\ViewControllers;

use Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Excel;
use DB;

class BatchImportController extends Controller {

    /**
     * 批量匯入的頁面
     */
    public function batchImport(){
        try {
            return View::make('batch/batchimport');
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }

    // function getRows($file)
    // {
    //     $handle = fopen($file, 'rb');
    //     if (!$handle) {
    //         throw new Exception();
    //     }
    //     while (!feof($handle)) {
    //         yield fgetcsv($handle);
    //     }
    //     fclose($handle);
    // }

    /**
     * 導入資料到table
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function importExcel(Request $request){

        if(Request::hasFile('import_file')){
            $path = Request::file('import_file')->getRealPath();
            $data = Excel::selectSheetsByIndex(0)->load($path, function($reader) {})->get();
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $qqq) {
                    if(!empty($qqq)){
                        $int_key = (int)$key;
                        if($qqq['sd_type'] == null && $qqq['sd_shopname'] == null && $qqq['sd_shoptel'] == null && $qqq['sd_zipcode'] == null && $qqq['sd_shopaddress'] == null && $qqq['sd_weeklystart'] == null && $qqq['sd_weeklyend'] == null && $qqq['sd_dailystart'] == null && $qqq['sd_dailyend'] == null && $qqq['sd_shopphotopath'] == null && $qqq['sd_introtext'] == null && $qqq['sd_contact_person'] == null && $qqq['sd_contact_tel'] == null && $qqq['sd_contact_mobile'] == null && $qqq['sd_contact_address'] == null && $qqq['sd_contact_email'] == null){
                            break;
                        }
                        // {"sd_type":2,"sd_shopname":"DG\u7fd4\u5a01-\u5ba2\u559c\u9054\u6c7d\u8eca\u767e\u8ca8(\u6843\u5712\u5e97)","sd_shoptel":"03-3588805","sd_zipcode":330,"sd_shopaddress":"\u6843\u5712\u5e02\u5927\u8208\u897f\u8def1\u6bb5237\u865f","sd_weeklystart":"\u4e00","sd_weeklyend":"\u65e5","sd_dailystart":{"date":"2018-01-08 10:30:00.000000","timezone_type":3,"timezone":"Asia\/Taipei"},"sd_dailyend":{"date":"2018-01-08 21:00:00.000000","timezone_type":3,"timezone":"Asia\/Taipei"},"sd_shopphotopath":null,"sd_introtext":null,"sd_contact_person":null,"sd_contact_tel":null,"sd_contact_mobile":null,"sd_contact_address":null,"sd_contact_email":null}
                        // 這邊就是你資料庫裡面所有的欄位設定
                        if($qqq['sd_type'] == null || $qqq['sd_shopname'] == null){
                            return back()->with('error','導入失敗，請檢查必填欄位是否填寫');
                        }
                        if($qqq['sd_shopaddress'] != ''){
                            \App\Library\CommonTools::Query_GeoCodeByGoogle($qqq['sd_shopaddress'],$sd_lng,$sd_lat);
                        }else{
                            $sd_lng = null;
                            $sd_lat = null;
                        }
                        if(isset($qqq['sd_dailystart'])){
                            $dailystart = \Carbon\Carbon::parse($qqq['sd_dailystart']);
                        }
                        if(isset($qqq['sd_dailyend'])){
                            $dailyend = \Carbon\Carbon::parse($qqq['sd_dailyend']);
                        }
                        $insert[] = array(
                                'sd_type' => $qqq['sd_type'],
                                'sd_shopname' => $qqq['sd_shopname'],
                                'sd_shoptel' => $qqq['sd_shoptel'],
                                'sd_zipcode' => $qqq['sd_zipcode'],
                                'sd_shopaddress' => $qqq['sd_shopaddress'],
                                'sd_lat' => $sd_lat,
                                'sd_lng' => $sd_lng,
                                'sd_weeklystart' => $qqq['sd_weeklystart'],
                                'sd_weeklyend' => $qqq['sd_weeklyend'],
                                'sd_dailystart' => $dailystart->toTimeString(),
                                'sd_dailyend' => $dailyend->toTimeString(),
                                'sd_shopphotopath' => $qqq['sd_shopphotopath'],
                                'sd_introtext' => $qqq['sd_introtext'],
                                'sd_contact_person' => $qqq['sd_contact_person'],
                                'sd_contact_tel' => $qqq['sd_contact_tel'],
                                'sd_contact_mobile' => $qqq['sd_contact_mobile'],
                                'sd_contact_address' => $qqq['sd_contact_address'],
                                'sd_contact_email' => $qqq['sd_contact_email'],
                                'sd_havebind' => 0
                            );
                    }
                }
                if(!empty($insert)){
                    // 新增特店資料(pm模組的)
                    // \App\Library\CommonTools::writeErrorLogByMessage(json_encode($insert));
                    $ms_s = new \App\Services\PMService;
                    $request = $ms_s->callApiCreateShopData($insert);
                    // \App\Library\CommonTools::writeErrorLogByMessage($request['message_no']);
                    if($request['message_no'] != '000000000'){
                        return back()->with('error','導入失敗，請檢查必填欄位以及欄位不可包含空白');
                    }
                    return back()->with('success','成功導入！');
                }
            }
        }
        return back()->with('error','導入失敗，請檢查你導入的檔案');
    }

    /**
     * 導出並下載檔案
     * @param  Request $request [description]
     * @param  [type]  $type    [檔案格式]
     * @return [type]           [description]
     */
    public function exportExcel(Request $request, $type){
        try {

            $data2['sd_type'] = '商家類別(必填)';
            $data2['sd_shopname'] = '商家名稱(必填)';
            $data2['sd_shoptel'] = '商家電話';
            $data2['sd_zipcode'] = '郵遞區號';
            $data2['sd_shopaddress'] = '商家地址';
            $data2['sd_weeklystart'] = '商家每週營業起始時間';
            $data2['sd_weeklyend'] = '商家每週營業結束時間';
            $data2['sd_dailystart'] = '商家營業起始時間';
            $data2['sd_dailyend'] = '商家營業結束時間';
            $data2['sd_shopphotopath'] = '商家圖片路徑';
            $data2['sd_introtext'] = '商家簡介內容';
            $data2['sd_contact_person'] = '商家聯絡人';
            $data2['sd_contact_tel'] = '聯絡市話';
            $data2['sd_contact_mobile'] = '聯絡手機';
            $data2['sd_contact_address'] = '聯絡地址';
            $data2['sd_contact_email'] = '聯絡Email';

            $data3['sd_type'] = '不可有空白,1:2手車商、2:汽車鍍膜、3:保養維修、4:輪胎避震、5:周邊配備、99:宮廟';
            $data3['sd_shopname'] = '限50個字,不可有空白,ex:XX車業';
            $data3['sd_shoptel'] = '限20個字,不可有空白,不可使用(),可輸入手機號碼';
            $data3['sd_zipcode'] = '限3個字,不可有空白，ex:100';
            $data3['sd_shopaddress'] = '限100個字,不可有空白';
            $data3['sd_weeklystart'] = '限1個字,不可有空白,ex:星期一就填一';
            $data3['sd_weeklyend'] = '限1個字,不可有空白,ex:星期二就填二';
            $data3['sd_dailystart'] = 'ex:09:30';
            $data3['sd_dailyend'] = 'ex:17:50';
            $data3['sd_shopphotopath'] = '';
            $data3['sd_introtext'] = '限150個字,記錄由管理人填入之該商家簡介內容';
            $data3['sd_contact_person'] = '限20個字,不可有空白,ex:王小明';
            $data3['sd_contact_tel'] = '限20個字,不可有空白,ex:02-29661717';
            $data3['sd_contact_mobile'] = '限20個字,不可有空白,ex:0912-547-855';
            $data3['sd_contact_address'] = '限100個字,不可有空白,ex:新北市板橋區文化路二段446號';
            $data3['sd_contact_email'] = '限100個字,不可有空白,ex:a12025000@yahoo.com';

            $data['sd_type'] = 'sd_type';
            $data['sd_shopname'] = 'sd_shopname';
            $data['sd_shoptel'] = 'sd_shoptel';
            $data['sd_zipcode'] = 'sd_zipcode';
            $data['sd_shopaddress'] = 'sd_shopaddress';
            $data['sd_weeklystart'] = 'sd_weeklystart';
            $data['sd_weeklyend'] = 'sd_weeklyend';
            $data['sd_dailystart'] = 'sd_dailystart';
            $data['sd_dailyend'] = 'sd_dailyend';
            $data['sd_shopphotopath'] = 'sd_shopphotopath';
            $data['sd_introtext'] = 'sd_introtext';
            $data['sd_contact_person'] = 'sd_contact_person';
            $data['sd_contact_tel'] = 'sd_contact_tel';
            $data['sd_contact_mobile'] = 'sd_contact_mobile';
            $data['sd_contact_address'] = 'sd_contact_address';
            $data['sd_contact_email'] = 'sd_contact_email';



            
            $result[0] = $data2;
            $result[1] = $data3;
            $result[2] = $data;


            // if($request['message_no'] != 000000000){
            //     return redirect('/batch/batch-import')->withInput()->withErrors(['啟用失敗！']);
            // }

            return Excel::create('template', function($excel) use ($result) {
                $excel->sheet('特店範本', function($sheet) use ($result)
                {
                    $sheet->fromArray($result);
                });
            })->download($type);
        } catch (Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }

    }

}
