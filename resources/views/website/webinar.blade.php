@extends('website.html')

@section('body-content')

<style type="text/css">
    body{
        color: white;
    }
    .centered-form .panel{
        /*background: rgba(255, 255, 255, 0.8);
        box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;*/
        background: transparent;
    }
    .btn-info{
        background-color: #608FE0;
        border-color: black;
    }
    .tryit-form .reset {
        background-color: transparent;
    }
    .tryit-form .panel-transparent-row{
        background: transparent;
        height: 10px;
    }
    .tryit-form .panel-heading{
        background-color: rgba(9, 134, 194, 0.8);
        color: white;
    }
    .tryit-form .panel-footing{
        background-color: rgba(9, 134, 194, 0.8);
        font-size: 18px;
    }
    .tryit-form .panel-footing input{
        margin-top: 19px !important;
        border: 1px solid white;
        background-color: #f38621;
        font-size: 18px;
    }
    .tryit-form .panel-footing a{
        margin-top: 19px !important;
    }
    .tryit-form .panel-body{
        background-color: rgba(9, 134, 194, 0.8);
        padding: 20px;
    }
    .tryit-form .panel-title{
        font-size: 25px;
        text-align: center;
    }
    #tryit-form label{
        color: dimgrey;
    }
    .tryit-form .form-control{
        color: #555;
    }
    .tryit-form .formError{
        background-color: #F7B7BA;
    }
    .tryit-form .ng-dirty.ng-invalid {
        background-color: #F7B7BA;
    }
    .tryit-form .ng-valid {
        background-color: #86E091;
    }
    .tryit-form em{
        color:#CF1A1A;
    }
    .noTouch{
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        pointer-events: none;
    }

    .form-group{
        margin-bottom: 5px;
    }

    @media (max-width: 530px) {
        .tryit-form .panel-footing input,a{
            font-size: 11px !important;
            padding: 8px 0px !important;
        }

    }

    .landing-realty .filler{
        position: relative !important;
    }

    .landing-realty .icon-box-content{
        margin: 0 !important;
        color: white;
    }
    .landing-realty .icon-box-content p{
        text-align: left !important;
        margin: 3px !important;
    }
    .landing-realty .panel{
        background: transparent;
    }
    .landing-realty .blog-preview .post-info{
        margin-bottom: 0;
    }
    .landing-realty .swiper-slide{
        padding: 50px 0;
    }

    .landing-realty .blog-preview .info-text{
        width: 60%;
        color: #337ab7;
    }
    .landing-realty .form-control{
        border: 1px solid rgb(154, 154, 154);
    }

    .landing-realty .device-content{
        margin-bottom: -220px;
    }
    .landing-realty .icons{
        display:inline-block; 
        background-image:url('/images/website/landing/icons.png');
        width:30px; height:30px; 
        background-size:100% 100%;
        text-align: center;
        padding-top: 4px;
    }
    #formContainer{
        margin-top:-100px;
        right: 65px;
    }
    .fluid-width-video-wrapper{
        width: 100% !important;
        position: relative !important;
        left: 0 !important;
        top:0 !important;
    }
    .agents{
        margin-top: 15px;
    }
    .agents div span{
        display: inline-block;
        margin-top: 4px;
        font-size: 18px;
    }
    @media (max-width: 767px) {
        #formContainer{
            margin-top: 15px;
            right: 0;
        }
    }
    @media (max-width: 380px) {
        .swiper-slide{
            width: 285px;
        }
    }

    #info #calendar{
        float: left;
        width: 126px;
        height: 139px;
        margin-right: 10px;
        background: url(/images/website/webinar/calendar_03.png) 0 0 no-repeat;
    }

    #info #calendar p{text-align: center;}
    #info #calendar p#month{font-family: Arial; font-size: 20px; color: #ffffff; font-weight: bold; padding-top: 10px;}
    #info #calendar p#date{font-family: Arial; font-size: 70px; color: #292929; font-weight: bold; padding-top: 20px;}
    #info #dates p#day{font-family: 'Oswald', sans-serif; font-weight:300; font-size: 30px; color: #2894e2; padding-top: 0;}
    #info #dates p#month-date{font-family: 'Oswald', sans-serif; font-weight:400; font-size: 48px; color: #2894e2; padding-top: 0; line-height: 26px;}
    #info #dates p#time{font-family: 'Oswald', sans-serif; font-weight:300; font-size: 23px; padding-top: 0;}
    #host-id .host .host-intro{font-family: 'Source Sans Pro', sans-serif; font-weight:200; font-size: 20px; color: #333333; font-style: italic; margin:0; margin-top: 10px;}
    #intro {
        padding-top: 35px;
    }
    #intro .shell{
        margin-top: -30px;
        padding: 0;
        min-height: 400px;
        -webkit-border-radius: 10px;
        border-radius: 10px;
        border: 1px solid #d8d8d8;
        background-color:#ffffff;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.13/angular.min.js"></script>

