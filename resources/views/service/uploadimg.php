<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>isCar就是行</title>

    <!-- <link rel="stylesheet" href="../app/libs/font-awesome-4.7.0/css/font-awesome.min.css">

    <script type="text/javascript" src="../app/js/string.js"></script> -->


    <style>
        html {
            height: 100%;
        }

        body {
            height: 100%;
            width: 100%;
            margin: 0 auto;
            font-family: Microsoft JhengHei !important;
            position: relative;
            overflow-x: hidden;
        }

        @media (min-width: 992px) {
            body {
                height: 100%;
                width: 50%;
                margin: 0 auto;
                background: #252525;
                box-shadow: 2px 2px 2px rgba(2%, 2%, 2%, 0.9), 4px 4px 6px rgba(2%, 2%, 2%, 0.7), 6px 6px 12px rgba(2%, 2%, 2%, 0.7);
                /*background-image: url(../app/image/iscar_bg.png);
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;*/
            }
        }

        .content {
            height: 100%;
            background: #151515;
            /*background-image: url(../app/image/carbon_bg.jpg);
            background-size: cover;*/
            text-align: center;
        }

        .loading-text {
            font-size: 2.5em;
            color: beige;
            font-weight: bold;
            text-align: center;
            padding-top: 45%;
        }

        .modal {
            background: snow;
            height: 17%;
        }

        .modal-head {
            padding: 3%;
            text-align: center;
            background: darkorange;
            color: #fff;
            font-size: 1.1em;
        }

        .modal-body {
            padding: 5%;
            text-align: center;
        }

    </style>


</head>


<body>

    <div class="content">

        <!-- <i class="fa fa-spinner fa-pulse" style="color:#777; font-size: 9em; margin-top: 38%;"></i> -->
        <div class="loading-text">處理中</div>

    </div>


</body>

</html>


<?php
define('FTP_UPLOAD_HOST', config('global.FTP_UPLOAD_HOST'));
// 設置基本FTP連線 ftp_connect(host,port,timeout);
$conn_id = ftp_connect(FTP_UPLOAD_HOST, 21);//123.51.218.177 tw-media.iscarmg.com 13.114.203.132

//登入 FTP, 帳號是 USERNAME, 密碼是 PASSWORD
$login_result = ftp_login($conn_id, 'iscar_app', 'haiH~e7a');//iscarmg  mF4&,b~UX\'!8B&rQc5b=

//上傳路徑
$upload_src = 'service/'.$_GET['pa_id'].'/'.$_GET['folder'];
// if(isset($_GET['type'])){
//     if($_GET['type'] === 'report'){
//         $upload_src = 'shopdata/'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$_GET['scm_id'].'/pick_pack'.'/'.$_GET['scl_id'];
//     }
// }



//切換成被動模式(true) turn passive mode on
ftp_pasv($conn_id, true);


//切換目錄
if(!@ftp_chdir($conn_id, $upload_src)){

    //新建資料夾
    //if (ftp_mkdir($conn_id, $upload_src)) {
        //資料夾建立成功
        //ftp_chdir($conn_id, $upload_src);
    //} else {
        //資料夾建立失敗
    //}
    $parts = explode('/',$upload_src);
    foreach($parts as $part){
      if(!@ftp_chdir($conn_id, $part)){
        ftp_mkdir($conn_id, $part);
        ftp_chdir($conn_id, $part);
      }
   }

}



//時區設定
date_default_timezone_set('Asia/Taipei');

//取得系統時間
$datetime = date ("YmdHis");

//上傳的檔案名稱
$file = $datetime.'.jpg';
// if(isset($_GET['type'])){
//     if($_GET['type'] === 'report'){
//         $file = $_GET['scl_id'].'.jpg';
//     }
// }


//讀取已選擇檔案
$fp = fopen($_FILES['pa_mainpic']['tmp_name'], 'r');
// $fp = fopen($_POST['pa_mainpic'], 'r');

