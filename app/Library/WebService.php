<?php

namespace App\Library;

use App\Models\Application;
use App\Models\Category;
use App\Models\Client;
use App\Models\Content;
use App\Models\ContentCategory;
use App\Models\Customer;
use App\Models\Token;
use App\User;
use Closure;
use DB;
use eDeviceType;
use eRemoveFromMobile;
use eServiceError;
use eStatus;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Response;

class WebService {

    const GoogleConsumptionStatePurchased = 0;
    const GoogleConsumptionStateCanceled = 1;
    const GoogleConsumptionStateRefunded = 2;
    const Version = 103;
    public static $availableServices = [103];

    /**
     * If there is a exception then catches it and returns a valid Response else returns what the Closure returns
     * @param Closure $cb
     * @return Response
     */
    public static function render(Closure $cb)
    {
        try
        {
            //return $cb();
            return call_user_func($cb);
        } catch (Exception $e)
        {
            return response([
                'status' => $e->getCode(),
                'error'  => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param $ServiceVersion
     * @param $customerID
     * @return Customer|null
     * @throws Exception
     */
    public static function getCheckCustomer($ServiceVersion, $customerID)
    {
        self::checkServiceVersion($ServiceVersion);
        $customer = Customer::where('CustomerID', '=', $customerID)->first();
        if (!$customer)
        {
            throw eServiceError::getException(eServiceError::UserNotFound);
        }

        return $customer;
    }

    /**
     *
     * @param int $applicationID
     * @return Application
     * @throws Exception
     */
    public static function getCheckApplication($applicationID)
    {
        $application = Application::find($applicationID);
        if (!$application)
        {
            throw eServiceError::getException(eServiceError::ApplicationNotFound);
        }
        if (!($application->ExpirationDate >= date("Y-m-d H:i:s") && (int)$application->Blocked == 0 && (int)$application->Status == 1))
        {
            throw eServiceError::getException(eServiceError::PassiveApplication);
        }

        return $application;
    }

    public static function getCheckApplicationCategories(Application $application)
    {
        $categories = [];
        //add general
        array_push($categories, [
            'CategoryID'   => 0,
            'CategoryName' => trans('common.contents_category_list_general', [], 'messages', $application->ApplicationLanguage),
        ]);
        $rs = Category::where('ApplicationID', '=', $application->ApplicationID)->orderBy('Name', 'ASC')->get();
        foreach ($rs as $r)
        {
            array_push($categories, [
                'CategoryID'   => (int)$r->CategoryID,
                'CategoryName' => $r->Name,
            ]);
        }

        return $categories;
    }

    public static function getCheckApplicationCategoryDetail($applicationID, $categoryID)
    {
        $category = Category::where('CategoryID', '=', $categoryID)
            ->where('ApplicationID', '=', $applicationID)->first();
        if (!$category)
        {
            throw eServiceError::getException(eServiceError::CategoryNotFound);
        }

        return $category;
    }

    public static function getCheckApplicationContents($data = null)
    {
        $ServiceVersion = isset($data["ServiceVersion"]) ? $data["ServiceVersion"] : false;
        self::checkServiceVersion($ServiceVersion);
        /** @var Application $application */
        $application = $data["application"];
        $accessToken = isset($data["accessToken"]) ? $data["accessToken"] : false;
        $isTest = isset($data["isTest"]) ? $data["isTest"] : false;

        $query = Content::where('ApplicationID', $application->ApplicationID)
            ->orderBy('OrderNo', 'DESC')
            ->orderBy('MonthlyName', 'ASC')
            ->orderBy('Name', 'ASC');
        if (!$isTest)
        {
            $query->where(function (Builder $q)
            {
                $q->where('Status', eStatus::Active);
                $q->orWhere("RemoveFromMobile", eRemoveFromMobile::Active);
            });
        }


        $categoryID = request('categoryID', '-1');
        if ($categoryID != -1)
        {
            $query->whereHas('ContentCategory', function (Builder $builder) use ($categoryID)
            {
                   $builder->where('CategoryID', $categoryID);
            });
        }

        $rs = $query->get();
        $contents = [];
        $client = WebService::getClientFromAccessToken($accessToken, $application->ApplicationID);
        foreach ($rs as $r)
        {
            if ($r->serveContent())
            {
                $clientBoughtContent = $client && $client->isContentBought($r->ContentID);
                array_push($contents, array_merge($r->getServiceData(), ['ContentBought' => $clientBoughtContent]));
            }
        }

        return $contents;
    }

    /**
     * @param $accessToken
     * @param $applicationID
     * @return Client
     * @throws Exception
     */
    public static function getClientFromAccessToken($accessToken, $applicationID)
    {
        $client = Client::where("Token", "=", $accessToken)
            ->where('ApplicationID', '=', $applicationID)->first();
        if (!empty($accessToken) && !$client)
        {
            throw eServiceError::getException(eServiceError::ClientNotFound);
        }

        return $client;
    }

    /**
     * RemoveFromMobilei aktif olanlari veya StatusID eStatus::Active olanlari doner.
     * @param int $contentID
     * @return Content
     * @throws Exception
     */
    public static function getCheckContent($ServiceVersion, $contentID)
    {
        self::checkServiceVersion($ServiceVersion);
        $content = Content::withoutGlobalScopes()->where('ContentID', '=', $contentID)
            ->where(function (Builder $q)
            {
                $q->where('StatusID', '=', eStatus::Active);
                $q->orWhere("RemoveFromMobile", "=", eRemoveFromMobile::Active);
            })
            ->first();

        if (!$content)
        {
            throw eServiceError::getException(eServiceError::ContentNotFound);
        }
        if (!((int)$content->Blocked == 0))
        {
            throw eServiceError::getException(eServiceError::ContentBlocked);
        }

        return $content;
    }


    public static function checkUserCredential($ServiceVersion, $customerID)
    {
        self::checkServiceVersion($ServiceVersion);
        $username = request('username', '');
        $password = request('password', '');
        $user = null;
        if (strlen($username) > 0)
        {
            $user = User::where('CustomerID', '=', (int)$customerID)
                ->where('Username', '=', $username)->first();
            if (!$user)
            {
                throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
            }

            if (!(crypt($password, $user->Password) === $user->Password))
            {
                throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
            }
        }

        return $user;
    }

    public static function saveToken(Application $application)
    {
        $UDID = request('udid', '');
        $applicationToken = request('applicationToken', '');
        $deviceToken = request('deviceToken', '');
        $deviceType = request('deviceType', 'ios');
        $accessToken = request('accessToken', '');

        //if(strlen($applicationToken) > 0 && strlen($deviceToken) > 0)
        $token = null;
        if (strlen($deviceToken) > 0)
        {
            if ($deviceType == eDeviceType::android && !empty($UDID))
            {
                $token = Token::where('ApplicationID', '=', $application->ApplicationID)
                    ->where('UDID', '=', $UDID)
                    ->first();
                if ($token)
                {
                    //eski android uygulamasi tekrardan geldi deviceTokeni guncelleyelim.
                    $token->DeviceToken = $deviceToken;
                }
            } else
            {
                $token = Token::where('ApplicationToken', '=', $applicationToken)->where('DeviceToken', '=', $deviceToken)->first();
                if ($token)
                {
                    //INFO:Added due to https://github.com/galepress/gp/issues/2
                    //Emre, Eger token tablosuna getAppDetail'den gelen bir deviceToken kaydedildiyse ayni deviceToken'ile baska insert yapilmiyor.
                    //Fakat soyle bir durum soz konusu. Benim deviceToken'im kaydedildi ama daha sonra yeni update ile udid'lerde geliyor.
                    //deviceToken tabloda varsa udid'sini update etmesi lazim. Yoksa udid eklemememizin bir manasi olmayacak.
                    //bir cihaza uygualma bir kez kurulduysa hic udid'sini alamayiz.
                    $token->UDID = $UDID;
                }
            }
            if (empty($token))
            {
                $token = new Token();
                $token->CustomerID = $application->CustomerID;
                $token->ApplicationID = $application->ApplicationID;
                $token->UDID = $UDID;
                $token->ApplicationToken = $applicationToken;
                $token->DeviceToken = $deviceToken;
                $token->DeviceType = $deviceType;
                $token->StatusID = eStatus::Active;
            }
            $token->save();
        }

        Client::updateDeviceToken($accessToken, $deviceToken);
    }

    /**
     *
     * @param string $username
     * @param string $password
     * @param string $userFacebookID
     * @param string $userFbEmail
     * @return User
     * @throws Exception
     */
    public static function getCheckUser($username, $password, $userFacebookID, $userFbEmail)
    {

        if (!empty($username) && !empty($password))
        {
            //username ve password login
            $user = User::where('Username', '=', $username)->where('StatusID', '=', eStatus::Active)->first();
            if (!$user)
            {
                throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
            }

            if (!Hash::check($password, $user->Password))
            {
                throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
            }
        } else if (!empty($userFacebookID) && !empty($userFbEmail))
        {
            //facebook login
            $user = User::where('FbUsername', '=', $userFacebookID)
                ->where('FbEmail', '=', $userFbEmail)
                ->where('StatusID', '=', eStatus::Active)->first();
            if (!$user)
            {
                throw eServiceError::getException(eServiceError::CreateAccount);
            }
        } else
        {
            throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
        }

        if ($user->CustomerID == 0)
        {
            //Customer not exist
            throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
        }

        return $user;
    }

    /**
     *
     * @param int $ServiceVersion
     * @param string $applicationID
     * @param string $username
     * @param string $password
     * @return Client
     * @throws Exception
     */
    public static function getCheckClient($ServiceVersion, $applicationID, $username, $password)
    {
        self::checkServiceVersion($ServiceVersion);
        if (empty($username) || empty($password))
        {
            throw eServiceError::getException(eServiceError::ClientNotFound);
        }

        /* @var $client Client */
        $client = Client::where('ApplicationID', '=', $applicationID)
            ->where('Username', '=', $username)
            ->where('StatusID', '=', eStatus::Active)->first();
        if (!$client)
        {
            throw eServiceError::getException(eServiceError::ClientNotFound);
        } else if ($client->Password != $password)
        {
            $client->InvalidPasswordAttempts++;
            $client->save();
            throw eServiceError::getException(eServiceError::ClientIncorrectPassword);
        } else if ($client->InvalidPasswordAttempts > 5 && (time() - strtotime($client->updated_at)) < 7200)
        {
            throw eServiceError::getException(eServiceError::ClientInvalidPasswordAttemptsLimit);
        }

        if (empty($client->Token))
        {
            $client->Token = $client->Username . "_" . md5(uniqid());
            $client->save();
        }

        return $client;
    }

    public static function buildAppleJSONReceiptObject($receipt, $password = null)
    {
        $preObject['receipt-data'] = $receipt;
        if ($password)
        {
            $preObject['password'] = $password;
        }

        return json_encode($preObject);
    }

    public static function makeAppleReceiptRequest($endpoint, $receiptObject)
    {
        $options = [];
        $options['http'] = [
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'method'  => 'POST',
            'content' => $receiptObject,
        ];

        // see: http://php.net/manual/en/function.stream-context-create.php
        $context = stream_context_create($options);
        // see: http://php.net/manual/en/function.file-get-contents.php
        $result = file_get_contents($endpoint, false, $context);
        if ($result === false)
        {
            throw new Exception('Error validating transaction.', 560);
        }

        // Decode json object (TRUE variable decodes as an associative array)
        return json_decode($result, true);
    }

    public static function checkIosResponse($response)
    {
        if (!isset($response["receipt"]))
        {
            if (isset($response["status"]))
            {
                switch ($response["status"])
                {
                    case 21000:
                        return 'The App Store could not read the JSON object you provided.';
                    case 21002:
                        return 'The App Store could not read the JSON object you provided.';
                    case 21003:
                        return 'The receipt could not be authenticated.';
                    case 21004:
                        return 'The shared secret you provided does not match the shared secret on file for your account.Only returned for iOS 6 style transaction receipts for auto-renewable subscriptions.';
                    case 21005:
                        return 'The receipt server is not currently available.';
                    case 21006:
                        return 'This receipt is valid but the subscription has expired.';
                    case 21007:
                        return 'This receipt is a sandbox receipt, but it was sent to the production server.';
                    case 21008:
                        return 'This receipt is a production receipt, but it was sent to the sandbox server.';
                    default:
                        return 'Receipt not set.';
                }
            }

            return 'Receipt not set.';
        } elseif (!isset($response["receipt"]["in_app"]))
        {
            return 'In-app not set.';
        } elseif (!isset($response["status"]))
        {
            return 'Response status not set';
        } elseif ($response["status"] != 0)
        {
            return 'Provided Receipt not valid.';
        } else
        {
            return null;
        }
    }

    public static function checkServiceVersion($ServiceVersion)
    {
        if (!in_array($ServiceVersion, self::$availableServices))
        {
            throw eServiceError::getException(eServiceError::ServiceNotFound);
        }
    }
}
