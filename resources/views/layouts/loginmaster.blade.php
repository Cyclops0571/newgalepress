@extends('layouts.html')
@section('body')

    <body id="login" class="bg-img-num1">
    	<div id="login_container">
	    	@yield('content')
        </div>
        <div class="statusbar hidden" id="myNotification">
	        <div class="statusbar-icon" style="margin-left:41%"><span></span></div>
	        <div class="statusbar-text">
	            <span class="text"></span>
	            <span class="detail"></span>
	        </div>
	        <div class="statusbar-close icon-remove" onclick="cNotification.hide()"></div>
	    </div>
	    @if(Session::has('message'))
	    <script type="text/javascript">
	    	$(function () {
				cNotification.info("{{ Session::get('message') }}");
	    	});
	    </script>
		@endif
		@if(Session::has('confirm'))
	    <script type="text/javascript">
	    	$(function () {
				cNotification.success("{{ Session::get('confirm') }}");
	    	});
	    </script>
		@endif
    </body>
@endsection