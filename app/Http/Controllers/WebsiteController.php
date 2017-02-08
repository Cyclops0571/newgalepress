<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use App\User;
use Validator;
use View;

class WebsiteController extends Controller
{

    public function get_home()
    {
        return View::make('website.pages.home');
    }

    public function get_galepress()
    {
        return View::make('website.pages.galepress');
    }

    public function get_products()
    {
        return View::make('website.pages.products');
    }

    public function post_contactform()
    {
        $rules = array(
            "senderName" => 'required',
            "senderEmail" => 'email',
            "phone" => 'required',
            "comment" => 'required',
        );
        //company comment

        $v = Validator::make($request->all(), $rules);
        if (!$v->passes()) {
            return $v->errors->first();
        }

        $body = '';
        $body .= "<b>Sender Name: </b>" . request()->get('senderName') . '<br/>';
        $body .= "<b>Sender Phone: </b>" . request()->get('phone') . '<br/>';
        if (request('company', '')) {
            $body .= "<b>Company: </b>" . request('company', '') . '<br/>';
        }
        $body .= "<b>Comment: </b>" . request()->get('comment') . '<br/>';
        $toEmail = (string)__('maillang.contanct_email');
        $toName = (string)__('maillang.contactform_recipient');
        $subject = (string)__('maillang.contactform_subject');
        $senderEmail = request('senderEmail');
        $senderName = request('senderName');
        if (Message::send(function ($m) use ($toEmail, $toName, $senderEmail, $senderName, $subject, $body) {
            /** @var  $m \Swiftmailer\Drivers\SMTP */
            $m->from($senderEmail, $senderName);
            //$m->to($toEmail);
            $m->to($toEmail, $toName);
            $m->subject($subject);
            $m->body($body);
            $m->html(true);
        })
        ) {
            $success = 'success';
        } else {
            $success = 'error: incomplete data';
        }
        echo $success;
    }

