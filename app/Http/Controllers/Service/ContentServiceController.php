<?php

namespace App\Http\Controllers\Service;

use App\Library\WebService;
use App\Models\Content;
use Common;
use Config;
use eRequestType;
use eServiceError;
use eStatus;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class ContentServiceController extends Controller {

    public $restful = true;

    public function version($sv, Content $content)
    {
        WebService::checkServiceVersion($sv);
        if ($content->Blocked)
        {
            throw eServiceError::getException(eServiceError::ContentBlocked);
        }

        return [
            'status'         => 0,
            'error'          => "",
            'ContentID'      => $content->ContentID,
            'ContentBlocked' => $content->Blocked == 1 ? true : false,
            'ContentStatus'  => $content->Status == eStatus::Active ? true : false,
            'ContentVersion' => $content->Version,
        ];
    }

    public function detail($sv, $contentID)
    {
        WebService::checkServiceVersion($sv);
        /** @var Content $content */
        $content = Content::withoutGlobalScopes()
            ->where('ContentID', '=', $contentID)
            ->where(function (Builder $query)
            {
                $query->where('StatusID', eStatus::Active)
                    ->orWhere('RemoveFromMobile', eStatus::Active);
            })
            ->first();

        return $content->getServiceDataDetailed();
    }

    public function coverImage(Request $request, $sv, Content $content)
    {

        WebService::checkServiceVersion($sv);
        $height = (int)$request->get('height', '0');
        $width = (int)$request->get('width', '0');
        $requestTypeID = $request->get('size', '0') == 1 ? eRequestType::SMALL_IMAGE_FILE : eRequestType::NORMAL_IMAGE_FILE;

        $parameters = [
            'W' => $width,
            'H' => $height,
            'ContentID' => $content->ContentID,
            'RequestTypeID' => $requestTypeID
        ];

        return [
            'status'    => 0,
            'error'     => "",
            'ContentID' => (int)$content->ContentID,
            'Url'       => route('contents_file', $parameters),
        ];
    }

    public function file(Request $request, $sv, Content $content)
    {
        WebService::checkServiceVersion($sv);

            $parameters = [
                'RequestTypeID' => eRequestType::PDF_FILE,
                'ContentID' => $content->ContentID,
                'Password' => $request->get('password', '')
            ];
            $url = route('contents_file', $parameters);

        return [
            'status'    => 0,
            'error'     => "",
            'ContentID' => (int)$content->ContentID,
            'Url'       => $url,
        ];
    }



    public function contentFile(Request $request)
    {
        $RequestTypeID = (int)$request->get('RequestTypeID', 0);
        $ContentID = (int)$request->get('ContentID', 0);
        $Password = $request->get('Password', '');
        $Width = (int)$request->get('W', 0);
        $Height = (int)$request->get('H', 0);


        try
        {
            if ($RequestTypeID == eRequestType::PDF_FILE)
            {
                //get file
                $oCustomerID = 0;
                $oApplicationID = 0;
                $oContentID = 0;
                $oContentFileID = 0;
                $oContentFilePath = '';
                $oContentFileName = '';
                Common::getContentDetail($ContentID, $Password, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, $oContentFilePath, $oContentFileName);
                Common::download($RequestTypeID, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, 0, $oContentFilePath, $oContentFileName);//todo: break this function to small pieces
            } else
            {
                //get image
                Common::downloadImage($ContentID, $RequestTypeID, $Width, $Height);//todo: break this function to small pieces
            }
        } catch (Exception $e)
        {
            return Response::make($this->xmlResponse($e), 200, ['content-type' => 'text/xml']);
        }

        return abort(404);
    }

    /**
     * @param $e
     * @return string
     */
    protected function xmlResponse(Exception $e)
    {
        $r = '';
        $r .= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
        $r .= "<Response>\n";
        $r .= "<Error code=\"" . $e->getCode() . "\">" . Common::xmlEscape($e->getMessage()) . "</Error>\n";
        $r .= "</Response>\n";

        return $r;
    }
}
