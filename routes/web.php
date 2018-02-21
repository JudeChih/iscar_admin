<?php
// Auth::routes();

// Route::get('/home', 'HomeController@index');
//Route::get('/', 'HomeController@landing');

/*Test Route for Gentelella Laravel 5 integration*/
// Route::get('/gentelellla', 'HomeController@gentelellla');

////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/login', function () {
  	return \Illuminate\Support\Facades\View::make('login/login');
});
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);
//////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/', function () {
    return redirect('/login');
});

/////////////////////////////////////////////Sunwai///////////////////////////////////////////////
Route::group(['middleware' => 'userdata'],function(){
//////////////////////////////////////////////////////////////////////////////////////////////////
	// index頁為統計頁
	Route::get('/index','ViewControllers\IndexTotalDataController@indexTotalData');
	// 業務管理
	Route::get('/sales/sales-management','ViewControllers\SalesDataController@salesManagement');
	Route::post('/salesdata/changeStatus','ViewControllers\SalesDataController@changeStatus');
	Route::get('/sales/sales-binding','ViewControllers\SalesBindingController@salesBinding');
	Route::post('/sales/sales-binding','ViewControllers\SalesBindingController@bindSalesAction');
	// 特店管理
	Route::get('/shop/shoptype','ViewControllers\ShopDataController@shopType');
	Route::get('/shop/shopdata-list','ViewControllers\ShopDataController@shopDataList');
	Route::post('/shop/shopdatadetail','ViewControllers\ShopDataController@shopDataDetail');
	Route::post('/shop/shopdata/modify','ViewControllers\ShopDataController@modifyShopData');
	Route::get('/shop/shopcoupondata-list','ViewControllers\ShopCouponDataController@shopCouponDataList');
	Route::post('/shop/shopcoupondetail','ViewControllers\ShopCouponDataController@shopCouponDetail');
	Route::post('/shop/shopcoupondata/modify','ViewControllers\ShopCouponDataController@modifyShopCoupon');
	// 批量匯入特店
	Route::get('/batch/batch-import','ViewControllers\BatchImportController@batchimport');
	Route::post('/batch/import-excel','ViewControllers\BatchImportController@importExcel');
	Route::get('/batch/export-excel/{type}', 'ViewControllers\BatchImportController@exportExcel');
	// 系統服務管理
	Route::get('/service/activity','ViewControllers\ServiceActivityController@serviceActivity');
	Route::get('/service/activity/modify','ViewControllers\ServiceActivityController@serviceModify');
	Route::post('/service/activity/modify','ViewControllers\ServiceActivityController@serviceModify');
	Route::get('/service/activity/create','ViewControllers\ServiceActivityController@serviceCreate');
	Route::post('/service/activity/save','ViewControllers\ServiceActivityController@serviceSave');
	Route::post('/service/activity/delete','ViewControllers\ServiceActivityController@serviceDelete');
	Route::get('/service/announcement','ViewControllers\ServiceAnnouncementController@serviceAnnouncement');
	Route::get('/service/announcement/modify','ViewControllers\ServiceAnnouncementController@serviceModify');
	Route::post('/service/announcement/modify','ViewControllers\ServiceAnnouncementController@serviceModify');
	Route::get('/service/announcement/create','ViewControllers\ServiceAnnouncementController@serviceCreate');
	Route::post('/service/announcement/save','ViewControllers\ServiceAnnouncementController@serviceSave');
	Route::post('/service/announcement/delete','ViewControllers\ServiceAnnouncementController@serviceDelete');
	// 帳務結算管理
	Route::get('/settle/settlementlist','ViewControllers\SettlementController@settlementList');
	Route::get('/settle/settlementshoplist','ViewControllers\SettlementController@settlementShopList');
	Route::post('/settle/settlementshoplist','ViewControllers\SettlementController@settlementShopList');
	Route::post('/settle/settlementcontent','ViewControllers\SettlementController@settlementContent');
	Route::get('/settle/settlementordercontent','ViewControllers\SettlementController@settlementOrderContent');
	Route::post('/settle/settlementordercontent','ViewControllers\SettlementController@settlementOrderContent');
	Route::post('/settle/review','ViewControllers\SettlementController@settlementReview');
	Route::post('/settle/outpayment','ViewControllers\SettlementController@settlementOutPayment');
	Route::post('/settle/inpayment','ViewControllers\SettlementController@settlementInPayment');
	// 後台使用者管理
	Route::get('/login/user-modify','ViewControllers\UserController@userData');
	Route::post('/login/user-modify','ViewControllers\UserController@save');
	Route::get('/login/user-list','ViewControllers\UserController@userList');
	Route::get('/login/user-list-modify','ViewControllers\UserController@userListModify');
	Route::post('/login/user-list-modify','ViewControllers\UserController@save');
	Route::get('/login/user-list-delete','ViewControllers\UserController@userListDelete');
	Route::get('/login/user-list-create','ViewControllers\UserController@userListCreate');
	Route::post('/login/user-list-create','ViewControllers\UserController@save');
	// 測試工具
	Route::get('/testtools/testpushnotification','ViewControllers\TestToolsController@testPushNotification');
	Route::post('/testtools/testpushnotification','ViewControllers\TestToolsController@startPush');

});
// 業務驗證頁面
Route::get('/sales/sales-verify/{hash}','ViewControllers\SalesVerifyController@saleVerify');
Route::post('/sales/sales-verify','ViewControllers\SalesVerifyController@saleVerifyAction');
/* 圖片上傳 */
Route::post('/service/announcement/upload','ViewControllers\ServiceAnnouncementController@uploadImage');
Route::post('/service/activity/upload','ViewControllers\ServiceActivityController@uploadImage');
