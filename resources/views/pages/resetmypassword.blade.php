@extends('layouts.login')

@section('content')
  {{ Form::open(__('route.resetmypassword'), 'POST') }}
  {{ Form::token() }}
  {{ Form::hidden('Email', request('email')) }}
  {{ Form::hidden('Code', request('code')) }}
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
                  <span class="icon-key" id="forgot-pass-icon"></span>
                </div>
                <input type="password" class="txt required" id="Password" name="Password"
                       placeholder="{{ __('common.users_password') }}"
                       onKeyPress="return cUser.loginEvent(event, cUser.resetMyPassword);"/>
                {{ $errors->first('Password', '<p class="error">:message</p>') }}
              </div>
            </div>
          </div>
          <div class="form-row user-change-row" style="display: block;">
            <div class="col-md-12">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="icon-key" id="forgot-pass-icon"></span>
                </div>
                <input type="password" class="txt required" id="Password2" name="Password2"
                       placeholder="{{ __('common.users_password2') }}"
                       onKeyPress="return cUser.loginEvent(event, cUser.resetMyPassword);"/>
                {{ $errors->first('Password2', '<p class="error">:message</p>') }}
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6">
              <a style="display:block;" class="btn btn-mini"
                 href="{{route('common_login_get')}}">{{ __('common.login_goback') }}</a>
            </div>
            <div class="col-md-6">
              <input type="button" name="login" id="login" class="btn btn-mini"
                     value="{{ __('common.login_button_resetmypassword') }}" onclick="cUser.resetMyPassword();"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{ Form::close() }}
@endsection