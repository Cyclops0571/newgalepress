<!DOCTYPE html>
<html>
<head>
    <title>{{__('website.galepress_payment') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" href="/website/img/favicon2.ico">
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

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="/website/styles/shop/vendor/jquery.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <meta name="viewport" content="initial-scale=1">
    <style>
        .demo-container {
            width: 100%;
            max-width: 400px;
            margin: 10px auto;
        }

        form {
            margin: 30px;
        }

        .jp-card .jp-card-front {
            background-color: #333333 !important;
            background-image: url(/website/img/galepress.png) !important;
        }

        .jp-card-back {
            background-color: #333333 !important;
        }

        #payBtn {
            height: 35px;
            background: #41A2FF;
            border: 1px solid white;
            color: white;
            cursor: pointer;
            margin-right: 16px;
            border-radius: 4px;
        }

        .form-horizontal {
            margin: 30px 0 30px 0;
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

        #header > .container {
            height: 100px;
            margin-bottom: -35px;
            position: relative;
            display: table;
            max-width: 1170px;
        }
    </style>
</head>
<body>
<?php
$currency = (string)__('website.currency');
if (false) {
    $paymentAccount = new PaymentAccount();
}
?>
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
                                class="icon icon-angle-right"></i><?php echo $currency; ?></a>
                </li>
                <li class="phone">
                    <span><i class="icon icon-phone"></i><?php echo __('website.galepressphone'); ?></span>
                </li>
            </ul>
        </nav>
    </div>
</header>

<div class="demo-container">
    <div class="card-wrapper"></div>

    <div class="form-container active">
        <form action="{{route('payment_approvement')}}" method="post" id="paymentForm" class="form-horizontal" autocomplete="off">
            <input type="hidden" name="card_brand" id="card_brand" value=""/>
            <div class="form-group">
                <label class="control-label col-md-5">{{__('website.price')}}</label>
                <label class="control-label col-md-7">
                    <?php echo $application->Price ?> {{__('website.currency')}}
                </label>
            </div>
            <div class="form-group">
                <label for="card_holder_name" class="control-label col-md-5">{{__('website.name_on_card')}}</label>
                <div class="col-xs-7">
                    <input class="form-control required" placeholder="{{__('website.name_on_card')}}" type="text"
                           name="card_holder_name" id="card_holder_name">
                </div>
            </div>
            <div class="form-group">
                <label for="card_number" class="control-label col-md-5">{{__('website.card_number')}}</label>
                <div class="col-xs-7">
                    <input class="form-control required" placeholder="{{__('website.card_number')}}" type="text"
                           name="card_number" id="card_number">
                </div>
            </div>
            <div class="form-group">
                <label for="card_expiry_month" class="control-label col-md-5">{{__('website.expiration_date')}}</label>
                <div class="col-md-3">
                    <select name="card_expiry_month" id="card_expiry_month" class="form-control" runat="server"
                            style="max-width: 181px;">
                        <option selected disabled>{{__('website.month')}}</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="card_expiry_year" id="card_expiry_year" class="form-control" runat="server"
                            style="max-width: 181px;">
                        <option selected disabled>{{__('website.year')}}</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="card_verification" class="control-label col-md-5">CVC2</label>
                <div class="col-md-7">
                    <input class="form-control required" placeholder="CVC2" type="text" name="card_verification"
                           id="card_verification" maxlength="3">
                </div>
            </div>
            <div class="form-group">
                <label for="3d_secure" class="control-label col-md-5">3D Secure</label>
                <div class="col-md-7">
                    <input type="checkbox" name="3d_secure" id="3d_secure" value="1">
                </div>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                        data-target="#myModal">{{__('website.payment_confirm')}}</button>
            </div>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">{{__('website.payment_confirm')}}</h4>
                        </div>
                        <div class="modal-body">
                            <label class="control-label">{{__('website.payment_confirmation_alert', array("COST" => $application->Price . $currency))}}</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{__('website.cancel')}}</button>
                            <input type="submit" value="{{__('website.payment_confirm')}}" name="payBtn" id="payBtn"
                                   class="pull-right">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group errorMsg hide" style="color:#CA0101; text-align:center; font-size:18px;">
                <span>{{__('website.please_check_your_information')}}</span>
            </div>
        </form>
    </div>

</div>

<script src="/website/scripts/shop/payment-galepress/card.js"></script>

<script>

    new Card({
        form: document.querySelector('form'),
        container: '.card-wrapper',
        formSelectors: {
            numberInput: 'input#card_number', // optional — default input[name="number"]
            expiryInput: 'input#expiry', // optional — default input[name="expiry"]
            cvcInput: 'input#card_verification', // optional — default input[name="cvc"]
            nameInput: 'input#card_holder_name' // optional - defaults input[name="name"]
        },
        values: {
            number: '•••• •••• •••• ••••',
            name: '{{__('website.name_on_card')}}',
            expiry: '••/••',
            cvc: '•••'
        },
        messages: {
            validDate: '', // optional - default 'valid\nthru'
            monthYear: '{{__('website.month')}} / {{__('website.year')}}', // optional - default 'month/year'
        },
    });

    $(function () {

        $('#card_number').keyup(function () {
            cardType = $('.jp-card').attr('class').split(' ')[1];
            cardType = cardType.split('-')[2];
            $('#card_brand').val(cardType);
        });

        var selectedMonth = "";
        var selectedYear = "";
        $('select#card_expiry_month').on('change', function () {
            selectedMonth = $('select#card_expiry_month option:selected').val();
            $('.jp-card-expiry').css('opacity', 1);
            $('.jp-card-expiry').text(selectedMonth + '/' + selectedYear);
        });

        $('select#card_expiry_year').on('change', function () {
            selectedYear = $('select#card_expiry_year option:selected').val();
            $('.jp-card-expiry').css('opacity', 1);
            $('.jp-card-expiry').text(selectedMonth + '/' + selectedYear);
        });

        $("#paymentForm").bind("submit", function () {
            var card_expiry_month = $("#card_expiry_month").val();
            var card_expiry_year = $("#card_expiry_year").val();
            $('#myModal').modal('hide');
            if ($('#card_number').val().length < 16) {

                $('.errorMsg').removeClass('hide').text('{{__('website.please_enter_your_16_digit_card_number')}}');
                $('#card_number').focus();
                return false;
            }

            else if ($('#card_holder_name').val().length == 0) {

                $('.errorMsg').removeClass('hide').text('{{__('website.please_enter_the_name_on_card')}}');
                $('#card_holder_name').focus();
                return false;
            }

            else if (card_expiry_month == null || card_expiry_year == null) {

                $('.errorMsg').removeClass('hide').text('{{__('website.please_select_card_expiration_date')}}');
                $('#card_expiry_month').focus();
                return false;
            }
            else if ($('#card_verification').val().length < 3) {

                $('.errorMsg').removeClass('hide').text('{{__('website.please_enter_ccv2_number')}}');
                $('#card_verification').focus();
                return false;
            }
            else {
                $('.errorMsg').addClass('hide');
            }
        });
    });
</script>
</body>
</html>
