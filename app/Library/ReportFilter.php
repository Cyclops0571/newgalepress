<?php


namespace App\Library;


use Common;
use DB;
use eUserTypes;
use File;

class ReportFilter {

    const SqlFolder = "report.sql/";
    public $reportID = 101;
    public $startDate = '';
    public $endDate = '';
    public $customerID = 0;
    public $applicationID = 0;
    public $contentID = 0;
    public $country = '';
    public $city = '';
    public $district = '';
    public $showAsXlsForm = 0;
    public $map = 0;
    public $rowCount = 0;
    public $userTypeID = eUserTypes::Customer;

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function getRows() {
        $sqlPath = resource_path(self::SqlFolder . $this->reportID . ($this->map ? "map.sql" : ".sql"));
        $sqlTemplate = File::get($sqlPath);
        $replacements = array(
            '{SD}' => Common::dateWrite($this->startDate, false),
            '{ED}' => Common::dateWrite($this->endDate, false),
            '{CONTENTID}' => $this->contentID > 0 ? $this->contentID : 'null',
            '{CUSTOMERID}' => ($this->customerID > 0 ? $this->customerID : 'null'),
            '{APPLICATIONID}' => ($this->applicationID > 0 ? $this->applicationID : 'null'),
            '{COUNTRY}' => ($this->country  ? "'$this->country'" : 'null'),
            '{CITY}' => ($this->city ? "'$this->city'" : 'null'),
            '{DISTRICT}' => ($this->district ?  "'$this->district'" : 'null'),
        );

        foreach($replacements as $key => $value) {
            $sqlTemplate = str_replace($key, $value, $sqlTemplate);
        }

//        DB::enableQueryLog();
//        DB::table(DB::raw('(' . $sqlTemplate . ') t'))->get();
//        $ql = DB::getQueryLog();
//        echo $ql['0']['query'];
//        exit;
        if($this->map) {
            return DB::table(DB::raw('(' . $sqlTemplate . ') t'))->get();
        } else if($this->showAsXlsForm) {
            $captions = $this->getRowCaptions();
            $fieldNames = $captions['fieldName'];
            $fieldCaptions = $captions['fieldCaption'];
            $columnQuery = [];
            foreach ($fieldCaptions as $key => $fieldCaption) {
                $columnQuery[] =  $fieldNames[$key] . " as " . $fieldCaption;
            }
            return DB::table(DB::raw('(' . $sqlTemplate . ') t'))->select($columnQuery)->get();
        }

        return DB::table(DB::raw('(' . $sqlTemplate . ') t'))->paginate($this->rowCount);

    }


    public function getRowCaptions () {
        $arrReport = [];
        switch ($this->reportID) {
            case Report::customerTrafficReport :
                $arrReport = Report::getCustomerTrafficReport();
                break;
            case Report::applicationTrafficReport :
                $arrReport = Report::getApplicationTrafficReport();
                break;
            case Report::trafficReport :
                $arrReport = Report::getTrafficReport();
                if ((int) $this->userTypeID == eUserTypes::Customer && (int) $this->applicationID > 0) {
                    array_shift($arrReport['fieldType']);
                    array_shift($arrReport['fieldName']);
                    array_shift($arrReport['fieldCaption']);
                }
                break;
            case Report::deviceReport :
                $arrReport = Report::getDeviceReport();
                break;
            case Report::downloadReport :
                $arrReport = Report::getDownloadReport();
                if ($this->userTypeID == eUserTypes::Manager) {
                    $arrReport['fieldType'] = array("String", "String", "String", "String", "Number");
                    $arrReport['fieldName'] = array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "DownloadCount");
                    $arrReport['fieldCaption'] = trans("common.reports_columns_report1001_admin");
                }

                //Uygulama secildiyse uygulama adini gosterme!
                if ((int) $this->userTypeID == eUserTypes::Customer && (int) $this->applicationID > 0) {
                    array_shift($arrReport['fieldType']);
                    array_shift($arrReport['fieldName']);
                    array_shift($arrReport['fieldCaption']);
                }
                break;
            case Report::customerLocationReport :
                $arrReport = Report::getCostomerLocationReport();
                break;
            case Report::applicationLocationReport :
                $arrReport = Report::getApplicationLocationReport();
                break;
            case Report::locationReport :
                if ($this->userTypeID == eUserTypes::Manager) {
                    $arrReport = array(
                        'fieldType' => array("String", "String", "String", "String", "String", "String", "String", "Percent"),
                        'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "Country", "City", "District", "Percent"),
                        'fieldCaption' => trans("common.reports_columns_report1301_admin")
                    );
                } else {
                    $arrReport = Report::getLocationReport();
                    //Uygulama secildiyse uygulama adini gosterme!
                    if ((int) $this->applicationID > 0) {
                        array_shift($arrReport['fieldType']);
                        array_shift($arrReport['fieldName']);
                        array_shift($arrReport['fieldCaption']);
                    }
                }

                break;
            case Report::viewReport :
                $arrReport = Report::getViewReport();
                break;
        }

        return $arrReport;
    }
}