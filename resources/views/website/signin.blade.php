<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/css/signUpBootstrap.css">
    <link rel="stylesheet" type="text/css" href="/css/signUpStyle.css">
    <title><?php echo __('website.signin_title') ?></title>
</head>
<body style="background-image: url(/img/signupimg/bGround.png);background-size: cover;">

<div class="container">
    <div class="row" style="text-align: right; margin-top: 25px">
        <img class="close" src="/img/signupimg/close.png"/>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <input class="textbox inputText userIcon kulAd" type="text" placeholder="<?php echo __('website.signin_name') ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <input class="textbox inputText keyIcon" type="password" placeholder="<?php echo __('website.signin_password') ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="kayitOl"><?php echo __('website.signin_button') ?></button>
        </div>
    </div>
    <div>
        <p style="margin: 3em 0 3em 0;"><?php echo __('website.forgot_password_title') ?></p>
    </div>
</div>
</body>
</html>