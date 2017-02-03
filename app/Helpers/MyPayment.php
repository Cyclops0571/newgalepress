<?php


namespace App\Helpers;


use App\Models\Customer;
use App\Models\PaymentAccount;
use Iyzipay\Model\BasicPayment;
use Iyzipay\Model\BasicThreedsInitialize;
use Iyzipay\Model\BasicThreedsPayment;
use Iyzipay\Model\Card;
use Iyzipay\Model\CardInformation;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentCard;
use Iyzipay\Options;
use Iyzipay\Request\CreateCardRequest;
use Iyzipay\Request\CreateThreedsPaymentRequest;

class MyPayment
{
    const iyzicoApiKey = "lGdLZQMXMGjJKAPX7RJtyWP3XLYnvWbT";
    const iyzicoSecretKey = "jYhw4nt0Zy55TtceMj320WAVzApj7sPL";
    const iyzicoBaseUrl = "https://api.iyzipay.com/";
    const sandboxIyzicoApiKey = "sandbox-056gEWAwqXC2F2HKpFWsahJXUmuGX5pg";
    const sandboxIyzicoSecretKey = "sandbox-OTcrn59sNuj2P1pyaAWQRkuSp17y7e6y";
    const sandboxIyzicoBaseUrl = "https://sandbox-api.iyzipay.com/";

    /** @var Options */
    public $options = null;
    /** @var PaymentTransaction */
    private $paymentTransaction = null;

    /** @var PaymentAccount */
    private $paymentAccount = null;

    public function __construct($options = null)
    {
        if (!$options) {
            $this->options = new  Options();
            $this->options->setApiKey(MyPayment::iyzicoApiKey);
            $this->options->setSecretKey(MyPayment::iyzicoSecretKey);
            $this->options->setBaseUrl(MyPayment::iyzicoBaseUrl);
        } else {
            $this->options = $options;
        }
    }

    public static function getLang()
    {
        switch (\Config::get('application.language')) {
            case 'tr':
                return Locale::TR;
                break;
            default:
                return Locale::EN;
        }
    }

    /**
     * @return User
     */
    private function getUser()
    {
        if (\App::isLocal()) {
            return User::find(65);
        }
        return Auth::user();
    }

    public function paymentFromWeb(PaymentCard $pc)
    {
        $user = $this->getUser();
        $this->setPaymentAccount($user);
        $this->setPaymentTransaction($this->paymentAccount);
        $request = $this->getRequest();
        $pc->setRegisterCard(1);
        $request->setPaymentCard($pc);
        $basicPayment = BasicPayment::create($request, $this->options);
        $this->paymentTransaction->updateTransaction($basicPayment);
        $this->paymentAccount->updateAccount($basicPayment);
        return $basicPayment;
    }

    /**
     * @param PaymentCard $pc
     * @return BasicThreedsInitialize
     */
    public function paymentFromWebThreeD(PaymentCard $pc)
    {
        $user = $this->getUser();
        $this->setPaymentAccount($user);
        $this->setPaymentTransaction($this->paymentAccount);

        $request = $this->getRequest(\Config::get("custom.galepress_https_url") . '/' . \Config::get('application.language') . '/3d-secure-response');
        $pc->setRegisterCard(1);
        $request->setPaymentCard($pc);
        $basicThreedsInitialize = BasicThreedsInitialize::create($request, $this->options);
        $this->paymentTransaction->update3dTransaction($basicThreedsInitialize);
        return $basicThreedsInitialize;
    }

    public function paymentWithToken(PaymentAccount $paymentAccount)
    {
        $this->paymentAccount = $paymentAccount;

        $userInfoSet = array();
        //if we charge within the mounth then dont charge anymore
        $lastPaymentFlag = $paymentAccount->last_payment_day < date("Y-m-d", strtotime("-1 month +1 day"));
        $installmentFlag = $paymentAccount->payment_count < $paymentAccount->Application->Installment;
        if ($paymentAccount->payment_count > 0 && $paymentAccount->ValidUntil <= date("Y-m-d") && $lastPaymentFlag && $installmentFlag) {
            $cardToken = $this->paymentAccount->cardToken;
            if (empty($cardToken)) {
                return $userInfoSet;
            }
            //sleep before getting blocked ...
            $this->setPaymentTransaction($this->paymentAccount);
            $request = $this->getRequest();
            $paymentCard = new PaymentCard();
            $paymentCard->setCardToken($this->paymentAccount->cardToken);
            $paymentCard->setCardUserKey($this->paymentAccount->cardUserKey);
            $request->setPaymentCard($paymentCard);

            $basicPayment = BasicPayment::create($request, $this->options);
            $this->paymentTransaction->updateTransaction($basicPayment);
            $this->paymentAccount->updateAccount($basicPayment);

            if ($basicPayment->getStatus() !== 'success') {
                $paymentAccount->WarningMailPhase++;
                if ($paymentAccount->WarningMailPhase < 3) {
                    $paymentAccount->save();
                }

                $userInfoSet["customerID"] = $paymentAccount->CustomerID;
                $userInfoSet["error_reason"] = $basicPayment->getErrorMessage();
                $userInfoSet["email"] = $paymentAccount->email;
                $userInfoSet["name_surname"] = $paymentAccount->holder;
                $userInfoSet["last_payment_day"] = $paymentAccount->last_payment_day;
                $userInfoSet["warning_mail_phase"] = $paymentAccount->WarningMailPhase;
            }
        }
        return $userInfoSet;
    }

