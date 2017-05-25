<?php
namespace App\Http\Controllers;
use App\Library\MyPayment;
use App\Models\City;
use App\Models\Qrcode;
use Illuminate\Http\Request;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentItem;
use Iyzipay\Options;
use Iyzipay\Request\RetrieveCheckoutFormRequest;
use Validator;

class IyzicoController extends Controller
{

    public function index(Request $request)
    {
        $qrCodeId = $request->get('qrCodeId', 0);
        $cb = $request->get('cb', '');
        $price = $request->get('price', '');
        $id = $request->get('id', '');
        $pm = $request->get('pm', '');
        $qrCode = new Qrcode();
        $errors = null;
        //iyzicoqr?qrCodeId=5
        if (empty($qrCodeId)) {
            $rules = array(
                "id" => 'required|integer',
                "price" => 'required',
                "cb" => 'required',
                "pm" => 'required'
            );

            $v = Validator::make($request->all(), $rules);
            if($v->fails()) {
                $errors = $v->errors();
            }

            if (strpos($cb, 'https://') === false || strpos($cb, 'http://') === false) {
                $cb = 'http://' . $cb;
            }
        } else {
            /** @var Qrcode $qrCode */
            $qrCode = Qrcode::find($request->get('qrCodeId'));
            if ($qrCode) {
                $cb = $qrCode->CallbackUrl;
                $price = $qrCode->Price;
                $id = $qrCode->QrSiteClientID;
                $pm = $qrCode->Parameter;
            }
        }


        $cities = array();
        $cities[] = City::where("CityID", 34)->first();
        $cities[] = City::where("CityID", 6)->first();
        $cities[] = City::where("CityID", 35)->first();
        $orderedCities = City::whereNotIn("CityID", array(6, 34, 35))->orderBy('CityName')->get();
        $cities = array_merge($cities, $orderedCities->all());
        $data = array();
        $data["city"] = $cities;
        $data["id"] = $id;
        $data["price"] = $price;
        $data["cb"] = $cb;
        $data["pm"] = $pm;
        $data["errors"] = $errors;
        $data["qrCode"] = $qrCode;

        return view('iyzicoqr.billing', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {

        $rules = array(
            "qrCodeClientId" => 'required|integer',
            "price" => 'required',
            "callback" => 'required',
            "email" => 'required',
            "phone" => 'required',
            "tc" => 'required',
            "address" => 'required',
            "pm" => 'required'
        );
        $qrCode = new Qrcode();
        $qrCode->CallbackUrl = $request->get("callback", "");
        $qrCode->QrSiteClientID = $request->get("qrCodeClientId", "");
        $qrCode->Price = $request->get("price", "");
        $qrCode->Parameter = $request->get("pm", "");
        $qrCode->Name = $request->get("name", "");
        $qrCode->Email = $request->get("email", "");
        $qrCode->Phone = $request->get("phone", "");
        $qrCode->TcNo = $request->get("tc", "");
        $qrCode->City = $request->get("city", "");
        $qrCode->Address = $request->get("address", "");
        $qrCode->save();
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            return \Redirect::to(\URL::to('iyzicoqr', ['errMsg' => urlencode($v->errors()->first())]));
            // 571571
        }
        return \Redirect::to(\URL::to('open_iyzico_iframe', ['qrCodeId' => $qrCode->QrcodeID]));
    }

    public function openIyzicoIframe(Qrcode $qrCode)
    {
        $checkoutFormInitialize = $qrCode->makeIyzicoIframeRequest();
        $errorMessage = $checkoutFormInitialize->getErrorMessage();
        if (!empty($errorMessage)) {
            return \Redirect::to(\URL::to('iyzicoqr', ['qrCodeId' => $qrCode->QrcodeID]));
        }

        $data = array();
        $data["checkoutFormInitialize"] = $checkoutFormInitialize;
        return view('iyzicoqr.payment', $data);
    }

    public function checkoutIyzicoResultForm(Request $request)
    {
        $rules = array("token" => "required", "qrCodeId" => "required|exists:Qrcode,QrcodeID");
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            return $v->errors()->first();
        }

        /** @var Qrcode $qrCode */
        $qrCode = Qrcode::find($request->get("qrCodeId"));
        $iyzicoFormRequest = new RetrieveCheckoutFormRequest();
        $iyzicoFormRequest->setLocale(Locale::TR);
        $iyzicoFormRequest->setConversationId($request->get("qrCodeId"));
        $iyzicoFormRequest->setToken($request->get('token'));
        # make request
        $options = new Options();
        $options->setApiKey(MyPayment::iyzicoApiKey);
        $options->setSecretKey(MyPayment::iyzicoSecretKey);
        $options->setBaseUrl(MyPayment::iyzicoBaseUrl);
        $checkoutForm = CheckoutForm::retrieve($iyzicoFormRequest, $options);
//        var_dump($checkoutForm); exit;
        /** @var PaymentItem[] $items */
        $items = $checkoutForm->getPaymentItems();

        $resultUrl = array();
        $resultUrl[] = $qrCode->CallbackUrl . "?success=" . $checkoutForm->getStatus();
        $resultUrl[] = "message=" . $checkoutForm->getErrorMessage();
        $resultUrl[] = "pm=" . $qrCode->Parameter;
        $resultUrl[] = "price=" . $qrCode->Price;
        $resultUrl[] = "id=" . $qrCode->QrSiteClientID;
        $resultUrl[] = "tid=" . ($items ? $items[0]->getPaymentTransactionId() : "");
        return \Redirect::to(implode('&', $resultUrl));
    }

}