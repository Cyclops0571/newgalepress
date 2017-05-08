<?php

namespace App\Http\Controllers\Service;

use App\Library\WebService;
use App\Models\Content;
use Config;
use eRequestType;
use eServiceError;
use eStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $urlPattern = Config::get('custom.url') . "/tr/icerikler/talep?W=%s&H=%s&RequestTypeID=%s&ContentID=%s";
        $url = sprintf($urlPattern, $width, $height, $requestTypeID, (int)$content->ContentID);

        return [
            'status'    => 0,
            'error'     => "",
            'ContentID' => (int)$content->ContentID,
            'Url'       => $url,
        ];
    }

    public function file($sv, Content $content)
    {
        WebService::checkServiceVersion($sv);

        return [
            'status'    => 0,
            'error'     => "",
            'ContentID' => (int)$content->ContentID,
            'Url'       => Config::get('custom.url') . "/tr/icerikler/talep?RequestTypeID=1001&ContentID=" . (int)$content->ContentID . "&Password=" . $request->get('password', ''),
        ];
    }


}
