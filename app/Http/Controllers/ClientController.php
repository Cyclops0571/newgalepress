<?php

namespace App\Http\Controllers;

use App\Library\AjaxResponse;
use App\Library\MyResponse;
use App\Library\UploadHandler;
use App\Mail\ClientPasswordChangedMailler;
use App\Mail\ClientPasswordResetMailler;
use App\Mail\ClientRegisteredMailler;
use App\Models\Application;
use App\Models\Client;
use App\User;
use Auth;
use Common;
use DateTime;
use DB;
use eStatus;
use Illuminate\Http\Request;
use Redirect;
use Response;
use URL;
use Validator;

class ClientController extends Controller {


    public $restful = true;
    public $page = '';
    public $route = '';
    public $table = '';
    public $pk = '';
    public $caption = '';
    public $detailcaption = '';
    public $fields;

    public function __construct()
    {
        $this->page = 'clients';
        $this->route = route('clients_list');
        $this->table = 'Client';
        $this->pk = 'ClientID';
        $this->caption = __('common.clients_caption');
        $this->detailcaption = __('common.clients_caption_detail');

        $this->fields = [
            0 => ['35px', __('common.clients_list_column1'), ''],
            1 => ['75px', __('common.clients_list_column2'), 'Username'],
            2 => ['75px', __('common.clients_list_column3'), 'Name'],
            3 => ['75px', __('common.clients_list_column4'), 'Surname'],
            4 => ['100px', __('common.clients_list_column5'), 'Email'],
            5 => ['75px', __('common.clients_list_column6'), 'ApplicationID'],
            6 => ['100px', __('common.clients_list_column7'), 'LastLoginDate'],
            7 => ['25px', __('common.clients_list_column8'), 'ClientID'],
        ];
    }

    public function index(Request $request)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $applications = $currentUser->Application();
        $search = $request->get('search', '');
        $sort = $request->get('sort', $this->pk);
        $sort_dir = $request->get('sort_dir', 'DESC');

        $data = [
            'route'        => route('clients_list'),
            'caption'      => $this->caption,
            'pk'           => $this->pk,
            'fields'       => $this->fields,
            'search'       => $search,
            'sort'         => $sort,
            'sort_dir'     => $sort_dir,
            'rows'         => Client::clientList($request),
            'applications' => $applications,
        ];


        return view('clients.clientlist', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selectableContents = null;
        /* @var $currentUser User */
        $currentUser = Auth::user();
        $applications = $currentUser->Applications;
        foreach ($applications as $app)
        {
            $tmpContents = $app->Contents;
            foreach ($tmpContents as $tmp)
            {
                $selectableContents[] = $tmp;
            }
        }

        $data = [];
        $data['page'] = $this->page;
        $data['route'] = $this->route;
        $data['caption'] = $this->caption;
        $data['detailcaption'] = $this->detailcaption;
        $data['applications'] = $applications;
        $data['contents'] = [];
        $data['selectableContents'] = $selectableContents;

        return view('clients.clientdetail', $data);
    }

    public function show(Client $client)
    {
        $selectableContents = null;
        /* @var $currentUser User */
        $currentUser = Auth::user();

        $applications = $currentUser->Applications;
        foreach ($applications as $app)
        {
            $tmpContents = $app->Contents;
            foreach ($tmpContents as $tmp)
            {
                $selectableContents[] = $tmp;
            }
        }

        $contents = $client->Contents();
        foreach ($selectableContents as $key => $selectableContent)
        {
            foreach ($contents as $content)
            {
                if ($selectableContent->ContentID == $content->ContentID)
                {
                    unset($selectableContents[$key]);
                }
            }
        }

        $data = [];
        $data['page'] = $this->page;
        $data['route'] = $this->route;
        $data['caption'] = $this->caption;
        $data['detailcaption'] = $this->detailcaption;
        $data['row'] = $client;
        $data['applications'] = $applications;
        $data['contents'] = $contents;
        $data['selectableContents'] = $selectableContents;
        return view('clients.clientdetail', $data);
    }

    public function delete(Request $request, MyResponse $myResponse)
    {
        $currentUser = Auth::user();
        $id = $request->get($this->pk, '0');

        $s = Client::find($id);
        if (!$s)
        {
            return $myResponse->error(trans('common.detailpage_validation'));
        }

        /* @var $applications Application[] */
        $applications = $currentUser->Applications;
        $appIDSet = [];
        foreach ($applications as $application)
        {
            $appIDSet[] = $application->ApplicationID;
        }

        if (!in_array($s->ApplicationID, $appIDSet))
        {
            return $myResponse->error(trans('common.detailpage_unauthorized_attempt'));
        }

        $s->StatusID = eStatus::Deleted;
        $s->save();

        return $myResponse->success();
    }

