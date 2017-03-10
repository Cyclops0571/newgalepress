<?php

namespace App\Http\Controllers;

use App\Library\MyResponse;
use App\Models\Application;
use App\Models\Customer;
use App\Models\Package;
use App\Models\PushNotification;
use App\Models\PushNotificationDevice;
use App\Models\Token;
use App\Models\Topic;
use Auth;
use Common;
use DateTime;
use DB;
use eProcessTypes;
use eStatus;
use eUserTypes;
use Exception;
use File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Subscription;
use UploadHandler;
use URL;
use Validator;

class ApplicationController extends Controller
{

    public $page = '';
    public $route = '';
    public $table = '';
    public $pk = '';
    public $caption = '';
    public $detailCaption = '';
    public $fields;

    public function __construct()
    {
        $this->page = 'applications';

        $this->route = __('route.' . $this->page);
        $this->table = 'Application';
        $this->pk = 'ApplicationID';
        $this->caption = __('common.applications_caption');
        $this->detailCaption = __('common.applications_caption_detail');
        $this->fields = array(
            0 => array('35px', __('common.applications_list_column1'), ''),
            1 => array('55px', __('common.applications_list_column2'), 'ContentCount'),
            2 => array('175px', __('common.applications_list_column3'), 'CustomerName'),
            3 => array('', __('common.applications_list_column4'), 'Name'),
            4 => array('155px', __('common.applications_list_column5'), 'ApplicationStatusName'),
            5 => array('75px', __('common.applications_list_column6'), 'PackageName'),
            6 => array('75px', __('common.applications_list_column7'), 'Blocked'),
            7 => array('100px', __('common.applications_list_column8'), 'Status'),
            8 => array('100px', __('common.applications_trail_title'), 'Trail'),
            9 => array('90px', __('common.applications_list_column9'), 'ExpirationDate'),
            10 => array('75px', __('common.applications_list_column10'), 'ApplicationID'),
            11 => array('75px', __('common.applications_list_column11'), 'IsExpired')
        );
    }

