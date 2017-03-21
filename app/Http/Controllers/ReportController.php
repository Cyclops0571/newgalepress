<?php

namespace App\Http\Controllers;

use App;
use App\Library\Report;
use App\Library\ReportFilter;
use App\Models\Content;
use Auth;
use Common;
use eUserTypes;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;
use PHPExcel_Worksheet;
use View;

class ReportController extends Controller {

    public function __construct()
    {
        $this->page = 'reports';
        $this->route = __('route.' . $this->page);
        $this->caption = __('common.reports_caption');
    }

    public function index(Request $request)
    {
        $report = (int)$request->get('r', '101');
        $reportName = trans("common.menu_report_" . $report . "_detail");

        $data = [
            'caption'    => $this->caption,
            'route'      => $this->route,
            'report'     => $report,
            'reportName' => $reportName,
        ];

        return View::make('pages.reports', $data);
    }

    public function show(Request $request, $id)
    {

        $reportFilter = new ReportFilter();
        $reportFilter->reportID = $id;
        $reportFilter->startDate = $request->get('sd', '') . ' 00:00:00';
        $reportFilter->endDate = $request->get('ed', '') . ' 00:00:00';
        $reportFilter->applicationID = (int)$request->get('applicationID', '0');
        $reportFilter->contentID = (int)$request->get('contentID', '0');
        $reportFilter->customerID = (int)$request->get('customerID', '0');
        $reportFilter->country = $request->get('country', '');
        $reportFilter->city = $request->get('city', '');
        $reportFilter->district = $request->get('district', '');
        $reportFilter->showAsXlsForm = (int)$request->get('xls', '0');
        $reportFilter->map = (int)$request->get('map', '0');
        $reportFilter->rowCount = config('custom.rowcount');
        $reportFilter->userTypeID = Auth::user()->UserTypeID == eUserTypes::Manager ? eUserTypes::Manager : eUserTypes::Customer;


        $rows = $reportFilter->getRows();
        if ($reportFilter->map == 1)
        {
            $arr = [];
            foreach ($rows as $row)
            {
                array_push($arr, ['lat' => $row->Lat, 'lng' => $row->Long, 'description' => $row->Country]);
            }
            $data = [
                'json' => json_encode($arr),
            ];

            return View::make('pages.reportmap', $data);
        }

        if ($reportFilter->showAsXlsForm == 1)
        {

            $excel = App::make('excel');
            $rows = $rows->toArray();
            $changedFromStdObjArray = array_map(function ($row)
            {
                return (array)$row;
            }, $rows);

            return $excel->create('Export ' . date("Y-m-d"), function (LaravelExcelWriter $excel) use ($changedFromStdObjArray)
            {
                $excel->sheet('Sheet 1', function (PHPExcel_Worksheet $sheet) use ($changedFromStdObjArray)
                {
                    $sheet->fromArray($changedFromStdObjArray);
                });
            })->export('xls');
        }

        $arrReport = $reportFilter->getRowCaptions();
        $data = [
            'report'          => $reportFilter->reportID,
            'sd'              => $reportFilter->startDate,
            'ed'              => $reportFilter->endDate,
            'arrFieldCaption' => $arrReport['fieldCaption'],
            'arrFieldType'    => $arrReport['fieldType'],
            'arrFieldName'    => $arrReport['fieldName'],
            'rows'            => $rows,
        ];

        return View::make('pages.reportdetail', $data);
    }

    public function country(Request $request)
    {
        $type = 'country';
        $customerID = (int)$request->get('customerID', '0');
        $applicationID = (int)$request->get('applicationID', '0');
        $contentID = (int)$request->get('contentID', '0');
        $rs = Common::getLocationData($type, $customerID, $applicationID, $contentID);
        $data = [
            'rows' => $rs,
        ];

        return View::make('pages.location' . $type . 'optionlist', $data);
    }

    public function city(Request $request)
    {
        $type = 'city';
        $customerID = (int)$request->get('customerID', '0');
        $applicationID = (int)$request->get('applicationID', '0');
        $contentID = (int)$request->get('contentID', '0');
        $country = $request->get('country', '');
        $rs = Common::getLocationData($type, $customerID, $applicationID, $contentID, $country);
        $data = [
            'rows' => $rs,
        ];

        return View::make('pages.location' . $type . 'optionlist', $data);
    }

    public function district(Request $request)
    {
        $type = 'district';
        $customerID = (int)$request->get('customerID', '0');
        $applicationID = (int)$request->get('applicationID', '0');
        $contentID = (int)$request->get('contentID', '0');
        $country = $request->get('country', '');
        $city = $request->get('city', '');
        $rs = Common::getLocationData($type, $customerID, $applicationID, $contentID, $country, $city);
        $data = [
            'rows' => $rs,
        ];

        return View::make('pages.location' . $type . 'optionlist', $data);
    }

}
