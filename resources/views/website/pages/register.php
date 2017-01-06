<?php

echo Form::open('register', 'POST', array('class' => 'register_form'));

echo Form::text('captcha', '', array('class' => 'captchainput', 'placeholder' => 'Insert captcha...'));
echo Form::image(MeCaptcha\Captcha::img(), 'captcha', array('class' => 'captchaimg'));

echo Form::close();


?>