<?php

namespace App\Http\Controllers;

use App\Helpers\MyPayment;
use App\Library\IyzicoThreeDResponse;
use App\Models\Application;
use App\Models\City;
use App\Models\Customer;
use App\Models\PaymentAccount;
use App\Models\PaymentTransaction;
use App\Models\ServerErrorLog;
use Auth;
use eStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Iyzipay\Model\PaymentCard;
use Redirect;
use View;

class PaymentController extends Controller {

    public function shop()
    {
        $user = Auth::user();
        if (!$user)
        {
            setcookie(GO_BACK_TO_SHOP, GO_BACK_TO_SHOP, time() + config('session.lifetime') * 60, "/");

            return Redirect::to(route('home'));
        }

        $customer = Customer::find($user->CustomerID);
        if (!$customer)
        {
            setcookie(GO_BACK_TO_SHOP, GO_BACK_TO_SHOP, time() + config('session.lifetime') * 60, "/");

            return Redirect::to(__('route.home'));
        }

        $applications = $customer->Application()->withoutGlobalScopes()->where(function(Builder $builder) {
            $builder->where('StatusID', eStatus::Active);
            $builder->orWhere('StatusID', eStatus::Passive);
        })->get();
        if (empty($applications) || $applications[0]->CustomerID != $customer->CustomerID)
        {
            return Redirect::to(__('route.home'));
        }

        $paymentAccount = $customer->getLastSelectedPaymentAccount();
        if (!$paymentAccount)
        {
            $paymentAccount = new PaymentAccount();
        }

        if ($paymentAccount->PaymentAccountID)
        {
            $selectedApp = $paymentAccount->Application;
        } else
        {
            $selectedApp = $applications[0];
        }

        $customerData = [];
        $customerData['city'] = City::all();
        $customerData['paymentAccount'] = $paymentAccount;
        $customerData['applications'] = $applications;
        $customerData['selectedApp'] = $selectedApp;
        setcookie(GO_BACK_TO_SHOP, GO_BACK_TO_SHOP, 1, "/");

        return View::make('payment.shop', $customerData);
    }


    public function paymentGalepress(Request $request)
    {
        $customerData = [];
        $customerEmail = $request->get('email');
        $customerTel = $request->get('phone');

        $customerData['email'] = $customerEmail;
        $customerData['phone'] = $customerTel;

        return View::make('payment.odeme', $customerData);
    }

    public function cardInfo(Request $request)
    {
        $user = Auth::user();
        $customer = Customer::find($user->CustomerID);
        $application = Application::find($request->get("applicationID"));
        if (!$customer)
        {
            return Redirect::to(__('route.home'));
        }

        if ($application->CustomerID != $customer->CustomerID)
        {
            return Redirect::to(__('route.home'));
        }

        $paymentAccount = $application->PaymentAccount;
        if (!$paymentAccount->exists)
        {
            $paymentAccount = new PaymentAccount();
            $paymentAccount->CustomerID = $customer->CustomerID;
            $paymentAccount->ApplicationID = $application->ApplicationID;
        }

        $paymentAccount->kurumsal = $request->get('customerType') == 'on' ? 0 : 1;
        $paymentAccount->email = $request->get('email');
        $paymentAccount->phone = $request->get('phone');
        $paymentAccount->title = $request->get('customerTitle');
        $paymentAccount->tckn = $request->get('tc');
        $paymentAccount->CityID = $request->get('city'); //id
        $paymentAccount->address = $request->get('address');
        $paymentAccount->vergi_dairesi = $request->get('taxOffice');
        $paymentAccount->vergi_no = $request->get('taxNo');
        $paymentAccount->selected_at = date("Y-m-d H:i:s");
        $paymentAccount->StatusID = eStatus::Active;
        $paymentAccount->save();

        $data = [];
        $data["paymentAccount"] = $paymentAccount;
        $data["application"] = $application;

        return View::make('payment.card_info', $data);
    }

