<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Statistic;
use Auth;
use Config;
use Html;
use Illuminate\Database\Query\Builder;
use View;

class TestController extends Controller
{

    public function test2() {
       return View::make('Test/test2');
    }

    public function index()
    {
        echo Config::get('custom.rowcount');
exit;
        echo Html::link(str_replace('(:num)', 15, __('route.applications_usersettings')), 'APPNAME', 'CLASSS');

//        echo request('deneme');
//        echo request()->get('deneme');
        exit;
        echo route('banners_list', ['applicationID' => 10]);
        exit;
        var_dump(Config::get('app.langs'));
        exit;
        echo Html::link(__('route.contents') . '?applicationID=' , 'nasdfasdf', 'zzzzzzzzz');
        exit;
        foreach (Auth::user()->expiringApps() as $expiringApp) {
            echo $expiringApp->ApplicationID;
        }
        dd(Auth::user()->expiringApps()[0]->ApplicationID);
        return Application::find(178)->Users();
        $keys = ['google_api_key' => 'AIzaSyCj2v2727lBWLeXbgM_Hw_VEQgzjDgb8KY',
            'api_key1' => 'AIzaSyA7xMDIVl2332zCKP70HceFTuq2gdwBwx0',
            'api_key2' => 'AIzaSyCFt9FNEys_tXed-VHu5CaI2_9bezEiaJY',
            'api_key3' => 'AIzaSyDUt1iTUfNJ0V9gQolAkkCwGqxNaijJgdw',
            'api_key4' => 'AIzaSyDPKOO2Z0S_iJLEPcJhRXAukmCoci4_cbc',
            'api_key5' => 'AIzaSyAHKuxx9RlYxbCRLxZwnF8DGISKCOQtW6g',
            'api_key6' => 'AIzaSyAmkOB9C8of9kYJZs9r7oN1mr0KrN1xB4g',
            'api_key7' => 'AIzaSyBdrHaCvdrxc43otOND3GgRk69cB_CvoaI',
            'api_key8' => 'AIzaSyCg98n77pfxmBzCzptyD4op5T7VxO84p5w',
            'api_key9' => 'AIzaSyCfeHTzoY_xhcCogtb1XYYUZ4_bzDlruvs'];

        try {
            $apiRequest = 0;
            $arr = array();

            $statistics = Statistic::query()
                ->where('Lat', '>', 0)
                ->where('Long', '>', 0)
                ->where(function(Builder $query) {
                    $query->whereNull('Country')
                    ->orWhere('Country', '=', 'NULL')
                    ->orWhere('Country', '=', 'NULL');
                })
                ->orderBy('StatisticID', 'DESC')
                ->take(1)
                ->get();

            foreach ($statistics as $statistic) {
                if ((float)$statistic->Lat > 0 && (float)$statistic->Long > 0) {


                    $country = '';
                    $city = '';
                    $district = '';
                    $quarter = '';
                    $avenue = '';

                    //try
                    //{
                    $apiIndex = intval($apiRequest / 1000);
                    if ($apiIndex > 9) {
                        $apiIndex = 1;
                    }

                    $apiKey = Config::get('custom.google_api_key');
                    $apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
                    $url = sprintf('%s?latlng=%s,%s&sensor=false&key=%s',
                        $apiUrl,
                        $statistic->Lat,
                        $statistic->Long,
                        $apiKey
                    );

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $apiRequest += 1;
                    curl_close($ch);
                    $json = json_decode($response, true);
                    if ($json["status"] == "OK") {
                        $results = $json["results"];
                        foreach ($results as $result) {
                            $addresses = $result["address_components"];
                            foreach ($addresses as $address) {
                                $types = $address["types"];

                                if (in_array("country", $types) && empty($country)) {
                                    $country = $address["long_name"];
                                } else if (in_array("locality", $types) && empty($city)) {
                                    $city = $address["long_name"];
                                } else if (in_array("sublocality", $types) && empty($district)) {
                                    $district = $address["long_name"];
                                } else if (in_array("neighborhood", $types) && empty($quarter)) {
                                    $quarter = $address["long_name"];
                                } else if (in_array("route", $types) && empty($avenue)) {
                                    $avenue = $address["long_name"];
                                }
                            }
                        }
                    }

                    $statistic->Country = $country;
                    $statistic->City = $city;
                    $statistic->District = $district;
                    $statistic->Quarter = $quarter;
                    $statistic->Avenue = $avenue;
                    $statistic->save();
                } else {
                    Log::warning("Can not locate specified latitude & longitude. Id=" . $statistic->StatisticID);
                }
            }
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                    'task' => '`UpdateLocation`',
                    'detail' => $e->getMessage()
                )
            );

            Common::sendErrorMail($msg);
        }
    }
}
