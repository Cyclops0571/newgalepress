<?php

namespace App\Models;

use Auth;
use Config;
use DateTime;
use DB;
use eProcessTypes;
use eStatus;
use eUserTypes;
use File;
use Illuminate\Database\Eloquent\Model;
use Session;
use Subscription;

/**
 * App\Models\Application
 *
 * @property int $ApplicationID
 * @property int $CustomerID
 * @property string $Name
 * @property string $Detail
 * @property string $ApplicationLanguage
 * @property int $ThemeBackground
 * @property int $ThemeForeground
 * @property string $ThemeForegroundColor
 * @property float $Price
 * @property int $Installment
 * @property int $InAppPurchaseActive
 * @property int $FlipboardActive
 * @property int $BreadCrumbActive
 * @property string $BundleText
 * @property string $StartDate
 * @property string $ExpirationDate
 * @property int $ApplicationStatusID
 * @property int $IOSVersion
 * @property string $IOSLink
 * @property string $IOSHexPasswordForSubscription
 * @property int $AndroidVersion
 * @property string $AndroidLink
 * @property int $PackageID
 * @property int $Blocked
 * @property int $Status
 * @property int $Trail
 * @property int $Version
 * @property int $Force
 * @property int $TotalFileSize
 * @property string $NotificationText
 * @property string $CkPem
 * @property int $BannerActive
 * @property int $BannerRandom
 * @property int $BannerCustomerActive
 * @property string $BannerCustomerUrl
 * @property int $BannerAutoplay
 * @property int $BannerIntervalTime
 * @property int $BannerTransitionRate
 * @property string $BannerColor
 * @property string $BannerSlideAnimation
 * @property int $TabActive
 * @property string $GoogleDeveloperKey
 * @property string $GoogleDeveloperEmail
 * @property int $SubscriptionWeekActive
 * @property string $WeekIdentifier
 * @property int $SubscriptionMonthActive
 * @property string $MonthIdentifier
 * @property int $SubscriptionYearActive
 * @property string $YearIdentifier
 * @property int $ShowDashboard
 * @property string $ConfirmationMessage
 * @property int $TopicStatus
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @property \App\Models\Customer $Customer
 * @property \App\Models\ApplicationTopic[] $ApplicationTopics
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereApplicationLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereThemeBackground($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereThemeForeground($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereThemeForegroundColor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereInstallment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereInAppPurchaseActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereFlipboardActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBreadCrumbActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBundleText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereExpirationDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereApplicationStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereIOSVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereIOSLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereIOSHexPasswordForSubscription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereAndroidVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereAndroidLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application wherePackageID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBlocked($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereTrail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereForce($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereTotalFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereNotificationText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereCkPem($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBannerActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBannerRandom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBannerCustomerActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBannerCustomerUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBannerAutoplay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBannerIntervalTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBannerTransitionRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBannerColor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereBannerSlideAnimation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereTabActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereGoogleDeveloperKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereGoogleDeveloperEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereSubscriptionWeekActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereWeekIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereSubscriptionMonthActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereMonthIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereSubscriptionYearActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereYearIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereShowDashboard($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereConfirmationMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereTopicStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Application whereProcessTypeID($value)
 * @mixin \Eloquent
 */
class Application extends Model
{

    const InstallmentCount = 24;
    const DefaultApplicationForegroundColor = '#0082CA';
    const DefaultApplicationBannerSlideAnimation = 'slide';

