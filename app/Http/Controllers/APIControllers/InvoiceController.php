<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;

class InvoiceController extends Controller {

    
         function createInvoice() {
               $CreateInvoice = new \App\Http\Controllers\APIControllers\Invoice\CreateInvoice();
               return $CreateInvoice->createInvoice();
        }
        
        
        function invalidInvoice() {
               $InvalidInvoice = new \App\Http\Controllers\APIControllers\Invoice\InvalidInvoice();
               return $InvalidInvoice->invalidInvoice();
        }

        
}