    public function post_tryit()
    {
        //date_default_timezone_set('Europe/Istanbul');
        $errors = array();
        $data = array();

        $customerName = request('name', '');

        $customerLastName = request('last_name', '');

        $email = request('email', '');

        $appName = request('app_name', '');

        $userName = request('user_name', '');

        $password = request('password', '');

        $password_verify = request('password_verify', '');

        $captcha = request('captcha', '');


        if (empty($customerName) || $customerName == "undefined")
            $errors['name'] = (string)__('website.tryit_form_error_required_firstname');

        if (empty($customerLastName) || $customerLastName == "undefined")
            $errors['last_name'] = (string)__('website.tryit_form_error_required_lastname');

        $rule = array('email' => 'required|email');
        $validationEmail = Validator::make($request->all(), $rule);
        if ($validationEmail->invalid()) {
            $errors['email'] = (string)__('website.tryit_form_error_required_email');
        }

        if (empty($appName) || $appName == "undefined") {
            $errors['app_name'] = (string)__('website.tryit_form_error_required_appname');
        } else {
            $applicatonExits = Application::where('Name', '=', $appName)->first();
            if ($applicatonExits) {
                $errors['app_name'] = (string)__('website.tryit_form_error_appname_exist');
            }
        }

        if (empty($userName) || $userName == "undefined")
            $errors['user_name'] = (string)__('website.tryit_form_error_required_username');

        if (empty($password) || $password == "undefined")
            $errors['password'] = (string)__('website.tryit_form_error_required_pass');

        if (empty($password_verify) || $password_verify == "undefined")
            $errors['password_verify'] = (string)__('website.tryit_form_error_required_pass2');

        if ($password != $password_verify)
            $errors['password_verify'] = (string)__('website.tryit_form_error_required_passmatch');

        if (empty($captcha) || $captcha == "undefined")
            $errors['captcha'] = (string)__('website.tryit_form_error_required_securitycode');

        if (app()->environment() != ENV_LOCAL) {
            $rules = array(
                'captcha' => 'mecaptcha|required',
            );
            $validation = Validator::make($request->all(), $rules);
            if ($validation->valid()) {
                //$errors['captcha'] = 'Invalid captcha';
            } else if ($captcha && !empty($captcha)) {
                $errors['captcha_invalid'] = (string)__('website.tryit_form_error_required_invalidcaptcha');
            }
        }


        //$errors['customerLastName'] = $customerLastName;

        $userExists = User::where('Email', '=', $email)->first();
        $customerExists = Customer::where('Email', '=', $email)->first();

        if ($userExists || $customerExists) {
            $errors['email_exist'] = (string)__('website.tryit_form_error2_email');
        }

        $userNameExist = DB::table('User')
            ->where('Username', '=', $userName)
            ->first();

        if ($userNameExist && !empty($userName)) {
            $errors['user_name_exist'] = (string)__('website.tryit_form_error_user');
        }

        // if there are errors
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
            $data['messageError'] = (string)__('website.tryit_form_error_required_checkfields');
        } else {

            //$data['userNameExist'] = $userNameExist;
            $highestCustomerID = DB::table('Customer')
                ->orderBy('CustomerID', 'DESC')
                ->take(1)
                ->only('CustomerID');

            // if there are no errors, return a message
            $data['success'] = true;

            $today = new DateTime();
            $todayAddWeek = Date("Y-m-d", strtotime("+7 days"));

            $customer = new Customer();
            $customer->CustomerNo = "m0" . (++$highestCustomerID);
            $customer->CustomerName = $customerName . " " . $customerLastName;
            $customer->Email = $email;
            $customer->StatusID = eStatus::Active;
            $customer->CreatorUserID = -1;
            $customer->DateCreated = new DateTime();
            $customer->ProcessUserID = -1;
            $customer->ProcessDate = new DateTime();
            $customer->ProcessTypeID = eProcessTypes::Insert;
            $customer->save();

            $applicaton = new Application();
            $applicaton->CustomerID = $customer->CustomerID;
            $applicaton->Name = $appName;
            $applicaton->StartDate = $today;
            $applicaton->ExpirationDate = $todayAddWeek;
            $applicaton->ApplicationStatusID = 151;
            $applicaton->PackageID = 5;
            $applicaton->Blocked = 0;
            $applicaton->Status = 1;
            $applicaton->Trail = 1;
            $applicaton->save();

            // $data['bugun'] = $today;
            // $data['exp-date'] = $todayAddWeek;
            // $data['lastCustomerID'] = $lastCustomerID;

            $confirmCode = rand(10000, 99999);

            $user = new User();
            $user->UserTypeID = 111;
            $user->CustomerID = $customer->CustomerID;
            $user->Username = $userName;
            $user->Password = Hash::make(trim($password));
            $user->FirstName = $customerName;
            $user->LastName = $customerLastName;
            $user->Email = $email;
            $user->StatusID = 0;
            $user->CreatorUserID = -1;
            $user->DateCreated = new DateTime();
            $user->ProcessUserID = -1;
            $user->ProcessDate = new DateTime();
            $user->ProcessTypeID = eProcessTypes::Insert;
            $user->ConfirmCode = $confirmCode;
            $user->save();

            $subject = __('common.confirm_email_title');
            $mailData = array(
                'name' => $user->FirstName,
                'surname' => $user->LastName,
                'url' => Config::get("custom.url") . '/' . Config::get('application.language') . '/' . __('route.confirmemail') . '?email=' . $user->Email . '&code=' . $confirmCode,
            );
            $msg = View::make('mail-templates.aktivasyon.index')->with($mailData)->render();
            // Common::sendHtmlEmail("serdar.saygili@detaysoft.com", $s->FirstName.' '.$s->LastName, $subject, $msg)
            $mailStatus = Common::sendHtmlEmail($user->Email, $user->FirstName . ' ' . $user->LastName, $subject, $msg);

            $m = new MailLog();
            $m->MailID = 1; //activation
            $m->UserID = $user->UserID;
            if (!$mailStatus) {
                $m->Arrived = 0;
            } else {
                $m->Arrived = 1;
            }
            $m->StatusID = eStatus::Active;
            $m->save();
        }
        echo json_encode($data);
    }

    public function get_article_workflow()
    {
        try {
            return View::make('website.pages.article-workflow');
        } catch (Exception $e) {
            //throw new Exception($e->getMessage());
            return Redirect::to(__('route.website_blog'));
        }
    }

    public function get_article_brandvalue()
    {
        try {
            return View::make('website.pages.article-brandvalue');
        } catch (Exception $e) {
            //throw new Exception($e->getMessage());
            return Redirect::to(__('route.website_blog'));
        }
    }

    public function get_article_whymobile()
    {
        try {
            return View::make('website.pages.article-whymobile');
        } catch (Exception $e) {
            //throw new Exception($e->getMessage());
            return Redirect::to(__('route.website_blog'));
        }
    }

    public function post_landing_page_realty()
    {
        $errors = array();
        $data = array();

        $customerName = request('name', '');

        $email = request('email', '');

        $userName = request('user_name', '');

        $password = request('password', '');

        $password_verify = request('password_verify', '');

        if (empty($customerName) || $customerName == "undefined")
            $errors['name'] = __('website.tryit_form_error_required_firstname');

        if (empty($email) || $email == "undefined")
            $errors['email'] = __('website.tryit_form_error_required_email');

        if (empty($userName) || $userName == "undefined")
            $errors['user_name'] = __('website.tryit_form_error_required_username');

        if (empty($password) || $password == "undefined")
            $errors['password'] = __('website.tryit_form_error_required_pass');

        if (empty($password_verify) || $password_verify == "undefined")
            $errors['password_verify'] = __('website.tryit_form_error_required_pass2');

        if ($password != $password_verify)
            $errors['password_verify'] = __('website.tryit_form_error_required_passmatch');

        $emailExist = DB::table('User')
            ->where('Email', '=', $email)
            ->first();

        if ($emailExist && !empty($email)) {
            $errors['email_exist'] = __('website.tryit_form_error2_email');
        }

        $userNameExist = DB::table('User')
            ->where('Username', '=', $userName)
            ->first();

        if ($userNameExist && !empty($userName)) {
            $errors['user_name_exist'] = __('website.tryit_form_error_user');
        }

        // if there are errors
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
            $data['messageError'] = __('website.tryit_form_error_required_checkfields');
        } else {
            //$data['userNameExist'] = $userNameExist;
            $lastCustomerNo = DB::table('Customer')
                ->orderBy('CustomerID', 'DESC')
                ->take(1)
                ->only('CustomerNo');

            //$data['lastCustomerNo'] = $lastCustomerNo;

            preg_match('!\d+!', $lastCustomerNo, $matches);
            $matches = intval($matches[0]);
            $matches++;
            // if there are no errors, return a message
            $data['success'] = true;

            $today = new DateTime();
            $todayAddWeek = Date("Y-m-d", strtotime("+7 days"));

            $s = new Customer();
            $s->CustomerNo = "m0" . $matches;
            $s->CustomerName = $customerName;
            $s->Email = $email;
            $s->StatusID = eStatus::Active;
            $s->CreatorUserID = -1;
            $s->DateCreated = new DateTime();
            $s->ProcessUserID = -1;
            $s->ProcessDate = new DateTime();
            $s->ProcessTypeID = eProcessTypes::Insert;
            $s->save();

            $lastCustomerID = DB::table('Customer')
                ->orderBy('CustomerID', 'DESC')
                ->take(1)
                ->only('CustomerID');


            $s = new Application();
            $s->CustomerID = $lastCustomerID;
            $s->Name = $userName . "-Realty";
            $s->StartDate = $today;
            $s->ExpirationDate = $todayAddWeek;
            $s->ApplicationStatusID = 151;
            $s->PackageID = 5;
            $s->Blocked = 0;
            $s->Status = 1;
            $s->Trail = 1;
            $s->save();

            // $data['bugun'] = $today;
            // $data['exp-date'] = $todayAddWeek;
            // $data['lastCustomerID'] = $lastCustomerID;

            $confirmCode = rand(10000, 99999);

            $s = new User();

            $s->UserTypeID = 111;
            $s->CustomerID = $lastCustomerID;
            $s->Username = $userName;
            $s->Password = Hash::make(trim($password));
            $s->FirstName = $customerName;
            $s->LastName = "";
            $s->Email = $email;
            $s->StatusID = 0;
            $s->CreatorUserID = -1;
            $s->DateCreated = new DateTime();
            $s->ProcessUserID = -1;
            $s->ProcessDate = new DateTime();
            $s->ProcessTypeID = eProcessTypes::Insert;
            $s->ConfirmCode = $confirmCode;
            $s->save();

            $subject = __('common.confirm_email_title');
            $mailData = array(
                'name' => $s->FirstName,
                'surname' => $s->LastName,
                'url' => Config::get("custom.url") . '/' . Config::get('application.language') . '/' . __('route.confirmemail') . '?email=' . $s->Email . '&code=' . $confirmCode,
            );
            $msg = View::make('mail-templates.aktivasyon.index')->with($mailData)->render();
            $mailStatus = Common::sendHtmlEmail($s->Email, $s->FirstName . ' ' . $s->LastName, $subject, $msg);

            $m = new MailLog();
            $m->MailID = 1; //Activation
            $m->UserID = $s->UserID;
            if (!$mailStatus) {
                $m->Arrived = 0;
            } else {
                $m->Arrived = 1;
            }
            $m->StatusID = eStatus::Active;
            $m->save();
        }
        echo json_encode($data);
    }


    public function get_namaz()
    {
        return View::make('website.pages.namaz-vakitleri');
    }

    public function post_namaz()
    {
        $myLocation = request('location');

        $getDistrictCode = DB::table('Towns')
            ->where('TownName', '=', $myLocation)
            ->first();

        $getDistrictTimes = DB::table('PrayerTimes')
            ->where('TownID', '=', $getDistrictCode->OldID)
            ->where('miladi_tarih', '=', date('Y-m-d'))
            ->first();

        if (empty($getDistrictTimes->id)) {
            $getCityCode = DB::table('Cities')
                ->where('CityID', '=', $getDistrictCode->CityID)
                ->first();

            $getCityTimes = DB::table('PrayerTimes')
                ->where('CityID', '=', $getCityCode->CityID)
                ->where('PlaceName', '=', trim($getCityCode->CityName))
                ->where('miladi_tarih', '=', date('Y-m-d'))
                ->first();

            $data = array();
            $data['imsak'] = $getCityTimes->imsak_zaman;
            $data['ogle'] = $getCityTimes->ogle_zaman;
            $data['ikindi'] = $getCityTimes->ikindi_zaman;
            $data['aksam'] = $getCityTimes->aksam_zaman;
            $data['yatsi'] = $getCityTimes->yatsi_zaman;
            return json_encode($data);
        } else {
            $data = array();
            $data['imsak'] = $getDistrictTimes->imsak_zaman;
            $data['ogle'] = $getDistrictTimes->ogle_zaman;
            $data['ikindi'] = $getDistrictTimes->ikindi_zaman;
            $data['aksam'] = $getDistrictTimes->aksam_zaman;
            $data['yatsi'] = $getDistrictTimes->yatsi_zaman;
            return json_encode($data);
        }
    }

    public function get_signUp() {
        return View::make('website.signup');
    }

    public function get_forgotPassword() {
        return View::make('website.forgotpassword');
    }

    public function get_signIn() {
        return View::make('website.signin');
    }

}
