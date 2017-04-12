<?php

namespace App\Http\Controllers;

use App\Library\TemplateColor;
use App\Models\Application;
use App\Models\Banner;
use DB;
use Illuminate\Http\Request;

class ApplicationTemplateController extends Controller
{

    public function show(Application $application)
    {
        if (!$application->CheckOwnership()) {
            return [];
        }
        /* START SQL FOR TEMPLATE-CHOOSER */
        $sqlTemplateChooser = 'SELECT * FROM ('
            . 'SELECT a.Name AS ApplicationName, c.ContentID, c.Name, c.Detail, c.MonthlyName, '
            . 'cf.ContentFileID,cf.FilePath, cf.InteractiveFilePath, '
            . 'ccf.ContentCoverImageFileID, ccf.FileName '
            . 'FROM `Application` AS a '
            . 'LEFT JOIN `Content` AS c ON c.ApplicationID=a.ApplicationID AND c.StatusID=1 '
            . 'LEFT JOIN `ContentFile` AS cf ON c.ContentID=cf.ContentID '
            . 'LEFT JOIN `ContentCoverImageFile` AS ccf ON ccf.ContentFileID=cf.ContentFileID '
            . 'WHERE a.ApplicationID= ' . $application->ApplicationID . ' '
            . 'order by  c.ContentID DESC, cf.ContentFileID DESC, ccf.ContentCoverImageFileID DESC) as innerTable '
            . 'group by innerTable.ContentID '
            . 'order by innerTable.ContentID DESC '
            . 'LIMIT 9';

        $templateResults = DB::table(DB::raw('(' . $sqlTemplateChooser . ') t'))->orderBy('ContentID', 'Desc')->get();
        $data = array();
        $data['application'] = $application;
        $data["templateResults"] = $templateResults;
        $data['bannerSet'] = Banner::getAppBanner($application->ApplicationID, FALSE);
        return view('sections.templatepreview', $data);


    }

    public function theme($fileName)
    {
        return response()->make(TemplateColor::templateCss($fileName), 200, array('content-type' => 'text/css'));
    }
}
