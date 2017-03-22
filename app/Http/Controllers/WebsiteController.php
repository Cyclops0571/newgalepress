<?php
namespace App\Http\Controllers;

use App\Mail\CustomerWelcomeMailler;
use App\Models\Application;
use App\Models\Customer;
use App\Models\MailLog;
use App\User;
use Common;
use DateTime;
use eProcessTypes;
use eStatus;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mail;
use Redirect;
use Validator;
use View;

class WebsiteController extends Controller {

    public function galepress()
    {
        return View::make('website.pages.galepress');
    }

    public function products()
    {
        return View::make('website.pages.products');
    }

    public function contactForm(Request $request)
    {
        $rules = [
            "senderName"  => 'required',
            "senderEmail" => 'email',
            "phone"       => 'required',
            "comment"     => 'required',
        ];

        $v = Validator::make($request->all(), $rules);
        if (!$v->passes())
        {
            return $v->errors->first();
        }

        Mail::to($request->get('senderEmail'))->queue(new CustomerWelcomeMailler($request));

        return ['success' => 'success'];
    }

    public function tryIt(Request $request)
    {
        //date_default_timezone_set('Europe/Istanbul');
        $errors = [];
        $data = [];

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

        $rule = ['email' => 'required|email'];
        $validationEmail = Validator::make($request->all(), $rule);
        if ($validationEmail->invalid())
        {
            $errors['email'] = (string)__('website.tryit_form_error_required_email');
        }

        if (empty($appName) || $appName == "undefined")
        {
            $errors['app_name'] = (string)__('website.tryit_form_error_required_appname');
        } else
        {
            $applicationExits = Application::where('Name', '=', $appName)->first();
            if ($applicationExits)
            {
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

        if (app()->environment() != ENV_LOCAL)
        {
            $rules = [
                'captcha' => 'mecaptcha|required',
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->valid())
            {
                //$errors['captcha'] = 'Invalid captcha';
            } else if ($captcha && !empty($captcha))
            {
                $errors['captcha_invalid'] = (string)__('website.tryit_form_error_required_invalidcaptcha');
            }
        }


        //$errors['customerLastName'] = $customerLastName;

        $userExists = User::where('Email', '=', $email)->first();
        $customerExists = Customer::where('Email', '=', $email)->first();

        if ($userExists || $customerExists)
        {
            $errors['email_exist'] = (string)__('website.tryit_form_error2_email');
        }

        $userNameExist = User::where('Username', '=', $userName)->first();

        if ($userNameExist && !empty($userName))
        {
            $errors['user_name_exist'] = (string)__('website.tryit_form_error_user');
        }

        // if there are errors
        if (!empty($errors))
        {
            $data['success'] = false;
            $data['errors'] = $errors;
            $data['messageError'] = (string)__('website.tryit_form_error_required_checkfields');
        } else
        {

            //$data['userNameExist'] = $userNameExist;
            $highestCustomerID = Customer::max('CustomerID');

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

            $application = new Application();
            $application->CustomerID = $customer->CustomerID;
            $application->Name = $appName;
            $application->StartDate = $today;
            $application->ExpirationDate = $todayAddWeek;
            $application->ApplicationStatusID = 151;
            $application->PackageID = 5;
            $application->Blocked = 0;
            $application->Status = 1;
            $application->Trail = 1;
            $application->save();


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
            $mailData = [
                'name'    => $user->FirstName,
                'surname' => $user->LastName,
                'url'     => config("custom.url") . '/' . app()->getLocale() . '/' . __('route.confirmemail') . '?email=' . $user->Email . '&code=' . $confirmCode,
            ];
            $msg = View::make('mail-templates.aktivasyon.index')->with($mailData)->render();
            // Common::sendHtmlEmail("serdar.saygili@detaysoft.com", $s->FirstName.' '.$s->LastName, $subject, $msg)
            $mailStatus = Common::sendHtmlEmail($user->Email, $user->FirstName . ' ' . $user->LastName, $subject, $msg);

            $m = new MailLog();
            $m->MailID = 1; //activation
            $m->UserID = $user->UserID;
            if (!$mailStatus)
            {
                $m->Arrived = 0;
            } else
            {
                $m->Arrived = 1;
            }
            $m->StatusID = eStatus::Active;
            $m->save();
        }
        echo json_encode($data);
    }

    public function index(Request $request, Response $response)
    {
        if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['REQUEST_METHOD']))
        {
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] == '/')
            {
                if (!empty($request->cookie('language')))
                {
                    $defaultLang = $request->cookie('language');
                } else
                {
                    $userInfo = ip_info();
                    $defaultLang = 'usa';
                    if (!empty($userInfo) && !empty($userInfo["country_code"]) && $userInfo["country_code"] == "TR")
                    {
                        $defaultLang = 'tr';
                    }
                }

                return view('language_redirect', compact('defaultLang'));
            }
        }

        return response()->view('website.pages.home')->cookie('language', app()->getLocale());
    }

    public function article_workflow()
    {
        try
        {
            return View::make('website.pages.article-workflow');
        } catch (Exception $e)
        {
            //throw new Exception($e->getMessage());
            return Redirect::to(__('route.website_blog'));
        }
    }

    public function article_brandvalue()
    {
        try
        {
            return View::make('website.pages.article-brandvalue');
        } catch (Exception $e)
        {
            //throw new Exception($e->getMessage());
            return Redirect::to(__('route.website_blog'));
        }
    }

    public function articleWhyMobile()
    {
        try
        {
            return View::make('website.pages.article-whymobile');
        } catch (Exception $e)
        {
            //throw new Exception($e->getMessage());
            return Redirect::to(__('route.website_blog'));
        }
    }


}
