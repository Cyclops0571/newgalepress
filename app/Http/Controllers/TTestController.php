<?php

namespace App\Http\Controllers;

use App\Library\MyResponse;
use App\Mail\CustomerWelcome;
use App\Models\Application;
use App\Models\Category;
use App\Models\Content;
use App\Models\ContentCategory;
use App\Models\Customer;
use App\Models\GoogleMap;
use App\User;
use DB;
use eStatus;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Mail\MailableMailer;
use Illuminate\Mail\Message;
use Maatwebsite\Excel\Collections\RowCollection;
use Maatwebsite\Excel\Readers\LaravelExcelReader;
use Mail;
use Route;

class TTestController extends Controller {

    public function index(Request $request)
    {


        $c = Content::find(6101);
        dd($c->Category->pluck('CategoryID'));
        dd($c->Category->sortBy('Name')->toArray());
        dd($c->WebserviceCategories(103));
        dd($c->Category);

    }

    private function kickCallback($callback, &$param) {
        return call_user_func($callback, $param);
    }

    public function test2(Request $request, Route $route, MyResponse $myResponse)
    {
        $a = 0;
        $b = 10;
        $result = $this->kickCallback(function(MyResponse $param){
            $param->success("asdfasdf");

        }, $myResponse);

        $file = public_path('files/sampleFiles/SampleMapExcel_tr.xls');
//        $Name = $data->val($row, $colNo++);
//        $Latitude = $data->val($row, $colNo++);
//        $Longitude = $data->val($row, $colNo++);
//        $googleMap->Address = $data->val($row, $colNo++);
//        $googleMap->Description = $data->val($row, $colNo++);
        $excelColumnNames = ['name', 'latitude', 'longitude', 'address', 'description'];
        \Excel::load($file, function(LaravelExcelReader $reader) use ($excelColumnNames) {
            $excelRows = $reader->setSelectedSheetIndices([0])->all();
            if($excelRows->count() == 0) {
                //error not info exists...
            }
            $rowNo = -1;
            foreach ($excelRows as $excelRow) {
                ++$rowNo;
                if($excelRow->count() != 5) {
                    //error column count does not match.
                }

                $tmp = [];
                $i = 0;
                foreach ($excelRow as $cellName => $cellValue) {
                    $columnName = $excelColumnNames[$i++];
                    $tmp[$columnName] =  $cellValue;

                }

                if(!$tmp['name'] || !$tmp['latitude'] || !$tmp['longitude']) {
                    //error invalid value.. at row $rowNo.
                }

                $googleMap = GoogleMap::where('ApplicationID', '=', $applicationID)
                    ->where('Latitude', '=', $tmp['latitude'])
                    ->where("Longitude", "=", $tmp['longitude'])
                    ->first();
                if (!$googleMap) {
                    $googleMap = new GoogleMap();
                    $addedCount++;
                } else {
                    $updatedCount++;
                }

                $googleMap->Name = $tmp['name'];
                $googleMap->ApplicationID = $applicationID;
                $googleMap->Latitude = $tmp['latitude'];
                $googleMap->Longitude = $tmp['longitude'];
                $googleMap->Address = $tmp['address'];
                $googleMap->Description = $tmp['description'];
                $googleMap->StatusID = eStatus::Active;
                $googleMap->save();

                var_dump($tmp);
            }
        });
        exit;
        echo route('application_setting');
        exit;
        DB::enableQueryLog();
        //$rows = Content::forPage(3, 10);
        $row2 = Content::forPage(2, 10)->get();
        dump(DB::getQueryLog());
        dump($row2);
        echo $row2;
//        echo Content::paginate(10);
        exit;
        dd(http_build_query(['serdar' => 'saygili', 'enes' => 'taskiran', 'deniz' => 'karacali']));
        dd(\URL::to("/maps/webview/10"));
//        dd(Content::where('ContentID', 4569));
        $content = Content::find(4569);
        dd($content->ContentFile());
        $contentFiles = $content->ContentFile()->where('ContentFileID', 5932)->get();
        dd($contentFiles);
        echo public_path(); exit;
        var_dump(User::where('Email', 'srdsaygili@gmail.com')->exists());
        echo Customer::max('CustomerID');
        //Mail::to('srdsaygili@gmail.com')->send(new CustomerWelcome($request));

        $request->route()->name('serdarserdar');
        echo $request->route()->getName();

        var_dump(trans('error.auth_interactivity'));
        var_dump(__('error.auth_interactivity'));
        echo \URL::to('/');
        //return abort(404);
        $a = Application::find(187);
        dd($a->Contents->keyBy('ContentID')->find(1912));

        echo $request->getUri(), PHP_EOL;
        echo "------------", PHP_EOL;
        echo $request->getBaseUrl(), PHP_EOL;
        echo $request->getRequestUri(), PHP_EOL;
        echo $request->getPathInfo() . "\n";
        echo Route::currentRouteName() . "\n";

        dd(Route::current());
        echo $request->route()->currentRouteName() . "\n";

        return [];
        $a = $request->get('a', 0);
        if ($a < 10)
        {
            return redirect($request->getUri() . "?a=" . ++$a);

        }

        return [$a];
    }
}
