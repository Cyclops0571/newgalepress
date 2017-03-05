<form method="post" action="register" class="register_form">
<?php
echo Form::text('captcha', '', array('class' => 'captchainput', 'placeholder' => 'Insert captcha...'));
echo Form::image(MeCaptcha\Captcha::img(), 'captcha', array('class' => 'captchaimg'));
echo '<input type="submit" name="deneme"/>';
?>
</form>

