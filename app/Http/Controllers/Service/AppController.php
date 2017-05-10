<?php

namespace App\Http\Controllers\Service;

use App\Library\WebService;
use App\Mail\ActivationMailler;
use App\Mail\ClientRegisteredMailler;
use App\Models\Application;
use App\Models\Category;
use App\Models\Client;
use App\Models\ClientReceipt;
use Carbon\Carbon;
use Common;
use Config;
use DB;
use eServiceError;
use eStatus;
use eUserTypes;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Mail;
use Subscription;
use URL;
use Validator;

class AppController extends Controller {

    public function version(Request $request, $sv, Application $application)
    {
        if (!$application->isOnAir())
        {
            throw eServiceError::getException(eServiceError::PassiveApplication);
        }
        $accessToken = $request->get('accessToken', "");
        $clientVersion = 0;
        if (!empty($accessToken))
        {
            $client = WebService::getClientFromAccessToken($accessToken, $application->ApplicationID);
            $clientVersion = $client->Version;
        }

        //Bu responsedaki Application Version Application tablosundaki Versiyon degildir.
        //Client icin ozel olusturulan Application Versiondur.
        return [
            'status'              => 0,
            'error'               => "",
            'ApplicationID'       => (int)$application->ApplicationID,
            'ApplicationBlocked'  => ((int)$application->Blocked == 1 ? true : false),
            'ApplicationStatus'   => ((int)$application->Status == 1 ? true : false),
            'ApplicationVersion'  => (int)($application->Version + $clientVersion),
            'ShowDashboard'       => (boolean)$application->ShowDashboard,
            'ConfirmationMessage' => $application->ConfirmationMessage,
        ];
    }


    public function detail($sv, Application $application)
    {

        /*
          INFO: Force | guncellemeye zorlanip zorlanmayacagini selimin tablosundan sorgula!
          0: Zorlama
          1: Uyari goster
          2: Zorla
          3: Sil ve zorla
         */
        if (!$application->isOnAir())
        {
            throw eServiceError::getException(eServiceError::PassiveApplication);
        }
        $customer = WebService::getCheckCustomer($sv, $application->CustomerID);

        //INFO:Save token method come from get_contents
        WebService::saveToken($application);

        return [
            'status'                      => 0,
            'error'                       => "",
            'CustomerID'                  => (int)$customer->CustomerID,
            'CustomerName'                => $customer->CustomerName,
            'ApplicationID'               => (int)$application->ApplicationID,
            'ApplicationName'             => $application->Name,
            'ApplicationDetail'           => $application->Detail,
            'ApplicationExpirationDate'   => $application->ExpirationDate,
            'IOSVersion'                  => $application->IOSVersion,
            'IOSLink'                     => $application->IOSLink,
            'AndroidVersion'              => $application->AndroidVersion,
            'AndroidLink'                 => $application->AndroidLink,
            'PackageID'                   => $application->PackageID,
            'ApplicationBlocked'          => ((int)$application->Blocked == 1 ? true : false),
            'ApplicationStatus'           => ((int)$application->Status == 1 ? true : false),
            'ApplicationVersion'          => (int)$application->Version,
            'Force'                       => (int)$application->Force,
            'SubscriptionWeekActive'      => (int)$application->SubscriptionWeekActive,
            'SubscriptionWeekIdentifier'  => $application->SubscriptionIdentifier(Subscription::week),
            'SubscriptionMonthActive'     => (int)$application->SubscriptionMonthActive,
            'SubscriptionMonthIdentifier' => $application->SubscriptionIdentifier(Subscription::mounth),
            'SubscriptionYearActive'      => (int)$application->SubscriptionYearActive,
            'SubscriptionYearIdentifier'  => $application->SubscriptionIdentifier(Subscription::year),
            'WeekPrice'                   => '',
            'MonthPrice'                  => '',
            'YearPrice'                   => '',
        ];
    }

    public function categories($sv, Application $application)
    {
        WebService::checkServiceVersion($sv);
        if (!$application->isOnAir())
        {
            throw eServiceError::getException(eServiceError::PassiveApplication);
        }

        $categories = WebService::getCheckApplicationCategories($application);

        return [
            'status'     => 0,
            'error'      => "",
            'Categories' => $categories,
        ];
    }

    public function categoryDetail($sv, Application $application, Category $category)
    {
        WebService::checkServiceVersion($sv);
        if (!$application->isOnAir())
        {
            throw eServiceError::getException(eServiceError::PassiveApplication);
        }

        if (!$application->Categories->has($category->CategoryID))
        {
            throw eServiceError::getException(eServiceError::CategoryNotFound);
        }

        return [
            'status'       => 0,
            'error'        => "",
            'CategoryID'   => (int)$category->CategoryID,
            'CategoryName' => $category->Name,
        ];
    }

