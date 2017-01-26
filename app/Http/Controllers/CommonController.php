<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Customer;
use App\User;
use Auth;
use DB;
use eStatus;
use eUserTypes;
use Hash;
use Illuminate\Http\Request;
use Redirect;

class CommonController extends Controller
{

    //login
    public function showMyLoginForm()
    {
        if (Auth::check()) {
            return Redirect::to(__('route.home'));
        } else {
            return view('pages.login');
        }
    }

    public function login(Request $request)
    {
        $username = $request->get('Username', '');
        $password = $request->get('Password', '');
        $remember = $request->get('Remember', '');
        $localDate = date("Y-m-d H:i:s", $request->get('LocalTime', time()));

        $validUser = false;
        $activeApps = false;

        $user = User::getByUsername($username);

        if ($user) {
            if (Hash::check($password, $user->Password)) {

                if ((int)$user->UserTypeID == (int)eUserTypes::Customer) {
                    DB::enableQueryLog();
                    $customer = Customer::getCustomerByID($user->CustomerID, eStatus::Active);
                    if ($customer) {
                        $validUser = true;
                        $activeApps = Application::getActiveAppCountByCustomerID($customer->CustomerID);
                    }
                } else if ((int)$user->UserTypeID == (int)eUserTypes::Manager) {
                    $validUser = true;
                    $activeApps = true;
                }
            }
        }

        if (!$validUser) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_error'));
        }

