<?php

namespace App\Http\Controllers;

use App\Mail\CustomerWelcome;
use App\Models\Application;
use App\Models\Content;
use App\Models\Customer;
use App\User;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Mail\MailableMailer;
use Illuminate\Mail\Message;
use Mail;
use Route;

class TTestController extends Controller {

    public function index(Request $request)
    {

        return [];
    }

    public function test2(Request $request, Route $route)
    {

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
