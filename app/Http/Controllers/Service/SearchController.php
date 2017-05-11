<?php

namespace App\Http\Controllers\Service;

use App\Library\AjaxResponse;
use App\Models\Application;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class SearchController extends Controller {

    public function search(Request $request)
    {
        $rules = [
            "applicationID" => 'required|integer|exists:Application,ApplicationID',
            "contentID"     => 'integer|exists:Content,ContentID',
            "query"         => 'required',
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails())
        {
            return ajaxResponse::error($v->errors()->first());
        }
        $url = 'http://37.9.205.205/search';
        $applicationID = $request->get('applicationID');
        $application = Application::find($applicationID);
        $contentID = $request->get('contentID', 0);
        $query = $request->get('query');
        if ($contentID)
        {
            $id = 'customer_' . $application->CustomerID . '/application_' . $application->ApplicationID . '/content_' . $contentID;
        } else
        {
            $id = 'customer_' . $application->CustomerID . '/application_' . $application->ApplicationID;
        }
        $parameters = [
            'id'    => $id,
            'query' => $query,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

    }

    public function searchGraff(Request $request)
    {
        $rules = [
            "applicationIds" => 'required',
            "query"          => 'required',
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails())
        {
            return ajaxResponse::error($v->errors()->first());
        }
        $url = 'http://37.9.205.205/search';
        $applicationIds = json_decode($request->get('applicationIds'));
        $applications = Application::whereIn('ApplicationID', $applicationIds)->get();
        $paths = [];
        foreach ($applications as $application)
        {
            $paths[] = 'customer_' . $application->CustomerID . '/application_' . $application->ApplicationID;
        }
        $query = $request->get('query');

        $parameters = [
            'id'    => implode(',', $paths),
            'query' => $query,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $rawResponse = curl_exec($ch);
        curl_close($ch);

        if (empty($rawResponse))
        {
            return ['status' => 0, 'error' => '', 'result' => []];
        }
        $response = json_decode($rawResponse);
        if (!isset($response->result) || empty($response->result))
        {
            return ['status' => 0, 'error' => '', 'result' => []];
        }

        $contentIds = [];

        foreach ($response->result as $key => $result)
        {
            $contentIds[] = $result->contentId;
        }
        $availableContents = Content::getAccessibleTopicContents($contentIds);

        foreach ($response->result as $key => &$result)
        {
            if(!$availableContents->contains('ContentID', $result->contentId)) {
                unset($response->result[$key]);
            } else {
                $response->result[$key]->applicationId = (int)$availableContents->where('ContentID', $result->contentId)->first()->ApplicationID;
            }
        }

        $response->result = array_values($response->result);

        return \Response::json($response);
    }

}
