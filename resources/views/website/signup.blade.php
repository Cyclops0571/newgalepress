<html>
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" type="text/css" href="/css/signUpBootstrap.css">
    <link rel="stylesheet" type="text/css" href="/css/signUpStyle.css">

    <title><?php echo __('website.signup_title') ?></title>
</head>
<body style="background-image: url(/img/signupimg/bGround.png);background-size: cover;">
<!-- denemeeee -->
<div class="container">
    <div class="row" style="text-align: right; margin-top: 25px">
        <img class="close" src="/img/signupimg/close.png"/>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <input class="textbox inputText userIcon" type="text" placeholder="<?php echo __('website.signup_name') ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <input class="textbox inputText userIcon" type="text" placeholder="<?php echo __('website.signup_surname') ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <input class="textbox inputText userIcon kulAd" type="text" placeholder="<?php echo __('website.signup_id') ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <input class="textbox inputText mailIcon" type="text" placeholder="<?php echo __('website.signup_mail') ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <input class="textbox inputText keyIcon" type="password" placeholder="<?php echo __('website.signup_password') ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <input class="textbox inputText keyIcon" type="password" placeholder="<?php echo __('website.signup_passwordagain') ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="kayitOl"><?php echo __('website.signup_registry') ?></button>
        </div>
    </div>
    <p class="subtitle fancy"><span><?php echo __('website.signup_connect') ?></span></p>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="face">Facebook</button>
        </div>
    </div>
    <div>
        <p style="margin: 3em 0 3em 0;"><?php echo __('website.signup_withoutacc') ?></p>
    </div>
</div>

</body>

</html>
