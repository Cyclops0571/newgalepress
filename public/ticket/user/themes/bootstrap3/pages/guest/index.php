<?php
namespace sts;
use sts as core;

if (!defined(__NAMESPACE__ . '\ROOT')) exit;

$site->set_title($language->get('Guest Portal'));
$site->set_config('container-type', 'container');

$guest_portal_index_html	= $config->get('guest_portal_index_html');
if (empty($guest_portal_index_html)) {
	header('Location: ' . $config->get('address') . '/guest/ticket_add/');
	exit;
}

include(core\ROOT . '/user/themes/'. CURRENT_THEME .'/includes/html_header.php');
?>
<div class="row-fluid">
	
	<div class="col-md-3">
		<div class="well well-sm">
			<div class="pull-left">
				<h4><?php echo safe_output($language->get('Guest Portal')); ?></h4>
			</div>
			
			<div class="pull-right">
				<a href="<?php echo safe_output($config->get('address')); ?>/guest/ticket_add/" class="btn btn-default"><?php echo safe_output($language->get('Create a Support Ticket')); ?></a>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

	<div class="col-md-9">
		<div class="well well-sm">
			
			<?php if ($config->get('html_enabled') == 1) { ?>
				<?php echo html_output($config->get('guest_portal_index_html')); ?>
			<?php } else { ?>
				<p><?php echo nl2br(safe_output($config->get('guest_portal_index_html'))); ?></p>
			<?php } ?>
			
			<div class="clearfix"></div>

		</div>
	</div>
</div>		
<?php include(core\ROOT . '/user/themes/'. CURRENT_THEME .'/includes/html_footer.php'); ?>