    public $timestamps = false;
    protected $table = 'Application';
    protected $primaryKey = 'ApplicationID';

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if (!$this->ApplicationID && Auth::user()) {
            $this->CustomerID = Auth::user()->CustomerID;
            $this->Installment = Application::InstallmentCount;
        }
    }

    /**
     *
     * @param int $applicationID
     * @param array $columns
     * @return Application|\Illuminate\Database\Eloquent\Builder
     */
    public static function find($applicationID, $columns = array('*'))
    {
        return Application::query()->where(self::getKey(), "=", $applicationID)->first($columns);
    }

    public static function getActiveAppCountByCustomerID($CustomerID)
    {
        return self::getQuery()
                ->where('CustomerID', '=', $CustomerID)
                ->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
                ->where('StatusID', '=', eStatus::Active)
                ->count() > 0;
    }

    public function ApplicationStatus($languageID)
    {
        if ((int)$this->ApplicationStatusID > 0) {
            $gc = GroupCode::find($this->ApplicationStatusID)->first();
            if ($gc) {
                return $gc->DisplayName($languageID);
            }
        }
        return '';
    }


    public function Package()
    {
        return $this->belongsTo('App\Models\Package', 'PackageID')->getQuery()->first();
    }


    /**
     * @param int $statusID
     * @return Category|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function Categories($statusID = eStatus::Active)
    {
        return $this->hasMany('App\Models\Category', self::getKey())->getQuery()->where('StatusID', '=', $statusID)->get();
    }


    /**
     *
     * @param int $statusID
     * @return Content|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function Contents($statusID = eStatus::All)
    {
        $rs = $this->hasMany('App\Models\Content', self::getKey())->getQuery();
        if ($statusID != eStatus::All) {
            $rs->where('StatusID', '=', $statusID);
        }
        return $rs->get();
    }

    public function Users()
    {
        return $this->hasMany('App\Models\ApplicationUser', $this->primaryKey);
    }

    public function Tags()
    {
        return $this->hasMany('App\Models\ApplicationTag', $this->primaryKey);
    }

    /**
     *
     * @return Content|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getContentSet()
    {
        return Content::query()->where('ApplicationID', '=', $this->ApplicationID)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('Name', 'ASC')
            ->get();
    }

    public function CheckOwnership()
    {
        $currentUser = Auth::user();
        if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
            return true;
        }

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
            if ((int)$this->StatusID == eStatus::Active) {
                $c = $this->Customer;
                if ((int)$c->StatusID == eStatus::Active) {
                    if ((int)$currentUser->CustomerID == (int)$c->CustomerID) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     *
     * @return Customer|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Customer()
    {
        return $this->belongsTo('App\Models\Customer', 'CustomerID');
    }

    public function incrementAppVersion()
    {
        $this->Version++;
        parent::save();
    }

    public function BannerPage()
    {
        if ($this->BannerCustomerActive) {
            return $this->BannerCustomerUrl;
        }
        return Config::get('custom.url') . "/banners/service_view/" . $this->ApplicationID . "?ver=" . $this->Version;
    }

    public function TabsForService()
    {
        $tabsForService = array();
        if (!$this->TabActive) {
            return $tabsForService;
        }
        $tabs = $this->Tabs();
        foreach ($tabs as $tab) {
            if ($tab->Status == eStatus::Active) {
                $tabsForService[] = array(
                    "tabTitle" => $tab->TabTitle,
                    "tabLogoUrl" => Config::get('custom.url') . $tab->IconUrl,
                    "tabLogoUrl_1x" => Config::get('custom.url') . str_replace("app-icons", "app-icons/1x", $tab->IconUrl),
                    "tabLogoUrl_2x" => Config::get('custom.url') . str_replace("app-icons", "app-icons/2x", $tab->IconUrl),
                    "tabLogoUrl_3x" => Config::get('custom.url') . str_replace("app-icons", "app-icons/3x", $tab->IconUrl),
                    "tabUrl" => $tab->urlForService()
                );
            }
        }
        return $tabsForService;
    }

    /**
     *
     * @return Tab[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function Tabs()
    {
        return $this->hasMany('App\Models\Tab', $this->getKey())->getQuery()->where('StatusID', '=', eStatus::Active)
            ->take(TAB_COUNT)
            ->get();
    }

    /**
     *
     * @return PaymentAccount|\Illuminate\Database\Eloquent\Builder
     */
    public function PaymentAccount()
    {
        return $this->hasOne('App\Models\PaymentAccount', "ApplicationID")->getQuery()->first();
    }

    /**
     *
     * @param int $type
     * @param boolean $refreshIdentifier
     * @return string
     */
    public function SubscriptionIdentifier($type = 1, $refreshIdentifier = false)
    {
        switch ($type) {
            case Subscription::mounth:
                $fieldName = "MonthIdentifier";
                break;
            case Subscription::year:
                $fieldName = "YearIdentifier";
                break;
            default:
                $fieldName = "WeekIdentifier";
                break;
        }

        if (empty($this->$fieldName) || $refreshIdentifier) {
            if (empty($this->BundleText)) {
                $identifier = "www.galepress.com.appid." . $this->ApplicationID . "type" . $type . "t" . time();
            } else {
                $identifier = strtolower($this->BundleText) . ".appid." . $this->ApplicationID . ".type" . $type . "t" . time();
            }
            if (empty($this->$fieldName)) {
                $this->$fieldName = $identifier;
                $this->save();
            } else {
                $this->$fieldName = $identifier;
            }
        }
        return $this->$fieldName;
    }

    public function save(array $options = [])
    {
        if ($this->isClean()) {
            return true;
        }

        $userID = -1;
        if (Auth::user()) {
            $userID = Auth::user()->UserID;
        }

        if ((int)$this->ApplicationID == 0) {
            $this->DateCreated = new DateTime();
            $this->ProcessTypeID = eProcessTypes::Insert;
            $this->CreatorUserID = $userID;
            $this->StatusID = eStatus::Active;
        } else {
            $this->ProcessTypeID = eProcessTypes::Update;
        }
        $this->ProcessUserID = $userID;
        $this->ProcessDate = new DateTime();
        if ($options['incrementVersion']) {
            $this->Version = (int)$this->Version + 1;
        }
        return parent::save($options);
    }

    /**
     *
     * @param int $key
     * @param int $value
     * @return int|string
     */
    public function subscriptionStatus($key, $value = -1)
    {
        $result = "";
        switch ($key) {
            case Subscription::week:
                if ($value != -1) {
                    $this->SubscriptionWeekActive = (int)((bool)$value);
                }
                $result = $this->SubscriptionWeekActive;
                break;
            case Subscription::mounth:
                if ($value != -1) {
                    $this->SubscriptionMonthActive = (int)((bool)$value);
                }
                $result = $this->SubscriptionMonthActive;
                break;
            case Subscription::year:
                if ($value != -1) {
                    $this->SubscriptionYearActive = (int)((bool)$value);
                }
                $result = $this->SubscriptionYearActive;
                break;
        }
        return $result;
    }

    public function sidebarClass($returnAsString = false)
    {
        if ($returnAsString) {
            return $this->ExpirationDate < date("Y-m-d") ? 'class="expired-app"' : '';
        } else {
            return $this->ExpirationDate < date("Y-m-d") ? array("class" => 'expired-app') : array();
        }
    }

    public function getServiceCategories()
    {
        $categories = array();
        array_push($categories, array(
            'CategoryID' => 0,
            'CategoryName' => trans('common.contents_category_list_general')
        ));

        $rs = Category::query()->where('ApplicationID', '=', $this->ApplicationID)->where('StatusID', '=', eStatus::Active)->orderBy('Name', 'ASC')->get();
        foreach ($rs as $r) {
            array_push($categories, array(
                'CategoryID' => (int)$r->CategoryID,
                'CategoryName' => $r->Name
            ));
        }
        return $categories;
    }

    public function getExpireTimeMessage()
    {
//        {{ $expApp->Name }} {{$diff->days}}
        $date1 = new DateTime($this->ExpirationDate);
        $date2 = new DateTime(date('Y-m-d'));
        $diff = $date1->diff($date2);
        if ($diff->days == 0) {
            return __('applicationlang.expiretime0days', array('ApplicationName' => $this->Name));
        } else {
            return __('applicationlang.expiretime15days', array('ApplicationName' => $this->Name, 'RemainingDays' => $diff->days));
        }
    }

    public function getCkPemPath()
    {
        return '/files/customer_' . $this->CustomerID . '/application_' . $this->ApplicationID . '/' . $this->CkPem;
    }

    public function getBannerColor()
    {
        if ($this->BannerColor) {
            return $this->BannerColor;
        }
        return $this->getThemeForegroundColor();
    }

    public function getThemeForegroundColor()
    {
        if ($this->ThemeForegroundColor) {
            return $this->ThemeForegroundColor;
        } else {
            return self::DefaultApplicationForegroundColor;
        }
    }

    public function initialLocation()
    {
        $currentLang = $this->ApplicationLanguage;
        if (Auth::user()) {
            $currentLang = Session::get('language');
        }

        $location = array();
        switch ($currentLang) {
            case 'tr':
                $location['x'] = '41.010455';
                $location['y'] = '28.985400';
                break;
            case 'de':
                $location['x'] = '52.518667';
                $location['y'] = '13.404631';
                break;
            case 'en':
            case 'usa':
            default:
                $location['x'] = '38.907147';
                $location['y'] = '-77.036545';
        }
        return $location;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|ApplicationTopic[]
     */
    public function ApplicationTopics()
    {
        return $this->hasMany('App\Models\ApplicationTopic', self::getKey());
    }

    public function setTopics($newTopicIds)
    {
        if ($this->TopicStatus != eStatus::Active) {
            return;
        }
        if (empty($newTopicIds)) {
            foreach ($this->ApplicationTopics as $applicationTopic) {
                $applicationTopic->delete();
            }
            return;
        }

        $applicationTopicIds = array();
        foreach ($this->ApplicationTopics as $topic) {
            $applicationTopicIds[] = $topic->TopicID;
        }


        foreach ($newTopicIds as $newTopicId) {
            foreach ($this->ApplicationTopics as $applicationTopic) {
                if (!in_array($applicationTopic->TopicID, $newTopicIds)) {
                    $applicationTopic->delete();
                }
            }
            if (!in_array($newTopicId, $applicationTopicIds)) {
                $applicationTopic = new ApplicationTopic();
                $applicationTopic->ApplicationID = $this->ApplicationID;
                $applicationTopic->TopicID = $newTopicId;
                $applicationTopic->save();
            }
        }

    }

    public function handleCkPem($sourceFileNameFull)
    {
        if (File::exists($sourceFileNameFull)) {

            $targetFilePath = 'files/customer_' . $this->CustomerID . '/application_' . $this->ApplicationID;
            $targetRealPath = public_path() . $targetFilePath;
            $targetFileNameFull = $targetRealPath . '/' . $this->CkPem;

            if (!File::exists($targetRealPath)) {
                File::makeDirectory($targetRealPath);
            }

            File::move($sourceFileNameFull, $targetFileNameFull);
        }
    }

}