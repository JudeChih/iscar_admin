<?php

namespace App\Http\Controllers\ViewControllers;

use Request;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\View;

class IndexTotalDataController extends Controller {

    /**
     * 導到[統計表]頁面
     */
    public function indexTotalData() {
        return View::make('index');
        try {

        } catch (\Exception $e) {
            \App\Library\CommonTools::writeErrorLogByException($e);
            return false;
        }
    }
}
