<script type="text/javascript">
	<!--
	<?php
	// For language cache
	$unusedLangRoute = __('route.login')->get();
	$unusedInteractivity = __('interactivity.ok')->get();
	$unusedValidation = __('notification.validation')->get();
	$unusedJavascriptLang = __('javascriptlang.select')->get();
    echo app()->getLocale();
    exit;

    ?>
	var currentLanguage = <?php echo json_encode(app()->getLocale(); ?>;
	var route = <?php echo json_encode(Lang::$lines["application"][app()->getLocale()]["route"]); ?>;
	var notification = <?php echo json_encode(Lang::$lines["application"][app()->getLocale()]["notification"]); ?>;
	var javascriptLang = <?php echo json_encode(Lang::$lines["application"][app()->getLocale()]["javascriptlang"]); ?>;
	var interactivity = <?php echo json_encode(Lang::$lines["application"][app()->getLocale()]["interactivity"]); ?>;
	// -->
</script>
