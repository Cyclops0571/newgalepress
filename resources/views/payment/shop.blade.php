<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>
<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html> <!--<![endif]-->
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <title>GalePress Shop</title>
    <meta name="keywords" content="Gale Press, Paketler"/>
    <meta name="description" content="Gale Press paket bilgilerinin bulunduğu sayfa.">
    <meta name="author" content="Gale Press">
    <link rel="shortcut icon" href="/website/img/favicon2.ico">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Web Fonts  -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,200italic,400italic&subset=latin,latin-ext'
          rel='stylesheet' type='text/css'>

    <!-- Libs CSS -->
    <link rel="stylesheet" href="/website/styles/shop/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/website/styles/shop/vendor/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="/website/styles/shop/vendor/owl-carousel/owl.carousel.css" media="screen">
    <link rel="stylesheet" href="/website/styles/shop/vendor/owl-carousel/owl.theme.css" media="screen">
    <link rel="stylesheet" href="/website/styles/shop/vendor/magnific-popup/magnific-popup.css" media="screen">
    <link rel="stylesheet" href="/website/styles/shop/vendor/isotope/jquery.isotope.css" media="screen">
    <link rel="stylesheet" href="/website/styles/shop/vendor/mediaelement/mediaelementplayer.css" media="screen">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="/website/styles/shop/theme.css">
    <link rel="stylesheet" href="/website/styles/shop/theme-elements.css">
    <link rel="stylesheet" href="/website/styles/shop/theme-blog.css">
    <link rel="stylesheet" href="/website/styles/shop/theme-shop.css">
    <link rel="stylesheet" href="/website/styles/shop/theme-animate.css">

    <!-- Responsive CSS -->
    <link rel="stylesheet" href="/website/styles/shop/theme-responsive.css"/>

    <!-- Skin CSS -->
    <link rel="stylesheet" href="/website/styles/shop/skins/default.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/website/styles/shop/custom.css">

    <!-- Head Libs -->
    <script src="/website/styles/shop/vendor/modernizr.js"></script>

    <!--[if IE]>
    <link rel="stylesheet" href="/website/styles/shop/ie.css">
    <![endif]-->

    <!--[if lte IE 8]>
    <script src="/website/styles/shop/vendor/respond.js"></script>
    <![endif]-->

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
    <style type="text/css">
        * {
            font-family: 'Titillium Web', sans-serif !important;
        }

        i[class~="icon"] {
            font-family: FontAwesome !important;
        }

        .lead {
            font-weight: 300 !important;
        }

        p .alternative-font {
            top: 0 !important;
            font-size: 1.1em !important;
        }

        .pricing-table h3 span {
            font-weight: 300 !important;
        }

        #footer .footer-copyright nav ul li {
            border: none !important;
        }

        #footer .container .row > div {
            margin-bottom: 12px !important;
        }

        /*#header > .container{
            height: 37px !important;
        }*/
        #header {
            min-height: 0 !important;
        }

        #header nav ul.nav-main {
            margin: 0 !important;
        }

        .sub-menu li a img {
            border: 1px solid black;
            -webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.50);
            -moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.50);
            box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.50);
        }

        .sub-menu a:hover img {
            opacity: 0.3;
        }

        .sub-menu .read {
            position: absolute;
            top: 48%;
            left: 28%;
            font-size: 3em;
            display: none;
        }

        .sub-menu li:hover .read {
            display: block;
        }

        .sub-menu li {
            max-width: 200px;
        }

        .modal {
            overflow: hidden;
        }

        .logo.logo-sticky-active img {
            top: 32px !important;
        }

        .modal .modal-body {
            max-height: 400px;
            overflow-y: scroll;
        }

        .toggle-group {
            width: 187%;
        }

        .modal .modal-dialog {
            height: 100%;
            overflow-y: auto;
        }

        #loading {
            background: rgba(255, 255, 255, 0) url(/img/loadingGale.gif) no-repeat center center;
            height: 64px;
            width: 64px;
            position: fixed;
            left: 50%;
            top: 50%;
            margin: -25px 0 0 -25px;
            z-index: 1100;
            display: none;
        }
    </style>

