<?php

namespace App\Http\Controllers;

use App\Library\MyResponse;
use App\Mail\ClientPasswordChangedMailler;
use App\Mail\ResetPasswordMailler;
use App\Mail\SendPasswordMailler;
use App\Models\Customer;
use App\Models\GroupCode;
use App\User;
use Auth;
use Common;
use DateTime;
use DB;
use eProcessTypes;
use eStatus;
use Hash;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller {


    public $page = '';
    public $route = '';
    public $table = '';
    public $pk = '';
    public $caption = '';
    public $detailcaption = '';
    public $fields;

    public function __construct()
    {
        $this->page = 'users';
        $this->route = __('route.' . $this->page);
        $this->table = 'User';
        $this->pk = 'UserID';
        $this->caption = __('common.users_caption');
        $this->detailcaption = __('common.users_caption_detail');
        $this->fields = [
            0 => [__('common.users_list_column2'), 'UserTypeName'],
            1 => [__('common.users_list_column3'), 'FirstName'],
            2 => [__('common.users_list_column4'), 'LastName'],
            3 => [__('common.users_list_column5'), 'Email'],
            4 => [__('common.users_list_column6'), 'UserID'],
        ];
    }

    public function index(Request $request)
    {
        $customerID = (int)$request->get('customerID', 0);
        $search = $request->get('search', '');
        $sort = $request->get('sort', $this->pk);
        $sortDirectory = $request->get('sort_dir', 'DESC');

        $rows = User::userList($customerID, $search, $sort, $sortDirectory);

        $data = [
            'page'     => $this->page,
            'route'    => $this->route,
            'caption'  => $this->caption,
            'pk'       => $this->pk,
            'fields'   => $this->fields,
            'search'   => $search,
            'sort'     => $sort,
            'sort_dir' => $sortDirectory,
            'rows'     => $rows,
        ];

        return view('pages.userlist', $data);
    }

    public function create()
    {

        $data = [
            'page'          => $this->page,
            'route'         => $this->route,
            'caption'       => $this->caption,
            'detailcaption' => $this->detailcaption,
            'groupcodes' => GroupCode::getGroupCodesWithName('UserTypes'),
            'customers' => Customer::orderBy('CustomerName')->get(),
            'timezones' => DB::table('Timezone')->orderBy('TimezoneID', 'ASC')->get(),
        ];

        return view('pages.userdetail', $data);
    }

    public function show(User $user)
    {
        $data = [
            'page'          => $this->page,
            'route'         => $this->route,
            'caption'       => $this->caption,
            'detailcaption' => $this->detailcaption,
            'row'           => $user,
            'groupcodes' => GroupCode::getGroupCodesWithName('UserTypes'),
            'customers' => Customer::orderBy('CustomerName')->get(),
            'timezones' => DB::table('Timezone')->orderBy('TimezoneID', 'ASC')->get(),
        ];

        return view('pages.userdetail', $data);
    }


    //POST
    public function save(Request $request, MyResponse $myResponse)
    {
        $currentUser = Auth::user();

        $id = (int)$request->get($this->pk, '0');

        $rules = [
            'UserTypeID' => 'required',
            'Username'   => 'required',
            //'Password'  => 'required_with:UserID|min:6|max:12',
            'FirstName'  => 'required',
            'LastName'   => 'required',
            'Email'      => 'required|email',
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails())
        {
            return $myResponse->error(trans('common.detailpage_validation'));
        }


        $password = $request->get('Password');

        if ($id == 0)
        {
            $s = new User();
        } else
        {
            $s = User::find($id);
        }
        $s->UserTypeID = (int)$request->get('UserTypeID');
        $s->CustomerID = (int)$request->get('CustomerID');
        $s->Username = $request->get('Username');
        if (strlen(trim($password)) > 0)
        {
            $s->Password = Hash::make($password);
        }
        $s->FirstName = $request->get('FirstName');
        $s->LastName = $request->get('LastName');
        $s->Email = $request->get('Email');
        $s->Timezone = $request->get('Timezone');
        if ($id == 0)
        {
            $s->StatusID = eStatus::Active;
            $s->CreatorUserID = $currentUser->UserID;
            $s->DateCreated = new DateTime();
        }
        $s->ProcessUserID = $currentUser->UserID;
        $s->ProcessDate = new DateTime();
        if ($id == 0)
        {
            $s->ProcessTypeID = eProcessTypes::Insert;
        } else
        {
            $s->ProcessTypeID = eProcessTypes::Update;
        }
        $s->save();

        return $myResponse->success();

    }

    /**
     * Send new password to user who forgets it
     */
    public function send(Request $request, MyResponse $myResponse)
    {
        $currentUser = Auth::user();

        $id = $request->get($this->pk, 0);

        $s = User::find($id);
        if ($s)
        {
            $pass = Common::generatePassword();

            $s->Password = Hash::make($pass);
            $s->ProcessUserID = $currentUser->UserID;
            $s->ProcessDate = new DateTime();
            $s->ProcessTypeID = eProcessTypes::Update;
            $s->save();

            \Mail::queue(new SendPasswordMailler($s, $pass));
        }

        return $myResponse->success();
    }

    /**
     * Makes StatusID eStatus::Deleted from user
     * @param Request $request
     * @param MyResponse $myResponse
     * @return string
     */
    public function delete(Request $request, MyResponse $myResponse)
    {
        $id = $request->get($this->pk, '0');

        $user = User::find($id);
        if (!$user->exists())
        {
            return $myResponse->error(trans('error.something_went_wrong'));
        }

        $user->StatusID = eStatus::Deleted;
        $user->save();

        return $myResponse->success();
    }


}
