<?php

namespace App\Http\Controllers\Service;

use App\Library\WebService;
use App\Models\Application;
use App\Models\Content;
use App\Models\Topic;
use eRequestType;
use eServiceError;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicController extends Controller {

    public function topic(Request $request)
    {

        $height = (int)$request->get('height', '0');
        $width = (int)$request->get('width', '0');
        $applications = Application::has('Topic')->get();
        $response = [];
        $response["applications"] = [];
        foreach ($applications as $application)
        {
            $responseChunk = [];
            $responseChunk["Topics"] = [];
            foreach ($application->Topic as $topic)
            {
                $content = Content::where('ApplicationID', $application->ApplicationID)
                    ->whereHas('Topic', function (Builder $query) use ($topic)
                    {
                        $query->where('Topic.TopicID', $topic->TopicID);
                    })->orderBy('ProcessDate', 'desc')->first();

                $responseTopicChunk = [];
                $responseTopicChunk["TopicID"] = $topic->TopicID;
                $parameters = [
                    'W'             => $width,
                    'H'             => $height,
                    'RequestTypeID' => eRequestType::SMALL_IMAGE_FILE,
                    'ContentID'     => $content->ContentID];
                $responseTopicChunk["CoverImageUrl"] = route('contents_file', $parameters);
                $responseTopicChunk["Order"] = strtotime($content->ProcessDate);
                $responseChunk["Topics"][] = $responseTopicChunk;
            }
            if (!empty($responseChunk["Topics"]))
            {
                $responseChunk["ApplicationID"] = $application->ApplicationID;
                $responseChunk["ApplicationName"] = $application->Name;
                $responseChunk["Version"] = $application->Version;
                $responseChunk["IosLink"] = $application->IOSLink;
                $responseChunk["AndroidLink"] = $application->AndroidLink;
                $responseChunk["Version"] = $application->Version;
                $response["applications"][] = $responseChunk;
            }
        }

        $topics = Topic::orderBy('Order')->get();
        $response["topics"] =  $topics->mapWithKeys(function (Topic $topic) {
            return $topic->getServiceData();
        });

//            array('id' => $this->TopicID, 'name' => $this->Name);
        $response["status"] = 0;
        $response["error"] = "";

        return $response;


    }

    public function applicationTopic(Request $request, $sv)
    {

        $applicationID = $request->get("applicationID", 0);
        WebService::checkServiceVersion($sv);
        $application = WebService::getCheckApplication($applicationID);

        $topicID = $request->get("topicID", 1);
        $applicationTopicIds = $application->Topic->pluck('TopicID')->toArray();

        if (empty($applicationTopicIds))
        {
            throw eServiceError::getException(eServiceError::ContentNotFound);
        }

        if ($topicID > 0)
        {
            $builder = Content::whereHas('Topic', function (Builder $query) use ($topicID)
            {
                $query->where('Topic.TopicID', $topicID);
            });
        } else
        {
            $builder = Content::has('Topic');

        }

        $contents = $builder->where("ApplicationID", $applicationID)
            ->orderBy('ProcessDate', "DESC")->get();

        if (empty($contents))
        {
            throw eServiceError::getException(eServiceError::ContentNotFound);
        }

        $serviceData = [];
        /** @var Content[] $contents */
        foreach ($contents as $content)
        {
            if ($content->serveContent())
            {
                //currently ignoring buyable contents...
                $serviceData["contents"][] = $content->getServiceData(false);
            }
        }

        $serviceData["status"] = 0;
        $serviceData["error"] = "";

        return $serviceData;

    }


}
