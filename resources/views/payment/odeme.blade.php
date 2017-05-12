<?php
$user = Auth::user();
$url = "https://api.iyzico.com/v2/create";   // sorgularda kullanacağımız endpoint
$data =  'api_id=im0322080005c70f195bca1434712720' . //size özel iyzico api
'&secret=im0339018007d7a8f10f1c1434712720' . // size özel iyzico secret
'&external_id=' . $user->CustomerID . //sipariş numarası olarka kullanabileceğimizalan
'&mode=' . config("custom.payment_environment") . // live olmalı, gerçek ödeme alabilmek için
'&type=RG.DB' . // iyzico form yükleme tipi. Kart saklayan form yüklemesi.
        '&return_url=' . config("custom.galepress_https_url") . '/' . app()->getLocale() . '/3d-secure-response' . //bu ödemenin sonucunu ben hangi sayfaya dönmeliyim. Sitenizde bu ödemeye ait sonuç nereye dönsün. Başarılımı başarısız mı orada anlayacağız.
'&amount=10000' . // 100 ile çarpılmış bağış bedeli. 10,99 TL bağış için 1099 olmalı.  100 lira bağış için 10000 olmalı
'&currency=TRY' . //  para birimi. Bu sabit olarak TRY olmalı
'&customer_contact_ip='. Request::ip() . // ödemeyi yapan kişinin ip adresi
'&customer_language=tr' . // ödeme formunun dili
'&installment=false' . // taksit açık kapalı. .
'&customer_contact_mobile=' . $phone . // mobil telefon
'&customer_contact_email=' . $email . // email
'&customer_presentation_usage=GalepressAylikOdeme_' . date('YmdHisu') . // iyzico kontrol panelde ilk bakışta ödemenin ne ile ilgili yapıldığını görebilme. Sipariş numarası ile aynı olabilir.
'&descriptor= GalepressAylikOdeme_' . date('YmdHisu'); // iyzico kontrol panelde ilk bakışta ödemenin ne ile ilgili yapıldığını görebilme. Sipariş numarası ile aynı olabilir.

                                $params = array('http' => array(
                                  'method' => 'POST',
                                    'content' => $data
                                  ));
                                $ctx = stream_context_create($params);
                                $fp = @fopen($url, 'rb', false, $ctx);
                                if (!$fp) {
                                  throw new Exception("Problem with $url, $php_errormsg");
                                }
                                $response = @stream_get_contents($fp);
                                if ($response === false) {
                                  throw new Exception("Problem reading data from $url, $php_errormsg");
                                }             
                                $resultJson = json_decode($response,true);
                               print_r($resultJson);
                               echo "email: " .$email. "phone: ". $phone;
                              
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"    "http://www.w3.org/TR/html4/loose.dtd">  
 <html>  
    <head>
      <style type="text/css">
        body{
          background: url(/images/website/galepress.png);
          background-opacity: 0.5;
        }
        .iyzico-payment-form.iyziForm{
          margin-left: 39%;
        }
      </style>
         <script src="https://www.iyzico.com/frontend/form/v1/widget.js?&mode={{config("custom.payment_environment")}}&installment=true&token={{$resultJson['transaction_token']}}&language=tr" ></script>
  </head>  
  <body>
         <form class="iyzico-payment-form"></form>
  </body>
  </html>