    public function index(Request $request)
    {
        $currentUser = Auth::user();

        if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
            try {
                $customerID = (int)$request->get('customerID', 0);
                $search = $request->get('search', '');
                $sort = $request->get('sort', $this->pk);
                $sort_dir = $request->get('sort_dir', 'DESC');
                $option = (int)$request->get('option', 0);

                $sql = '' .
                    'SELECT ' .
                    '(SELECT COUNT(*) FROM `Content` WHERE ApplicationID=a.ApplicationID AND StatusID=1) AS ContentCount, ' .
                    'c.CustomerID, ' .
                    'c.CustomerName, ' .
                    'a.Name, ' .
                    'IFNULL((SELECT DisplayName FROM `GroupCodeLanguage` WHERE GroupCodeID=a.ApplicationStatusID AND LanguageID=' . Common::getLocaleId() . '), \'\') AS ApplicationStatusName, ' .
                    'IFNULL((SELECT Name FROM `Package` WHERE PackageID=a.PackageID), \'\') AS PackageName, ' .
                    '(CASE a.Blocked WHEN 1 THEN \'' . __('common.applications_list_blocked1') . '\' ELSE \'' . __('common.applications_list_blocked0') . '\' END) AS Blocked, ' .
                    '(CASE a.Status WHEN 1 THEN \'' . __('common.applications_list_status1') . '\' ELSE \'' . __('common.applications_list_status0') . '\' END) AS Status, ' .
                    '(CASE a.Trail WHEN 2 THEN \'' . __('common.applications_trail_customer') . '\' ELSE \'' . __('common.applications_trail_demo') . '\' END) AS Trail, ' .
                    '(CASE WHEN a.ExpirationDate < NOW() THEN \'' . __('common.applications_isexpired_yes') . '\' ELSE \'' . __('common.applications_isexpired_no') . '\' END) AS IsExpired, ' .
                    'a.ExpirationDate, ' .
                    'a.ApplicationID ' .
                    'FROM `Customer` AS c ' .
                    'INNER JOIN `Application` AS a ON a.CustomerID=c.CustomerID AND a.StatusID=1 ' .
                    'WHERE c.StatusID=1';

                $rs = DB::table(DB::raw('(' . $sql . ') t'))
                    ->where(function (Builder $query) use ($customerID, $search) {
                        if ($customerID > 0) {
                            $query->where('CustomerID', '=', $customerID);
                        }

                        if (strlen(trim($search)) > 0) {
                            $query->where('ContentCount', 'LIKE', '%' . $search . '%');
                            $query->orWhere('CustomerName', 'LIKE', '%' . $search . '%');
                            $query->orWhere('Name', 'LIKE', '%' . $search . '%');
                            $query->orWhere('ApplicationStatusName', 'LIKE', '%' . $search . '%');
                            $query->orWhere('PackageName', 'LIKE', '%' . $search . '%');
                            $query->orWhere('Blocked', 'LIKE', '%' . $search . '%');
                            $query->orWhere('Status', 'LIKE', '%' . $search . '%');
                            $query->orWhere('ApplicationID', 'LIKE', '%' . $search . '%');
                        }
                    })
                    ->orderBy($sort, $sort_dir);

                if ($option == 1) {
                    $data = array(
                        'rows' => $rs->get()
                    );
                    return view('pages.applicationoptionlist', $data);
                }

//                $count = $rs->count();
//                $results = $rs->paginate($rowcount);
//                forPage($p, $rowcount)->paginate($rowcount);
//                $rows = Paginator::make($results, $count, $rowcount);


                $rows = $rs->paginate(config('custom.rowcount'));

                $data = array(
                    'page' => $this->page,
                    'route' => $this->route,
                    'caption' => $this->caption,
                    'pk' => $this->pk,
                    'fields' => $this->fields,
                    'search' => $search,
                    'sort' => $sort,
                    'sort_dir' => $sort_dir,
                    'rows' => $rows
                );
                return view('pages.applicationlist', $data);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
                //				return Redirect::to(__('route.home'));
            }
        } else {
            $option = (int)$request->get('option', 0);

            if ($option == 1) {
                $data = array(
                    'rows' => $currentUser->Customer->Applications(eStatus::Active)
                );
                return view('pages.applicationoptionlist', $data);
            }
        }
        return redirect()->route('home');
    }

    public function create()
    {
        if (Auth::user()->UserTypeID != eUserTypes::Manager) {
            return redirect()->route('home');
        }

        $customers = Customer::where('StatusID', '=', eStatus::Active)
            ->orderBy('CustomerName', 'ASC')
            ->get();

        $groupcodes = DB::table('GroupCode AS gc')
            ->join('GroupCodeLanguage AS gcl', function (JoinClause $join) {
                $join->on('gcl.GroupCodeID', '=', 'gc.GroupCodeID');
                $join->on('gcl.LanguageID', '=', Common::getLocaleId());
            })
            ->where('gc.GroupName', '=', 'ApplicationStatus')
            ->where('gc.StatusID', '=', eStatus::Active)
            ->orderBy('gc.DisplayOrder', 'ASC')
            ->orderBy('gcl.DisplayName', 'ASC')
            ->get();

        $packages = Package::orderBy('PackageID', 'ASC')->get();

        $app = new Application();
        $data = array(
            'app' => $app,
            'customers' => $customers,
            'groupcodes' => $groupcodes,
            'packages' => $packages,
            'page' => $this->page,
            'route' => $this->route,
            'caption' => $this->caption,
            'detailCaption' => $this->detailCaption,
            'topics' => array(),
        );
        return view('pages.' . Str::lower($this->table) . 'detail', $data);
    }

    public function show(Application $application)
    {

        if (Auth::user()->UserTypeID != eUserTypes::Manager) {
            return redirect()->route('home');
        }

        $customers = Customer::where('StatusID', '=', eStatus::Active)
            ->orderBy('CustomerName', 'ASC')
            ->get();

        $groupcodes = DB::table('GroupCode AS gc')
            ->join('GroupCodeLanguage AS gcl', function (JoinClause $join) {
                $join->on('gcl.GroupCodeID', '=', 'gc.GroupCodeID');
                $join->on('gcl.LanguageID', '=', Common::getLocaleId());
            })
            ->where('gc.GroupName', '=', 'ApplicationStatus')
            ->where('gc.StatusID', '=', eStatus::Active)
            ->orderBy('gc.DisplayOrder', 'ASC')
            ->orderBy('gcl.DisplayName', 'ASC')
            ->get();

        $packages = Package::orderBy('PackageID', 'ASC')->get();
        $data = array(
            'app' => $application,
            'customers' => $customers,
            'groupcodes' => $groupcodes,
            'packages' => $packages,
            'page' => $this->page,
            'route' => $this->route,
            'caption' => $this->caption,
            'detailCaption' => $this->detailCaption,
            'topics' => Topic::where('StatusID', '=', eStatus::Active )->get()
        );
        return view('pages.applicationdetail', $data);

    }

    public function push(Request $request, $id)
    {
        try {
            $rules = array(
                'NotificationText' => 'required'
            );
            $v = Validator::make($request->all(), $rules);
            if ($v->fails()) {
                throw new Exception(__('common.detailpage_validation'));
            }

            $chk = Common::CheckApplicationOwnership($id);
            if (!$chk) {
                //				throw new Exception("Unauthorized user attempt");
                throw new Exception(__('error.unauthorized_user_attempt'));
            }

            $currentUser = Auth::user();
            DB::transaction(function () use ($request, $currentUser, $id) {
                $customerID = 0;
                $applicationID = 0;

                $app = DB::table('Application')->where('ApplicationID', '=', (int)$id)->first();
                if ($app) {
                    $customerID = (int)$app->CustomerID;
                    $applicationID = (int)$app->ApplicationID;
                }

                $s = new PushNotification();
                $s->CustomerID = (int)$customerID;
                $s->ApplicationID = (int)$applicationID;
                $s->NotificationText = $request->get('NotificationText');
                $s->StatusID = eStatus::Active;
                $s->CreatorUserID = $currentUser->UserID;
                $s->DateCreated = new DateTime();
                $s->ProcessUserID = $currentUser->UserID;
                $s->ProcessDate = new DateTime();
                $s->ProcessTypeID = eProcessTypes::Insert;
                $s->save();

                //Insert
                $deviceTokens = array();
                //Son geleni son alalim... onemli
                $tokens = Token::where('ApplicationID', '=', (int)$applicationID)
                    ->where("StatusID", '=', eStatus::Active)
                    ->get();
                foreach ($tokens as $token) {
                    if (!in_array($token->DeviceToken, $deviceTokens)) {
                        //save to push notification
                        $p = new PushNotificationDevice();
                        $p->PushNotificationID = $s->PushNotificationID;
                        $p->TokenID = $token->TokenID;
                        $p->UDID = $token->UDID;
                        $p->ApplicationToken = $token->ApplicationToken;
                        $p->DeviceToken = $token->DeviceToken;
                        $p->DeviceType = $token->DeviceType;
                        $p->Sent = 0;
                        $p->ErrorCount = 0;
                        $p->StatusID = eStatus::Active;
                        $p->CreatorUserID = $currentUser->UserID;
                        $p->DateCreated = new DateTime();
                        $p->ProcessUserID = $currentUser->UserID;
                        $p->ProcessDate = new DateTime();
                        $p->ProcessTypeID = eProcessTypes::Insert;
                        $p->save();
                        array_push($deviceTokens, $token->DeviceToken);
                    }
                }
            });

            // burada queueya atiyoruz
            $connection = new AMQPStreamConnection('localhost', 5672, 'galepress', 'galeprens');
            $channel = $connection->channel();
            $channel->queue_declare('queue_pushnotification', false, false, false, false);
            $msg = new AMQPMessage('Start Progress!');
            $channel->basic_publish($msg, '', 'queue_pushnotification');
            $channel->close();
            $connection->close();
        } catch (Exception $e) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }
        return "success=" . base64_encode("true");
    }

    public function save(Request $request, MyResponse $myResponse)
    {
        $currentUser = Auth::user();
        if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
            $id = (int)$request->get($this->pk, '0');

            $rules = array(
                'CustomerID' => 'required',
                'Name' => 'required',
                'ExpirationDate' => 'required',
                'PackageID' => 'required|integer',
                'ApplicationLanguage' => 'required',
            );
            $v = Validator::make($request->all(), $rules);
            if ($v->passes()) {
                //File
                $sourceFileName = $request->get('hdnCkPemName');
                $sourceFilePath = 'files/temp';
                $sourceRealPath = public_path($sourceFilePath);
                $sourceFileNameFull = $sourceRealPath . '/' . $sourceFileName;

                $targetFileName = $currentUser->UserID . '_' . date("YmdHis") . '_' . $sourceFileName;

                if (!((int)$request->get('hdnCkPemSelected', 0) == 1 && File::exists($sourceFileNameFull))) {
                    $targetFileName = $sourceFileName;
                }

                if ($id == 0) {
                    $application = new Application();
                } else {
                    $application = Application::find($id);
                }
                $application->CustomerID = (int)$request->get('CustomerID');
                $application->Name = $request->get('Name');
                $application->Detail = $request->get('Detail');
                $application->ApplicationLanguage = $request->get('ApplicationLanguage');
                $application->Price = str_replace(',', '', $request->get('Price'));
                $application->Installment = $request->get('Installment', Application::InstallmentCount);
                $application->InAppPurchaseActive = $request->get('InAppPurchaseActive', 0);
                $application->FlipboardActive = $request->get('FlipboardActive', 0);
                $application->BundleText = strtolower($request->get('BundleText'));
                $application->StartDate = new DateTime(Common::dateWrite($request->get('StartDate')));
                $application->ExpirationDate = new DateTime(Common::dateWrite($request->get('ExpirationDate')));
                $application->ApplicationStatusID = (int)$request->get('ApplicationStatusID');
                $application->IOSVersion = (int)$request->get('IOSVersion');
                $application->IOSLink = $request->get('IOSLink', '');
                $application->AndroidVersion = (int)$request->get('AndroidVersion');
                $application->AndroidLink = $request->get('AndroidLink', '');
                $application->PackageID = (int)$request->get('PackageID');
                $application->Blocked = (int)$request->get('Blocked');
                $application->Status = (int)$request->get('Status');
                $application->Trail = (int)$request->get('Trail');
                $application->NotificationText = $request->get('NotificationText');
                $application->CkPem = $targetFileName;
                $application->TopicStatus = $request->get('topicStatus', 0) === "on";
                $application->save();
                if($request->get('hdnCkPemSelected', 0)) {
                    $application->handleCkPem($sourceFileNameFull);
                }

                $application->setTopics($request->get('topicIds', array()));

                return $myResponse->success();
            } else {
                return $myResponse->error(__('common.detailpage_validation'));
            }
        }
        return $myResponse->error(__('common.detailpage_validation'));
    }

    public function delete(Request $request)
    {
        $currentUser = Auth::user();
        $id = (int)$request->get($this->pk, '0');
        $s = Application::find($id);

        if ((int)$currentUser->UserTypeID != eUserTypes::Manager || !$s) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        $s->StatusID = eStatus::Deleted;
        $s->save();
        return "success=" . base64_encode("true");
    }

    public function uploadFile(Request $request)
    {
        $element = $request->get('element');

        $options = array(
            'upload_dir' => public_path('files/temp/'),
            'upload_url' => URL::to('/files/temp/'),
            'param_name' => $element,
            'accept_file_types' => '/\.(pem)$/i'
        );
        $upload_handler = new UploadHandler($options);

        if (!$request->ajax())
            return;

        $upload_handler->post(false);
    }


    public function refresh_identifier(Request $request, MyResponse $myResponse)
    {
        $max = 1;
        foreach (Subscription::types() as $key => $value) {
            if ($key > $max) {
                $max = $key;
            }
        }

        $rules = array(
            "ApplicationID" => "required|numeric|min:1",
            "SubscrioptionType" => "required|numeric|min:1|max:" . $max,
        );
        $v = Validator::make($request->all(), $rules);
        if (!$v->passes()) {
          return $myResponse->error($v->errors->first());
        }

        $application = Application::find($request->get("ApplicationID"));
        $subscriptionIdentifier = $application->SubscriptionIdentifier($request->get("SubscrioptionType"), TRUE);
        $application->save();
        return $myResponse->success(['SubscriptionIdentifier' => $subscriptionIdentifier]);
    }
}
