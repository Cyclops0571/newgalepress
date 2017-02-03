<?php


namespace App\Helpers;


use Common;
use DB;
use eUserTypes;
use File;

class ReportFilter
{
    const SqlFolder = "Reports/";
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
     *
     * @return string Sql
     */
    public function getRows() {
        $sqlPath = app_path(self::SqlFolder . $this->reportID . ($this->map ? "map.sql" : ".sql"));
        $sqlTemplate = File::get($sqlPath);
        $replecements = array(
            '{SD}' => Common::dateWrite($this->startDate, false),
            '{ED}' => Common::dateWrite($this->endDate, false),
            '{CONTENTID}' => $this->contentID > 0 ? $this->contentID : 'null',
            '{CUSTOMERID}' => ($this->customerID > 0 ? $this->customerID : 'null'),
            '{APPLICATIONID}' => ($this->applicationID > 0 ? $this->applicationID : 'null'),
            '{COUNTRY}' => ($this->country  ? "'$this->country'" : 'null'),
            '{CITY}' => ($this->city ? "'$this->city'" : 'null'),
            '{DISTRICT}' => ($this->district ?  "'$this->district'" : 'null'),
        );

        foreach($replecements as $key => $value) {
            $sqlTemplate = str_replace($key, $value, $sqlTemplate);
        }

//		echo $sqlTemplate; exit;
        if($this->map || $this->showAsXlsForm) {
            return DB::table(DB::raw('(' . $sqlTemplate . ') t'))->get();
        }

//		echo DB::raw('(' . $sqlTemplate . ') t'); exit;

        DB::table(DB::raw('(' . $sqlTemplate . ') t'))->paginate($this->rowCount);
//		dd(DB::last_query()); exit;
        return DB::table(DB::raw('(' . $sqlTemplate . ') t'))->paginate($this->rowCount);

    }



}