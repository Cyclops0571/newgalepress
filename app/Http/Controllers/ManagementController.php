<?php

namespace App\Http\Controllers;

use App\Library\AjaxResponse;
use App\Models\Customer;
use Illuminate\Http\Request;
use View;

class ManagementController extends Controller
{
    //TODO: 572572 https://sebastiandedeyne.com/posts/2016/using-a-database-for-localization-in-laravel
    public $restful = true;
    public $table = 'Management';

    public function get_list() {
        $customerSizes = Customer::CustomerFileSize();
        //        dd($customerSizes);
        $data = array();
        $data['rows'] = $customerSizes;
        return View::make('managements.management_list', $data);
    }

    public function importlanguages()
    {
        LaravelLang::Import();
        return ajaxResponse::success("Import işlemi başarıyla tamamlandı.");
    }

    public function exportlanguages()
    {
        LaravelLang::Export();
        return ajaxResponse::success("Export işlemi başarıyla tamamlandı.");
    }



}