    public function save(Request $request, MyResponse $myResponse)
    {
        /* @var $currentUser User */
        $currentUser = Auth::user();
        /* @var $applications Application[] */
        $applications = $currentUser->Application();
        $appIDSet = [];
        foreach ($applications as $application)
        {
            $appIDSet[] = $application->ApplicationID;
        }

        $clientID = $request->get($this->pk, '0');
        $password = $request->get('Password');
        $username = trim($request->get('Username'));
        $applicationID = $request->get('ApplicationID');
        $email = $request->get('Email');
        $contentIDSet = $request->get("contentIDSet", []);

        $rules = [
            'Username'  => 'required|min:2',
            'FirstName' => 'required',
            'LastName'  => 'required',
            'Email'     => 'required|email',
        ];

        if ($clientID == 0)
        {
            $rules['Password'] = 'required|min:2';
            $clientSameUsername = Client::where('ApplicationID', $applicationID)->where('Username', $username)->first();
            $clientSameEmail = Client::where('ApplicationID', $applicationID)->where('Email', $email)->first();
            if ($clientSameUsername)
            {
                return $myResponse->error(trans('clients.username_must_be_unique'));
            } else if ($clientSameEmail)
            {
                return $myResponse->error(trans('clients.email_must_be_unique'));
            }
            $client = new Client();
            $client->Token = $username . "_" . md5(uniqid());
        } else
        {
            $client = Client::find($clientID);
            if (!$client)
            {
                return $myResponse->error(trans('clients.user_not_found'));
            }

            $clientSameUsername = Client::where('ApplicationID', $applicationID)
                ->where('Username', $username)
                ->where('ClientID', "!=", $client->ClientID)->first();
            $clientSameEmail = Client::where('ApplicationID', $applicationID)
                ->where('Email', $email)
                ->where('ClientID', "!=", $client->ClientID)->first();
            if ($clientSameUsername)
            {
                return $myResponse->error(trans('clients.username_must_be_unique'));
            } else if ($clientSameEmail)
            {
                return $myResponse->error(trans('clients.email_must_be_unique'));
            }
        }

        $v = Validator::make($request->all(), $rules);
        if ($v->fails())
        {
            return ajaxResponse::error($v->errors()->first());
        }

        $client->Username = $username;
        $client->Email = $email;
        $client->ApplicationID = $applicationID;

        if (strlen(trim($password)) > 0)
        {
            $client->Password = md5($password);
        }

        $client->Name = $request->get('FirstName');
        $client->Surname = $request->get('LastName');
        if ($clientID == 0)
        {
            $client->StatusID = eStatus::Active;
            $client->CreatorUserID = $currentUser->UserID;
        }

        if (count($appIDSet) == 1)
        {
            $client->ApplicationID = $appIDSet[0];
        } else if (!in_array($client->ApplicationID, $appIDSet))
        {
            return $myResponse->error(trans('common.detailpage_unauthorized_attempt'));
        }

        $selecteableContentIDSet = [];
        foreach ($applications as $application)
        {
            $contents = $application->Contents;
            foreach ($contents as $content)
            {
                $selecteableContentIDSet[] = $content->ContentID;
            }
        }
        foreach ($contentIDSet as $key => $contentID)
        {
            if (!in_array($contentID, $selecteableContentIDSet))
            {
                unset($contentIDSet[$key]);
            }
        }

        $contentIDSet = array_unique($contentIDSet);
        sort($contentIDSet);
        $client->ContentIDSet = implode(",", $contentIDSet);
        $client->save();

        return $myResponse->success(['id' => $client->ClientID]);
    }

