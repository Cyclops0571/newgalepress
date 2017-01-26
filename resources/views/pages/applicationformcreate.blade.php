<?php
$orderNo = '';
$note = '';
$product = '';
$qty = 0;
if (isset($_GET['orderno'])) {
    $orderNo = $_GET['orderno'];
}

if (isset($_GET['note']) && strlen($orderNo) == 0) {
    $note = $_GET['note'];
    preg_match("'<b>Havale No </b> : (.*?)<br>'s", $note, $matches);
    if ($matches) {
        $orderNo = $matches[1];
    }
}
if (strlen($orderNo) == 0)
    $orderNo = 'm000' . ($lastorderno->OrderID + 1);

if (isset($_GET['product'])) {
    $product = $_GET['product'];
}

if (isset($_GET['qty'])) {
    $qty = (int)$_GET['qty'];
}
?>
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
    <title>Uygulama Oluşturma Formu</title>
    <meta name="keywords" content="Gale Press Dijital Yayıncılık"/>
    <meta name="description" content="Gale Press - Dijital Yayıncılık Platformu">
    <meta name="author" content="galepress.com">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('js.language')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/website/vendor/jquery.js"><\/script>')</script>
    <script src="/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="/uploadify/jquery.uploadify-3.1.min.js"></script>
    <script src="/bundles/jupload/js/jquery.iframe-transport.js"></script>
    <script src="/bundles/jupload/js/jquery.fileupload.js"></script>
    <script src="/js/jquery.base64.decode.js"></script>
    <script src="/js/gurus.string.js"></script>


    <!-- Bootstrap core CSS -->
    <link href="/website/app-form/css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="/website/app-form/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="/website/app-form/font-awesome/css/font-awesome.min.css">

    <style type="text/css">
        .stageSuccess {
            background: #5FCA17;
        }

        .navbar-inverse .navbar-nav > li.disabled a {
            color: #999 !important;
        }

        .navbar-inverse .navbar-nav > li a:hover {
            background: #d6dce1 !important;
        }

        .navbar-inverse .navbar-nav > li a:focus {
            background: #d6dce1 !important;
        }

        .headerPattern {
            background: url(/website/app-form/images/pattern.jpg) repeat;
            background-color: white;
        }

        .fileUploadRequiredField {
            padding: 0;
        }

        .noWhiteSpace {
            white-space: normal;
            padding: 15px;
            margin-top: 10px;
            position: relative;
            cursor: pointer !important;
        }

        .appListSuccess {
            color: #464242 !important;
            font-weight: 700 !important;
        }

        .disabled {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            pointer-events: none;
        }

        .ulDisabled {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            pointer-events: none;
        }

        .liBorders {
            border-left: 6px solid rgba(0, 0, 0, 0.1);
            left: 0;
            top: 0;
            position: absolute;
            height: 100%;
        }

        .liBordersActive {
            border-left: 6px solid #428bca;
            left: 0;
            top: 0;
            position: absolute;
            height: 100%;
        }

        .active {
            background: #d6dce1;
        }

        ::-webkit-input-placeholder {
            color: rgba(0, 0, 0, .32) !important;
            font-size: 12px !important;
            font-style: italic;
        }

        :-moz-placeholder { /* Firefox 18- */
            color: rgba(0, 0, 0, .32) !important;
            font-size: 12px !important;
            font-style: italic;
        }

        ::-moz-placeholder { /* Firefox 19+ */
            color: rgba(0, 0, 0, .32) !important;
            font-size: 12px !important;
            font-style: italic;
        }

        :-ms-input-placeholder {
            color: rgba(0, 0, 0, .32) !important;
            font-size: 12px !important;
            font-style: italic;
        }

        fieldset.scheduler-border {
            border: 2px dashed #e5e5e5 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #e5e5e5;
            box-shadow: 0px 0px 0px 0px #e5e5e5;
        }

        fieldset .row {
            margin-top: -15px !important;
        }

        fieldset .btn-primary {
            border-left: 3px solid #4E7DA5 !important;
            border-bottom: 5px solid #4E7DA5 !important;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
        }

        input[type=button] {
            outline: 0 !important;
        }

        .screenshotsInfo {
            color: rgba(0, 0, 0, 0.3);
            font-size: 24px;
            cursor: pointer;
            float: right;
            margin-bottom: -20px;
            margin-right: -18px;
            margin-top: 12px;
        }

        .upload {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }

        .isCheck {
            color: rgba(0, 0, 0, 0.3);
            font-size: 14px;
            display: none;
            margin-top: 7px;
            display: inline-block;
        }

        @media all and (max-width: 579px) {
            .fullStage {
                margin-top: 28px;
            }
        }

        @media all and (max-width: 346px) {
            .fullStage {
                margin-top: 52px;
            }
        }
    </style>
    <?php
    $a = include($_SERVER['DOCUMENT_ROOT'] . "/../application/language/" . "tr" . "/route.php");
    ?>
    <script type="text/javascript">
        <!--
        var route = new Array();
        route["orders_save"] = "<?php echo $a['orders_save']; ?>";
        route["orders_uploadfile"] = "<?php echo $a['orders_uploadfile']; ?>";
        route["orders_uploadfile2"] = "<?php echo $a['orders_uploadfile2']; ?>";
        // -->
    </script>