    /**
     * @param User $user
     * @return PaymentAccount
     */
    private function setPaymentAccount(User $user)
    {
        $customer = Customer::find($user->CustomerID);
        return $this->paymentAccount = $customer->getLastSelectedPaymentAccount();
    }

    /**
     * @param PaymentAccount $paymentAccount
     * @return PaymentTransaction
     */
    private function setPaymentTransaction(PaymentAccount $paymentAccount)
    {
        $this->paymentTransaction = new PaymentTransaction();
        $this->paymentTransaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
        $this->paymentTransaction->CustomerID = $paymentAccount->CustomerID;
        $this->paymentTransaction->amount = $this->paymentAccount->Application->Price;
        $this->paymentTransaction->currency = \Iyzipay\Model\Currency::TL;
        $this->paymentTransaction->save();
        return $this->paymentTransaction;
    }

    /**
     * @param string $callbackUri
     * @return \Iyzipay\Request\CreateBasicPaymentRequest
     */
    private function getRequest($callbackUri = '')
    {
        $request = new \Iyzipay\Request\CreateBasicPaymentRequest();
        $request->setLocale(MyPayment::getLang());
        $request->setConversationId($this->paymentTransaction->PaymentTransactionID);
        $request->setBuyerEmail($this->paymentAccount->email);
        $request->setBuyerId($this->paymentAccount->CustomerID);
        $request->setBuyerIp(Request::ip());
        $request->setConnectorName("690-garanti");
        $request->setInstallment(1);
        $request->setPaidPrice($this->paymentAccount->Application->Price);
        $request->setPrice($this->paymentAccount->Application->Price);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        if ($callbackUri) {
            $request->setCallbackUrl($callbackUri);
        }
        return $request;
    }

    public function get3dsResponse(iyzico3dsResponse $response)
    {
        $this->paymentTransaction = PaymentTransaction::find($response->conversationId);
        if (!$this->paymentTransaction) {
            $errorLog = new ServerErrorLog();
            $errorLog->Header = 571;
            $errorLog->Url = 'Server 3ds payment';
            $errorLog->Parameters = $response;
            $errorLog->ErrorMessage = 'Payment Transaction Data does not exists in Database.';
            $errorLog->save();
        }

        //lets get the PaymentAccount now
        $this->paymentAccount = PaymentAccount::find($this->paymentTransaction->PaymentAccountID);
        if ($response->status == 'success') {
            $request = new CreateThreedsPaymentRequest();
            $request->setLocale(MyPayment::getLang());
            $request->setConversationId($response->conversationId);
            $request->setPaymentId($response->paymentId);
            $basicThreedsPayment = BasicThreedsPayment::create($request, $this->options);
            $this->paymentAccount->updateAccount($basicThreedsPayment);
            $this->paymentTransaction->updateTransaction($basicThreedsPayment);
            return "Success";
        }
        return (string)__('error.something_went_wrong');
    }

    public function iyzicoSystemChange()
    {
        $accountIds = array();
        /** @var PaymentAccount[] $paymentAccounts */
        $paymentAccounts = PaymentAccount::all();
        foreach ($paymentAccounts as $paymentAccount) {
            if (!empty($paymentAccount->card_token) && empty($paymentAccount->cardToken)) {
                $parameters = array();
                $parameters['api_id'] = "im015089500879819fdc991436189064";
                $parameters['secret'] = "im015536200eaf0002c8d01436189064";
                $parameters['rnd'] = "x8y_jdsik9";
                $parameters['mode'] = "live";
                $parameters['card_token'] = $paymentAccount->card_token;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://iyziconnect.com/card-storage/get-card-detail/v2/");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                if (!empty($response)) {
                    $myResponse = json_decode($response, true);
                }
                if (!isset($myResponse['response']["state"])) {
                    continue;
                }

                if ($myResponse['response']["state"] != "success") {
                    continue;
                }

                $transaction = new PaymentTransaction();
                $transaction->PaymentAccountID = $paymentAccount->PaymentAccountID;
                $transaction->request = "token request";
                $transaction->save();


                $request = new CreateCardRequest();
                $request->setLocale(Locale::TR);
                $request->setConversationId($transaction->PaymentAccountID);
                $request->setEmail($paymentAccount->email);

                $cardInformation = new CardInformation();
                $cardInformation->setCardAlias("");
                $cardInformation->setCardHolderName($paymentAccount->holder);
                $cardInformation->setCardNumber($myResponse['card']["pan"]);
                $cardInformation->setExpireMonth($myResponse['card']["expiry_month"]);
                $cardInformation->setExpireYear($myResponse['card']["expiry_year"]);
                $request->setCard($cardInformation);

                $options = new Options();
                $options->setApiKey(MyPayment::iyzicoApiKey);
                $options->setSecretKey(MyPayment::iyzicoSecretKey);
                $options->setBaseUrl(MyPayment::iyzicoBaseUrl);
                # make request
                $card = Card::create($request, $options);
                $paymentAccount->cardToken = $card->getCardToken();
                $paymentAccount->cardUserKey = $card->getCardUserKey();
                $paymentAccount->save();
                $accountIds[] = $paymentAccount->PaymentAccountID;

            }
        }

        echo implode(',', $accountIds);
    }
}