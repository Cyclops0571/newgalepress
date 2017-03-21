<?php


namespace App\Library;


class Report {

    const customerTrafficReport = 101; //admin
    const applicationTrafficReport = 201; //admin
    const trafficReport = 301;
    const deviceReport = 302;
    const downloadReport = 1001;
    const customerLocationReport = 1101;
    const applicationLocationReport = 1201; //admin
    const locationReport = 1301; //admin
    const viewReport = 1302;


    public static function getCustomerTrafficReport() {
        return  array(
            'fieldType' => array("String", "String", "Number", "Number", "Number", "Number", "Number", "Size", "Number", "Size"),
            'fieldName' => array("CustomerNo", "CustomerName", "ApplicationCount", "ApplicationBlockedCount", "ContentCount", "ContentApprovalCount", "ContentBlockedCount", "AmountOfFileSize", "DownloadCount", "AmountOfTraffic"),
            'fieldCaption' => trans("common.reports_columns_report101")
        );
    }

    public static function getApplicationTrafficReport() {
        return array(
            'fieldType' => array("String", "String", "String", "Date", "String", "Bit", "Number", "Number", "Number", "Size", "Number", "Size"),
            'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ExpirationDate", "ApplicationStatusName", "ApplicationBlocked", "ContentCount", "ContentApprovalCount", "ContentBlockedCount", "AmountOfFileSize", "DownloadCount", "AmountOfTraffic"),
            'fieldCaption' => trans("common.reports_columns_report201")
        );
    }

    public static function getTrafficReport() {
        return array(
            'fieldType' => array("String", "String", "Size", "Size"),
            'fieldName' => array("ApplicationName", "ContentName", "AmountOfFileSize", "AmountOfTraffic"),
            'fieldCaption' => trans("common.reports_columns_report301")
        );
    }

    public static function getDeviceReport() {
        return array(
            'fieldType' => array("String", "Number"),
            'fieldName' => array("Device", "DownloadCount"),
            'fieldCaption' => trans("common.reports_columns_report302")
        );
    }

    public static function getDownloadReport() {
        return array(
            'fieldType' => array("String", "String", "Number"),
            'fieldName' => array("ApplicationName", "ContentName", "DownloadCount"),
            'fieldCaption' => trans("common.reports_columns_report1001")
        );
    }

    public static function getCostomerLocationReport() {
        return array(
            'fieldType' => array("String", "String", "String", "String", "String", "Number"),
            'fieldName' => array("CustomerNo", "CustomerName", "Country", "City", "District", "DownloadCount"),
            'fieldCaption' => trans("common.reports_columns_report1101")
        );
    }

    public static function getApplicationLocationReport() {
        return array(
            'fieldType' => array("String", "String", "String", "String", "String", "String", "Number"),
            'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "Country", "City", "District", "DownloadCount"),
            'fieldCaption' => trans("common.reports_columns_report1201")
        );
    }

    public static function getLocationReport() {
        return array(
            'fieldType' => array("String", "String", "String", "String", "String", "Percent"),
            'fieldName' => array("ApplicationName", "ContentName", "Country", "City", "District", "Percent"),
            'fieldCaption' => trans("common.reports_columns_report1301")
        );
    }

    public static function getViewReport() {
        return array(
            'fieldType' => array("String", "String", "String", "String", "String", "String", "String", "Number", "Number", "Number"),
            'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "Country", "City", "District", "Page", "People", "Duration"),
            'fieldCaption' => trans("common.reports_columns_report1302")
        );
    }

}