    /**
     * iyzco.com dan 6 hane icin kart bilgisi sorar.
     * sonrasinda gene iyzco.comdan odemeyi almaya calisir...
     * 3d secure yapilmis ise get_secure_3d_response a gider.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentApproval(Request $request)
    {
        $user = Auth::user();
        $customer = Customer::find($user->CustomerID);
        if (!$customer)
        {
            return Redirect::to(__('route.home'));
        }
        $paymentAccount = $customer->getLastSelectedPaymentAccount();
        if (!$paymentAccount->exists())
        {
            return Redirect::route('payment_shop');
        }


        //eger kullanici bugun icinde bir odeme yapmis ise baska bir odeme almayalim...
        $oldPaymentTransactions = PaymentTransaction::where('PaymentAccountID', $paymentAccount->PaymentAccountID)
            ->where('created_at', ">", date('Y-m-d'))
            ->where('paid', 1)
            ->first();

        if ($oldPaymentTransactions)
        {
            $paymentResult = (string)__('error.cannot_make_two_payment_in_the_same_day');

            return Redirect::route("website_payment_result", $paymentResult);
        }

        $paymentCard = new PaymentCard();
        $paymentCard->setCardHolderName($request->get("card_holder_name"));
        $paymentCard->setCardNumber(str_replace(" ", "", $request->get("card_number")));
        $paymentCard->setExpireMonth($request->get("card_expiry_month"));
        $paymentCard->setExpireYear($request->get("card_expiry_year"));
        $paymentCard->setCvc($request->get("card_verification"));
        $paymentCard->setRegisterCard(1);
        $secure3D = $request->get("3d_secure", 0);

        $payment = new MyPayment();
        if ($secure3D)
        {
            $basicThreeDsInitialize = $payment->paymentFromWebThreeD($paymentCard);

            return $basicThreeDsInitialize->getHtmlContent();
        } else
        {
            $basicPayment = $payment->paymentFromWeb($paymentCard);
            if ($basicPayment->getStatus() == 'success')
            {
                $paymentResult = "Success";
            } else
            {
                $paymentResult = $basicPayment->getErrorMessage();
            }

            return Redirect::route("website_payment_result", [str_replace('%2F', '/', urlencode($paymentResult))]);
        }
    }

    /**
     * 3d secure kullanilmis ise buraya geliyoruz
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function secure3dResponse(Request $request)
    {
        $response = $request->all();
        if (empty($response))
        {
            $errorLog = new ServerErrorLog();
            $errorLog->Header = 571;
            $errorLog->Url = 'Server 3ds payment';
            $errorLog->Parameters = $request->all();
            $errorLog->ErrorMessage = 'Response Data';
            $errorLog->save();
            $responseText = (string)__('error.service_supplier_do_not_answer_try_again_later');
        } else if (!isset($response['status']))
        {
            $errorLog = new ServerErrorLog();
            $errorLog->Header = 571;
            $errorLog->Url = 'Server 3ds payment';
            $errorLog->Parameters = $request->all();
            $errorLog->ErrorMessage = 'Response status does not exists.';
            $errorLog->save();
            $responseText = (string)__('error.there_is_an_error_on_the_service_supplier_please_try_again_later');
        } else
        {
            $iyzicoResponse = new IyzicoThreeDResponse($response);
            $payment = new MyPayment();
            $responseText = $payment->get3dsResponse($iyzicoResponse);

        }

        return Redirect::route('website_payment_result', $responseText);
    }

    public function paymentResult($encodedResult)
    {
        $result = urldecode($encodedResult);
        if ($result == "Success")
        {
            $payDataMsg = __('website.payment_result_successful');
            $payDataTitle = __('website.payment_successful');
        } else
        {
            $payDataMsg = $result;
            $payDataTitle = __('website.payment_failure');
        }
        $data = ['payDataMsg' => $payDataMsg, 'payDataTitle' => $payDataTitle, 'result' => $result];

        return View::make('payment.odeme_sonuc', $data);
    }

    public function paymentAccountByApplicationID($appID)
    {
        return PaymentAccount::where('ApplicationID', $appID)->first()->toArray();
    }

}