    public function excelupload(Request $request)
    {
        $selectableContentIDSet = null;
        $responseMsg = "";
        $status = "Failed";
        /* @var $user User */
        $user = Auth::user();
        $applications = $user->Application();
        $appIDSet = [];
        foreach ($applications as $application)
        {
            $appIDSet[] = $application->ApplicationID;
        }
        ob_start();
        $element = $request->get('element');
        $options = [
            'upload_dir'        => public_path('files/temp/'),
            'upload_url'        => URL::to('/files/temp/'),
            'param_name'        => $element,
            'accept_file_types' => '/\.(xls)$/i',
        ];
        $upload_handler = new UploadHandler($options);

        if (!Request::ajax())
        {
            return Response::error('404');
        }


        $upload_handler->post(false);

        $ob = ob_get_contents();
        ob_end_clean();
        $object = json_decode($ob);
        $filePath = public_path('files/temp/' . $object->File[0]->name);

        include_once app_path("libraries/excel_reader2.php");
        error_reporting(E_ALL ^ E_NOTICE);
        $data = new Spreadsheet_Excel_Reader($filePath);
        $rowCount = $data->rowcount();
        $columnCount = $data->colcount();

        if ($rowCount < 2)
        {
            $responseMsg = trans('error.invalid_excel_file_two_rows');
        } else if ($columnCount != 8)
        {
            $responseMsg = trans('clients.invalid_excel_file_seven_columns');
        } else
        {
            $addedUserCount = 0;
            $updatedUserCount = 0;
            for ($row = 2; $row <= $rowCount; $row++)
            {
                $colNo = 1;
                $applicationID = (int)$data->val($row, $colNo++);
                $username = $data->val($row, $colNo++);
                $password = $data->val($row, $colNo++);
                $email = $data->val($row, $colNo++);
                $name = $data->val($row, $colNo++);
                $surname = $data->val($row, $colNo++);
                $paidUntil = date("Y-m-d", strtotime($data->val($row, $colNo++)));
                $contentIDSetNew = explode(",", $data->val($row, $colNo));
                if ($applicationID <= 0)
                {
                    continue;
                }

                if (!in_array($applicationID, $appIDSet))
                {
                    $responseMsg .= trans('clients.invalid_application_id_at_row') . $row;
                    break;
                }

                /* @var $client Client */
                $clientSameUsername = Client::where('ApplicationID', $applicationID)->where('Username', $username)->first();
                $clientSameEmail = Client::where('ApplicationID', $applicationID)->where('Email', $email)->first();
                if ($clientSameUsername)
                {
                    //user exists same
                    $client = $clientSameUsername;
                    $client->Name = $name;
                    $client->Surname = $surname;
                    $client->PaidUntil = $paidUntil;
                    $updatedUserCount++;
                } else if ($clientSameEmail)
                {
                    $client = $clientSameEmail;
                    $client->Name = $name;
                    $client->Surname = $surname;
                    $client->PaidUntil = $paidUntil;
                    $updatedUserCount++;
                } else
                {
                    $client = new Client();
                    $client->ApplicationID = $applicationID;
                    $client->Username = $username;
                    $client->Token = $client->Username . "_" . md5(uniqid());
                    $client->Password = md5($password);
                    $client->Email = $email;
                    $client->Name = $name;
                    $client->Surname = $surname;
                    $client->PaidUntil = $paidUntil;
                    $client->StatusID = eStatus::Active;
                    $client->CreatorUserID = $user->UserID;
                    $addedUserCount++;
                }

                //Uygulama sahibi bu contentID ye yetkilendirme yapabilir mi diye bakmiyorum su anda ama bakmaliyim...
                if (!empty($contentIDSetNew))
                {
                    $contentIDSet = explode(",", $client->ContentIDSet);
                    $mergedContentIDSet = array_merge($contentIDSet, $contentIDSetNew);
                    $uniqueContentIDSet = array_unique($mergedContentIDSet);
                    sort($uniqueContentIDSet);
                    $filteredContentIDSet = array_filter($uniqueContentIDSet);
                    if (count($filteredContentIDSet) != $contentIDSet)
                    {
                        if ($selectableContentIDSet == null)
                        {
                            $selectableContentIDSet = [];
                            foreach ($applications as $application)
                            {
                                $contents = $application->Contents();
                                foreach ($contents as $content)
                                {
                                    $selectableContentIDSet[] = $content->ContentID;
                                }
                            }
                        }
                        //yeni eklenilenler var
                        foreach ($filteredContentIDSet as $key => $contentID)
                        {
                            if (!in_array($contentID, $selectableContentIDSet))
                            {
                                unset($filteredContentIDSet[$key]);
                            }
                        }
                    }
                    $client->ContentIDSet = implode(",", $filteredContentIDSet);
                }
                $client->save();
            }

            $responseMsg .= trans('clients.inserted_mobile_user_count') . $addedUserCount
                . " " . trans('clients.updated_mobile_user_count') . $updatedUserCount;
            $status = 'success';
        }

        $json = get_object_vars($object);
        $arr = $json[$element];
        $obj = $arr[0];
        $obj->responseMsg = (string)$responseMsg;
        $obj->status = $status;

        return Response::json($obj);
    }

}
