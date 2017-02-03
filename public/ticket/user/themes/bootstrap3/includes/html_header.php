<?php 
namespace sts;
use sts as core;

if (!defined(__NAMESPACE__ . '\ROOT')) exit;

$pm_unread_count = 0;
if ($auth->logged_in() && $config->get('database_version') > 9) {
	$pm_unread_count = $messages->unread_count(array('user_id' => $auth->get('id')));
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo safe_output($site->get_title()); ?></title>

	<meta name="viewport" content="width=device-width, maximum-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	
	<link href="<?php echo $config->get('address'); ?>/user/themes/<?php echo safe_output(CURRENT_THEME); ?>/sub/<?php echo safe_output(CURRENT_THEME_SUB); ?>/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo $config->get('address'); ?>/user/themes/<?php echo safe_output(CURRENT_THEME); ?>/sub/<?php echo safe_output(CURRENT_THEME_SUB); ?>/css/responsive-tables.css" rel="stylesheet">    
	<link href="<?php echo $config->get('address'); ?>/user/themes/<?php echo safe_output(CURRENT_THEME); ?>/sub/<?php echo safe_output(CURRENT_THEME_SUB); ?>/css/bootstrap-custom.css" rel="stylesheet">  

	<link rel="shortcut icon" href="<?php echo $config->get('address'); ?>/favicon.ico" />
	
	<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/libraries/js/jquery.js"></script>

	<script type="text/javascript" src="<?php echo $config->get('address'); ?>/user/themes/<?php echo safe_output(CURRENT_THEME); ?>/sub/<?php echo safe_output(CURRENT_THEME_SUB); ?>/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/libraries/js/respond.min.js"></script>
	
	<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/libraries/js/moment.min.js"></script>	
	<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/libraries/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	<link href="<?php echo $config->get('address'); ?>/system/libraries/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">    
	
	<script type="text/javascript">
		var sts_base_url 			= "<?php echo safe_output($config->get('address')); ?>";
		var sts_current_theme		= "<?php echo safe_output(CURRENT_THEME); ?>";
		var sts_current_theme_sub	= "<?php echo safe_output(CURRENT_THEME_SUB); ?>";
	</script>
	
	<?php if ($auth->logged_in()) { ?>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/js/priorities.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/js/departments.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/js/tickets.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/js/add_ticket.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/js/custom_fields.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/js/user_selector.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/js/users.js"></script>
	<?php } ?>
	
	<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/js/modal.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/js/view_ticket.js"></script>
	
	<?php if ($config->get('html_enabled')) { ?>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/libraries/redactor/fontsize.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/libraries/redactor/fontfamily.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/libraries/redactor/fullscreen.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/libraries/redactor/fontcolor.js"></script>

		<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/libraries/redactor/redactor.js"></script>
		<link rel="stylesheet" href="<?php echo $config->get('address'); ?>/system/libraries/redactor/css/redactor.css" />

        <script type="text/javascript">
		$(document).ready(
			function()
			{
				$('.wysiwyg_enabled').redactor({
					focus: false, 
					buttonSource: true,
					buttons: [
						'html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
						'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
						'image', 'table', 'link', '|',
						'alignleft', 'aligncenter', 'alignright', 'justify', '|',
						'horizontalrule'
					],
					plugins: ['fontsize', 'fontfamily', 'fontcolor'],
					minHeight: 100,
					toolbarFixed: false,
                    lang: <?php echo json_encode(__CURRENT_LANGUAGE__); ?>
				});
			}
		);
		</script>
	<?php } ?>
	
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo $config->get('address'); ?>/system/libraries/select2/select2.css" />	
	<script type="text/javascript" src="<?php echo $config->get('address'); ?>/system/libraries/select2/select2.min.js"></script>
	
	<!-- Colorbox -->

	<link rel="stylesheet" href="<?php echo $config->get('address'); ?>/system/libraries/colorbox/colorbox.css" />
	<script src="<?php echo $config->get('address'); ?>/system/libraries/colorbox/jquery.colorbox-min.js"></script>
	
	<script type="text/javascript"> 
	$(document).ready(function () {
		<?php if (!$site->get_config('disable_custom_select')) { ?>
			//Custom Selectmenu
			$('select').select2({
				width: 'resolve',
				allowClear: true
			});
		<?php } ?>
		
		//tooltip
		$(".glyphicon-question-sign").tooltip({html: true});
		//popover
		$('.popover-item').popover().click(function(e){e.preventDefault();});
		
	});
	</script>
		
	<!-- 57x57 (precomposed) for iPhone 3GS, 2011 iPod Touch and older Android devices -->
	<link rel="apple-touch-icon-precomposed" href="<?php echo $config->get('address'); ?>/user/themes/<?php echo safe_output(CURRENT_THEME); ?>/sub/<?php echo safe_output(CURRENT_THEME_SUB); ?>/img/apple-touch-icon-precomposed.png">

	<!-- 72x72 (precomposed) for 1st generation iPad, iPad 2 and iPad mini -->
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $config->get('address'); ?>/user/themes/<?php echo safe_output(CURRENT_THEME); ?>/sub/<?php echo safe_output(CURRENT_THEME_SUB); ?>/img/apple-touch-icon-72x72-precomposed.png">

	<!-- 114x114 (precomposed) for iPhone 4, 4S, 5 and 2012 iPod Touch -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $config->get('address'); ?>/user/themes/<?php echo safe_output(CURRENT_THEME); ?>/sub/<?php echo safe_output(CURRENT_THEME_SUB); ?>/img/apple-touch-icon-114x114-precomposed.png">

	<!-- 144x144 (precomposed) for iPad 3rd and 4th generation -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $config->get('address'); ?>/user/themes/<?php echo safe_output(CURRENT_THEME); ?>/sub/<?php echo safe_output(CURRENT_THEME_SUB); ?>/img/apple-touch-icon-144x144-precomposed.png">
	
	<?php $plugins->run('html_header'); ?>
</head>

<body>
	<?php $plugins->run('body_header'); ?>
	<?php if (CURRENT_THEME_SUB == 'chrome' || CURRENT_THEME_SUB == 'sesamo') { ?>
		<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
	<?php } else { ?>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<?php } ?>
	
		<div class="navbar-header">
            <a style="padding: 0 0 0 0" class="navbar-brand"
               href="http://<?php echo $config->get('domain') . $language->get('route_home'); ?>">
			<img style="height: 50px"
			alt="<?php echo safe_output($config->get('name')); ?>"
			src='<?php echo $config->get('address'); ?>/user/themes/<?php echo safe_output(CURRENT_THEME); ?>/images/ticketIcon.png' >
		    </a>			
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		
		<div class="collapse navbar-collapse">			  		
			<ul class="nav navbar-nav">
			
				<?php if ($auth->logged_in() && $config->get('display_dashboard')) { ?>
					<li<?php if ($url->get_action() == 'dashboard') echo ' class="active"'; ?>><a href="<?php echo $config->get('address'); ?>/dashboard/"><span class="glyphicon glyphicon-th-large"></span> <?php echo safe_output($language->get('Dashboard')); ?></a></li>
				<?php } ?>
				
				<?php $plugins->run('html_header_nav_start'); ?>

				<?php if ($auth->logged_in()) { ?>
					<?php if ($auth->can('tickets')) { ?>
						<li<?php if ($url->get_action() == 'tickets') echo ' class="active"'; ?>><a href="<?php echo $config->get('address'); ?>/tickets/"><span class="glyphicon glyphicon-list"></span> <?php echo safe_output($language->get('Tickets')); ?></a></li>
					<?php } ?>
					<?php if ($auth->can('manage_users')) { ?>
						<li<?php if ($url->get_action() == 'users') echo ' class="active"'; ?>><a href="<?php echo $config->get('address'); ?>/users/"><span class="glyphicon glyphicon-user"></span> <?php echo safe_output($language->get('Users')); ?></a></li>
					<?php } ?>
					<?php if ($auth->can('manage_system_settings')) { ?>
						<li class="dropdown<?php if ($url->get_action() == 'settings' || $url->get_action() == 'logs') echo ' active'; ?>">
							<a class="dropdown-toggle" data-toggle="dropdown" data-target="#settings" href="<?php echo $config->get('address'); ?>/settings/"><span class="glyphicon glyphicon-cog"></span> <?php echo safe_output($language->get('Settings')); ?> <strong class="caret"></strong></a>							
							<ul class="dropdown-menu">
								<li><a href="<?php echo $config->get('address'); ?>/settings/"><?php echo safe_output($language->get('General')); ?></a></li>
								<li><a href="<?php echo $config->get('address'); ?>/settings/api/"><?php echo safe_output($language->get('API')); ?></a></li>
								<li><a href="<?php echo $config->get('address'); ?>/settings/authentication/"><?php echo safe_output($language->get('Authentication')); ?></a></li>
								<li><a href="<?php echo $config->get('address'); ?>/settings/permissions/"><?php echo safe_output($language->get('Permissions')); ?></a></li>
								<li><a href="<?php echo $config->get('address'); ?>/settings/email/"><?php echo safe_output($language->get('Email')); ?></a></li>
								<li><a href="<?php echo $config->get('address'); ?>/settings/tickets/"><?php echo safe_output($language->get('Tickets')); ?></a></li>
								<li><a href="<?php echo $config->get('address'); ?>/settings/plugins/"><?php echo safe_output($language->get('Plugins')); ?></a></li>
								<li><a href="<?php echo $config->get('address'); ?>/logs/"><?php echo safe_output($language->get('Logs')); ?></a></li>
								<?php $plugins->run('html_header_nav_settings'); ?>
							</ul>
						</li>
					<?php } ?>
				<?php } else { ?>
					<li<?php if ($url->get_action() == 'login') echo ' class="active"'; ?>><a href="<?php echo $config->get('address'); ?>/"><span class="glyphicon glyphicon-home"></span> <?php echo safe_output($language->get('Home')); ?></a></li>
					<?php if ($config->get('guest_portal')) { ?>
						<li<?php if ($url->get_action() == 'guest') echo ' class="active"'; ?>><a href="<?php echo $config->get('address'); ?>/guest/"><span class="glyphicon glyphicon-plane"></span> <?php echo safe_output($language->get('Guest Portal')); ?></a></li>
					<?php } ?>	
				<?php } ?>
				
				<?php $plugins->run('html_header_nav_finish'); ?>				
			</ul>
			<?php if ($auth->logged_in()) { ?>
<!--				<ul class="nav navbar-nav navbar-right">						
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-star"></span> <?php echo safe_output(ucwords($auth->get('name'))); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $config->get('address'); ?>/profile/"><span class="glyphicon glyphicon-user"></span> <?php echo safe_output($language->get('Profile')); ?></a></li>
							<?php $plugins->run('html_header_nav_profile'); ?>				
							<li class="divider"></li>
							<li><a href="<?php echo $config->get('address'); ?>/logout/"><span class="glyphicon glyphicon-eject"></span> <?php echo safe_output($language->get('Logout')); ?></a></li>

						</ul>
					</li>
				</ul>-->
			<?php } ?>
		</div><!--/.nav-collapse -->	

	</nav>
	
    <div class="<?php echo safe_output($site->get_config('container-type')); ?>">
	