// FTP 上傳檔案(同步上傳)
// ftp_fput() 上傳文件
if (ftp_fput($conn_id, $file, $fp, FTP_BINARY)) {//FTP_ASCII  FTP_BINARY
    //echo "成功上傳 $file\n";

    switch($_GET['folder']){
        case 'serviceannouncement':
            echo '<script>var shop_data = JSON.parse(localStorage.getItem("shop_data")) || {};
            shop_data.sd_shopphotopath = "'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$file.'";</script>';
            echo '<script>localStorage.setItem("shop_data", JSON.stringify(shop_data));</script>';
            echo '<script>localStorage.setItem("imagePath", "'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$file.'");</script>';
            break;
        case 'serviceactivity':
            
            break;
        // case 'shopcoupon':
        //     echo '<script>var branchData = JSON.parse(localStorage.getItem("branchData")) || {};</script>';
        //     if($_GET['type'] === 'main'){
        //         echo '<script>branchData.shopcoupon_imgs.main = "'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$file.'";</script>';
        //         echo '<script>localStorage.setItem("branchData", JSON.stringify(branchData));</script>';
        //     echo '<script>localStorage.setItem("imagePath", "ShopCoupon");</script>';
        //     }else if($_GET['type'] === 'sub'){
        //         if ($_GET['position'] != 'add') {
        //             echo '<script>branchData.shopcoupon_imgs.imgs.splice("'.$_GET['position'].'", 1, "'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$file.'");</script>';
        //         } else {
        //             echo '<script>branchData.shopcoupon_imgs.imgs.push("'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$file.'");</script>';
        //         }
        //         echo '<script>localStorage.setItem("branchData", JSON.stringify(branchData));</script>';
        //     echo '<script>localStorage.setItem("imagePath", "ShopCoupon");</script>';
        //     }else if($_GET['type'] === 'details'){

        //         echo '<script>var commodity_data = JSON.parse(localStorage.getItem("commodity_data")) || {};</script>';
        //     if ($_GET['position'] != 'add') {
        //             echo '<script>var nowIndex;
        //                     findArrayItem = function(array, property, value) {
        //                     array.forEach(function(result, index) {
        //                     if (result[property] === value) {
        //                          nowIndex = index;
        //                         }
        //                      });
        //                     };</script>';

        //             echo '<script>
        //             commodity_data.scm_advancedescribe["'.$_GET['position'].'"].content_img = "'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$file.'";
        //             localStorage.setItem("commodity_data", JSON.stringify(commodity_data));</script>';
        //     } else {
        //             echo '<script>commodity_data.scm_advancedescribe.push({content_text:"",content_img:"'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$file.'"});
        //             localStorage.setItem("commodity_data", JSON.stringify(commodity_data));
        //             </script>';

        //     }

        //     echo '<script>localStorage.setItem("branchData", JSON.stringify(branchData));</script>';
        //     echo '<script>localStorage.setItem("imagePath", "ShopCoupon");</script>';

        //     } else if($_GET['type'] === 'report'){

        //         echo '<script>localStorage.setItem("report_img", "'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$_GET['scm_id'].'/pick_pack'.'/'.$_GET['scl_id'].'/'.$file.'");</script>';

        //     }
        //     break;
        // case 'shoppush':
        //     echo '<script>localStorage.setItem("imagePath", "'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$file.'");</script>';
        //     break;
        // case 'shopcontent':
        //     echo '<script>var shop_data = JSON.parse(localStorage.getItem("shop_data")) || {};</script>';
        //     if ($_GET['position'] != 'add') {
        //             echo '<script>var nowIndex;
        //                     findArrayItem = function(array, property, value) {
        //                     array.forEach(function(result, index) {
        //                     if (result[property] === value) {
        //                          nowIndex = index;
        //                         }
        //                      });
        //                     };</script>';

        //             echo '<script>
        //             shop_data.sd_advancedata["'.$_GET['position'].'"].content_img = "'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$file.'";
        //             localStorage.setItem("shop_data", JSON.stringify(shop_data));</script>';
        //     } else {
        //             echo '<script>shop_data.sd_advancedata.push({content_text:"",content_img:"'.$_GET['sd_id'].'/'.$_GET['folder'].'/'.$file.'"});
        //             localStorage.setItem("shop_data", JSON.stringify(shop_data));
        //             </script>';

        //     }
        //     break;
    }
    echo '<script>window.location = "/Shop?upload_back=true";</script>';
    echo '<br>';
} else {
    echo '<script>window.location = "/Shop?upload_back=true";</script>';
    //echo "上傳檔案 $file 失敗\n";
	//echo '<br>';

}

fclose($fp); // 關閉檔案

ftp_close($conn_id); //關閉連線



/*$old_file = '/iscarapp/shopdata/temporary/'.$_GET['sd_id'].'/maincover/'.$file;
$new_file = '/iscarapp/shopdata/'.$_GET['sd_id'].'/maincover/'.$file;


//將圖片移至正式資料夾
// try to rename $old_file to $new_file
if (ftp_rename($conn_id, $old_file, $new_file)) {
 echo "successfully renamed $old_file to $new_file\n";
    echo '<br>';
} else {
 echo "There was a problem while renaming $old_file to $new_file\n";
    echo '<br>';
}*/

//ftp_close($conn_id); //關閉連線




/*echo '檔案名稱: ' . $_FILES['file']["name"]."<br/>";
echo '檔案類型: ' . $_FILES['file']["type"]."<br/>";
echo '檔案大小: ' . ($_FILES['file']['size'] / 1024)." Kb<br />";
echo '暫存名稱: ' . $_FILES['file']['tmp_name'];*/



?>