    public function contents(Request $request, $sv, Application $application)
    {
        WebService::checkServiceVersion($sv);
        //get user token here then return according to this

        $isTest = $request->get('isTest', 0) ? true : false;
        $accessToken = $request->get('accessToken', "");
        if (!$application->isOnAir())
        {
            throw eServiceError::getException(eServiceError::PassiveApplication);
        }

        $serviceData = [];
        $serviceData["ServiceVersion"] = $sv;
        $serviceData["application"] = $application;
        $serviceData["isTest"] = $isTest;
        $serviceData["accessToken"] = $accessToken;
        $contents = WebService::getCheckApplicationContents($serviceData);
        $status = 0;
        $error = "";

        if (empty($contents))
        {
            $status = eServiceError::ContentNotFound;
            $error = eServiceError::ContentNotFoundMessage;
        }

        $activeSubscription = false;
        $subscriptionEndDate = date("Y-m-d H:i:s");
        $remainingDay = 0;
        if (!empty($accessToken))
        {
            $client = WebService::getClientFromAccessToken($accessToken, $application->ApplicationID);
            if ($client->PaidUntil > date("Y-m-d H:i:s", strtotime("-1 day")))
            {
                //I give 1 more day...
                $activeSubscription = true;
                $subscriptionEndDate = $client->PaidUntil;
                $remainingDay = ceil((strtotime($client->PaidUntil) - time()) / 86400);
            }
        }

        return [
            'status'              => $status,
            'error'               => $error,
            'ActiveSubscription'  => $activeSubscription,
            'RemainingDay'        => $remainingDay,
            'SubscriptionEndDate' => $subscriptionEndDate,
            'ThemeBackground'     => $application->ThemeBackground,
            'ThemeForeground'     => $application->ThemeForegroundColor,
            'BannerActive'        => $application->BannerActive,
            'BannerPage'          => $application->BannerPage(),
            'Tabs'                => $application->TabsForService(),
            'Contents'            => $contents,
        ];

    }

    public function authorizedApplicationList(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $applicationSet = [];
        $userFacebookID = $request->get('userFacebookID');
        $userFbEmail = $request->get('userFbEmail');
        $responseSet = [];
        $user = WebService::getCheckUser($username, $password, $userFacebookID, $userFbEmail);

        //We have a user now...
        if ($user->UserTypeID == eUserTypes::Customer)
        {
            $applicationSet = Application::where('CustomerID', '=', $user->CustomerID)
                ->whereDate('ExpirationDate', '>=', Carbon::today())
                ->get();
        } else if ($user->UserTypeID == eUserTypes::Manager)
        {
            $applicationSet = Application::whereDate('ExpirationDate', '>=', Carbon::today())->get();
        }

        foreach ($applicationSet as $application)
        {
            $responseSet[] = [
                'ApplicationID' => $application->ApplicationID,
                'Name'          => $application->Name,
            ];
        }

        return $responseSet;
    }

    public function loginApplication(Request $request, $sv)
    {

        $applicationID = $request->get("applicationID");
        $username = $request->get("username");
        $password = $request->get("password");

        WebService::getCheckApplication($applicationID);
        $client = WebService::getCheckClient($sv, $applicationID, $username, $password);
        if (!$client)
        {
            return false;
        }

        $result = [];
        $result['accessToken'] = $client->Token;

        return $result;
    }

    public function facebookLogin(Request $request)
    {
        if (true) {
            throw eServiceError::getException(eServiceError::PassiveApplication);
        }
        /* @var $client Client */
        $rules = [
            'clientLanguage' => 'required|in:' . implode(",", config("application.languages")),
            'applicationID'  => 'required|integer',
            'facebookAppId' => 'required',
            'facebookUserId' => 'required',
            'facebookEmail'  => 'required|email',
            'facebookToken'  => 'required',
            'name'           => 'required',
            'surname'        => 'required',
        ];


        $v = Validator::make($request->all(), $rules);
        if ($v->invalid())
        {
            throw eServiceError::getException(eServiceError::GenericError, $v->errors()->first());
        }

        $applicationID = $request->get("applicationID");
        $fbAppId = $request->get("facebookAppId");
        $fbUserId = $request->get("facebookUserId");
        $fbEmail = $request->get("facebookEmail");
        $fbToken = $request->get("facebookToken");
        //TODO: check client from facebook...




        $name = $request->get("name");
        Config::set("application.language", $request->get("clientLanguage"));
        $surname = $request->get("surname");
        WebService::getCheckApplication($applicationID);
        $client = Client::where("ApplicationID", "=", $applicationID)
            ->where("Email", "=", $fbEmail)
            ->orWhere("FbEmail", $fbEmail)->first();
        if ($client)
        {
            $client->FbAppID = $fbAppId;
            $client->FbUserID = $fbUserId;
            $client->FbEmail = $fbEmail;
            $client->FbToken = $fbToken;
            $client->save();
            $result = [];
            $result['accessToken'] = $client->Token;

            return $result;
        }

        $userNo = "";

        do
        {
            $username = Str::ascii($name . $surname . $userNo);
            $clientExists = Client::where("Username", "=", $username)
                ->where("ApplicationID", "=", $applicationID)->exists();
            $userNo = 1 + (int)$userNo;
        } while ($clientExists);

        $password = Common::generatePassword();
        $clientNew = new Client();
        $clientNew->Password = $password;
        $clientNew->Token = $username . "_" . md5(uniqid());
        $clientNew->StatusID = eStatus::Active;
        $clientNew->CreatorUserID = 0;
        $clientNew->Username = $username;
        $clientNew->Email = $fbEmail;
        $client->FbAppID = $fbAppId;
        $client->FbUserID = $fbUserId;
        $client->FbEmail = $fbEmail;
        $client->FbToken = $fbToken;
        $clientNew->ApplicationID = $applicationID;
        $clientNew->Name = $name;
        $clientNew->Surname = $surname;
        $clientNew->save();

        Mail::to($clientNew->Email)->queue(new ClientRegisteredMailler($clientNew, $password));
        $result = [];
        $result['accessToken'] = $clientNew->Token;

        return $result;
    }