</head>
<body>
<div id="wrapper">
    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top headerPattern" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Navigasyon</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <h3 style="margin-left:10px;">{{ __('common.orders_appformcreate') }} |
                <small><span id="detailStage">{{ __('common.orders_form_addappdetail') }}</span></small>
            </h3>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav"
                style="background: #F7F7F7 url('/website/img/sidebarlogo.png') no-repeat center 200px;">
                <li class="active"><a href="#" id="firstListItem" style="line-height: 15px;"><span
                                class="liBordersActive"></span> {{ __('common.orders_app_detail') }}<i
                                class="fa fa-check-circle pull-right" style="opacity:0.3; padding:1px"></i></a></li>
                <li class="disabled"><a href="#" id="secondListItem" style="line-height: 15px;"><span
                                class="liBorders"></span> {{ __('common.orders_app_images') }}<i
                                class="fa fa-check-circle pull-right" style="opacity:0.3; padding:1px"></i></a></li>
                <li class="disabled"><a href="#" id="thirdListItem" style="line-height: 15px;"><span
                                class="liBorders"></span> {{ __('common.orders_app_create') }}<i
                                class="fa fa-check-circle pull-right" style="opacity:0.3; padding:1px"></i></a></li>
        </div><!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">
        <div class="row fullStage">
            <div class="col-lg-6 col-sm-7 col-xs-8">
                <form role="form">
                    <div id="stage1">
                        <div class="pull-right"><span
                                    style="color: #428bca;font-size: 17px;font-family: monospace; font-weight:bold">*</span><span
                                    style="font-size: 13px;font-style: italic; color: rgb(165, 165, 165);">  {{ __('common.orders_appformrequiredfields') }}</span>
                        </div>
                        <hr style="margin-top:3px; margin-bottom:10px; clear:both;">
                        <div class="form-group">
                            <label>{{ __('common.orders_list_column1') }} <span
                                        style="color: #428bca;font-size: 17px;font-family: monospace;">*</span></label>
                            <i style="color: rgba(0,0,0,0.3); font-size:14px; cursor:pointer;" id="OrderNoPopup"
                               data-toggle="popover" title="{{ __('common.orders_list_column1') }}"
                               data-content="{{ __('common.orders_hints_orderno') }}" class="fa fa-info-circle"></i>
                            <input type="hidden" name="Product" id="Product" value="<?php echo $product; ?>">
                            <input type="hidden" name="Qty" id="Qty" value="<?php echo $qty; ?>">
                            <input type="text" placeholder="{{ __('common.orders_list_column1') }}" name="OrderNo"
                                   id="OrderNo" maxlength="50" class="form-control" value="<?php echo $orderNo; ?>"
                                   readonly="true" required>
                        </div>

                        <div class="form-group">
                            <label>{{ __('common.orders_name') }} <span
                                        style="color: #428bca;font-size: 17px;font-family: monospace;">*</span></label>
                            <i style="color: rgba(0,0,0,0.3); font-size:14px; cursor:pointer;" id="AppNamePopup"
                               data-toggle="popover" title="{{ __('common.orders_name') }}"
                               data-content="{{ __('common.orders_hints_appname') }}" class="fa fa-info-circle"></i>
                            <input type="text" id="Name" placeholder="{{ __('common.orders_placeholders_appname') }}"
                                   name="Name" maxlength="14" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>{{ __('common.orders_description') }} <span
                                        style="color: #428bca;font-size: 17px;font-family: monospace;">*</span></label>
                            <i style="color: rgba(0,0,0,0.3); font-size:14px; cursor:pointer;" id="AppDescPopup"
                               data-toggle="popover" title="{{ __('common.orders_description') }}"
                               data-content="{{ __('common.orders_hints_appdescription') }}"
                               class="fa fa-info-circle"></i>
                            <textarea id="Description" name="Description"
                                      placeholder="{{ __('common.orders_placeholders_appdescription') }}"
                                      minlength="100" rows="3" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('common.orders_keywords') }} <span
                                        style="color: #428bca;font-size: 17px;font-family: monospace;">*</span></label>
                            <i style="color: rgba(0,0,0,0.3); font-size:14px; cursor:pointer;" id="KeywordsPopup"
                               data-toggle="popover" title="{{ __('common.orders_keywords') }}"
                               data-content="{{ __('common.orders_hints_keywords') }}" class="fa fa-info-circle"></i>
                            <textarea id="Keywords"
                                      placeholder="Gale Press, Dijital Yayıncılık, Digital Publishing, İnteraktif Pdf, Mobil Uygulama, Detaysoft"
                                      name="Keywords" maxlength="100" rows="2" class="form-control" required></textarea>
                        </div>
                        <hr style="margin-bottom:10px;margin-top:0px;">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <i style="color: rgba(0,0,0,0.3); font-size:14px; cursor:pointer;" id="EmailPopup"
                                       data-toggle="popover" title="Email"
                                       data-content="{{ __('common.orders_hints_email') }}"
                                       class="fa fa-info-circle"></i>
                                    <input id="Email" type="email" placeholder="youremail@youradress.com" name="Email"
                                           maxlength="50" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Web Site</label>
                                    <i style="color: rgba(0,0,0,0.3); font-size:14px; cursor:pointer;" id="WebSitePopup"
                                       data-toggle="popover" title="Web Site"
                                       data-content="{{ __('common.orders_hints_website') }}"
                                       class="fa fa-info-circle"></i>
                                    <input id="Website" type="text" name="Website" placeholder="http://www.yoursite.com"
                                           maxlength="50" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Facebook</label>
                                    <i style="color: rgba(0,0,0,0.3); font-size:14px; cursor:pointer;" id="FacePopup"
                                       data-toggle="popover" title="Facebook"
                                       data-content="{{ __('common.orders_hints_facebook') }}"
                                       class="fa fa-info-circle"></i>
                                    <input id="Facebook" type="text" placeholder="http://facebook.com/YourPage"
                                           name="Facebook" maxlength="50" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Twitter</label>
                                    <i style="color: rgba(0,0,0,0.3); font-size:14px; cursor:pointer;" id="TwitterPopup"
                                       data-toggle="popover" title="Twitter"
                                       data-content="{{ __('common.orders_hints_twitter') }}"
                                       class="fa fa-info-circle"></i>
                                    <input id="Twitter" type="text" name="Twitter"
                                           placeholder="http://twitter.com/YourPage" maxlength="50"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        //var startAnime;
                        function submitForm() {
                            var finalStage = false;
                            //validation
                            var o, o2;
                            o = $("#OrderNo");
                            if (o.val().length == 0) {
                                $('#myModal').find('.modal-title').text('{{ __("common.orders_placeholders_orderno") }}');
                                $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_orderno") }}');
                                $('#myModal').modal('show');
                                $("#firstListItem").removeClass('appListSuccess');
                                $("a#firstListItem").find('i').css('opacity', '0.3');
                                $("a#firstListItem").find('i').css('color', '#999');
                                return;
                            }

                            o = $("#Name");
                            if (o.val().length == 0) {
                                $('#myModal').find('.modal-title').text('{{ __("common.orders_name") }}');
                                $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_appname") }}');
                                $('#myModal').modal('show');
                                $("#firstListItem").removeClass('appListSuccess');
                                $("a#firstListItem").find('i').css('opacity', '0.3');
                                $("a#firstListItem").find('i').css('color', '#999');
                                return;
                            }

                            o = $("#Description");
                            if (o.val().length == 0 || o.val().length < 100) {
                                $('#myModal').find('.modal-title').text('{{ __("common.orders_description") }}');
                                if (o.val().length == 0) {
                                    $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_appdetail") }}');
                                }
                                else if (o.val().length < 100) {
                                    $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_appdetail_minlimit") }}');
                                }
                                $('#myModal').modal('show');
                                $("#firstListItem").removeClass('appListSuccess');
                                $("a#firstListItem").find('i').css('opacity', '0.3');
                                $("a#firstListItem").find('i').css('color', '#999');
                                return;
                            }

                            if (o.val().length > 4000) {
                                $('#myModal').find('.modal-title').text('{{ __("common.orders_description") }}');
                                $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_maxdesc") }}');
                                $('#myModal').modal('show')
                                return;
                            }

                            o = $("#Keywords");
                            if (o.val().length == 0) {
                                $('#myModal').find('.modal-title').text('{{ __("common.orders_keywords") }}');
                                $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_keywords") }}');
                                $('#myModal').modal('show');
                                $("#firstListItem").removeClass('appListSuccess');
                                $("a#firstListItem").find('i').css('opacity', '0.3');
                                $("a#firstListItem").find('i').css('color', '#999');
                                return;
                            }

                            function validateEmail($email) {
                                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                                if (!emailReg.test($email)) {
                                    $('#myModal').find('.modal-title').text('Email');
                                    $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_email") }}');
                                    $('#myModal').modal('show');
                                    return false;
                                } else {
                                    return true;
                                }
                            }

                            o = $("#Email");
                            if (o.val().length > 0) {
                                if (!validateEmail(o.val())) {
                                    $('#myModal').on('hidden.bs.modal', function (e) {
                                        o.focus();
                                        $('#myModal').unbind('hidden.bs.modal');
                                    })
                                    return;
                                }
                            }


                            // function validate_website(website_url)
                            // {
                            //   var websiteReg =/[a-zA-Z0-9-]/;
                            //   if (!websiteReg.test(website_url) || $("#Website").val().length<4)
                            //   {
                            //     $('#myModal').find('.modal-title').text('Website');
                            //     $('#myModal').find('.modal-body p').text('Website site adresi hatalı');
                            //     $('#myModal').modal('show');
                            //     return false;
                            //   }
                            //   else
                            //   {
                            //     return true;
                            //   }
                            // }

                            function validate_facebook(facebook_url) {
                                var facebookReg = /^(https?:\/\/)?((w{3}\.)?)facebook.com\/.*/i;

                                if (!facebookReg.test(facebook_url) && $("#Facebook").val().length > 0) {
                                    $('#myModal').find('.modal-title').text('Facebook');
                                    $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_facebookformat") }}');
                                    $('#myModal').modal('show');
                                    return false;
                                }
                                else
                                    return true;
                            }

                            function validate_twitter(twitter_url) {
                                var twitterReg = /^(https?:\/\/)?((w{3}\.)?)twitter\.com\/(#!\/)?[a-z0-9_]+$/i;

                                if (twitterReg.test(twitter_url) == false && $("#Twitter").val().length > 0) {
                                    $('#myModal').find('.modal-title').text('Twitter');
                                    $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_twitterformat") }}');
                                    $('#myModal').modal('show');
                                    return false;
                                }
                                else
                                    return true;
                            }

                            // o = $("#Website");
                            // if(!validate_website(o.val()))
                            // {
                            //   $('#myModal').on('hidden.bs.modal', function (e) {
                            //       o.focus();
                            //       $('#myModal').unbind('hidden.bs.modal');
                            //   })
                            //   return;
                            // }

                            o = $("#Facebook");
                            if (!validate_facebook(o.val())) {
                                $('#myModal').on('hidden.bs.modal', function (e) {
                                    o.focus();
                                    $('#myModal').unbind('hidden.bs.modal');
                                })
                                return;
                            }

                            o = $("#Twitter");
                            if (!validate_twitter(o.val())) {
                                $('#myModal').on('hidden.bs.modal', function (e) {
                                    o.focus();
                                    $('#myModal').unbind('hidden.bs.modal');
                                })
                                return;
                            }

                            if ($('ul li:nth-child(2)').prev().hasClass('active') == true) {

                                $("a#firstListItem").removeClass().addClass('appListSuccess');
                                $("a#firstListItem").find('i').css('opacity', '1');
                                $("a#firstListItem").find('i').css('color', 'rgb(0, 202, 16);');
                                $("#stage1").animate({marginTop: "-1000"}, 500, function () {
                                    $("#stage1").addClass('hide');
                                    $('#stage2').css('margin-top', '-800px').removeClass('hide');
                                    $("#stage2").animate({
                                        marginTop: "0"
                                    }, 1000);
                                    $('#appBackButton').removeClass('hide').fadeIn();

                                    $("#detailStage").animate({marginLeft: "100"}, 500, function () {
                                        $('#detailStage').text('{{ __("common.orders_form_loadappimages") }}');
                                        $("#detailStage").animate({marginLeft: "0"}, 500);
                                    });
                                });

                                $('ul li:nth-child(2)').prev().removeClass('active').find('span').removeClass().addClass('liBorders');
                                $('ul li:nth-child(2)').removeClass('disabled').addClass('active').find('span').removeClass().addClass('liBordersActive');
                                $(".appimg").fadeTo('slow', 0);
                                $(".appimg img").each(function () {
                                    $(this).addClass('hide');
                                });

                                // startAnime = function(){

                                //   if( $('ul li:nth-child(2)').hasClass('active')==true){

                                //     $( ".appimg #launcImages" ).fadeTo( 'slow' , 1);

                                //     $( ".appimg" ).fadeTo( 'slow' , 0, function() {
                                //       $( ".appimg img" ).each(function(){
                                //         $(this).addClass('hide');
                                //       })
                                //       $('#imgLaunch1').removeClass('hide');
                                //       $( ".appimg" ).fadeTo( 'slow' , 1);
                                //       if( $('ul li:nth-child(2)').hasClass('active')!=true){
                                //         return;
                                //       }

                                //         $( ".appimg" ).delay(3000).fadeTo( 'slow' , 0, function() {
                                //           $( ".appimg img" ).each(function(){
                                //             $(this).addClass('hide');
                                //           })
                                //           $('#imgLaunch2').removeClass('hide');
                                //           $( ".appimg" ).fadeTo( 'slow' , 1);

                                //           if( $('ul li:nth-child(2)').hasClass('active')!=true){
                                //             return;
                                //           }

                                //            $( ".appimg" ).delay(3000).fadeTo( 'slow' , 0, function() {
                                //             $( ".appimg img" ).each(function(){
                                //               $(this).addClass('hide');
                                //             })
                                //             $('#imgLaunch3').removeClass('hide');
                                //             $( ".appimg" ).fadeTo( 'slow' , 1);

                                //             if( $('ul li:nth-child(2)').hasClass('active')!=true){
                                //               return;
                                //             }


                                //               $( ".appimg" ).delay(3000).fadeTo( 'slow' , 0, function() {
                                //                 $( ".appimg img" ).each(function(){
                                //                   $(this).addClass('hide');
                                //                 })
                                //                 $( ".appimg" ).fadeTo( 'slow' , 1);
                                //                 if( $('ul li:nth-child(2)').hasClass('active')==true){
                                //                   setTimeout(function(){
                                //                     startAnime();
                                //                   },1500)
                                //                 }
                                //               })

                                //         })
                                //     })
                                //   })
                                // }

                                //   else{
                                //     $( ".appimg #launcImages" ).fadeTo( 'slow' , 0);
                                //     return;
                                //   }
                                // }

                                // startAnime();
                                return;
                            }

                            if ($("ul li:nth-child(2)").hasClass("active") == true) {

                                if ($('#hdnImage1024x1024Selected').val() == 0 && $('#hdnPdfSelected').val() == 0) {
                                    $('#myModal').find('.modal-title').text('{{ __("common.orders_logoandpdffiles") }} ');
                                    $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_pdfand1024") }}');
                                    $('#myModal').modal('show');
                                    $("#secondListItem").removeClass('appListSuccess');
                                    $("a#secondListItem").find('i').css('opacity', '0.3');
                                    $("a#secondListItem").find('i').css('color', '#999');
                                    $(this).parent().next().removeClass().addClass('fa fa-exclamation-triangle').removeClass('hide').css('color', 'red').fadeIn();
                                    return;
                                }

                                if ($('#hdnImage1024x1024Selected').val() == 0) {
                                    $('#myModal').find('.modal-title').text('Logo');
                                    $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_1024") }}');
                                    $('#myModal').modal('show');
                                    $("#secondListItem").removeClass('appListSuccess');
                                    $("a#secondListItem").find('i').css('opacity', '0.3');
                                    $("a#secondListItem").find('i').css('color', '#999');
                                    $('#hdnImage1024x1024Selected').parent().next().removeClass().addClass('fa fa-exclamation-triangle').removeClass('hide').css('color', 'red').fadeIn();
                                    return;
                                }

                                if ($('#hdnPdfSelected').val() == 0) {
                                    $('#myModal').find('.modal-title').text('{{ __("common.orders_pdf") }}');
                                    $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_pdf") }}');
                                    $('#myModal').modal('show');
                                    $("#secondListItem").removeClass('appListSuccess');
                                    $("a#secondListItem").find('i').css('opacity', '0.3');
                                    $("a#secondListItem").find('i').css('color', '#999');
                                    $('#Pdf').parent().next().removeClass().addClass('fa fa-exclamation-triangle').removeClass('hide').css('color', 'red').fadeIn();
                                    return;
                                }

                                $("a#secondListItem").removeClass().addClass('appListSuccess');
                                $("a#secondListItem").find('i').css('opacity', '1');
                                $("a#firstListItem").find('i').css('color', 'rgb(0, 202, 16);');

                                $("#stage2").animate({marginTop: "-1000"}, 500, function () {
                                    $("#stage2").addClass('hide');
                                    $('#stage3').css('margin-top', '-800px').removeClass('hide');
                                    $("#stage3").animate({
                                        marginTop: "0"
                                    }, 1000);
                                });

                                $("#detailStage").animate({marginLeft: "100"}, 500, function () {

                                    $('#detailStage').text('{{ __("common.orders_submit_form") }}');
                                    $("#detailStage").animate({marginLeft: "0"}, 500);

                                    $('ul li:nth-child(2)').removeClass('active').find('span').removeClass().addClass('liBorders');
                                    $('ul li:nth-child(3)').removeClass('disabled').addClass('active').find('span').removeClass().addClass('liBordersActive');
                                    $('#appSubmitButton').val('{{ __("common.orders_formfinal") }}');

                                    $("a#firstListItem").removeClass().addClass('appListSuccess');
                                    $("a#secondListItem").removeClass().addClass('appListSuccess');
                                    $("a#firstListItem").find('i').css('opacity', '1');
                                    $("a#secondListItem").find('i').css('opacity', '1');
                                    $("a#firstListItem").find('i').css('color', 'rgb(0, 202, 16);');
                                    $("a#secondListItem").find('i').css('color', 'rgb(0, 202, 16);');

                                    $(".appimg #launcImages").fadeTo('slow', 0);

                                });

                                return;
                            }

                            o = $("#hdnImage1024x1024Selected");
                            o2 = $("#hdnImage1024x1024Name");

                            if (o.val() == 0 && o2.val().length == 0) {
                                $('#myModal').find('.modal-title').text('{{ __("common.orders_icon") }}');
                                $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_1024") }}');
                                $('#myModal').modal('show');
                                return;
                            }

                            o = $("#hdnPdfSelected");
                            o2 = $("#hdnPdfName");
                            if (o.val() == 0 && o2.val().length == 0) {
                                $('#myModal').find('.modal-title').text('{{ __("common.orders_pdf") }}');
                                $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_pdf") }}');
                                $('#myModal').modal('show');
                                return;
                            }

                            $.ajax({
                                type: "POST",
                                url: '/' + currentLanguage + '/' + route["orders_save"],
                                data: $("form").serialize(),
                                success: function (data, textStatus) {
                                    if (data.getValue("success") == "true") {
                                        $('#hdnImage1024x1024Selected').val(0);
                                        $('#hdnImage640x960Selected').val(0);
                                        $('#hdnImage640x1136Selected').val(0);
                                        $('#hdnImage1536x2048Selected').val(0);
                                        $('#hdnImage2048x1536Selected').val(0);
                                        $('#hdnPdfSelected').val(0);

                                        $('#hdnImage1024x1024Name').val("");
                                        $('#hdnImage640x960Name').val("");
                                        $('#hdnImage640x1136Name').val("");
                                        $('#hdnImage1536x2048Name').val("");
                                        $('#hdnImage2048x1536Name').val("");
                                        $('#hdnPdfName').val("");

                                        $("#stage3").animate({marginTop: "-1000"}, 500, function () {
                                            $("#stage3").addClass('hide');
                                            $('#stage4').css('margin-top', '-800px').removeClass('hide');
                                            $("#stage4").animate({
                                                marginTop: "0"
                                            }, 1000);
                                        });
                                        $(".appimg #launcImages").fadeTo('slow', 0);

                                        $("a#thirdListItem").removeClass().addClass('appListSuccess');
                                        $("a#thirdListItem").find('i').css('opacity', '1');
                                        $("a#thirdListItem").find('i').css('color', 'rgb(0, 202, 16);');

                                        $('#appSubmitButton').fadeOut();
                                        $('#appBackButton').fadeOut();

                                        $("#detailStage").animate({marginLeft: "100"}, 500, function () {
                                            $('#detailStage').text('{{ __("common.orders_submitted_form") }}');
                                            $("#detailStage").animate({marginLeft: "0"}, 500);
                                        });

                                        $('ul li:nth-child(2)').prev().parent().removeClass('ulDisabled');
                                        $('ul li:nth-child(2)').prev().removeClass();
                                        $('ul li:nth-child(2)').removeClass();
                                        $('ul li:nth-child(3)').removeClass();
                                    }
                                },
                                error: function (resp) {
                                    //error
                                }
                            });
                            return false;
                        }
                    </script>
                    <div class="form-group hide" id="stage2" style="text-align: center;">
                        <div class="pull-right"><span
                                    style="color: #428bca;font-size: 17px;font-family: monospace; font-weight:bold">*</span><span
                                    style="font-size: 13px;font-style: italic; color: rgb(165, 165, 165);">  {{ __('common.orders_appformrequiredfields') }}</span>
                        </div>
                        <hr style="margin-top:3px; margin-bottom:10px; clear:both;"/>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border"><span
                                        style="color: #428bca;font-size: 17px;font-family: monospace; margin-top:-10px; font-weight:bold">*</span>
                                Logo & PDF
                            </legend>
                            <div class="control-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="btn-primary">
                                            <div class="noWhiteSpace"><i class="fa fa-cloud-upload"
                                                                         style="font-size:18px;"></i><br>{{ __('common.orders_image1024x1024') }}
                                            </div>
                                            <input id="Image1024x1024" name="Image1024x1024" type="file" class="upload"
                                                   required/>
                                            <input type="hidden" name="hdnImage1024x1024Selected"
                                                   id="hdnImage1024x1024Selected" value="0"/>
                                            <input type="hidden" name="hdnImage1024x1024Name" id="hdnImage1024x1024Name"
                                                   value=""/>
                                            <script type="text/javascript">
                                                $(function () {
                                                    $("#Image1024x1024").fileupload({
                                                        url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                                                        dataType: 'json',
                                                        sequentialUploads: true,
                                                        formData: {
                                                            'element': 'Image1024x1024',
                                                            'type': 'uploadpng1024x1024'
                                                        },
                                                        add: function (e, data) {
                                                            if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name)) {
                                                                $('#hdnImage1024x1024Selected').val("1");
                                                                $("[for='Image1024x1024']").removeClass("hide");

                                                                data.context = $("[for='Image1024x1024']");
                                                                data.context.find('a').click(function (e) {
                                                                    e.preventDefault();
                                                                    var template = $("[for='Image1024x1024']");
                                                                    data = template.data('data') || {};
                                                                    if (data.jqXHR) {
                                                                        data.jqXHR.abort();
                                                                    }
                                                                });
                                                                var xhr = data.submit();
                                                                data.context.data('data', {jqXHR: xhr});
                                                            }
                                                        },
                                                        progressall: function (e, data) {
                                                            var progress = data.loaded / data.total * 100;

                                                            $("[for='Image1024x1024'] label").html(progress.toFixed(0) + '%');
                                                            $("[for='Image1024x1024'] div.scale").css('width', progress.toFixed(0) + '%');
                                                        },
                                                        done: function (e, data) {
                                                            if (data.textStatus == 'success') {
                                                                $('#hdnImage1024x1024Name').val(data.result.fileName);
                                                                $("[for='Image1024x1024']").addClass("hide");
                                                            }
                                                        },
                                                        fail: function (e, data) {
                                                            $('#hdnImage1024x1024Selected').val("0");
                                                            $('#hdnImage1024x1024Name').val("");
                                                            $("[for='Image1024x1024']").addClass("hide");

                                                        }
                                                    });

                                                    //select file
                                                    $("#Image1024x1024Button").removeClass("hide").click(function () {

                                                        $("#Image1024x1024").click();
                                                    });
                                                });
                                            </script>
                                        </div>
                                        <i class="fa fa-check-circle hide"></i>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="btn-primary">
                                            <div class="noWhiteSpace"><i class="fa fa-cloud-upload"
                                                                         style="font-size:18px;"></i><br>PDF<br> {{ __('common.orders_app_fileload') }}
                                            </div>
                                            <input id="Pdf" name="Pdf" type="file" class="upload" required/>
                                            <input type="hidden" name="hdnPdfSelected" id="hdnPdfSelected" value="0"/>
                                            <input type="hidden" name="hdnPdfName" id="hdnPdfName" value=""/>
                                            <script type="text/javascript">
                                                $(function () {

                                                    $("#Pdf").fileupload({
                                                        url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                                                        dataType: 'json',
                                                        sequentialUploads: true,
                                                        formData: {
                                                            'element': 'Pdf',
                                                            'type': 'uploadpdf'
                                                        },
                                                        add: function (e, data) {
                                                            if (data.files[0].size / 1024 / 1024 > 100) {

                                                                $('.alert').removeClass('alert-info').addClass('alert-error').show();
                                                                $('.alert span').text('{{ __("common.orders_warning_pdfmaxfilesize") }}');
                                                                $('html, body').animate({scrollTop: 0}, 'slow');
                                                                $('#hdnPdfSelected').val("0");
                                                                $('#hdnPdfName').val("");
                                                                return;

                                                            }
                                                            if (/\.(pdf)$/i.test(data.files[0].name)) {
                                                                $('#hdnPdfSelected').val("1");
                                                                $("[for='Pdf']").removeClass("hide");
                                                                $("#pdfLoadingStatus").fadeIn();

                                                                data.context = $("[for='Pdf']");
                                                                data.context.find('a').click(function (e) {
                                                                    e.preventDefault();
                                                                    var template = $("[for='Pdf']");
                                                                    data = template.data('data') || {};
                                                                    if (data.jqXHR) {
                                                                        data.jqXHR.abort();
                                                                    }
                                                                });
                                                                var xhr = data.submit();
                                                                data.context.data('data', {jqXHR: xhr});
                                                            }
                                                        },
                                                        progressall: function (e, data) {
                                                            var progress = data.loaded / data.total * 100;
                                                            $("#pdfLoadingStatus").text(progress.toFixed(0) + '%');

                                                            $("[for='Pdf'] label").html(progress.toFixed(0) + '%');
                                                            $("[for='Pdf'] div.scale").css('width', progress.toFixed(0) + '%');
                                                        },
                                                        done: function (e, data) {
                                                            if (data.textStatus == 'success') {
                                                                $('#hdnPdfName').val(data.result.fileName);
                                                                $("[for='Pdf']").addClass("hide");
                                                                $("#pdfLoadingStatus").fadeOut();
                                                            }
                                                        },
                                                        fail: function (e, data) {
                                                            $('#hdnPdfSelected').val("0");
                                                            $('#hdnPdfName').val("");
                                                            $("[for='Pdf']").addClass("hide");
                                                        }
                                                    });

                                                    //select file
                                                    $("#PdfButton").removeClass("hide").click(function () {
                                                        $("#Pdf").click();
                                                    });
                                                });
                                            </script>
                                        </div>
                                        <i class="fa fa-check-circle hide"></i>

                                        <div id="pdfLoadingStatus" style="border:none; float:right"></div>
                                    </div>
                                </div>
                                <i id="pdf1024Popup" data-toggle="popover"
                                   title="{{ __('common.orders_title_pdfand1024') }}"
                                   data-content="{{ __('common.orders_hints_pdfand1024') }}"
                                   class="fa fa-info-circle screenshotsInfo"></i>
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">{{ __('common.orders_app_screenshots') }}</legend>
                            <div class="control-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="btn-primary">
                                            <div class="noWhiteSpace"><i class="fa fa-cloud-upload"
                                                                         style="font-size:18px;"></i><br>{{ __('common.orders_image640x960') }}
                                            </div>
                                            <input id="Image640x960" name="Image640x960" type="file" class="upload"/>
                                            <input type="hidden" name="hdnImage640x960Selected"
                                                   id="hdnImage640x960Selected" value="0"/>
                                            <input type="hidden" name="hdnImage640x960Name" id="hdnImage640x960Name"
                                                   value=""/>
                                            <script type="text/javascript">
                                                $(function () {

                                                    $("#Image640x960").fileupload({
                                                        url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                                                        dataType: 'json',
                                                        sequentialUploads: true,
                                                        formData: {
                                                            'element': 'Image640x960',
                                                            'type': 'uploadpng640x960'
                                                        },
                                                        add: function (e, data) {
                                                            if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name)) {
                                                                $('#hdnImage640x960Selected').val("1");
                                                                $("[for='Image640x960']").removeClass("hide");

                                                                data.context = $("[for='Image640x960']");
                                                                data.context.find('a').click(function (e) {
                                                                    e.preventDefault();
                                                                    var template = $("[for='Image640x960']");
                                                                    data = template.data('data') || {};
                                                                    if (data.jqXHR) {
                                                                        data.jqXHR.abort();
                                                                    }
                                                                });
                                                                var xhr = data.submit();
                                                                data.context.data('data', {jqXHR: xhr});
                                                            }
                                                        },
                                                        progressall: function (e, data) {
                                                            var progress = data.loaded / data.total * 100;

                                                            $("[for='Image640x960'] label").html(progress.toFixed(0) + '%');
                                                            $("[for='Image640x960'] div.scale").css('width', progress.toFixed(0) + '%');
                                                        },
                                                        done: function (e, data) {
                                                            if (data.textStatus == 'success') {
                                                                $('#hdnImage640x960Name').val(data.result.fileName);
                                                                $("[for='Image640x960']").addClass("hide");
                                                            }
                                                        },
                                                        fail: function (e, data) {
                                                            $('#hdnImage640x960Selected').val("0");
                                                            $('#hdnImage640x960Name').val("");
                                                            $("[for='Image640x960']").addClass("hide");
                                                        }
                                                    });

                                                    //select file
                                                    $("#Image640x960Button").removeClass("hide").click(function () {

                                                        $("#Image640x960").click();
                                                    });

                                                });
                                            </script>
                                        </div>
                                        <i class="fa fa-check-circle hide"></i>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="btn-primary">
                                            <div class="noWhiteSpace"><i class="fa fa-cloud-upload"
                                                                         style="font-size:18px;"></i><br>{{ __('common.orders_image640x1136') }}
                                            </div>
                                            <input id="Image640x1136" name="Image640x1136" type="file" class="upload"/>
                                            <input type="hidden" name="hdnImage640x1136Selected"
                                                   id="hdnImage640x1136Selected" value="0"/>
                                            <input type="hidden" name="hdnImage640x1136Name" id="hdnImage640x1136Name"
                                                   value=""/>
                                            <script type="text/javascript">
                                                $(function () {

                                                    $("#Image640x1136").fileupload({
                                                        url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                                                        dataType: 'json',
                                                        sequentialUploads: true,
                                                        formData: {
                                                            'element': 'Image640x1136',
                                                            'type': 'uploadpng640x1136'
                                                        },
                                                        add: function (e, data) {
                                                            if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name)) {
                                                                $('#hdnImage640x1136Selected').val("1");
                                                                $("[for='Image640x1136']").removeClass("hide");

                                                                data.context = $("[for='Image640x1136']");
                                                                data.context.find('a').click(function (e) {
                                                                    e.preventDefault();
                                                                    var template = $("[for='Image640x1136']");
                                                                    data = template.data('data') || {};
                                                                    if (data.jqXHR) {
                                                                        data.jqXHR.abort();
                                                                    }
                                                                });
                                                                var xhr = data.submit();
                                                                data.context.data('data', {jqXHR: xhr});
                                                            }
                                                        },
                                                        progressall: function (e, data) {
                                                            var progress = data.loaded / data.total * 100;

                                                            $("[for='Image640x1136'] label").html(progress.toFixed(0) + '%');
                                                            $("[for='Image640x1136'] div.scale").css('width', progress.toFixed(0) + '%');
                                                        },
                                                        done: function (e, data) {
                                                            if (data.textStatus == 'success') {
                                                                $('#hdnImage640x1136Name').val(data.result.fileName);
                                                                $("[for='Image640x1136']").addClass("hide");
                                                            }
                                                        },
                                                        fail: function (e, data) {
                                                            $('#hdnImage640x1136Selected').val("0");
                                                            $('#hdnImage640x1136Name').val("");
                                                            $("[for='Image640x1136']").addClass("hide");
                                                        }
                                                    });

                                                    //select file
                                                    $("#Image640x1136Button").removeClass("hide").click(function () {

                                                        $("#Image640x1136").click();
                                                    });
                                                });
                                            </script>
                                        </div>
                                        <i class="fa fa-check-circle hide"></i>
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="btn-primary">
                                            <div class="noWhiteSpace"><i class="fa fa-cloud-upload"
                                                                         style="font-size:18px;"></i><br>{{ __('common.orders_image1536x2048') }}
                                            </div>
                                            <input id="Image1536x2048" name="Image1536x2048" type="file"
                                                   class="upload"/>
                                            <input type="hidden" name="hdnImage1536x2048Selected"
                                                   id="hdnImage1536x2048Selected" value="0"/>
                                            <input type="hidden" name="hdnImage1536x2048Name" id="hdnImage1536x2048Name"
                                                   value=""/>
                                            <script type="text/javascript">
                                                $(function () {

                                                    $("#Image1536x2048").fileupload({
                                                        url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                                                        dataType: 'json',
                                                        sequentialUploads: true,
                                                        formData: {
                                                            'element': 'Image1536x2048',
                                                            'type': 'uploadpng1536x2048'
                                                        },
                                                        add: function (e, data) {
                                                            if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name)) {
                                                                $('#hdnImage1536x2048Selected').val("1");
                                                                $("[for='Image1536x2048']").removeClass("hide");

                                                                data.context = $("[for='Image1536x2048']");
                                                                data.context.find('a').click(function (e) {
                                                                    e.preventDefault();
                                                                    var template = $("[for='Image1536x2048']");
                                                                    data = template.data('data') || {};
                                                                    if (data.jqXHR) {
                                                                        data.jqXHR.abort();
                                                                    }
                                                                });
                                                                var xhr = data.submit();
                                                                data.context.data('data', {jqXHR: xhr});
                                                            }
                                                        },
                                                        progressall: function (e, data) {
                                                            var progress = data.loaded / data.total * 100;

                                                            $("[for='Image1536x2048'] label").html(progress.toFixed(0) + '%');
                                                            $("[for='Image1536x2048'] div.scale").css('width', progress.toFixed(0) + '%');
                                                        },
                                                        done: function (e, data) {
                                                            if (data.textStatus == 'success') {
                                                                $('#hdnImage1536x2048Name').val(data.result.fileName);
                                                                $("[for='Image1536x2048']").addClass("hide");
                                                            }
                                                        },
                                                        fail: function (e, data) {
                                                            $('#hdnImage1536x2048Selected').val("0");
                                                            $('#hdnImage1536x2048Name').val("");
                                                            $("[for='Image1536x2048']").addClass("hide");
                                                        }
                                                    });

                                                    //select file
                                                    $("#Image1536x2048Button").removeClass("hide").click(function () {

                                                        $("#Image1536x2048").click();
                                                    });
                                                });
                                            </script>
                                        </div>
                                        <i class="fa fa-check-circle hide"></i>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="btn-primary">
                                            <div class="noWhiteSpace"><i class="fa fa-cloud-upload"
                                                                         style="font-size:18px;"></i><br>{{ __('common.orders_image2048x1536') }}
                                            </div>
                                            <input id="Image2048x1536" name="Image2048x1536" type="file"
                                                   class="upload"/>
                                            <input type="hidden" name="hdnImage2048x1536Selected"
                                                   id="hdnImage2048x1536Selected" value="0"/>
                                            <input type="hidden" name="hdnImage2048x1536Name" id="hdnImage2048x1536Name"
                                                   value=""/>
                                            <script type="text/javascript">
                                                $(function () {

                                                    $("#Image2048x1536").fileupload({
                                                        url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                                                        dataType: 'json',
                                                        sequentialUploads: true,
                                                        formData: {
                                                            'element': 'Image2048x1536',
                                                            'type': 'uploadpng2048x1536'
                                                        },
                                                        add: function (e, data) {
                                                            if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name)) {
                                                                $('#hdnImage2048x1536Selected').val("1");
                                                                $("[for='Image2048x1536']").removeClass("hide");

                                                                data.context = $("[for='Image2048x1536']");
                                                                data.context.find('a').click(function (e) {
                                                                    e.preventDefault();
                                                                    $('#hdnImage2048x1536Selected').val("0");
                                                                    $('#hdnImage2048x1536Name').val("");
                                                                    $("[for='Image2048x1536']").addClass("hide");
                                                                    var template = $("[for='Image2048x1536']");
                                                                    data = template.data('data') || {};
                                                                    if (data.jqXHR) {
                                                                        data.jqXHR.abort();
                                                                    }
                                                                });
                                                                var xhr = data.submit();
                                                                data.context.data('data', {jqXHR: xhr});
                                                            }
                                                        },
                                                        progressall: function (e, data) {
                                                            var progress = data.loaded / data.total * 100;

                                                            $("[for='Image2048x1536'] label").html(progress.toFixed(0) + '%');
                                                            $("[for='Image2048x1536'] div.scale").css('width', progress.toFixed(0) + '%');
                                                        },
                                                        done: function (e, data) {
                                                            if (data.textStatus == 'success') {
                                                                $('#hdnImage2048x1536Name').val(data.result.fileName);
                                                                $("[for='Image2048x1536']").addClass("hide");
                                                            }
                                                        },
                                                        fail: function (e, data) {
                                                            $('#hdnImage2048x1536Selected').val("0");
                                                            $('#hdnImage2048x1536Name').val("");
                                                            $("[for='Image2048x1536']").addClass("hide");
                                                        }
                                                    });

                                                    //select file
                                                    $("#Image2048x1536Button").removeClass("hide").click(function () {

                                                        $("#Image2048x1536").click();
                                                    });
                                                });
                                            </script>
                                        </div>
                                        <i class="fa fa-check-circle hide"></i>
                                    </div>
                                </div>
                            </div>
                            <i id="otherImages" data-toggle="popover"
                               title="{{ __('common.orders_title_appscreenshots') }}"
                               data-content="{{ __('common.orders_hints_appscreenshots') }}"
                               class="fa fa-info-circle screenshotsInfo"></i>
                        </fieldset>
                    </div>
                    <div class="form-group hide" id="stage3">
                        <div class="row controls" style="padding-left:45px;">
                            <h3>{{ __('common.orders_stage3_msg1') }}<br><br> {{ __('common.orders_stage3_msg2') }}</h3>
                        </div>
                    </div>
                    <div class="form-group hide" id="stage4">
                        <div class="row controls" style="padding-left:45px;">
                            <br>

                            <h3>{{ __('common.orders_final_msg') }}</h3>
                        </div>
                    </div>
                    <hr class="tall" style="margin: 1px 0 9px 0; height:1px; clear:both;"/>
                    <input type="button" value="{{ __('common.orders_form_next') }}" class="btn btn-primary pull-right"
                           id="appSubmitButton" onclick="submitForm()" style="width: 119px;">
                    <input type="button" class="btn btn-info hide" id="appBackButton"
                           value="{{ __('common.orders_form_back') }}">
                </form>
            </div>
            <div class="col-lg-6 col-sm-5 col-xs-4 appimg">
                <!--<img src="/website/app-form/images/test.jpg" class="hide" id="imgOrderNo">-->
                <img src="/website/app-form/images/yeni2/04.png" class="hide" id="imgAppName">
                <img src="/website/app-form/images/yeni2/02.png" class="hide" id="imgAppDesc">
                <img src="/website/app-form/images/yeni2/01.png" class="hide" id="imgKeywords">
                <img src="/website/app-form/images/yeni2/03.png" class="hide" id="imgEmail">
                <img src="/website/app-form/images/yeni2/03.png" class="hide" id="imgWebSite">
                <img src="/website/app-form/images/yeni2/03.png" class="hide" id="imgFacebook">
                <img src="/website/app-form/images/yeni2/03.png" class="hide" id="imgTwitter">

                <div id="launcImages">
                    <img src="/website/app-form/images/yeni2/05.png" class="hide" id="imgLaunch1">
                    <img src="/website/app-form/images/yeni2/06.png" class="hide" id="imgLaunch2">
                    <img src="/website/app-form/images/yeni2/07.png" class="hide" id="imgLaunch3">
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: rgb(255, 239, 239);">
                <button type="button" class="close" data-dismiss="modal" id="modal-closeBtn"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">{{ __('common.orders_popup_close') }}</span></button>
                <i class="fa fa-exclamation-triangle" style="float: left;font-size: 25px; color: rgb(199, 40, 40);">
                    &nbsp;</i><h4 class="modal-title">{{ __('common.orders_popup_title') }}</h4>
            </div>
            <div class="modal-body">
                <p style="margin:0; font-size:17px;">{{ __('common.orders_popup_content') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                        style="outline:0;">{{ __('common.orders_popup_ok') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function () {

        $("#OrderNoPopup").popover();
        $("#AppNamePopup").popover();
        $("#AppDescPopup").popover();
        $("#KeywordsPopup").popover();

        $("#EmailPopup").popover();
        $("#WebSitePopup").popover();
        $("#FacePopup").popover();
        $("#TwitterPopup").popover();

        $("#pdf1024Popup").popover();
        $("#otherImages").popover();

        $('#Description').inputlimiter({
            zeroPlural: false,
            limit: 4000,
            allowExceed: true,
            remText: '%n',
            limitText: '(%n) {{ __("common.orders_textarea_character") }}'
        });
        $('#Name').inputlimiter({remText: '%n', limitText: '(%n) {{ __("common.orders_textarea_character") }}'});
        $('#Keywords').inputlimiter({remText: '%n', limitText: '(%n) {{ __("common.orders_textarea_character") }}'});
        $('#OrderNo').inputlimiter({remText: '%n', limitText: '(%n) {{ __("common.orders_textarea_character") }}'});

        $('#Description').bind('input', function () {
            if ($(this).val().length > 4000)
                $('#limiterBox').css('color', 'red');
            else
                $('#limiterBox').css('color', 'black');
        });

        $('#Description').bind('focusout', function () {
            $('#limiterBox').css('color', 'black');
        });

        var lastHeight = 0;
        $('textarea').bind('mousemove', function () {
            if ($(this).css('height') != lastHeight) {
                $('#limiterBox').css("display", "none");
                lastHeight = $(this).css('height');
            }
        });

        var _URL = window.URL || window.webkitURL;

        function imageDimensionCheck(input, w, h, type, size) {

            if (size > 5) {
                $('#myModal').find('.modal-title').text('{{ __("common.orders_image_filesize") }}');
                $('#myModal').find('.modal-body p').text('{{ __("common.orders_image_maxfilesize") }}');
                $('#myModal').modal('show');
                $("ul li:nth-child(2) a").removeClass('appListSuccess');
                $('html, body').animate({scrollTop: 0}, 'slow');
                $('#' + input.id).parent().next().removeClass().addClass('fa fa-exclamation-triangle').removeClass('hide').css('color', 'red').fadeIn();
                $("#secondListItem").removeClass('appListSuccess');
                $("a#secondListItem").find('i').css('opacity', '0.3');
                $("a#secondListItem").find('i').css('color', '#999');
                return;
            }
            else {
                var file, img;
                if ((file = input.files[0])) {
                    img = new Image();
                    img.onload = function () {
                        var imgWidth = this.width;
                        var imgHeight = this.height;
                        if (imgWidth != w || imgHeight != h) {
                            $('#myModal').find('.modal-title').text('{{ __("common.orders_image_resolution") }}');
                            $('#myModal').find('.modal-body p').text('{{ __("common.orders_image_yourimage") }}'.replace(":resolution", w + "x" + h));
                            $('#myModal').modal('show');
                            $("ul li:nth-child(2) a").removeClass('appListSuccess');
                            $('html, body').animate({scrollTop: 0}, 'slow');

                            $('#' + input.id).parent().next().removeClass().addClass('fa fa-exclamation-triangle').removeClass('hide').css('color', 'red').fadeIn();
                            $("#secondListItem").removeClass('appListSuccess');
                            $("a#secondListItem").find('i').css('opacity', '0.3');
                            $("a#secondListItem").find('i').css('color', '#999');
                            return;
                        }
                        else {
                            $("ul li:nth-child(2) a").addClass('appListSuccess');
                            $('#' + input.id).parent().next().removeClass().addClass('fa fa-check-circle').removeClass('hide').css('color', 'rgb(0, 202, 16);').fadeIn();
                        }
                    };
                    img.src = _URL.createObjectURL(file);
                }
            }
        }

        var fileType, fileSize;
        $("#Image1024x1024").change(function (e) {
            fileType = this.files[0].type.split('/');
            fileSize = (this.files[0].size) / 1024 / 1024;
            imageDimensionCheck(this, 1024, 1024, fileType[1], fileSize);
        });

        $("#Image640x960").change(function (e) {
            fileType = this.files[0].type.split('/');
            fileSize = (this.files[0].size) / 1024 / 1024;
            imageDimensionCheck(this, 640, 960, fileType[1], fileSize);
        });

        $("#Image640x1136").change(function (e) {
            fileType = this.files[0].type.split('/');
            fileSize = (this.files[0].size) / 1024 / 1024;
            imageDimensionCheck(this, 640, 1136, fileType[1], fileSize);
        });

        $("#Image1536x2048").change(function (e) {
            fileType = this.files[0].type.split('/');
            fileSize = (this.files[0].size) / 1024 / 1024;
            imageDimensionCheck(this, 1536, 2048, fileType[1], fileSize);
        });

        $("#Image2048x1536").change(function (e) {
            fileType = this.files[0].type.split('/');
            fileSize = (this.files[0].size) / 1024 / 1024;
            imageDimensionCheck(this, 2048, 1536, fileType[1], fileSize);
        });

        $('#appBackButton').on('click', function () {
            $(".appimg").fadeTo('slow', 0);
            $(".appimg #launcImages").fadeTo('slow', 0);

            $("#appSubmitButton").val("{{ __('common.orders_form_next') }}");
            if ($("ul li:nth-child(2)").hasClass("active") == true) {
                $("#stage2").animate({marginTop: "-1000"}, 500, function () {
                    $("#stage2").addClass('hide');
                    $("#stage3").addClass('hide');
                    $("#stage4").addClass('hide');
                    $('#stage1').css('margin-top', '-800px').removeClass('hide');
                    $("#stage1").animate({
                        marginTop: "0"
                    }, 1000);
                    $("#appBackButton").fadeOut();
                    $("ul li:nth-child(2)").removeClass("active");
                    $("ul li:nth-child(2)").prev().addClass("active");
                });

                $('ul li:nth-child(2)').prev().addClass('active').find('span').removeClass().addClass('liBordersActive');
                $('ul li:nth-child(2)').removeClass('disabled').removeClass('active').find('span').removeClass().addClass('liBorders');
                $(".appimg").fadeTo('slow', 1);
                $(".appimg img").each(function () {
                    $(this).addClass('hide');
                });

                $("#detailStage").animate({marginLeft: "100"}, 500, function () {
                    $('#detailStage').text('{{ __("common.orders_form_addappdetail") }}');
                    $("#detailStage").animate({marginLeft: "0"}, 500);
                });
            }
            if ($("ul li:nth-child(3)").hasClass("active") == true) {
                $("#stage3").animate({marginTop: "-1000"}, 500, function () {
                    $("#stage3").addClass('hide');
                    $("#stage1").addClass('hide');
                    $("#stage4").addClass('hide');
                    $('#stage2').css('margin-top', '-800px').removeClass('hide');
                    $("#stage2").animate({
                        marginTop: "0"
                    }, 1000);
                    $("ul li:nth-child(2)").removeClass().addClass("active");
                    $("ul li:nth-child(3)").removeClass("active");
                });

                $('ul li:nth-child(2)').addClass('active').find('span').removeClass().addClass('liBordersActive');
                $('ul li:nth-child(3)').removeClass('disabled').removeClass('active').find('span').removeClass().addClass('liBorders');

                $("#detailStage").animate({marginLeft: "100"}, 500, function () {
                    $('#detailStage').text('{{ __("common.orders_form_loadappimages") }}');
                    $("#detailStage").animate({marginLeft: "0"}, 500);
                });
            }
        });

        $('ul li a').on('click', function () {
            $("li").each(function () {
                $(this).find('a').removeClass('active');
                if ($(this).hasClass('disabled') == false)
                    $(this).removeClass();
                $(this).find('span').removeClass().addClass('liBorders');
            });
            $(this).parent().addClass('active');
        })

        $('ul li:nth-child(1) a').on('click', function () {
            $(".appimg #launcImages").fadeTo('slow', 0);
            $(this).parent().addClass('active');
            $('ul li:nth-child(1)').addClass('active').find('span').removeClass().addClass('liBordersActive');
            $("#appBackButton").fadeOut();
            $('#appSubmitButton').val('{{ __("common.orders_form_next") }}');
        })

        $('ul li:nth-child(2) a').on('click', function () {
            $(".appimg").fadeTo('slow', 1);
            $(".appimg img").each(function () {
                $(this).addClass('hide');
            });
            $(this).parent().addClass('active');
            $('ul li:nth-child(2)').addClass('active').find('span').removeClass().addClass('liBordersActive');
            $("#appBackButton").fadeIn();
            $('#appSubmitButton').val('{{ __("common.orders_form_next") }}');
        })

        $('ul li:nth-child(3) a').on('click', function () {
            $(this).parent().addClass('active');
            $('ul li:nth-child(3)').addClass('active').find('span').removeClass().addClass('liBordersActive');
            $("#appBackButton").fadeIn();
            $('#appSubmitButton').val('{{ __("common.orders_formfinal") }}');
        })

        $('#stage2').mouseover(function () {
            $(".appimg > img").each(function () {
                $(this).addClass('hide');
            });
        })

        $('#Image1024x1024').mouseover(function () {
            $(".appimg").fadeTo('slow', 1).dequeue();
            $(".appimg #launcImages").fadeTo('slow', 0, function () {
                $(".appimg #launcImages img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgLaunch1').removeClass('hide');
                $(this).fadeTo('slow', 1).dequeue();
            }).dequeue();
        });

        $('#Pdf').mouseover(function () {
            $(".appimg").fadeTo('slow', 1).dequeue();
            $(".appimg #launcImages").fadeTo('slow', 0, function () {
                $(".appimg #launcImages img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgLaunch3').removeClass('hide');
                $(this).fadeTo('slow', 1).dequeue();
            }).dequeue();
        });

        $('#Image640x960').mouseover(function () {
            $(".appimg").fadeTo('slow', 1).dequeue();
            $(".appimg #launcImages").fadeTo('slow', 0, function () {
                $(".appimg #launcImages img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgLaunch2').removeClass('hide');
                $(this).fadeTo('slow', 1).dequeue();
            }).dequeue();
        });

        $('#Image640x1136').mouseover(function () {
            $(".appimg").fadeTo('slow', 1).dequeue();
            $(".appimg #launcImages").fadeTo('slow', 0, function () {
                $(".appimg #launcImages img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgLaunch2').removeClass('hide');
                $(this).fadeTo('slow', 1).dequeue();
            }).dequeue();
        });

        $('#Image1536x2048').mouseover(function () {
            $(".appimg").fadeTo('slow', 1).dequeue();
            $(".appimg #launcImages").fadeTo('slow', 0, function () {
                $(".appimg #launcImages img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgLaunch2').removeClass('hide');
                $(this).fadeTo('slow', 1).dequeue();
            }).dequeue();
        });

        $('#Image2048x1536').mouseover(function () {
            $(".appimg").fadeTo('slow', 1).dequeue();
            $(".appimg #launcImages").fadeTo('slow', 0, function () {
                $(".appimg #launcImages img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgLaunch2').removeClass('hide');
                $(this).fadeTo('slow', 1).dequeue();
            }).dequeue();
        });

        $('.close').on('click', function () {
            if (this.id != 'modal-closeBtn')
                $(this).parent().hide();
        });
        $('.modal-okBtn').on('click', function () {
            $('#myModal').modal('hide');
        });

        $('#myModal').on('hidden.bs.modal', function (e) {
            setTimeout(function () {
                $('.alert').fadeOut(3500);
                $('.file-status').fadeOut(3500);
            });
        })
        $("#Pdf").change(function (e) {
            fileType = this.files[0].type.split('/');
            fileSize = (this.files[0].size) / 1024 / 1024;
            if (fileType[1] != 'pdf') {
                $('#myModal').find('.modal-title').text('{{ __("common.orders_pdf") }}');
                $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_pdf") }}');
                $('#myModal').modal('show');
                $("ul li:nth-child(2) a").removeClass('appListSuccess');
                $('html, body').animate({scrollTop: 0}, 'slow');
                $('#hdnPdfSelected').val("0");
                $('#hdnPdfName').val("");
                $("#Pdf").parent().next().removeClass().addClass('fa fa-exclamation-triangle').removeClass('hide').css('color', 'red').fadeIn();
                $("#secondListItem").removeClass('appListSuccess');
                $("a#secondListItem").find('i').css('opacity', '0.3');
                $("a#secondListItem").find('i').css('color', '#999');
                return;
            }
            else {
                if (fileSize > 5) {
                    $('#myModal').find('.modal-title').text('{{ __("common.orders_pdffilesize") }}');
                    $('#myModal').find('.modal-body p').text('{{ __("common.orders_warning_pdfmaxfilesize") }}');
                    $('#myModal').modal('show');
                    $("ul li:nth-child(2) a").removeClass('appListSuccess');
                    $('html, body').animate({scrollTop: 0}, 'slow');
                    $('#hdnPdfSelected').val("0");
                    $('#hdnPdfName').val("");
                    $("#Pdf").parent().next().removeClass().addClass('fa fa-exclamation-triangle').removeClass('hide').css('color', 'red').fadeIn();
                    $("a#secondListItem").find('i').css('opacity', '0.3');
                    $("a#secondListItem").find('i').css('color', '#999');
                    return;
                }
                else {
                    $("ul li:nth-child(2) a").addClass('appListSuccess');
                    $("#Pdf").parent().next().removeClass().addClass('fa fa-check-circle').removeClass('hide').css('color', 'rgb(0, 202, 16);').fadeIn();
                }
            }
        })

        $('#OrderNo').on('focus', function () {
            $(".appimg").fadeTo('slow', 0, function () {
                $(".appimg img").each(function () {
                    $(this).addClass('hide');
                })
            });
        });

        $('#Name').on('focus', function () {
            $(".appimg").fadeTo('slow', 0, function () {
                $(".appimg img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgAppName').removeClass('hide');
                $(".appimg").fadeTo('slow', 1);
            });
        });
        $('input[type="text"], textarea, input[type="email"]').on('focusout', function () {
            var inputID = $(this).attr('id');
            if (!$(this).prev().hasClass(inputID + "isCheck")) {
                $(this).before("<i class='" + inputID + "isCheck'" + "></i>");
            }
            if ($(this).val().length > 0) {
                $(this).prev().replaceWith("<i class='fa fa-check-circle isCheck " + inputID + "isCheck" + " pull-right'" + "style='color:rgb(0, 202, 16);'></i>");
            }
            else {
                $(this).prev().replaceWith("<i class='fa fa-exclamation-triangle isCheck " + inputID + "isCheck" + " pull-right'" + "style='color:red;'></i>");
            }

            if ($(this).attr('id') == 'Description' && $(this).val().length < 100) {
                $(this).prev().replaceWith("<i class='fa fa-exclamation-triangle isCheck " + inputID + "isCheck" + " pull-right'" + "style='color:red;'></i>");
            }

            if ($(this).attr('id') == 'Facebook' && $(this).val().length > 0) {
                function validate_facebook(facebook_url) {
                    var facebookReg = /^(https?:\/\/)?((w{3}\.)?)facebook.com\/.*/i;
                    if (!facebookReg.test(facebook_url)) {
                        return false;
                    }
                    else
                        return true;
                }

                if (!validate_facebook($(this).val()))
                    $(this).prev().replaceWith("<i class='fa fa-exclamation-triangle isCheck " + inputID + "isCheck" + " pull-right'" + "style='color:red;'></i>");
                else
                    $(this).prev().replaceWith("<i class='fa fa-check-circle isCheck " + inputID + "isCheck" + " pull-right'" + "style='color:rgb(0, 202, 16);'></i>");
            }
            else if ($(this).attr('id') == 'Twitter' && $(this).val().length > 0) {
                function validate_twitter(twitter_url) {
                    var twitterReg = /^(https?:\/\/)?((w{3}\.)?)twitter\.com\/(#!\/)?[a-z0-9_]+$/i;
                    if (!twitterReg.test(twitter_url)) {
                        return false;
                    }
                    else
                        return true;
                }

                if (!validate_twitter($(this).val()))
                    $(this).prev().replaceWith("<i class='fa fa-exclamation-triangle isCheck " + inputID + "isCheck" + " pull-right'" + "style='color:red;'></i>");
                else
                    $(this).prev().replaceWith("<i class='fa fa-check-circle isCheck " + inputID + "isCheck" + " pull-right'" + "style='color:rgb(0, 202, 16);'></i>");
            }
            else if ($(this).attr('id') == 'Website' && $(this).val().length > 0) {
                $(this).prev().replaceWith("<i class='fa fa-check-circle isCheck " + inputID + "isCheck" + " pull-right'" + "style='color:rgb(0, 202, 16);'></i>");
            }
            else if ($(this).attr('id') == 'Email' && $(this).val().length > 0) {
                function validateEmail($email) {
                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    if (!emailReg.test($email)) {
                        return false;
                    } else {
                        return true;
                    }
                }

                if (!validateEmail($(this).val())) {
                    $(this).prev().replaceWith("<i class='fa fa-exclamation-triangle isCheck " + inputID + "isCheck" + " pull-right'" + "style='color:red;'></i>");
                }
                else {
                    $(this).prev().replaceWith("<i class='fa fa-check-circle isCheck " + inputID + "isCheck" + " pull-right'" + "style='color:rgb(0, 202, 16);'></i>");
                }
            }
            else if ($(this).attr('id') == 'Email' || $(this).attr('id') == 'Facebook' || $(this).attr('id') == 'Twitter' || $(this).attr('id') == 'Website')
                $(this).prev().css('display', 'none');
        });
        $('#Description').on('focus', function () {
            $(".appimg").fadeTo('slow', 0, function () {
                $(".appimg img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgAppDesc').removeClass('hide');
                $(".appimg").fadeTo('slow', 1);
            });
        });
        $('#Keywords').on('focus', function () {
            $(".appimg").fadeTo('slow', 0, function () {
                $(".appimg img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgKeywords').removeClass('hide');
                $(".appimg").fadeTo('slow', 1);
            });
        });
        $('#Email').on('focus', function () {
            $(".appimg").fadeTo('slow', 0, function () {
                $(".appimg img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgEmail').removeClass('hide');
                $(".appimg").fadeTo('slow', 1);
            });
        });
        $('#Website').on('focus', function () {
            $(".appimg").fadeTo('slow', 0, function () {
                $(".appimg img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgWebSite').removeClass('hide');
                $(".appimg").fadeTo('slow', 1);
            });
        });
        $('#Facebook').on('focus', function () {
            $(".appimg").fadeTo('slow', 0, function () {
                $(".appimg img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgFacebook').removeClass('hide');
                $(".appimg").fadeTo('slow', 1);
            });
        });
        $('#Twitter').on('focus', function () {
            $(".appimg").fadeTo('slow', 0, function () {
                $(".appimg img").each(function () {
                    $(this).addClass('hide');
                })
                $('#imgTwitter').removeClass('hide');
                $(".appimg").fadeTo('slow', 1);
            });
        });
        $("#firstListItem").click(function () {
            $("#stage2").addClass('hide');
            $("#stage3").addClass('hide');
            $("#stage4").addClass('hide');
            $("#stage1").removeClass().fadeIn().css('margin-top', '0');
        })
        $("#secondListItem").click(function () {
            $("#stage1").addClass('hide');
            $("#stage3").addClass('hide');
            $("#stage4").addClass('hide');
            $("#stage2").removeClass().fadeIn().css('margin-top', '0');
        })
        $("#thirdListItem").click(function () {
            $("#stage1").addClass('hide');
            $("#stage2").addClass('hide');
            if ($("a#thirdListItem").hasClass('appListSuccess') == false) {
                $("#stage3").removeClass().fadeIn().css('margin-top', '0');
            }
            else {
                $("#stage3").addClass('hide');
                $("#stage4").removeClass().fadeIn().css('margin-top', '0');
            }
        })
    });
</script>
</div>
<script src="/website/app-form/js/bootstrap.js"></script>
<script src="/website/scripts/jquery.inputlimiter.1.3.1.min.js"></script>
</body>
</html>