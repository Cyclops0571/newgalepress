@layout('layouts.genericmaster')

@section('content')
<script>
    /* global notification, route, sNotifications, currentLanguage, sForm, sClient */
</script>
<div class="header">
    <h2><?php echo __('clients.reset_password'); ?> </h2>
</div>
<div class="login col-lg-12 col-md-12 col-sm-12 col-sx-12 pagination-centered">
    <?php if(!empty($errorMsg)): ?>
    <div class="stepFirst"><span>1</span></div>
    <h3><?php echo $errorMsg; ?></h3>
    <?php else: ?>
    <div class="headerContent text-center">
	<div class="stepFirst"><span>1</span></div>
	<h3><?php echo __('clients.reset_password'); ?></h3>
    </div>   
    <div class="login-info">
	<form id="loginForm" name="signUp" method="POST">
	    <?php echo Form::token(); ?>
	    <?php echo Form::hidden('ApplicationID', Input::get('ApplicationID')); ?>
	    <?php echo Form::hidden('Email', Input::get('email')); ?>
	    <?php echo Form::hidden('Code', Input::get('code')) ?>
	    <div id="input_container">
		<input type="password" name="Password" id="Password" placeholder="{{ __('common.users_password') }}" required autocomplete="off" onkeypress='return sForm.bindEnterKey(event, sClient.resetMyPassword);'/>
		<img id="input_img" src="/images/lock.png"/>	
		<span id="PasswordValidator" class="text-center validationMessage"><?php echo __('common.detailpage_fill_this_arae'); ?></span>
	    </div>
	    <div id="input_container">
		<input type="password" name="Password2" id="Password2" placeholder="{{ __('common.users_password2') }}" required autocomplete="off" onkeypress='return sForm.bindEnterKey(event, sClient.resetMyPassword);'/>
		<img id="input_img" src="/images/lock.png"/>	
		<span id="Password2Validator" class="text-center validationMessage"><?php echo __('common.detailpage_fill_this_arae'); ?></span>
	    </div>
	    <div class="btns">
		<input type="button" value="<?php echo __('common.detailpage_send'); ?>" onclick="sClient.resetMyPassword();">                                        
	    </div>
	</form>
    </div>
    <?php endif; ?>
</div>
@endsection