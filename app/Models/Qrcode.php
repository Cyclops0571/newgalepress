<?php namespace App\Models;
use App\Helpers\MyPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;

/**
 * App\Models\Qrcode
 *
 * @property int $QrcodeID
 * @property int $QrSiteClientID
 * @property string $Name
 * @property string $Email
 * @property string $TcNo
 * @property string $Address
 * @property string $City
 * @property string $Phone
 * @property float $Price
 * @property string $Parameter
 * @property string $CallbackUrl
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static Builder|Qrcode whereQrcodeID($value)
 * @method static Builder|Qrcode whereQrSiteClientID($value)
 * @method static Builder|Qrcode whereName($value)
 * @method static Builder|Qrcode whereEmail($value)
 * @method static Builder|Qrcode whereTcNo($value)
 * @method static Builder|Qrcode whereAddress($value)
 * @method static Builder|Qrcode whereCity($value)
 * @method static Builder|Qrcode wherePhone($value)
 * @method static Builder|Qrcode wherePrice($value)
 * @method static Builder|Qrcode whereParameter($value)
 * @method static Builder|Qrcode whereCallbackUrl($value)
 * @method static Builder|Qrcode whereCreatedAt($value)
 * @method static Builder|Qrcode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Qrcode extends Model
{
    protected $table = 'Qrcode';
    protected $primaryKey = 'QrcodeID';

    public function makeIyzicoIframeRequest() {
        $name = explode(" ", $this->Name);
        $firstName = '';
        for($i = 0; $i < count($name) - 1; $i++) {
            $firstName = $firstName . $name[$i] . " ";
        }

        $firstName = trim($firstName);
        $lastName = $name[count($name) -1];

        //<editor-fold desc="Request">
        $request = new CreateCheckoutFormInitializeRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId($this->QrcodeID);
        $request->setPrice($this->Price);
        $request->setPaidPrice($this->Price);
        $request->setCurrency(Currency::TL);
        $request->setBasketId($this->QrcodeID);
        $request->setPaymentGroup(PaymentGroup::PRODUCT);
        $request->setCallbackUrl(route('get_checkout_result_form', ['qrCodeId' => $this->QrcodeID]));
        $request->setEnabledInstallments(array(1, 2, 3, 6, 9));
        //</editor-fold>

        $buyer = new Buyer();
        $buyer->setId($this->QrSiteClientID);
        $buyer->setEmail($this->Email);
        $buyer->setName($firstName);
        $buyer->setSurname($lastName);
        $buyer->setIdentityNumber($this->TcNo);
        $buyer->setRegistrationAddress($this->Address);
        $buyer->setCity($this->City);
        $buyer->setCountry("Turkey");
        $request->setBuyer($buyer);

        $billingAddress = new Address();
        $billingAddress->setContactName($this->Name);
        $billingAddress->setCity($this->City);
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress($this->Address);
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new BasketItem();
        $firstBasketItem->setId($this->QrcodeID);
        $firstBasketItem->setName("Qrcode Kredisi");
        $firstBasketItem->setCategory1("Qr-Code Kredisi");
//        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(BasketItemType::VIRTUAL);
        $firstBasketItem->setPrice($this->Price);
        $basketItems[] = $firstBasketItem;
        $request->setBasketItems($basketItems);

        # make request
        $options = new Options();
        $options->setApiKey(MyPayment::iyzicoApiKey);
        $options->setSecretKey(MyPayment::iyzicoSecretKey);
        $options->setBaseUrl(MyPayment::iyzicoBaseUrl);
        return CheckoutFormInitialize::create($request, $options);
    }
}