<!--<section id="parallax4" class="header-section parallax landing-realty">-->
<section id="parallax4" style="background-image: url(/images/website/webinar/webinar_background.jpg);" class="parallax">
    <div class="sep-top-3x sep-bottom-2x">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="col-md-12">
                        <span style="font-size:50px;">EMLAK SEKTÖRÜNDE</span>
                    </div>
                    <div class="col-md-12">
                        <span style="font-size:50px ">MOBİL PAZARLAMA</span>
                    </div>
                    <div class="col-md-12">
                        <section id="intro">
                            <div id="info">
                                <div id="calendar">
                                    <p id="month">May</p>
                                    <p id="date" style="line-height: 26px;">17</p>
                                </div>
                                <div id="dates">
                                    <p id="day">Thursday</p>
                                    <p id="month-date">May 17th</p>
                                    <p id="time">at 5am Pacific, 8pm Eastern</p>
                                </div>
                            </div>
                        </section>
                    </div>

                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="row agents">
                        <div class="col-xs-10 col-sm-10 col-md-11 col-lg-11">
                            <span>Kendi mobil uygulamanız ile artık kontrol sizde.
                                Hiç bir kodlama bilgisine gerek yok, anahtar teslim çözüm.
                                Müşterilerinize en hızlı çözümü siz getirin: anlık push notification.
                                Veri toplayarak portföyünüze nereden ne zaman erişildiğini tespit edin.
                                Uygulamanızda yer alacak "Beni ara" butonu ile sürekli telefonunuz çalsın.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="tryit" class="landing-realty">
    <div class="container">
        <div class="row">
            <!-- BOOTSTRAP PULL-PUSH ILE DE COLUMN SIRALARI DEGISTIRILEBILIR -->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-xs" style="margin-bottom:-145px;">
                <div data-device="macbook" data-orientation="landscape" data-color="black" class="device-mockup" style="margin-top:14%;">
                    <div class="device">
                        <div class="screen">
                            <iframe scrolling="no" src="/website/animating/web/animasyon2.html" style="width:100% !important; height:100% !important;max-width:100% !important; max-height:100% !important;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2 col-lg-4" id="formContainer" ng-app="websiteApp">
                <form name="form" ng-submit="submitForm()" ng-controller="FormController" class="tryit-form" novalidate>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ücretsiz Katılın</h3>
                        </div>
                        <div class="panel-transparent-row"></div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="name">{{__('website.tryit_form_name_surname')}}</label>
                                <input type="text" id="name" name="name" ng-model="formData.name" 
                                       ng-class="{'ng-invalid ng-invalid-required formError' : errorName}" 
                                       required class="form-control input-sm" placeholder="{{__('website.webinar_form_name_surname_placeholder')}}">
                                <div ng-show="form.$submitted || form.name.$touched">
                                    <em ng-show="form.name.$error.required">{{__('website.webinar_form_name_surname_placeholder')}}</em>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail">{{__('website.tryit_form_email')}}</label>
                                <input id="inputEmail" type="email" name="email" ng-model="formData.email" 
                                       ng-class="{'ng-invalid ng-invalid-required formError' : errorEmail}" 
                                       required class="form-control input-sm" placeholder="{{__('website.tryit_form_email_placeholder')}}">
                                <div ng-show="form.$submitted || form.email.$touched">
                                    <em ng-show="form.email.$error.required">{{__('website.tryit_form_email_placeholder')}}</em>
                                    <em ng-show="form.email.$error.email">{{__('website.tryit_form_error_email')}}</em>
                                    <em ng-show="emailExist">{{__('website.tryit_form_error2_email')}}</em>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_name">{{__('website.webinar_phone')}}</label>
                                <input type="text"id="user_name" name="user_name" ng-model="formData.user_name" 
                                       ng-class="{'ng-invalid ng-invalid-required formError' : errorUserName}" 
                                       required class="form-control input-sm" placeholder="{{__('website.webinar_form_phone_placeholder')}}">
                                <div ng-show="form.$submitted || form.user_name.$touched">
                                    <em ng-show="form.user_name.$error.required">{{__('website.webinar_form_phone_placeholder')}}</em>
                                </div>
                                <div ng-show="userExist">
                                    <em>{{__('website.tryit_form_error_user')}}</em>
                                </div>
                            </div>
                        </div>
                        <div class="panel-transparent-row"></div>
                        <div class="panel-footing" style="display:-webkit-box !important; height:80px;">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <input type="submit" value="{{__('website.webinar_form_submit')}}" class="btn btn-primary btn-block" style="outline:none;">
                            </div>
                        </div>

                        <div class="panel-transparent-row"></div>
                        <div class="form-group">
                            <label for="send_email" style="color: black; font-size: 12px;">
                                <input type="checkbox" id='send_email' name='send_email' checked="checked" style="vertical-align: sub;"/>
                                {{__('website.webinar_accept_email')}}
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <!-- BOOTSTRAP PULL-PUSH ILE DE COLUMN SIRALARI DEGISTIRILEBILIR -->
            <div class="col-xs-12 visible-xs-block">
                <div data-device="macbook" data-orientation="landscape" data-color="black" class="device-mockup" style="margin-top:14%;">
                    <div class="device">
                        <div class="screen">
                            <iframe scrolling="no" src="/website/animating/web/animasyon2.html" style="width:100% !important; height:100% !important;max-width:100% !important; max-height:100% !important;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-primary sep-top-md sep-bottom-md">
        <div class="container">
            <div class="row">
                <div class="col-xs-offset-0 col-xs-12 col-sm-offset-7 col-sm-5 col-md-offset-7 col-md-5 col-lg-offset-7 col-lg-5">
                    <p class="lead x2 light wow bounceInLeft" style="font-size:1.7em;">Kaygının tedavisi hareket halinde olmaktır.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="blog" class="landing-realty">
    <div class="container">
        <div class="row" style="padding: 35px 30px 35px ;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="blog-preview">
                    <div class="post-info text-center">
                        <a>
                            <img src="/images/website/webinar/fatih_resim.jpg" alt="Mustafa Yerdemir" style="width:99px; height:99px;" class="img-circle user-thumb">
                        </a>
                        <span class="info-text text-left">Fatih Deniz Karaçalı
                            <small>
                                <a>Mobil portföyümü güncellerken emlak portallarıma harcadığım zamanında yarısından azını harcıyorum . 
                                    Mobil portföyümü güncellerken emlak portallarıma harcadığım zamanında yarısından azını harcıyorum .
                                </a>
                            </small>
                        </span>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
		function changeCaptcha() {
			// var captchaUrl=document.getElementById("captcha").src;
			// var captchaPrevParam=captchaUrl.substr(0,captchaUrl.indexOf("?"));
			// captchaNextParam = parseInt(captchaUrl.substr(captchaUrl.indexOf("?")+1))+1;
			// document.getElementById("captcha").src = captchaPrevParam+"?"+captchaNextParam;
			location.reload();
		}
		// creating Angular Module
		var websiteApp = angular.module('websiteApp', []);
		// create angular controller and pass in $scope and $http

		//FOR PASSWORDS MATCH
		websiteApp.directive('nxEqual', function () {
			return {
				require: 'ngModel',
				link: function (scope, elem, attrs, model) {
					if (!attrs.nxEqual) {
						//console.error('nxEqual expects a model as an argument!');
						return;
					}
					scope.$watch(attrs.nxEqual, function (value) {
						model.$setValidity('nxEqual', value === model.$viewValue);
					});
					model.$parsers.push(function (value) {
						var isValid = value === scope.$eval(attrs.nxEqual);
						model.$setValidity('nxEqual', isValid);
						return isValid ? value : undefined;
					});
				}
			};
		});
		websiteApp.controller('FormController', function ($scope, $http) {
			//$scope will allow this to pass between controller and view
			$scope.master = {};

			$scope.reset = function (form) {
				if (form) {
					form.$setPristine();
					form.$setUntouched();
				}
				$scope.formData = angular.copy($scope.master);
			};

			var param = function (data) {
				var returnString = '';
				for (d in data) {
					if (data.hasOwnProperty(d))
						returnString += d + '=' + data[d] + '&';
				}
				// Remove last ampersand and return
				return returnString.slice(0, returnString.length - 1);
			};
			$scope.submitForm = function () {
				$http({
					method: 'POST',
					url: "{{__('route.website_landing_page_realty')}}",
					data: param($scope.formData), // pass in data as strings
					headers: {'Content-Type': 'application/x-www-form-urlencoded'} // set the headers so angular passing info as form data (not request payload)
				})
					.success(function (data) {
						if (!data.success) {
							// if not successful, bind errors to error variables
							$scope.errorName = data.errors.name;
							$scope.errorLastName = data.errors.last_name;
							$scope.errorEmail = data.errors.email;
							$scope.errorUserName = data.errors.user_name;
							$scope.errorAppName = data.errors.app_name;
							$scope.userExist = data.errors.user_name_exist;
							$scope.emailExist = data.errors.email_exist;
							$scope.errorPassword = data.errors.password;
							$scope.errorPasswordVerify = data.errors.password_verify;
							$scope.errorCaptcha = data.errors.captcha;
							$scope.errorCaptchaInvalid = data.errors.captcha_invalid;


						} else {
							$scope.userExist = false;
							//$scope.reset($scope.form);
							alert("{{__('website.tryit_form_message_mail')}}");

							/*Google Code for Website Conversion Galepress Conversion*/
							/* <![CDATA[ */
							var google_conversion_id = 980149592;
							var google_conversion_language = "en";
							var google_conversion_format = "3";
							var google_conversion_color = "ffffff";
							var google_conversion_label = "vsCnCMHg-VoQ2Mqv0wM";
							var google_conversion_value = 50.00;
							var google_conversion_currency = "TRY";
							var google_remarketing_only = false;
							/* ]]> */

						}
					});
			};
		});
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/980149592/?value=50.00&amp;currency_code=TRY&amp;label=vsCnCMHg-VoQ2Mqv0wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

@endsection