        if (!$activeApps) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_error_expiration'));
        }

        //Kullanici aktif & Musteriyse (musteri aktif & aktif uygulamaya sahip)

        if (Auth::attempt(array('username' => $username, 'password' => $password, 'StatusID' => eStatus::Active))) {
            //once biz kontrol ettik simdi laravele diyoruz ki git kontrol et bilgileri tekrardan duzgun kullaniciyi login et - salaklik 572572
            $user = Auth::user();
            $s = new Sessionn;
            $s->UserID = $user->UserID;
            $s->IP = $request->ip(); //getenv("REMOTE_ADDR");
            $s->Session = Session::instance()->session['id'];
            $s->LoginDate = new DateTime();
            $s->LocalLoginDate = $localDate;
            $s->save();

            if ($remember == "on") {
                Cookie::forever('DSCATALOG_USERNAME', $user->Username);
            } else {
                Cookie::forever('DSCATALOG_USERNAME', '');
            }

            setcookie("loggedin", "true", time() + Config::get('session.lifetime') * 60, "/");
            return "success=" . base64_encode("true") . "&msg=" . base64_encode(__('common.login_success_redirect'));
        } else {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_error'));
        }
    }

    //forgotmypassword
    public function get_forgotmypassword()
    {
        return View::make('pages.forgotmypassword');
    }

    public function post_forgotmypassword()
    {
        $email = $request->get('Email');
        $rules = array(
            'Email' => 'required|email'
        );
        $v = Validator::make(Input::all(), $rules);
        if ($v->passes()) {
            /** @var User $user */
            $user = User::where('Email', '=', $email)
                ->where('StatusID', '=', 1)
                ->first();
            if ($user) {
                $pass = Common::generatePassword();
                /** @var User $s */
                $user->PWRecoveryCode = $pass;
                $user->PWRecoveryDate = new DateTime();
                $user->ProcessUserID = $user->UserID;
                $user->ProcessDate = new DateTime();
                $user->ProcessTypeID = eProcessTypes::Update;
                $user->save();

                $applications = $user->Application();
                $subject = __('common.login_email_subject');
                $msg = __('common.login_email_message', array(
                        'Application' => $applications[0]->Name,
                        'firstname' => $user->FirstName,
                        'lastname' => $user->LastName,
                        'username' => $user->Username,
                        'url' => Config::get('custom.url') . "/" . Config::get('application.language') . '/' . __('route.resetmypassword') . '?email=' . $user->Email . '&code=' . $pass
                    )
                );

                Common::sendEmail($user->Email, $user->FirstName . ' ' . $user->LastName, $subject, $msg);

                return "success=" . base64_encode("true") . "&msg=" . base64_encode(__('common.login_emailsent'));
            } else {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_emailnotfound'));
            }
        } else {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }
    }

    //resetmypassword
    public function get_resetmypassword()
    {
        $email = $request->get('email');
        $code = $request->get('code');

        $user = DB::table('User')
            ->where('Email', '=', $email)
            ->where('PWRecoveryCode', '=', $code)
            ->where('PWRecoveryDate', '>', DB::raw('ADDDATE(CURDATE(), INTERVAL -7 DAY)'))
            ->where('StatusID', '=', 1)
            ->first();

        if ($user) {
            return View::make('pages.resetmypassword');
        } else {
            return Redirect::to(__('route.login'))
                ->with('message', __('common.login_ticketnotfound'));
        }
    }

    public function post_resetmypassword()
    {
        $email = $request->get('Email');
        $code = $request->get('Code');
        $password = $request->get('Password');

        $rules = array(
            'Email' => 'required|email',
            'Code' => 'required',
            'Password' => 'required|min:4|max:12',
            'Password2' => 'required|min:4|max:12|same:Password'
        );
        $v = Validator::make(Input::all(), $rules);
        if (!$v->passes()) {
            $errMsg = $v->errors->first();
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($errMsg);
        }


        $user = DB::table('User')
            ->where('Email', '=', $email)
            ->where('PWRecoveryCode', '=', $code)
            ->where('PWRecoveryDate', '>', DB::raw('ADDDATE(CURDATE(), INTERVAL -7 DAY)'))
            ->where('StatusID', '=', 1)
            ->first();

        if ($user) {
            $s = User::find($user->UserID);
            $s->Password = Hash::make($password);
            $s->ProcessUserID = $user->UserID;
            $s->ProcessDate = new DateTime();
            $s->ProcessTypeID = eProcessTypes::Update;
            $s->save();

            return "success=" . base64_encode("true") . "&msg=" . base64_encode(__('common.login_passwordhasbeenchanged'));
        } else {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_ticketnotfound'));
        }
    }

    public function get_logout()
    {
        if (Auth::check()) {
            $user = Auth::user();

            $sessionID = DB::table('Session')
                ->where('UserID', '=', $user->UserID)
                ->where('Session', '=', Session::instance()->session['id'])
                ->max('SessionID');

            if ((int)$sessionID > 0) {
                $s = Sessionn::find($sessionID);
                $s->LogoutDate = new DateTime();
                $s->ProcessUserID = $user->UserID;
                $s->ProcessDate = new DateTime();
                $s->ProcessTypeID = eProcessTypes::Update;
                $s->save();
            }
            Auth::logout();
        }

        setcookie("loggedin", "false", time(), "/");

        return Redirect::to(__('route.login'))
            ->with('message', __('common.login_succesfullyloggedout'));
    }

    //home
    public function get_home()
    {
        if ((int)Auth::user()->UserTypeID == eUserTypes::Manager) {
            return View::make('pages.homeadmin');
        }

        $applications = DB::table('Application')
            ->where('CustomerID', '=', Auth::user()->CustomerID)
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('Name', 'ASC')
            ->get();

        //parametrik olacak
        $customerID = (int)Auth::user()->CustomerID;
        $applicationID = (int)$request->get('ddlApplication', '0');
        if ($applicationID == 0) {
            foreach ($applications as $app) {
                $applicationID = (int)$app->ApplicationID;
                break;
            }
        } else if (!Common::CheckApplicationOwnership($applicationID)) {
            return;
        }
        $contentID = (int)$request->get('ddlContent', '0');
        $date = Common::dateWrite($request->get('date', date("d.m.Y")), false);

        $appDetail = Application::where('ApplicationID', '=', $applicationID)->first();
        $arrApp = array();
        foreach ($applications as $app) {
            array_push($arrApp, (int)$app->ApplicationID);
        }
        $contentCount = DB::table('Content')->where_in('ApplicationID', $arrApp)->where('StatusID', '=', eStatus::Active)->count();

        //indirilme raporu son hafta
        $w = array_fill(1, 7, '0');
        $downloadMaxData = 0;
        $downloadTotalData = 0;
        $downloadTodayTotalData = 0;
        $downloadMonthTotalData = 0;
        $sql = File::get(path('app') . ReportFilter::SqlFolder . 'Dashboard1.sql');
        $sql = str_replace('{DATE}', $date, $sql);
        $sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? '' . $customerID : 'null'), $sql);
        $sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? '' . $applicationID : 'null'), $sql);
        $sql = str_replace('{CONTENTID}', ($contentID > 0 ? '' . $contentID : 'null'), $sql);
        $downloadStatistics = DB::table(DB::raw('(' . $sql . ') t'))->get();

        foreach ($downloadStatistics as $d) {
            if ((int)$d->indx == 199) {
                //Today
                $downloadTodayTotalData = (int)$d->DownloadCount;
            } elseif ((int)$d->indx == 299) {
                //Month
                $downloadMonthTotalData = (int)$d->DownloadCount;
            } else {
                //Selected week
                $w[$d->indx] = $d->DownloadCount;
                $downloadTotalData = $downloadTotalData + (int)$d->DownloadCount;

                if ($downloadMaxData < (int)$d->DownloadCount) {
                    $downloadMaxData = $d->DownloadCount;
                }
            }
        }

        $columns = array();
        for ($i = 0; $i < 7; $i++) {
            $add_day = strtotime($date . " - $i days");
            $columns[$i] = date('d', $add_day) . ' ' . Common::monthName((int)date('m', $add_day));
        }

        //indirilme raporu son 5 ay
        $sql = File::get(path('app') . ReportFilter::SqlFolder . 'Dashboard2.sql');
        $sql = str_replace('{DATE}', $date, $sql);
        $sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? '' . $customerID : 'null'), $sql);
        $sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? '' . $applicationID : 'null'), $sql);
        $sql = str_replace('{CONTENTID}', ($contentID > 0 ? '' . $contentID : 'null'), $sql);
        $previousMonths = DB::table(DB::raw('(' . $sql . ') t'))->get();
        $previousMonthsMaxData = 0;
        foreach ($previousMonths as $d) {
            if ($previousMonthsMaxData < (int)$d->DownloadCount) {
                $previousMonthsMaxData = $d->DownloadCount;
            }
        }

        //cihaz son 5 ay
        $sql = File::get(path('app') . ReportFilter::SqlFolder . 'Dashboard3.sql');
        $sql = str_replace('{DATE}', $date, $sql);
        $sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? '' . $customerID : 'null'), $sql);
        $sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? '' . $applicationID : 'null'), $sql);
        $sql = str_replace('{CONTENTID}', ($contentID > 0 ? '' . $contentID : 'null'), $sql);
        $devices = DB::table(DB::raw('(' . $sql . ') t'))->get();
        //return var_dump($devices);

        $iosTotalDownload = 0;
        $androidTotalDownload = 0;

        $ios = array_fill(1, 5, '0');
        $android = array_fill(1, 5, '0');
        foreach ($devices as $d) {
            if ($d->Device == 'iOS') {
                $ios[$d->indx] = $d->DownloadCount;
                $iosTotalDownload = $iosTotalDownload + (int)$d->DownloadCount;
            } else if ($d->Device == 'Android') {
                $android[$d->indx] = $d->DownloadCount;
                $androidTotalDownload = $androidTotalDownload + (int)$d->DownloadCount;
            }
        }
        $ios = array_reverse($ios);
        $android = array_reverse($android);

        $deviceColumns = array();
        foreach ($previousMonths as $month) {
            array_push($deviceColumns, Common::monthName($month->Month) . " " . $month->Year);
        }

        $data = array(
            'customerID' => $customerID,
            'applicationID' => $applicationID,
            'contentID' => $contentID,
            'date' => $date,
            'appDetail' => $appDetail,
            'applications' => $applications,
            'applicationCount' => count($applications),
            'contentCount' => $contentCount,
            'downloadStatistics' => implode('-', $w),
            'downloadMaxData' => $downloadMaxData,
            'downloadTotalData' => $downloadTotalData,
            'downloadTodayTotalData' => $downloadTodayTotalData,
            'downloadMonthTotalData' => $downloadMonthTotalData,
            'columns' => implode('-', $columns),
            'previousMonths' => $previousMonths,
            'previousMonthsMaxData' => $previousMonthsMaxData,
            'iosTotalDownload' => $iosTotalDownload,
            'androidTotalDownload' => $androidTotalDownload,
            'iosDeviceDownload' => implode('-', $ios),
            'androidDeviceDownload' => implode('-', $android),
            'deviceColumns' => implode('-', $deviceColumns)
        );
        return View::make('pages.home', $data);
    }

    //mydetail
    public function get_mydetail()
    {
        $data = array(
            'page' => __('route.mydetail'),
            'caption' => __('common.mydetail')
        );
        return View::make('pages.mydetail')
            ->nest('filterbar', 'sections.filterbar', $data);
    }

    public function post_mydetail()
    {
        $firstName = $request->get('FirstName');
        $lastName = $request->get('LastName');
        $email = $request->get('Email');
        $password = $request->get('Password', '');
        $timezone = $request->get('Timezone', '');

        $rules = array(
            'FirstName' => 'required',
            'LastName' => 'required',
            'Email' => 'required|email'
        );
        $v = Validator::make(Input::all(), $rules);
        if ($v->passes()) {
            /** @var User $s */
            $s = User::find(Auth::user()->UserID);
            $s->FirstName = $firstName;
            $s->LastName = $lastName;
            $s->Email = $email;
            if (strlen(trim($password)) > 0) {
                $s->Password = Hash::make($password);
            }
            $s->Timezone = $timezone;
            $s->ProcessUserID = Auth::user()->UserID;
            $s->ProcessDate = new DateTime();
            $s->ProcessTypeID = eProcessTypes::Update;
            $s->save();

            return "success=" . base64_encode("true");
        } else {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }
    }

    public function get_confirmemail()
    {
        $email = $request->get('email');
        $code = $request->get('code');

        $rules = array(
            'email' => 'required|email',
            'code' => 'required',
        );
        $v = Validator::make(Input::all(), $rules);
        if ($v->passes()) {
            $user = DB::table('User')
                ->where('Email', '=', $email)
                ->where('ConfirmCode', '=', $code)
                ->first();
            if ($user) {
                $s = User::find($user->UserID);
                $s->StatusID = eStatus::Active;
                $s->ProcessUserID = $user->UserID;
                $s->ProcessDate = new DateTime();
                $s->ProcessTypeID = eProcessTypes::Update;
                $s->save();

                // return View::make('pages.login')
                // ->with('message', "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.login_accounthasbeenconfirmed')));

                $subject = __('common.welcome_email_title');
                $mailData = array(
                    'name' => $s->FirstName,
                    'surname' => $s->LastName,
                    'url' => Config::get("custom.url") . '/' . Config::get('application.language') . __('route.login'),
                );
                $msg = View::make('mail-templates.hosgeldiniz.index')->with($mailData)->render();
                $mailStatus = Common::sendHtmlEmail($s->Email, $s->FirstName . ' ' . $s->LastName, $subject, $msg);

                $m = new MailLog();
                $m->MailID = 2; //Welcome
                $m->UserID = $s->UserID;
                if (!$mailStatus) {
                    $m->Arrived = 0;
                } else {
                    $m->Arrived = 1;
                }
                $m->StatusID = eStatus::Active;
                $m->save();

                return Redirect::to(__('route.login'))
                    ->with('confirm', __('common.login_accounthasbeenconfirmed'));

                //return "success=".base64_encode("true")."&msg=".base64_encode(__('common.login_accounthasbeenconfirmed'));
            } else {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_accountticketnotfound'));
            }
        } else {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }
    }

    public function post_facebookAttempt()
    {
        $facebookData = $request->get('formData', '');
        $faceUserObj = json_decode($facebookData);
        $accessToken = $request->get('accessToken', '');

        if (isset($faceUserObj->email)) {

            $userEmailControl = DB::table('User')
                ->where('Email', '=', $faceUserObj->email)
                ->where('StatusID', '=', eStatus::Active)
                ->or_where('FbUsername', '=', $faceUserObj->id)
                ->first();

            if ($userEmailControl) {
                $s = User::find($userEmailControl->UserID);
                $s->FbUsername = $faceUserObj->id;
                $s->FbEmail = $faceUserObj->email;
                $s->FbAccessToken = $accessToken;
                $s->PWRecoveryDate = new DateTime();
                $s->ProcessUserID = $userEmailControl->UserID;
                $s->ProcessDate = new DateTime();
                $s->ProcessTypeID = eProcessTypes::Update;
                $s->save();
            }
        } else {
            $faceUserObj->email = "";
        }

        $user = DB::table('User')
            ->where('FbUsername', '=', $faceUserObj->id)
            // ->where('FbEmail', '=', $faceUserObj->email)
            //->where('Password', '=', Hash::make($password))
            ->where('StatusID', '=', eStatus::Active)
            ->first();

        if (!$user) {
            $lastCustomerNo = DB::table('Customer')
                ->order_by('CustomerID', 'DESC')
                ->take(1)
                ->only('CustomerNo');

            preg_match('!\d+!', $lastCustomerNo, $matches);
            $matches = intval($matches[0]);
            $matches++;
            $data['success'] = true;

            $today = new DateTime();
            $todayAddWeek = Date("Y-m-d", strtotime("+7 days"));

            $Customer = new Customer();
            $Customer->CustomerNo = "m0" . $matches;
            $Customer->CustomerName = $faceUserObj->first_name . " " . $faceUserObj->last_name;
            $Customer->Email = $faceUserObj->email;
            $Customer->StatusID = eStatus::Active;
            $Customer->CreatorUserID = -1;
            $Customer->DateCreated = new DateTime();
            $Customer->ProcessUserID = -1;
            $Customer->ProcessDate = new DateTime();
            $Customer->ProcessTypeID = eProcessTypes::Insert;
            $Customer->save();

            $lastCustomerID = DB::table('Customer')
                ->order_by('CustomerID', 'DESC')
                ->take(1)
                ->only('CustomerID');


            $app = new Application();
            $app->CustomerID = $lastCustomerID;
            $app->Name = $faceUserObj->first_name . $faceUserObj->last_name;
            $app->StartDate = $today;
            $app->ExpirationDate = $todayAddWeek;
            $app->ApplicationStatusID = 151;
            $app->PackageID = 5;
            $app->Blocked = 0;
            $app->Status = 1;
            $app->Trail = 1;
            $app->save();

            $user = new User();
            $user->UserTypeID = 111;
            $user->CustomerID = $lastCustomerID;
            $user->Username = $faceUserObj->id;
            $user->FbUsername = $faceUserObj->id;
            //$user->Password = Hash::make("TestPassword");
            $user->FirstName = $faceUserObj->first_name;
            $user->LastName = $faceUserObj->last_name;
            $user->Email = $faceUserObj->email;
            $user->FbEmail = $faceUserObj->email;
            $user->FbAccessToken = $accessToken;
            $user->StatusID = eStatus::Active;
            $user->CreatorUserID = -1;
            $user->DateCreated = new DateTime();
            $user->ProcessUserID = -1;
            $user->ProcessDate = new DateTime();
            $user->ProcessTypeID = eProcessTypes::Insert;
            //$user->ConfirmCode = $confirmCode;
            $user->save();

            if (Auth::facebookAttempt(array('username' => $user->Username, 'fbemail' => $user->FbEmail, 'StatusID' => eStatus::Active))) {

                $user = Auth::user();
                $s = new Sessionn;
                $s->UserID = $user->UserID;
                $s->IP = Request::ip(); //getenv("REMOTE_ADDR");
                $s->Session = Session::instance()->session['id'];
                $s->LoginDate = new DateTime();
                $s->StatusID = eStatus::Active;
                $s->CreatorUserID = $user->UserID;
                $s->DateCreated = new DateTime();
                $s->ProcessUserID = $user->UserID;
                $s->ProcessDate = new DateTime();
                $s->ProcessTypeID = eProcessTypes::Insert;
                $s->save();

                Cookie::forever('DSCATALOG_USERNAME', $user->Username);

                setcookie("loggedin", "true", time() + 3600, "/");

                return "success=" . base64_encode("true") . "&msg=" . base64_encode(__('common.login_success_redirect'));
            }
        } else {

            if (Auth::facebookAttempt(array('username' => $user->Username, 'fbemail' => $user->FbEmail, 'StatusID' => eStatus::Active))) {

                $user = Auth::user();
                $s = new Sessionn;
                $s->UserID = $user->UserID;
                $s->IP = Request::ip(); //getenv("REMOTE_ADDR");
                $s->Session = Session::instance()->session['id'];
                $s->LoginDate = new DateTime();
                $s->StatusID = eStatus::Active;
                $s->CreatorUserID = $user->UserID;
                $s->DateCreated = new DateTime();
                $s->ProcessUserID = $user->UserID;
                $s->ProcessDate = new DateTime();
                $s->ProcessTypeID = eProcessTypes::Insert;
                $s->save();

                Cookie::forever('DSCATALOG_USERNAME', '');

                setcookie("loggedin", "true", time() + 3600, "/");

                return "success=" . base64_encode("true") . "&msg=" . base64_encode(__('common.login_success_redirect'));
            }
        }
    }

    public function post_imageupload()
    {
        ob_start();
        $element = $request->get('element');

        $options = array(
            'upload_dir' => path('public') . 'files/temp/',
            'upload_url' => URL::base() . '/files/temp/',
            'param_name' => $element,
            'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i'
        );
        $upload_handler = new UploadHandler($options);

        if (!Request::ajax()) {
            return;
        }

        $upload_handler->post(false);

        $ob = ob_get_contents();
        ob_end_clean();

        $json = get_object_vars(json_decode($ob));
        $arr = $json[$element];
        $obj = $arr[0];
        $tempFile = $obj->name;
        //var_dump($obj->name);
        Uploader::CmykControl($tempFile);
        return Response::json(array("fileName" => $tempFile));
    }

    public function post_imageupload_ltie10()
    {

    }

    /**
     * if user not exits creates user to the ticket system
     * Authenticates the user to the ticket system
     * @return boolean
     */
    public function get_ticket()
    {
        include(path('public') . "ticket/bootstrap.php");
        //find out if user exists
        $users = sts\singleton::get('sts\users');
        /** @var User $laravelUser */
        $laravelUser = Auth::user();
        $ticketUserExists = $users->is_user($laravelUser->Username);
        if (!$ticketUserExists) {
            //add user to the system
            $add_array = array(
                'name' => $laravelUser->FirstName . " " . $laravelUser->LastName,
                'email' => $laravelUser->Email,
                'authentication_id' => $laravelUser->UserID,
                'allow_login' => 1,
                'username' => $laravelUser->Username,
                'password' => 2233,
                'group_id' => 1,
                'user_level' => 1,
            );
            $users->add($add_array);
        } else {
            $ticketUserSet = $users->get(array('username' => $laravelUser->Username));
            $ticketUser = $ticketUserSet[0];
            $password = $laravelUser->UserTypeID == eUserTypes::Manager ? 'detay2006' : 2233;
            $users->edit(array('id' => $ticketUser['id'], 'password' => $password));
        }

        //authenticate user
        $data = array(
            'api_version' => '1',
            'api_action' => 'authenticate',
            'api_key' => '19664485-923e-46eb-8220-338300870052',
        );
        if ($laravelUser->UserTypeID == eUserTypes::Manager) {
            //managerler tek bir accounttan login olsunlar...
            $data['username'] = 'admin';
            $data['password'] = 'detay2006';
        } else {
            $data["username"] = $laravelUser->Username;
            $data["password"] = 2233;

        }
        $result = $api->receive(array("data" => json_encode($data)));
        return \Laravel\Redirect::to(Laravel\Config::get('custom.url') . '/ticket');

    }

}
