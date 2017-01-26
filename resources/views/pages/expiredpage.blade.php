@extends('layouts.master')

@section('content')

    <div class="container unclickable" style="overflow:hidden;">       
        <div class="block-error">
            <div class="col-md-12">
                <div class="error-code">
                    <u style="color:#1681bf;">{{$appName}}</u> {{__('common.login_error_expiration')}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">            
                    <div class="error-text">{{__('common.applications_expired_detail')}}</div>
                    <div class="error-logo" style="margin-top:-100px; overflow:hidden;"><img src="/img/expiredBack.png" /></div>
                </div>
            </div>
            <img src="/img/press.png" style="float:right; margin-top:-550px; margin-right:-300px; opacity: 0.8;"/>
        </div>
    </div>

@endsection