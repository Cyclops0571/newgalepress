@layout('layouts.genericmaster')

@section('content') 
<div class="header">
    <h2><?php echo __('clients.forgot_password'); ?> </h2>
</div>
<div class="login col-lg-12 col-md-12 col-sm-12 col-sx-12 pagination-centered">	                        
    <div class="headerContent text-center">
	<div class="stepFirst"><span>1</span></div>
	<h3><?php echo  __('clients.forgot_password'); ?></h3>
    </div>   
    <div class="login-info">
	<form id="loginForm" name="signUp" method="POST">
	    <input type="hidden" name="ApplicationID" value="<?php echo $application->ApplicationID; ?>" />
	    <div id="input_container">
		<input type="email" name="Email" id="Email" placeholder="<?php echo __('common.users_email'); ?>" class="email"  required autocomplete="off">
		<img id="input_img" src="/images/envelope.png"/>	
		<span id="EmailValidator" class="text-center validationMessage"><?php echo __('common.detailpage_fill_this_arae'); ?></span>
	    </div>
	    <div class="btns">
		<input type="button" value="<?php echo __('common.pushnotify_send'); ?>" onclick="sClient.forgotMyPassword();">                                        
	    </div>
	</form>
    </div>
</div>
@endsection