</head>
<body>
<?php
if (FALSE) {
    $paymentAccount = new PaymentAccount();
    $applications = new Application();
}

$priceDiffers = FALSE;
if (count($applications) == 0) {
    $priceDiffers = FALSE;
    $price = 100.00;
} else if (count($applications) == 1) {
    $priceDiffers = FALSE;
    $price = $applications[0]->Price;
} else if (count($applications) != 1) {
    $initialPrice = $applications[0]->Price;
    foreach ($applications as $application) {
        if ($initialPrice != $application->Price) {
            $priceDiffers = TRUE;
        }
    }
}
$tabIndex = 1;
?>
<div class="body">
    <header id="header">
        <div class="container">
            <h1 class="logo">
                <a href="index.html">
                    <img alt="Gale Press" data-sticky-width="252" data-sticky-height="82"
                         src="/website/img/logo-dark.png">
                </a>
            </h1>
            <nav>
                <ul class="nav nav-pills nav-top">
                    <li>
                        <a href="<?php echo __('website.about_us_url');?>" target="_blank"><i
                                    class="icon icon-angle-right"></i><?php echo __('website.about_us');?></a>
                    </li>
                    <li>
                        <a href="<?php echo __('website.contact_url');?>" target="_blank"><i
                                    class="icon icon-angle-right"></i><?php echo __('website.contact'); ?></a>
                    </li>
                    <li class="phone">
                        <span><i class="icon icon-phone"></i><?php echo __('website.galepressphone'); ?></span>
                    </li>
                </ul>
            </nav>
            <button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
                <i class="icon icon-bars"></i>
            </button>
        </div>
        <div class="navbar-collapse nav-main-collapse collapse">
            <div class="container">
                <nav class="nav-main mega-menu">
                    <ul class="nav nav-pills nav-main" id="mainMenu">
                        <li class="dropdown mega-menu-item mega-menu-fullwidth active">
                            <a class="dropdown-toggle" href="#">
                                <?php echo __('website.contract'); ?>
                                <i class="icon icon-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="mega-menu-content">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <ul class="sub-menu">
                                                    <li>
                                                        <span class="read"><?php echo __('website.read'); ?></span>
                                                        <span class="mega-menu-sub-title"><?php echo __('website.distance_sales_contract'); ?></span>
                                                        <ul class="sub-menu">
                                                            <li>
                                                                <a href="/website/sozlesme/mesafeli-satis-sozlesmesi.docx?1"><img
                                                                            src="/website/styles/shop/img/mesafeliSatis.jpg"
                                                                            width="200"/></a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-3">
                                                <ul class="sub-menu">
                                                    <li>
                                                        <span class="read"><?php echo __('website.read'); ?></span>
                                                        <span class="mega-menu-sub-title"><?php echo __('website.confidentiality_agreement');?></span>
                                                        <ul class="sub-menu">
                                                            <li>
                                                                <a href="/website/sozlesme/gizlilik.docx"><img
                                                                            src="/website/styles/shop/img/gizlilik.jpg"
                                                                            width="200"/></a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div role="main" class="main">

        <section class="page-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li><a href="/"><?php echo __('website.page_home'); ?></a></li>
                            <li class="active"><?php echo __('website.packeges'); ?></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2><?php echo __('website.galepress_packeges'); ?></h2>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">

            <h2><?php echo __('website.interactive_packeges'); ?></h2>

            <div class="row">
                <div class="col-md-12">
                    <?php echo __('website.shop_description'); ?>
                </div>
            </div>

            <hr class="tall"/>
            <div class="row">

                <div class="pricing-table">

                    <div class="col-md-offset-4 col-md-3 center">
                        <div class="plan most-popular">
                            <?php if (!$priceDiffers): ?>
                            <div class="plan-ribbon-wrapper">
                                <div class="plan-ribbon">Popular</div>
                            </div>
                            <h3>Standart<span
                                        style="line-height: 80px;">&#x20BA;<?php echo $applications[0]->Price ?></span><br/><i
                                        style="color: rgb(0, 136, 204);font-size: 15px;"><?php echo __('website.monthly'); ?></i>
                            </h3>
                            <?php endif; ?>
                            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                                    data-target="#myModal"><?php echo __('website.buy');?></button>
                            <ul>
                                <?php if ($priceDiffers): ?>
                                <li><b><?php echo __('website.price_change'); ?></b></li>
                                <?php endif; ?>
                                <?php echo __('website.shop_properties');?>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>


        </div>

    </div>

    <footer id="footer">
        <?php if(Config::get('application.language') == 'tr'):?>
        <div class="container">
            <div class="row">

                <div class="col-md-5">
                    <div class="newsletter">
                        <h4><?php echo __('website.about_us');?></h4>
                        <p>Detaysoft, 13 yılı aşkın bir süredir, yazılım uygulamaları ve yenilikçi geliştirme konusunda,
                            personel sayısı 200'ü aşan ve kendi sektöründe lider kuruluşlara danışmanlık hizmeti
                            vermektedir.</p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="contact-details">
                        <h4>İletişim</h4>
                        <ul class="contact">
                            <li><p><i class="icon icon-map-marker"></i> <strong>Adres:</strong> Alemdağ Cad. No: 109,
                                    Üsküdar / İstanbul / Türkiye</p></li>
                            <li><p><i class="icon icon-phone"></i> <strong>Telefon:</strong> +90 (216) 443 13 29</p>
                            </li>
                            <li><p><i class="icon icon-print"></i> <strong>Fax:</strong> +90 (216) 443 08 27</p></li>
                            <li><p><i class="icon icon-envelope"></i> <strong>Email:</strong> <a
                                            href="mailto:info@galepress.com">info@galepress.com</a></p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <h4>Takip Edin</h4>

                    <div class="social-icons">
                        <ul class="social-icons">
                            <li class="facebook"><a
                                        href="https://www.facebook.com/pages/Galepress/267455253374597?fref=ts"
                                        target="_blank" data-placement="bottom" rel="tooltip"
                                        title="Facebook">Facebook</a></li>
                            <li class="twitter"><a href="https://twitter.com/GalePress" target="_blank"
                                                   data-placement="bottom" rel="tooltip" title="Twitter">Twitter</a>
                            </li>
                            <li class="linkedin"><a href="https://www.linkedin.com/company/galepress" target="_blank"
                                                    data-placement="bottom" rel="tooltip" title="Linkedin">Linkedin</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?>
        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-8" style="padding:0; margin-top:3px;">
                        <?php echo __('website.footer_copyright'); ?>
                    </div>
                    <div class="col-md-4">
                        <nav id="sub-menu">
                            <ul>
                                <li><img src="/website/styles/shop/img/visa.png" width="45"/></li>
                                <li><img src="/website/styles/shop/img/master.png" width="45"/></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo __('website.towards_payment_page'); ?></h4>
            </div>
            <form action="{{URL::to_route((string)__('route.payment_card_info'))}}" method="post" id="userInfos"
                  class="form-horizontal" novalidate>
                <div class="modal-body">
                    <?php if (count($applications) > 1): ?>
                    <script>
                        function setUIPrice() {
                            jQuery('#loading').show();
                            var app = JSON.parse($('#applicationID option:selected').attr('data-application'));
                            $("#Price").val(app["attributes"]["Price"]);
                            $("#Installment").val(app["attributes"]["Installment"]);

                            var paymentAccount = null;
                            //application degisti bu yeni applicasyonun PaymentAccountu bize gerekli.
                            $.get('payment/paymentAccountByApplicationID/' + app["attributes"]["ApplicationID"],
                                    function (data) {
                                        jQuery('#loading').hide();
                                        paymentAccount = JSON.parse(data);
                                        if (paymentAccount) {

                                            if (paymentAccount["attributes"]["kurumsal"] == 0) {
                                                //bireysel
                                                $("#customerType").bootstrapToggle('on');
                                            } else {
                                                $("#customerType").bootstrapToggle('off');

                                            }

                                            changeCustomerType();
                                            $("#email").val(paymentAccount["attributes"]["email"]);
                                            $("#phone").val(paymentAccount["attributes"]["phone"]);
                                            $("#customerTitle").val(paymentAccount["attributes"]["title"]);
                                            $("#tc").val(paymentAccount["attributes"]["tckn"]);
                                            //$("#city").val(paymentAccount["attributes"]["city"]); 572572
                                            $("#address").val(paymentAccount["attributes"]["address"]);
                                            $("#taxOffice").val(paymentAccount["attributes"]["vergi_dairesi"]);
                                            $("#taxNo").val(paymentAccount["attributes"]["vergi_no"]);
                                        }
                                    }
                            );
                        }
                    </script>
                    <h5 class="col-xs-12"><?php echo strtoupper((string)__('website.application_selection'));?></h5>

                    <div class="form-group">
                        <label for="applicationID" class="control-label col-xs-3"
                               style="padding-top: 16px;"><?php echo __('website.application_selection');?></label>

                        <div class="col-xs-9">
                            <select id="applicationID" onchange="setUIPrice();" class="form-control required"
                                    name="applicationID" tabindex="{{$tabIndex++}}" required>
                                <option data-price='0.00'
                                        selected="selected"><?php echo __('website.application_select') ?></option>
                                <?php foreach ($applications as $application): ?>
                                <option data-application='<?php echo json_encode($application, TRUE); ?>'
                                        value="{{$application->ApplicationID}}" <?php echo $application->ApplicationID == $paymentAccount->ApplicationID ? 'selected="selected"' : ''; ?> >{{$application->Name}}</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div id='userInterfacePriceDiv' class='form-group'>
                        <div class="col-md-3">{{ __('common.applications_price') }}</div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <?php
                                $selectedApplicationPrice = 0.00;
                                foreach ($applications as $application) {
                                    if ($application->ApplicationID == $paymentAccount->ApplicationID) {
                                        $selectedApplicationPrice = $application->Price;
                                    }
                                }
                                ?>

                                <input type="text" name="Price" id="Price" class="form-control textbox" disabled
                                       value="{{ $selectedApplicationPrice }}"/>
                                <span class="input-group-addon"><?php echo __('website.currency'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div id='userInterfacePriceDiv' class='form-group'>
                        <div class="col-md-3">{{ __('common.applications_price') }}</div>
                        <div class="col-md-9">
                            <span class="info-content"><?php echo $selectedApp->Installment; ?></span>
                        </div>
                    </div>
                    <hr>
                    <?php else: ?>
                    <input type="hidden" name="applicationID" value="<?php echo $applications[0]->ApplicationID; ?>"/>
                    <?php endif; ?>

                    <h5 class="col-xs-12"><?php echo __('website.user_info');?></h5>
                    <div class="form-group">
                        <label for="customerType" class="control-label col-xs-3" style="padding-top: 16px;">
                            <?php echo __('website.individual') . '/' . __('website.company');?>
                        </label>

                        <div class="col-xs-9">
                            <input class="form-control required" type="checkbox"
                                   checked data-toggle="toggle" data-size="normal"
                                   id="customerType" name="customerType"
                                   data-onstyle="success"
                                   data-offstyle="info"
                                   data-on="<?php echo __('website.individual');?>"
                                   data-off="<?php echo __('website.company');?>"
                                   data-width="200"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email"
                               class="control-label col-xs-3"><?php echo __('website.email_address');?></label>

                        <div class="col-xs-9">
                            <input id="email" class="form-control required" maxlength="50" name="email" size="50"
                                   type="email" tabindex="1" value="<?php echo $paymentAccount->email; ?>"
                                   placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label col-xs-3"><?php echo __('website.phone');?></label>

                        <div class="col-xs-9">
                            <input id="phone" maxlength="14" name="phone" size="20" type="text"
                                   class="form-control required" tabindex="2"
                                   value="<?php echo $paymentAccount->phone; ?>" placeholder="Telefon" required>
                        </div>
                    </div>
                    <hr>
                    <h5 class="col-xs-12"><?php echo __('website.billing_info');?></h5>

                    <div class="form-group">
                        <label for="customerTitle"
                               class="control-label col-xs-3"><?php echo __('website.contact_form_name');?></label>

                        <div class="col-xs-9">
                            <input id="customerTitle" class="form-control required" maxlength="100" name="customerTitle"
                                   size="20" type="text" tabindex="6" value="<?php echo $paymentAccount->title; ?>"
                                   placeholder="<?php echo __('website.username_company_name');?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tc"
                               class="control-label col-xs-3"><?php echo __('website.identification_number');?></label>

                        <div class="col-xs-9">
                            <input class="form-control required" id="tc" name="tc" type="text" maxlength="11"
                                   tabindex="3" value="<?php echo $paymentAccount->tckn; ?>"
                                   placeholder="<?php echo $paymentAccount->tckn; ?>"/>
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label for="taxOffice"
                               class="control-label col-xs-3"><?php echo __('website.tax_administration');?></label>

                        <div class="col-xs-9">
                            <input id="taxOffice" class="form-control required" maxlength="100" name="taxOffice"
                                   size="20" type="text" tabindex="7"
                                   value="<?php echo $paymentAccount->vergi_dairesi; ?>"
                                   placeholder="<?php echo __('website.tax_administration');?>"
                                   required>
                        </div>
                    </div>
                    <div class="form-group hide">
                        <label for="taxNo" class="control-label col-xs-3"><?php echo __('website.tax_number');?></label>

                        <div class="col-xs-9">
                            <input id="taxNo" class="form-control required" maxlength="100" name="taxNo" size="20"
                                   type="text" tabindex="8" value="<?php echo $paymentAccount->vergi_no; ?>"
                                   placeholder="<?php echo __('website.tax_number');?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country" class="control-label col-xs-3"><?php echo __('website.country');?></label>

                        <div class="col-xs-9">
                            <input id="country" class="form-control required" maxlength="25" name="country" size="20"
                                   type="text" tabindex="4" value="Türkiye"
                                   placeholder="<?php echo __('website.country');?>" required
                                   disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="city" class="control-label col-xs-3"><?php echo __('website.city');?></label>

                        <div class="col-xs-9">
                            <select id="city" class="form-control required" name="city" tabindex="6"
                                    placeholder="<?php echo __('website.city');?>" required>
                                <option selected="selected"
                                        disabled="disabled"><?php echo __('website.select_city');?></option>
                                @foreach($city as $c)
                                    <option value="{{$c->CityID}}" <?php echo $c->CityID == $paymentAccount->CityID ? 'selected="selected"' : ''; ?> >{{$c->CityName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label col-xs-3"><?php echo __('website.address');?></label>

                        <div class="col-xs-9">
                            <textarea id="address" class="form-control required" maxlength="100" name="address"
                                      size="20" tabindex="6" placeholder="<?php echo __('website.address_info');?>"
                                      required
                                      rows="4"><?php echo $paymentAccount->address; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group errorMsg hide" style="color:#CA0101; text-align:center; font-size:18px;">
                        <span><?php echo __('website.check_your_info');?></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="payBtn"
                            type="submit"><?php echo __('website.continue');?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Libs -->
<script src="/website/styles/shop/vendor/jquery.js"></script>
<script src="/website/styles/shop/vendor/jquery.appear.js"></script>
<script src="/website/styles/shop/vendor/jquery.easing.js"></script>
<script src="/website/styles/shop/vendor/jquery.cookie.js"></script>
<script src="/website/styles/shop/vendor/bootstrap/js/bootstrap.js"></script>
<script src="/website/styles/shop/vendor/jquery.validate.js"></script>
<script src="/website/styles/shop/vendor/jquery.stellar.js"></script>
<script src="/website/styles/shop/vendor/jquery.knob.js"></script>
<script src="/website/styles/shop/vendor/jquery.gmap.js"></script>
<script src="/website/styles/shop/vendor/twitterjs/twitter.js"></script>
<script src="/website/styles/shop/vendor/isotope/jquery.isotope.js"></script>
<script src="/website/styles/shop/vendor/owl-carousel/owl.carousel.js"></script>
<script src="/website/styles/shop/vendor/jflickrfeed/jflickrfeed.js"></script>
<script src="/website/styles/shop/vendor/magnific-popup/magnific-popup.js"></script>
<script src="/website/styles/shop/vendor/mediaelement/mediaelement-and-player.js"></script>

<!-- Theme Initializer -->
<script src="/website/scripts/shop/theme.plugins.js"></script>
<script src="/website/scripts/shop/theme.js"></script>

<!-- Custom JS -->
<script src="/website/scripts/shop/custom.js"></script>
<script src="/website/scripts/shop/validate/jquery.mask.min.js"></script>
<script src="/js/bootstrap-toggle.min.js"></script>


<script type="text/javascript">
    var bootstrapInitialStatus = <?php echo json_encode($paymentAccount->kurumsal ? "off" : "on")?>;
    function changeCustomerType() {
        if ($("#customerType").prop('checked')) {//bireysel
            $('#tc').closest('.form-group').removeClass('hide');
            $('#taxOffice').closest('.form-group').addClass('hide');
            $('#taxNo').closest('.form-group').addClass('hide');
        }
        else {//kurumsal
            $('#taxOffice').closest('.form-group').removeClass('hide');
            $('#taxNo').closest('.form-group').removeClass('hide');
            $('#tc').closest('.form-group').addClass('hide');
        }
    }

    $(function () {
        $("#customerType").bootstrapToggle(bootstrapInitialStatus);
        changeCustomerType();
        $('#customerType').change(function () {
            changeCustomerType();
        });

        $("#tc").keyup(function () {
            $("#tc").val(this.value.match(/[0-9]*/));
        });

        $("#phone").mask("(999) 999-9999", {placeholder: "(___) __ ____"});


        $("#userInfos").bind("submit", function () {

            var email = $("#email").val();
            var phone = $("#phone").val();

            var phonePattern = /[0-9]/;
            var mailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            if (phone.length < 14 || !phonePattern.test(phone)) {
                $('.errorMsg').removeClass('hide').text('<?php echo __('website.valid_phone');?>');
                $('#phone').focus();
                return false;
            }
            else if (email == "" || !mailPattern.test(email)) {
                $('.errorMsg').removeClass('hide').text('<?php echo __('website.valid_email');?>');
                $('#email').focus();
                return false;
            }
            else if ($("#tc").val().length < 11 && $('#customerType').prop('checked')) {
                $('.errorMsg').removeClass('hide').text('<?php echo __('website.valid_identification_number');?>');
                $('#tc').focus();
                return false;
            }
            else if ($("#city").val() == null) {
                $('.errorMsg').removeClass('hide').text('<?php echo __('website.select_city');?>');
                $('#city').focus();
                return false;
            }
            else {
                $('.errorMsg').addClass('hide');
                // return false;
            }
        });

    });
</script>
<div id="loading"></div>
</body>
</html>