    public function androidRestore(Request $request, $sv, Application $application)
    {
        WebService::checkServiceVersion($sv);

        if (!$application->isOnAir())
        {
            throw eServiceError::getException(eServiceError::PassiveApplication);
        }

        $errorIdentifier = [];
        $rules = [
            'accessToken'    => 'required',
            'purchaseTokens' => 'required',
            'packageName'    => 'required',
            'productIds'     => 'required',
            'platformType'   => 'required|in:android,ios',
        ];

        $v = Validator::make($request->all(), $rules);
        if ($v->invalid())
        {
            throw eServiceError::getException(eServiceError::GenericError, $v->errors()->first());
        }

        $productIds = json_decode($request->get('productIds'));
            $purchaseTokens = json_decode($request->get('purchaseTokens'));
            $accessToken = $request->get('accessToken');
            $myClient = WebService::getClientFromAccessToken($accessToken, $application->ApplicationID);
            $platformType = $request->get('platformType');
            $packageName = $request->get('packageName');
            for ($i = 0; $i < count($productIds); $i++)
            {
                $purchaseToken = $purchaseTokens[$i]; //receiptToken
                $productID = $productIds[$i]; //subscriptionIdentifier
                //ise baslamadan gonderilen receipti kaydedelim...
                /** @var ClientReceipt $clientReceipt */
                $clientReceipt = ClientReceipt::where("Receipt", "=", $purchaseToken)->first();
                if (!$clientReceipt)
                {
                    $clientReceipt = new ClientReceipt();
                } else
                {
                    if ($clientReceipt->SubscriptionID != $productID || $clientReceipt->ClientID != $myClient->ClientID)
                    {
                        throw eServiceError::getException(eServiceError::GenericError, 'Receipt used for another product or client');
                    }
                }
                $clientReceipt->ClientID = $myClient->ClientID;
                $clientReceipt->SubscriptionID = $productID;
                $clientReceipt->Platform = $platformType;
                $clientReceipt->PackageName = $packageName;
                $clientReceipt->Receipt = $purchaseToken;
                $clientReceipt->save();
                try
                {
                    $myClient->CheckReceipt($clientReceipt);
                } catch (Exception $e)
                {
                    array_push($errorIdentifier, $productID);
                }
            }
            return ['status' => 0, 'error' => "", 'errorIdentifier' => json_encode($errorIdentifier)];

    }

    public function receipt(Request $request, $ServiceVersion, $applicationID)
    {
        WebService::checkServiceVersion($ServiceVersion);
        WebService::getCheckApplication($applicationID);

        $rules = [
            'accessToken'   => 'required',
            'purchaseToken' => 'required',
            'packageName'   => 'required',
            'productId'     => 'required',
            'platformType'  => 'required|in:android,ios',
        ];

        $v = Validator::make($request->all(), $rules);
        if ($v->invalid())
        {
            throw eServiceError::getException(eServiceError::GenericError, $v->errors()->first());
        }

        $accessToken = $request->get('accessToken');
        $purchaseToken = $request->get('purchaseToken'); //receiptToken
        $packageName = $request->get('packageName');
        $productID = $request->get('productId'); //subscriptionIdentifier
        $platformType = $request->get('platformType');
        $myClient = WebService::getClientFromAccessToken($accessToken, $applicationID);

        //ise baslamadan gonderilen receipti kaydedelim...
        /** @var ClientReceipt $clientReceipt */
        $clientReceipt = ClientReceipt::where("Receipt", "=", $purchaseToken)->first();
        if (!$clientReceipt)
        {
            $clientReceipt = new ClientReceipt();
        } else
        {
            if ($clientReceipt->SubscriptionID != $productID || $clientReceipt->ClientID != $myClient->ClientID)
            {
                throw eServiceError::getException(eServiceError::GenericError, 'Receipt used for another product or client');
            }
        }
        $clientReceipt->ClientID = $myClient->ClientID;
        $clientReceipt->SubscriptionID = $productID;
        $clientReceipt->Platform = $platformType;
        $clientReceipt->PackageName = $packageName;
        $clientReceipt->Receipt = $purchaseToken;
        $clientReceipt->save();

        $myClient->CheckReceipt($clientReceipt);

        return ['status' => 0, 'error' => ""];
    }

}
