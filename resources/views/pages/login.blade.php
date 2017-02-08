@extends('layouts.loginmaster')


@section('content')
    <?php
    $cookie = Cookie::get('DSCATALOG_USERNAME', '');
    ?>
    <form method="post" action="{{__('route.login')}}">
      {{csrf_field()}}
      <div class="container">
        <div class="login-block">
          <div class="block bg-light loginBlock" style="border-radius:13px;">
            <div class="head">
              <div class="user">
                <img src="/images/myLogo3.png">
              </div>
            </div>
            <div class="content controls npt">
              <div class="form-row user-change-row" style="display: block;">
                <div class="col-md-12">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="icon-user" id="login-icon-user" style="font-size:15px;"></span>
                    </div>
                    <input class="form-control txt required" type="text"
                           placeholder="{{ __('common.users_username') }}" id="Username" name="Username"
                           onKeyPress="return cUser.loginEvent(event, cUser.login);"
                           value="{{ $cookie }}"/>
                    {{ $errors->first('Username', '<p class="error">:message</p>') }}
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span class="icon-key" id="login-icon-key"></span>
                    </div>
                    <input type="password" class="form-control txt required" id="Password"
                           name="Password" onKeyPress="return cUser.loginEvent(event, cUser.login);"
                           placeholder="{{ __('common.users_password') }}"/>
                    {{ $errors->first('Password', '<p class="error">:message</p>') }}
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-8">
                  <div class="checkbox" style="padding-left:0;">
                    <label style="font-size:14px;"><input type="checkbox"
                                                          name="Remember" {{ (strlen($cookie) > 0 ? ' checked="checked"' : '') }} />{{ __('common.login_remember') }}
                    </label>
                  </div>
                </div>
                <div class="col-md-4">
                  <input type="button" class="btn btn-mini" name="login" id="login"
                         value="{{ __('common.login_button') }}" onclick="cUser.login();"/>
                </div>
              </div>
              <div class="form-row" style="margin-bottom:0;">
                <!-- border-bottom:1px solid #202020; height:35px; -->
                <div class="col-md-12">
                  <div style="text-align:center"><u>
                      <a href="{{route('common_forgotmypassword_get')}}">{{ __('common.login_forgotmypassword') }}</a></u>
                  </div>
                </div>
              </div>
              <div class="form-row">

                <style type="text/css">
                  .faceDivider {
                    border-top: 1px solid #202020;
                    border-bottom: 1px solid #525050;
                    margin-bottom: 2px;
                    /*202020*/
                  }

                </style>

                <div class="col-xs-5 col-sm-5 col-md-5">
                  <hr class="faceDivider">
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 text-center"
                     style="padding-top:2px;">{{__('common.or')}}</div>
                <div class="col-xs-5 col-sm-5 col-md-5">
                  <hr class="faceDivider">
                </div>

              </div>
              <div class="form-row">
                <div class="col-md-12 text-center">
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
                                  window.location = "{{__('route.home')}}";
                              }).fail(function (msg) {
                                  ;
                              });
                          });
                      }
                  </script>

                  <style type="text/css">
                    .social-media {
                      /*margin-top: 22px;*/
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

                    .noTouch {
                      -webkit-touch-callout: none;
                      -webkit-user-select: none;
                      -khtml-user-select: none;
                      -moz-user-select: none;
                      -ms-user-select: none;
                      user-select: none;
                      pointer-events: none;
                    }

                  </style>

                <!-- <label style="display:block;">{{__('common.or')}}</label> -->

                  <div class="btn-group social-media">
                    <button type="button" name="glogin" id="glogin" class="btn fb-button noTouch"><i
                          class="icon-facebook"></i></button>
                    <button type="button" name="fblogin" id="fblogin" class="btn fb-button"
                            onlogin="checkLoginState();"
                            onclick="checkLoginState();">{{__('common.login_facebook')}}</button>
                  </div>

                  <!-- <a href="#" class="btn fb-button" name="fblogin" id="fblogin"><i class="icon-facebook"></i> <div class="btn-insent-border"></div> Facebook ile Oturum Aç</a> -->

                  <!-- <fb:login-button scope="public_profile,email" data-size="large" onlogin="checkLoginState();" style="margin-top:15px;">Facebook ile Oturum Aç</fb:login-button> -->

                  <div id="status"></div>
                  <div id="fb-root"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>

@endsection