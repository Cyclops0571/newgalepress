@extends('website.html')

@section('body-content')

  <style type="text/css">

    body {
      color: #777;
    }

    .centered-form {
      margin-top: 60px;
    }

    .centered-form .panel {
      /*background: rgba(255, 255, 255, 0.8);
      box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;*/
      background: transparent;
    }

    .btn-info {
      background-color: #608FE0;
      border-color: black;
    }

    .tryit-form .reset {
      background-color: transparent;
    }

    .tryit-form .panel-transparent-row {
      background: transparent;
      height: 10px;
    }

    .tryit-form .panel-heading {
      background-color: rgba(222, 222, 222, 0.80);
    }

    .tryit-form .panel-footing {
      background-color: rgba(222, 222, 222, 0.80);
    }

    .tryit-form .panel-footing input {
      margin-top: 19px !important;
    }

    .tryit-form .panel-footing a {
      margin-top: 19px !important;
    }

    .tryit-form .panel-body {
      background-color: rgba(222, 222, 222, 0.80);
    }

    .tryit-form .panel-title {
      font-size: 25px;
      text-align: center;
    }

    #tryit-form label {
      color: dimgrey;
    }

    .tryit-form .form-control {
      color: #555;
    }

    .tryit-form .formError {
      background-color: #F7B7BA;
    }

    .tryit-form .ng-dirty.ng-invalid {
      background-color: #F7B7BA;
    }

    .tryit-form .ng-valid {
      background-color: #86E091;
    }

    .tryit-form em {
      color: #CF1A1A;
    }

    .noTouch {
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      pointer-events: none;
    }

    .social-media * {
      /*margin-top: 22px;*/
      /*border:1px solid;*/
      outline: none !important;
    }

    .social-media .btn {
      /*margin-top: 22px;*/
      border: 1px solid;
    }

    .g-button {
      background: #dd4b39 !important;
      color: white !important;
    }

    .g-button i {
      font-size: 1.4em;
    }

    .fb-button {
      background: #3b5998 !important;
      color: white !important;
      font-family: "lucida grande", tahoma, verdana, arial, sans-serif;
      /*margin-top: 22px;*/
    }

    .fb-button i {
      font-size: 1.4em;
      vertical-align: middle;
    }

    @media (max-width: 530px) {

      .social-media button:first-child {
        width: 40px !important;
      }

      .social-media button:last-child {
        width: 180px;
        padding: 11.3px 0;
        font-size: 12px;
      }

      .tryit-form .panel-footing input, a {
        font-size: 11px !important;
        padding: 8px 0px !important;
      }

    }

  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.13/angular.min.js"></script>

  <section id="tryit" class="sep-top-3x sep-bottom-3x"
           style="background-image: url(/images/website/sectors/backgroundBlur.jpg); background-repeat:no-repeat; background-size:cover;"
           class="header-section">
    <div class="container">
      <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3"
             ng-app="websiteApp">
          <form name="form" ng-submit="submitForm()" ng-controller="FormController" class="tryit-form" novalidate>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">{{__('website.tryit_form_title')}}
                  <small>{{__('website.tryit_form_subtitle')}}</small>
                </h3>
              </div>
              <div class="panel-transparent-row"></div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group text-center" style="line-height:35px; border-bottom: 1px solid #B5B5B5;">
                      <script>
                          // This is called with the results from from FB.getLoginStatus().
                          function statusChangeCallback(response) {
                              // The response object is returned with a status field that lets the
                              // app know the current login status of the person.
                              // Full docs on the response object can be found in the documentation
                              // Logged into your app and Facebook.

                              if (response.status === "connected") {
                                  var uID = response.authResponse.userID;
                                  testAPI(response.authResponse.accessToken);
                              }
                              else if (response.status === 'not_authorized') {
                                  // The person is logged into Facebook, but not your app.
                                  //document.getElementById('status').innerHTML = 'Please log ' +'into this app.';
                              } else {
                                  // The person is not logged into Facebook, so we're not sure if
                                  // they are logged into this app or not.
                                  //document.getElementById('status').innerHTML = 'Please log ' +'into Facebook.';
                              }
                          }

                          // This function is called when someone finishes with the Login
                          // Button.  See the onlogin handler attached to it in the sample
                          // code below.
                          function checkLoginState() {

                              FB.login(function (response) {
                                      statusChangeCallback(response);
                                  },
                                  {
                                      scope: 'email'
                                  });
                          }

                          window.fbAsyncInit = function () {
                              FB.init({
                                  appId: '583822921756369',
                                  cookie: true,  // enable cookies to allow the server to access
                                                 // the session
                                  xfbml: true,  // parse social plugins on this page
                                  version: 'v2.2' // use version 2.2
                              });

                          };

                          // Load the SDK asynchronously
                          (function (d, s, id) {
                              var js, fjs = d.getElementsByTagName(s)[0];
                              if (d.getElementById(id)) return;
                              js = d.createElement(s);
                              js.id = id;
                              js.src = "//connect.facebook.net/tr_TR/sdk.js";
                              fjs.parentNode.insertBefore(js, fjs);
                          }(document, 'script', 'facebook-jssdk'));

                          // Here we run a very simple test of the Graph API after login is
                          // successful.  See statusChangeCallback() for when this call is made.


                          function testAPI(accessToken) {
                              FB.api('/' + 'me', function (response) {
                                  document.getElementById('status').innerHTML =
                                      '{{__("common.thanku")}}, ' + response.name + '!';

                                  $.ajax({
                                      type: "POST",
                                      url: "{{__('route.facebook_attempt')}}",
                                      data: {
                                          formData: JSON.stringify(response),
                                          accessToken: accessToken
                                      }
                                  }).success(function (msg) {
                                      window.location.href = "<?php echo route('home');?>";
                                  }).fail(function (msg) {
                                  });
                              });
                          }
                      </script>

                      <label for="name">{{__('common.signup_facebook_title')}}</label>


                      <div class="btn-group social-media">
                        <button type="button" name="glogin" id="glogin" class="btn fb-button noTouch"
                                style="width:60px; height:42px; padding:0;"><i class="fa fa-facebook"></i></button>
                        <button type="button" name="fblogin" id="fblogin" class="btn fb-button"
                                onclick="checkLoginState();">{{__('common.signup_facebook')}}</button>
                      </div>

                      <!-- <a href="#" class="btn fb-button" name="fblogin" id="fblogin"><i class="icon-facebook"></i> <div class="btn-insent-border"></div> Facebook ile Oturum Aç</a> -->

                      <!-- <fb:login-button scope="public_profile,email" data-size="large" onlogin="checkLoginState();" style="margin-top:15px;">Facebook ile Oturum Aç</fb:login-button> -->

                      <div id="status"></div>
                      <div id="fb-root"></div>
                      <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>

                      <div id="status"></div>
                      <div id="fb-root"></div> -->
                      <label style="display:block;">{{__('common.or')}}</label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <label for="name">{{__('website.tryit_form_name')}}</label>
                      <input type="text" id="name" name="name" ng-model="formData.name"
                             ng-class="{'ng-invalid ng-invalid-required formError' : errorName}" required
                             class="form-control input-sm" placeholder="{{__('website.tryit_form_name_placeholder')}}">

                      <div ng-show="form.$submitted || form.name.$touched">
                        <em ng-show="form.name.$error.required">{{__('website.tryit_form_name_placeholder')}}</em>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <label for="last_name">{{__('website.tryit_form_lastname')}}</label>
                      <input type="text" id="last_name" name="last_name" ng-model="formData.last_name"
                             ng-class="{'ng-invalid ng-invalid-required formError' : errorLastName}" required
                             class="form-control input-sm"
                             placeholder="{{__('website.tryit_form_lastname_placeholder')}}">

                      <div ng-show="form.$submitted || form.last_name.$touched">
                        <em ng-show="form.last_name.$error.required">{{__('website.tryit_form_lastname_placeholder')}}</em>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail">{{__('website.tryit_form_email')}}</label>
                  <input id="inputEmail" type="email" name="email" ng-model="formData.email"
                         ng-class="{'ng-invalid ng-invalid-required formError' : errorEmail}" required
                         class="form-control input-sm" placeholder="{{__('website.tryit_form_email_placeholder')}}">

                  <div ng-show="form.$submitted || form.email.$touched">
                    <em ng-show="form.email.$error.required">{{__('website.tryit_form_email_placeholder')}}</em>
                    <em ng-show="form.email.$error.email">{{__('website.tryit_form_error_email')}}</em>
                    <em ng-show="emailExist">{{__('website.tryit_form_error2_email')}}</em>
                  </div>
                </div>

                <div class="form-group">
                  <label for="app_name">{{__('website.tryit_form_appname')}}</label>
                  <input type="text" id="app_name" name="app_name" ng-model="formData.app_name"
                         ng-class="{'ng-invalid ng-invalid-required formError' : errorAppName}" required
                         class="form-control input-sm" placeholder="{{__('website.tryit_form_appname_placeholder')}}">

                  <div ng-show="form.$submitted || form.app_name.$touched">
                    <em ng-show="form.app_name.$error.required">{{__('website.tryit_form_appname_placeholder')}}</em>
                  </div>
                </div>

                <div class="form-group">
                  <label for="user_name">{{__('website.tryit_form_username')}}</label>
                  <input type="text" id="user_name" name="user_name" ng-model="formData.user_name"
                         ng-class="{'ng-invalid ng-invalid-required formError' : errorUserName}" required
                         class="form-control input-sm" placeholder="{{__('website.tryit_form_username_placeholder')}}">

                  <div ng-show="form.$submitted || form.user_name.$touched">
                    <em ng-show="form.user_name.$error.required">{{__('website.tryit_form_username_placeholder')}}</em>
                  </div>
                  <div ng-show="userExist">
                    <em>{{__('website.tryit_form_error_user')}}</em>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <label for="password">{{__('website.tryit_form_pass')}}</label>
                      <input type="password" id="password" name="password" ng-model="formData.password"
                             ng-class="{'ng-invalid ng-invalid-required formError' : errorPassword}" required
                             class="form-control input-sm" placeholder="{{__('website.tryit_form_pass_placeholder')}}">
                      <em class="col-xs-12 col-sm-12 col-md-12"
                          ng-show="errorPasswordVerify">{{__('website.tryit_form_error_pass')}}</em>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <label for="password_verify">{{__('website.tryit_form_pass2')}}</label>
                      <input type="password" id="password_verify" name="password_verify"
                             ng-model="formData.password_verify" nx-equal="formData.password"
                             ng-class="{'ng-invalid ng-invalid-required formError' : errorPasswordVerify}" required
                             class="form-control input-sm" placeholder="{{__('website.tryit_form_pass2_placeholder')}}">
                      <em class="col-xs-12 col-sm-12 col-md-12"
                          ng-show="errorPasswordVerify">{{__('website.tryit_form_error_pass')}}</em>
                      <span ng-show="form.password_verify.$error.nxEqual">{{__('website.tryit_form_error_pass')}}</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <label for="captcha">{{__('website.tryit_form_securitycode')}}</label>
                      <input class="captchainput form-control input-sm"
                             placeholder="{{__('website.tryit_form_securitycode_placeholder')}}" id="captcha"
                             name="captcha" ng-model="formData.captcha"
                             ng-class="{'ng-invalid ng-invalid-required formError' : errorCaptcha}" required
                             type="text">

                      <div ng-show="form.$submitted || form.captcha.$touched">
                        <em ng-show="form.captcha.$error.required">{{__('website.tryit_form_securitycode_placeholder')}}</em>
                        <em ng-show="errorCaptchaInvalid">{{__('website.tryit_form_error_securitycode')}}</em>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group" onclick="changeCaptcha()" style="cursor:pointer">
                      <input class="captchaimg noTouch" src="{{MeCaptcha\Captcha::img()}}" name="captcha" id="captcha"
                             type="image" style="margin-top:26.05px;">
                    </div>
                  </div>
                </div>
              </div>
              <div class="panel-transparent-row"></div>

              <div id="succesMessage" class="bs-example" style="display: none">
                <div class="alert alert-success">
                  <strong><?php echo __('website.tryit_form_message_mail'); ?></strong>
                </div>
              </div>

              <div class="panel-footing" style="display:-webkit-box !important; height:80px;">
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <input type="submit" value="{{__('website.tryit_form_submit')}}" class="btn btn-primary btn-block"
                         style="outline:none;">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <a href="{{route('common_login_get')}}"
                     class="btn btn-bordered btn-block">{{__('website.tryit_form_return')}}</a>
                </div>
              </div>
              <div class="panel-transparent-row"></div>
              <div class="panel-footing" style="padding: 10px;">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
                    {{__('website.download_gpviewer')}}
                  </div>
                </div>
                <div class="row" style="margin-top: 5px; align-content: center">
                  <div class="col-xs-3 col-sm-3 col-md-3"></div>
                  <div class="col-xs-3 col-sm-3 col-md-3">
                    <a href="<?php echo config("custom.galepress_https_url"); ?>/enterprise/gpviewer/ipa/GalePress.plist">
                      <img style="width: 100%; height:auto;" src="/images/website/appstore.png"/>
                    </a>
                  </div>
                  <div class="col-xs-1 col-sm-1 col-md-1"></div>
                  <div class="col-xs-3 col-sm-3 col-md-3">
                    <a href="<?php echo config("custom.galepress_https_url"); ?>/enterprise/gpviewer/ipa/gpviewer.apk">
                      <img style="width: 100%; height:auto;" src="/images/website/googleplay.png"/>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </form>
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
                  url: "{{__('route.website_tryit')}}",
                  data: param($scope.formData), // pass in data as strings
                  headers: {'Content-Type': 'application/x-www-form-urlencoded'} // set the headers so angular passing info as form data (not request payload)
              })
                  .success(function (data) {
                      if (!data.success) {
                          // if not successful, bind errors to error variables
                          $scope.errorName = data.errors.name;
                          $scope.errorLastName = data.errors.last_name;
                          $scope.errorEmail = data.errors.email;
                          $scope.errorUserName = data.errors.user_name
                          $scope.errorAppName = data.errors.app_name;
                          $scope.userExist = data.errors.user_name_exist;
                          $scope.emailExist = data.errors.email_exist;
                          $scope.errorPassword = data.errors.password;
                          $scope.errorPasswordVerify = data.errors.password_verify;
                          $scope.errorCaptcha = data.errors.captcha;
                          $scope.errorCaptchaInvalid = data.errors.captcha_invalid;
                          $("#succesMessage").hide();

                      } else {
                          $scope.errorName = false;
                          $scope.errorLastName = false;
                          $scope.errorEmail = false;
                          $scope.errorUserName = false
                          $scope.errorAppName = false;
                          $scope.userExist = false;
                          $scope.emailExist = false;
                          $scope.errorPassword = false;
                          $scope.errorPasswordVerify = false;
                          $scope.errorCaptcha = false;
                          $scope.errorCaptchaInvalid = false;
                          $("#succesMessage").show();
                          setTimeout(function () {
                              window.location.href = '<?php echo route('home');?>';
                          }, 3000);


                        /*Google Code for Website Conversion Gale Press Conversion*/
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
      <img height="1" width="1" style="border-style:none;" alt=""
           src="//www.googleadservices.com/pagead/conversion/980149592/?value=50.00&amp;currency_code=TRY&amp;label=vsCnCMHg-VoQ2Mqv0wM&amp;guid=ON&amp;script=0"/>
    </div>
  </noscript>

@endsection