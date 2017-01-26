<script type="text/javascript">
	<!--
	<?php
	// For language cache
	$unusedLangRoute = __('route.login')->get();
	$unusedInteractivity = __('interactivity.ok')->get();
	$unusedValidation = __('notification.validation')->get();
	$unusedJavascriptLang = __('javascriptlang.select')->get();
	?>
	var currentLanguage = <?php echo json_encode(Config::get('application.language')); ?>;
	var route = <?php echo json_encode(Lang::$lines["application"][Config::get('application.language')]["route"]); ?>;
	var notification = <?php echo json_encode(Lang::$lines["application"][Config::get('application.language')]["notification"]); ?>;
	var javascriptLang = <?php echo json_encode(Lang::$lines["application"][Config::get('application.language')]["javascriptlang"]); ?>;
	var interactivity = <?php echo json_encode(Lang::$lines["application"][Config::get('application.language')]["interactivity"]); ?>;
	// -->
</script>
