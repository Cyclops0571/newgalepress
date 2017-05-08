<?php

namespace App\Http\Controllers\Service;

use App\Library\WebService;
use App\Models\Application;
use App\Models\Content;
use App\Models\Statistic;
use App\Models\StatisticGraff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticController extends Controller {


    public function create(Request $request)
    {
        return $this->updateStatistics($request, new Statistic());
    }

    public function graff(Request $request)
    {
        return $this->updateStatistics($request, new StatisticGraff());
    }

    /**
     * @param Request $request
     * @param Statistic|StatisticGraff $statistic
     * @return mixed
     */
    private function updateStatistics($request, $statistic)
    {

        //$id, $type, $time, $lat, $long, $deviceID, $applicationID, $contentID, $page, $param5, $param6, $param7

        $id = $request->get('id', ''); //random id for not duplicate the record
        $deviceID = $request->get('deviceID', ''); //device's id


        $page = (int)$request->get('page', '0');
        $contentID = (int)$request->get('contentID', '0');
        $applicationID = (int)$request->get('applicationID', '0');
        $customerID = 0;
        $application = Application::find($applicationID);
        if ($application)
        {
            $customerID = (int)$application->CustomerID;
        }

        $statistic->ServiceVersion = WebService::Version;
        $statistic->UID = $id;
        $statistic->Type = (int)$request->get('type', '0');
        $statistic->Time = $request->get('time', '');
        $statistic->RequestDate = date("Y-m-d", strtotime($statistic->Time));
        $statistic->Lat = $request->get('lat', '');
        $statistic->Long = $request->get('lon', '');
        $statistic->DeviceID = $deviceID;
        $statistic->CustomerID = $customerID;
        $statistic->ApplicationID = $applicationID;
        $statistic->ContentID = $contentID;
        $statistic->Page = $page;
        $statistic->Param5 = $request->get('param5', '');
        $statistic->Param6 = $request->get('param6', '');
        $statistic->Param7 = $request->get('param7', '');
        $statistic->save();


        return [
            'status' => 0,
            'error'  => "",
            'id'     => $id,
        ];


    }


}
