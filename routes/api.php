<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'api'],function(){
	Route::post('/bindingcompany','APIControllers\BindingCompanyController@BindingCompany');
	Route::post('/getcompanyparameter','APIControllers\GetCompanyParameterController@GetCompanyParameter');
	Route::post('/querycompanyname','APIControllers\QueryCompanyNameController@QueryCompanyName');
	Route::post('/updatecompanydata','APIControllers\UpdateCompanyDataController@UpdateCompanyData');
        
                    Route::post('/createinvoice', 'APIControllers\InvoiceController@createInvoice');
                    Route::post('/invalidinvoice', 'APIControllers\InvoiceController@invalidInvoice');
                    
});


