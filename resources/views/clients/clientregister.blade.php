@layout('layouts.genericmaster')

@section('content')
</style>
<?php
$ClientID = 0;
$ApplicationID = 0;
$Username = '';
$Password = '';
$Email = '';
$FirstName = '';
$LastName = '';
$LastLoginData = '';
$InvalidPasswordAttempts = 0;
/* @var $applications Application */
$applications;
/* @var $client Client */
if (isset($client)) {
    $ClientID = (int) $client->ClientID;
    $ApplicationID = (int) $client->ApplicationID;
    $Username = $client->Username;
    $Password = $client->Password;
    $Email = $client->Email;
    $FirstName = $client->Name;
    $LastName = $client->Surname;
}
?>



<div class="header">
    <p><?php echo __('common.detailpage_caption'); ?></p>
</div>

<div class="login col-lg-12 col-md-12 col-sm-12 col-sx-12 pagination-centered">	                        

    <div class="headerContent text-center">
	<div class="stepFirst"><span>1</span></div>
	<h3><?php echo __('clients.personol_info'); ?></h3>
    </div>                  

    <div class="login-info">      
	<form id="loginForm" name="signUp" method="POST">
	    <input type="hidden" name="ApplicationID" value="<?php echo $application->ApplicationID; ?>" />
	    <div id="input_container">
		<input type="text" name="FirstName" class="text" value="<?php echo $FirstName; ?>" placeholder="<?php echo __('common.clients_firstname'); ?>" required autocomplete="off">
		<img id="input_img" src="/images/user.png"/>	
		<span id="FirstNameValidator" class="text-center validationMessage"><?php echo __('common.detailpage_fill_this_arae'); ?></span>
	    </div>

	    <div id="input_container">
		<input type="text" name="LastName" value="<?php echo $LastName; ?>" class="text" placeholder="<?php echo __('common.clients_lastname'); ?>" required autocomplete="off">
		<img id="input_img" src="/images/user.png"/>	
		<span id="LastNameValidator" class="text-center validationMessage"><?php echo __('common.detailpage_fill_this_arae'); ?></span>
	    </div>


	    <div id="input_container">
		<input type="text" name="Username" value="<?php echo $Username; ?>" class="text" placeholder="<?php echo __('common.clients_username'); ?>" required autocomplete="off">
		<img id="input_img" src="/images/user.png"/>
		<span id="UsernameValidator" class="text-center validationMessage"><?php echo __('common.detailpage_fill_this_arae'); ?></span>
	    </div>

	    <div id="input_container">
		<input type="email" name="Email" value="<?php echo $Email; ?>" class="email" placeholder="<?php echo __('common.users_email'); ?>" required autocomplete="off">
		<img id="input_img" src="/images/envelope.png"/>
		<span id="EmailValidator" class="text-center validationMessage"><?php echo __('common.detailpage_fill_this_arae'); ?></span>
	    </div>

	    <div id="input_container">
		<input id="password" type="password" value="" name="Password" placeholder="<?php echo __('common.clients_password'); ?>" required autocomplete="off">
		<img id="input_img" src="/images/lock.png"/>	
		<span id="PasswordValidator" class="text-center validationMessage"><?php echo __('common.detailpage_fill_this_arae'); ?></span>
	    </div>

	    <div id="input_container">
		<input id="confirmPassword" type="password" value="" name="Password2" placeholder="<?php echo __('common.clients_password2'); ?>" onblur="sClient.validatePassword();" required>
		<img id="input_img" src="/images/key.png"/>	
		<span id="Password2Validator" class="text-center validationMessage"><?php echo __('common.detailpage_fill_this_arae'); ?></span>
		<p id="confirmMessage" class="text-center" style="color:#fff;font-size:1em;display:none;color:#00aeff"><?php echo __('clients.password_does_not_match'); ?></p>
	    </div>


	    <div class="btns">
		<input type="button" value="<?php echo __('common.detailpage_save'); ?>" onclick="sClient.save();">                                        
<!--		<div style="position:relative;height:56px;top:-5px;">
		    <input class="submit_facebook" id="submit_facebook" type="submit" value="" >                                                            
		    <div style="width:160px;margin-left:auto;margin-right:auto;position:relative;bottom:56px;pointer-events: none;">                           
			<span style="font-size:23px;color:#fff;border-right:1px solid #456fae;padding-right:8px;">f</span>
			<span style="color:#fff;display:inline;position:absolute;display:inline;left:25px;top:6px;width:150px;"> Login with <span style="font-weight:600;">Facebook</span></span>
		    </div>
		</div>-->
	    </div>

	</form>
    </div>
</div>
@endsection