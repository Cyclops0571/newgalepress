<?php

namespace App\Http\Controllers\Mobile;

use App\Library\AjaxResponse;
use App\Mail\ClientPasswordChangedMailler;
use App\Mail\ClientPasswordResetMailler;
use App\Mail\ClientRegisteredMailler;
use App\Models\Application;
use App\Models\Client;
use Carbon\Carbon;
use Common;
use DateTime;
use eStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use Validator;

class AuthController extends Controller
{
    public function register(Application $application)
    {
        $data = [];
        $data["application"] = $application;
        return view('mobile.register', $data);
    }

    /**
     * Mobil application interface for user profile update
     * @param $applicationID
     * @param $clientToken
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($applicationID, $clientToken)
    {
        /* @var $client Client */
        $client = Client::where('Token', $clientToken)->first();
        if (!$client)
        {
            return Redirect::to(str_replace("(:num)", $applicationID, __("route.clients_register")));
        }
        $data = [];
        $data["application"] = $client->Application;
        $data["client"] = $client;

        //
        return view('mobile.register', $data);
    }


    public function store(Request $request)
    {
        $clientID = $request->get('ClientID', '0');
        $username = trim($request->get('Username'));
        $applicationID = $request->get('ApplicationID');
        $email = $request->get('Email');
        $password = $request->get('Password');
        $newPassword = $request->get('NewPassword');
        $newPassword2 = $request->get('NewPassword2');

        $rules = [
            'ApplicationID' => 'required',
            'Username'      => 'required|min:2',
            'Password'      => 'required|min:2',
            'FirstName'     => 'required',
            'LastName'      => 'required',
            'Email'         => 'required|email',
        ];
        if ($clientID == 0)
        {
            $rules['Password'] = 'required|min:2|max:12';
            $rules['Password2'] = 'required|min:2|max:12|same:Password';
        }

        $v = Validator::make($request->all(), $rules);
        if ($v->fails())
        {
            return ajaxResponse::error(__('common.detailpage_validation'));
        }

        if ($clientID == 0)
        {
            $clientSameUsername = Client::where('ApplicationID', $applicationID)->where('Username', $username)->first();
            $clientSameEmail = Client::where('ApplicationID', $applicationID)->where('Email', $email)->first();
            if ($clientSameUsername)
            {
                return ajaxResponse::error(trans('clients.username_must_be_unique'));
            } else if ($clientSameEmail)
            {
                return ajaxResponse::error(trans('clients.email_must_be_unique'));
            }

            $client = new Client();
            $client->Password = md5($password);
            $client->Token = $username . "_" . md5(uniqid());
            $client->StatusID = eStatus::Active;
            $client->CreatorUserID = 0;
        } else
        {
            //current password is a must !!!
            $client = Client::find($clientID);
            if (!$client)
            {
                return ajaxResponse::error(trans('clients.user_not_found'));
            } else if ($client->ApplicationID != $applicationID)
            {
                return ajaxResponse::error(trans('clients.client_application_invalid'));
            }

            $clientSameUsername = Client::where('ApplicationID', $applicationID)->where('Username', $username)->where('ClientID', "!=", $client->ClientID)->first();
            $clientSameEmail = Client::where('ApplicationID', $applicationID)->where('Email', $email)->where('ClientID', "!=", $client->ClientID)->first();
            if ($clientSameUsername)
            {
                return ajaxResponse::error(trans('clients.username_must_be_unique'));
            } else if ($clientSameEmail)
            {
                return ajaxResponse::error(trans('clients.email_must_be_unique'));
            }

            if ($client->Password != md5($password))
            {
                return ajaxResponse::error(trans("clients.invalid_password"));
            }

            if (!empty($newPassword) || !empty($newPassword2))
            {
                if ($newPassword != $newPassword2)
                {
                    return ajaxResponse::error(trans("clients.password_does_not_match"));
                }
                $client->Password = md5($newPassword);
            }
        }

        $client->Username = $username;
        $client->Email = $email;
        $client->ApplicationID = $applicationID;
        $client->Name = $request->get('FirstName');
        $client->Surname = $request->get('LastName');
        $client->save();
        \Mail::to($client->Email)->queue(new ClientRegisteredMailler($client, empty($newPassword) ? $password : $newPassword));
        return ajaxResponse::success(route('mobile_user_registration_success', ['usertoken' => $client->Token]));
    }

    public function forgotPasswordForm(Application $application)
    {
        $data = [];
        $data["application"] = $application;

        return view("mobile.forgot_password_form", $data);
    }

    public function sendTokenMail(Request $request)
    {
        $rules = [
            'Email'         => 'required|email',
            'ApplicationID' => 'required',
        ];

        $v = Validator::make($request->all(), $rules);
        if ($v->fails())
        {
            $errorMsg = $v->errors()->first();
            if (empty($errorMsg))
            {
                $errorMsg = trans('common.detailpage_validation');
            }

            return ajaxResponse::error($errorMsg);
        }
        $email = $request->get("Email");
        $applicationID = $request->get("ApplicationID");
        /* @var $client Client */
        $client = Client::where('ApplicationID', $applicationID)->where('Email', $email)->first();
        if (!$client)
        {
            return ajaxResponse::error(trans("clients.user_not_found"));
        }

        $client->PWRecoveryCode = Common::generatePassword();
        $client->PWRecoveryDate = new DateTime();
        $client->save();

        \Mail::to($client->Email)->queue(new ClientPasswordResetMailler($client));
        return ajaxResponse::success(__('common.login_emailsent'));
    }

    public function resetPasswordForm(Request $request)
    {
        //             * Mobil application interface for renewing user password

        $errorMsg = "";
        $rules = [
            'ApplicationID' => 'required',
            'email'         => 'required|email',
            'code'          => 'required|min:2',
        ];

        $v = Validator::make($request->all(), $rules);
        if ($v->fails())
        {
            $errorMsg = $v->errors()->first();
            if (empty($errorMsg))
            {
                $errorMsg = trans('common.login_ticketnotfound');
            }
        }

        $applicationID = $request->get("ApplicationID");
        $email = $request->get("email");
        $code = $request->get("code");

        $client = Client::where("ApplicationID", $applicationID)
            ->where("Email", $email)
            ->where("PwRecoveryCode", $code)
            ->where("PwRecoveryDate", ">", Carbon::today()->subDays(7))
            ->first();

        if (!$client)
        {
            $errorMsg = __('common.login_ticketnotfound');
        }

        $data = [];
        $data["errorMsg"] = $errorMsg;

        return view("mobile.reset_password_form", $data);
    }

    /**
     * Saves new user password then redirect to successful token page
     * @param Request $request
     * @return string
     */
    public function updatePassword(Request $request)
    {
        $rules = [
            'Email'     => 'required|email',
            'Code'      => 'required',
            'Password'  => 'required|min:6|max:12',
            'Password2' => 'required|min:6|max:12|same:Password',
        ];

        $v = Validator::make($request->all(), $rules);
        if ($v->fails())
        {
            $errorMsg = $v->errors()->first();
            if (empty($errorMsg))
            {
                $errorMsg = trans('common.detailpage_validation');
            }

            return ajaxResponse::error($errorMsg);
        }

        $applicationID = $request->get('ApplicationID');

        /* @var $client Client */
        $client = $client = Client::where("ApplicationID", $applicationID)
            ->where("Email", $request->get('Email'))
            ->where("PwRecoveryDate", ">", Carbon::today()->subDays(7))
            ->first();
        if (!$client)
        {
            return ajaxResponse::error(trans('common.login_ticketnotfound'));
        }

        $pass = trim($request->get("Password"));
        $client->Password = md5($pass);
        $client->save();
        \Mail::to($client->Email)->queue(new ClientPasswordChangedMailler($client));


        return ajaxResponse::success(route("mobile_user_password_changed", ['usertoken' => $client->Token]));
    }
}
