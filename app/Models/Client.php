<?php

namespace App\Models;

use App\Library\WebService;
use App\Scopes\StatusScope;
use eServiceError;
use Exception;
use Google_Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Log;

/**
 * App\Models\Client
 *
 * @property int $ClientID
 * @property int $ApplicationID
 * @property string $Username
 * @property string $Password
 * @property string $Email
 * @property string $FbAppID
 * @property string $FbUserID
 * @property string $FbEmail
 * @property string $FbToken
 * @property string $Token
 * @property string $DeviceToken
 * @property string $Name
 * @property string $Surname
 * @property string $PaidUntil
 * @property int $SubscriptionChecked
 * @property string $ContentIDSet
 * @property string $LastLoginDate
 * @property int $InvalidPasswordAttempts
 * @property string $PWRecoveryCode
 * @property string $PWRecoveryDate
 * @property int $Version
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereClientID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereContentIDSet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereDeviceToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereFbAppID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereFbEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereFbToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereFbUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereInvalidPasswordAttempts($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereLastLoginDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client wherePWRecoveryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client wherePWRecoveryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client wherePaidUntil($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereSubscriptionChecked($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereSurname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client whereVersion($value)
 * @mixin \Eloquent
 */
class Client extends Model {


    protected $table = 'Client';
    protected $primaryKey = 'ClientID';
    public static $key = 'ClientID';

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new StatusScope);
    }


    public static function getSampleXmlUrl()
    {
        return sprintf("/files/sampleFiles/SampleClientExcel_%s.xls", app()->getLocale());
    }

    public static function updateDeviceToken($accessToken, $deviceToken)
    {
        if (!empty($deviceToken))
        {
            /* @var $client Client */
            $client = Client::where("Token", $accessToken)->first();
            if ($client && $client->DeviceToken !== $deviceToken)
            {
                $client->DeviceToken = $deviceToken;
                $client->save();
            }
        }
    }

    public function save(array $options = [])
    {
        if ($this->isClean())
        {
            return true;
        }

        if ($this->PaidUntil > date('Y:m:d H:i:s'))
        {
            $this->SubscriptionChecked = 0;
        }

        $this->Version = (int)$this->Version + 1;
        parent::save();
    }

    public function isContentBought($contentID)
    {
        $boughtContentIDSet = explode(",", $this->ContentIDSet);
        if (in_array($contentID, $boughtContentIDSet))
        {
            return true;
        }

        return false;
    }


    /**
     *
     * @return Content[]
     */
    public function Contents()
    {
        $contents = [];
        $contentIDSet = explode(",", $this->ContentIDSet);
        foreach ($contentIDSet as $contentID)
        {
            $tmpContent = Content::find($contentID);
            if ($tmpContent)
            {
                $contents[] = $tmpContent;
            }
        }

        return $contents;
    }

    /**
     * @param ClientReceipt $receipt
     * @throws Exception
     */
    public function CheckReceipt($receipt)
    {
        /** @var ClientReceipt $clientReceipt */
        switch ($receipt->Platform)
        {
            case 'android':
                $this->checkReceiptGoogle($receipt);
                break;
            case 'ios':
                $this->checkReceiptIos($receipt);
                break;
        }
        $this->save();
    }

    /**
     * @param $clientReceipt
     * @throws Exception
     */
    private function checkReceiptGoogle($clientReceipt)
    {
        $client = new Google_Client();
        $application = $this->Application;
        // set Application Name to the name of the mobile app
        $client->setApplicationName($application->Name);
        // get p12 key file
        if (!empty($application->GoogleDeveloperKey))
        {
            $key = file_get_contents(app_path('keys/' . $application->GoogleDeveloperKey));
        } else
        {
            $key = file_get_contents(app_path('keys/GooglePlayAndroidDeveloper-74176ee02cd0.p12'));
        }

        if (!empty($application->GoogleDeveloperEmail))
        {
            $email = $application->GoogleDeveloperEmail;
        } else
        {
            $email = '552236962262-compute@developer.gserviceaccount.com';
        }

        // create assertion credentials class and pass in:
        // - service account email address
        // - query scope as an array (which APIs the call will access)
        // - the contents of the key file
        $cred = new Google_Auth_AssertionCredentials(
            $email,
            ['https://www.googleapis.com/auth/androidpublisher'],
            $key
        );
        // add the credentials to the client
        $client->setAssertionCredentials($cred);
        // create a new Android Publisher service class
        $service = new Google_Service_AndroidPublisher($client);
        // use the purchase token to make a call to Google to get the subscription info
        /** @var Content $content */
        $content = Content::where("Identifier", $clientReceipt->SubscriptionID)->where("ApplicationID", $this->Application->ApplicationID)->first();
        if ($content)
        {
            //content ise valide edip contenti erişebilir content listesine koyacağız...
            $productPurchaseResponse = $service->purchases_products->get($clientReceipt->PackageName, $clientReceipt->SubscriptionID, $clientReceipt->Receipt);
            $clientReceipt->SubscriptionType = $productPurchaseResponse->getKind();
            $clientReceipt->MarketResponse = json_encode($productPurchaseResponse->toSimpleObject());
            $clientReceipt->save();

            if ($productPurchaseResponse->consumptionState == WebService::GoogleConsumptionStatePurchased)
            {
                //Content bought so save content to clients purchased products
                $this->addPurchasedItem($content->ContentID);
            } else
            {
                throw eServiceError::getException(eServiceError::GenericError, 'Content Not Bought.');
            }

        } else
        {
            //applicationda $productID var mi kontrol edecegiz...
            $subscription = $service->purchases_subscriptions->get($clientReceipt->PackageName, $clientReceipt->SubscriptionID, $clientReceipt->Receipt);
            $clientReceipt->MarketResponse = json_encode($subscription->toSimpleObject());
            if (is_null($subscription) || !$subscription->getExpiryTimeMillis() > 0)
            {
                $clientReceipt->save();
                throw eServiceError::getException(eServiceError::GenericError, 'Error validating transaction.');
            }

            //validate oldu tekrar kaydedelim...
            $clientReceipt->SubscriptionType = $subscription->getKind();
            $clientReceipt->SubscriptionStartDate = date("Y-m-d H:i:s", $subscription->getStartTimeMillis() / 1000);
            $clientReceipt->SubscriptionEndDate = date("Y-m-d H:i:s", $subscription->getExpiryTimeMillis() / 1000);
            $clientReceipt->save();


            if (empty($this->PaidUntil) || $this->PaidUntil < $clientReceipt->SubscriptionEndDate)
            {
                $this->PaidUntil = $clientReceipt->SubscriptionEndDate;
            }
        }
    }

    public function addPurchasedItem($contentID)
    {
        $contentIDSet = $this->ContentIDSet;
        if (empty($contentIDSet))
        {
            $contentIDSet = [$contentID];
        } else
        {
            $contentIDSet = explode(',', $this->ContentIDSet);
            array_push($contentIDSet, $contentID);
        }
        $contentIDSet = array_unique($contentIDSet);
        sort($contentIDSet);
        $this->ContentIDSet = trim(implode(",", $contentIDSet), ',');
    }

    /**
     * @param $clientReceipt
     * @throws Exception
     */
    private function checkReceiptIos($clientReceipt)
    {
        //validate olursa $clientReceipt'i ona gore kaydedicegiz...

        $receiptObject = WebService::buildAppleJSONReceiptObject($clientReceipt->Receipt, $this->Application->IOSHexPasswordForSubscription);
        $response = WebService::makeAppleReceiptRequest('https://buy.itunes.apple.com/verifyReceipt', $receiptObject);
        $clientReceipt->MarketResponse = json_encode($response);
        if (isset($response["status"]) && $response["status"] == 21007)
        {
            //sandbox receipti geldi url sandboxa dönmeli...
            $response = WebService::makeAppleReceiptRequest('https://sandbox.itunes.apple.com/verifyReceipt', $receiptObject);
            $clientReceipt->MarketResponse = json_encode($response);
        }

        $errorMsg = WebService::checkIosResponse($response);
        if (!empty($errorMsg))
        {
            $clientReceipt->save();
            throw eServiceError::getException(eServiceError::GenericError, $errorMsg);
        }

        //apple icin butun receiptleri donup direk restore edicem...
        foreach ($response["receipt"]["in_app"] as $key => $inApp)
        {
            if (!isset($inApp['expires_date_ms']))
            {
                //expires_date_ms set edilmemis ise product satin almadir.
                if (isset($inApp["product_id"]))
                {
                    $content = Content::where("Identifier", $clientReceipt->SubscriptionID)->where("ApplicationID", $this->Application->ApplicationID)->first();
                    if (isset($content))
                    {
                        $this->addPurchasedItem($content->ContentID);
                    }
                }
            } else
            {
                //expires_date_ms set edilmis subscription satin alinmis.
                $clientReceipt->SubscriptionType = "iospublisher#subscriptionPurchase";
                $inAppExpiresDate = date("Y-m-d H:i:s", $inApp["expires_date_ms"] / 1000);
                if (empty($this->PaidUntil) || $this->PaidUntil < $inAppExpiresDate)
                {
                    $this->PaidUntil = $inAppExpiresDate;
                }

                if ($key == count($response["receipt"]["in_app"]) - 1)
                {
                    //en son alinmis receipti kaydedelim...
                    $clientReceipt->SubscriptionStartDate = date("Y-m-d H:i:s", $inApp["purchase_date_ms"] / 1000);
                    $clientReceipt->SubscriptionEndDate = $inAppExpiresDate;
                    $clientReceipt->save();
                }
            }
        }
    }

    public function checkReceiptGoogleTest($clientReceipt)
    {
        require_once path('bundle') . '/google/src/Google/autoload.php';
        $client = new Google_Client();

        $application = $this->Application;
        // set Application Name to the name of the mobile app
        $client->setApplicationName($application->Name);


        // get p12 key file
        if (!empty($application->GoogleDeveloperKey))
        {
            $key = file_get_contents(path('app') . 'keys/' . $application->GoogleDeveloperKey);
        } else
        {
            $key = file_get_contents(path('app') . 'keys/GooglePlayAndroidDeveloper-74176ee02cd0.p12');
        }

        if (!empty($application->GoogleDeveloperEmail))
        {
            $email = $application->GoogleDeveloperEmail;
        } else
        {
            $email = '552236962262-compute@developer.gserviceaccount.com';
        }

        // create assertion credentials class and pass in:
        // - service account email address
        // - query scope as an array (which APIs the call will access)
        // - the contents of the key file
        $cred = new Google_Auth_AssertionCredentials(
            $email,
            ['https://www.googleapis.com/auth/androidpublisher'],
            $key
        );
        // add the credentials to the client
        $client->setAssertionCredentials($cred);
        // create a new Android Publisher service class
        $service = new Google_Service_AndroidPublisher($client);
        // use the purchase token to make a call to Google to get the subscription info
        /** @var Content $content */
        $content = Content::where("Identifier", $clientReceipt->SubscriptionID)->where("ApplicationID", $this->Application->ApplicationID)->first();
        if ($content)
        {
            //content ise valide edip contenti erişebilir content listesine koyacağız...
            $productPurchaseResponse = $service->purchases_products->get($clientReceipt->PackageName, $clientReceipt->SubscriptionID, $clientReceipt->Receipt);
            var_dump($productPurchaseResponse);
        } else
        {
            //applicationda $productID var mi kontrol edecegiz...
            $subscriptionResponse = $service->purchases_subscriptions->get($clientReceipt->PackageName, $clientReceipt->SubscriptionID, $clientReceipt->Receipt);
            var_dump($subscriptionResponse);
        }
    }

    public function CheckReceiptCLI()
    {
        /** @var ClientReceipt[] $clientReceipts */
        $clientReceipts = ClientReceipt::where('clientID', $this->ClientID)
            ->where_in('SubscriptionType', ['iospublisher#subscriptionPurchase', 'androidpublisher#subscriptionPurchase'])
            ->get();

        foreach ($clientReceipts as $clientReceipt)
        {
            try
            {
                switch ($clientReceipt->Platform)
                {
                    case 'android':
                        $this->checkReceiptGoogle($clientReceipt);
                        break;
                    case 'ios':
                        $this->checkReceiptIos($clientReceipt);
                        break;
                }
            } catch (Exception $e)
            {
                Log::error($e->getMessage() . ' - Receipt ID: ' . $clientReceipt->ClientReceiptID);
            }
        }
        $this->Version++;
        $this->save();
    }

    protected function Application()
    {
        return $this->belongsTo(Application::class, 'ApplicationID');
    }

    public static function clientList(Request $request) {
        $applications = \Auth::user()->Applications;

        if (empty($applications))
        {
            throw new Exception('This user does not have applications. UserID: ' . \Auth::user()->UserID);
        }

        $appIDSet = [];

        foreach ($applications as $app)
        {
            $appIDSet[] = $app->ApplicationID;
        }
        $search = $request->get('search', '');
        $sort = $request->get('sort', self::$key);
        $sort_dir = $request->get('sort_dir', 'DESC');

        $rs = Client::whereIn('ApplicationID', $appIDSet)->orderBy($sort, $sort_dir);
        if (!empty($search)) {
            $rs->where(function (Builder $builder) use ($search) {
                $builder->orWhere('Username', 'LIKE', '%' . $search . '%');
                $builder->where('Name', 'LIKE', '%' . $search . '%');
                $builder->orWhere('Surname', 'LIKE', '%' . $search . '%');
                $builder->orWhere('Email', 'LIKE', '%' . $search . '%');
                $builder->orWhere('ClientID', 'LIKE', '%' . $search . '%');
            });
        }

        $rows = $rs->paginate(config('custom.rowcount'));
        return $rows;
    }

}
