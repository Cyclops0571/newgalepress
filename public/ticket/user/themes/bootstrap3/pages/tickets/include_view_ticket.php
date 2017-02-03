<?php
namespace sts;
use sts as core;

if (!defined(__NAMESPACE__ . '\ROOT')) exit;

?>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="pull-left">
			<h1 class="panel-title"><?php echo safe_output($ticket['subject']); ?></h1>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">
		<?php if ($config->get('gravatar_enabled')) { ?>
			<div class="pull-right">
				<?php $gravatar->setEmail($ticket['owner_email']); ?>
				<img src="<?php echo $gravatar->getUrl(); ?>" alt="Gravatar" />
			</div>
		<?php } ?>
		<?php if ($ticket['html'] == 1) { ?>
			<?php echo html_output($ticket['description']); ?>
		<?php } else { ?>
			<p><?php echo nl2br(safe_output($ticket['description'])); ?></p>
		<?php } ?>
	
		<div class="clearfix"></div>
		<br />
		<?php $site->view_custom_field_values(array('ticket' => $ticket)); ?>
	</div>
	<div class="panel-footer">
		<div class="pull-left">
			<?php if ($auth->can('manage_tickets') == 2 && !empty($ticket['email_data'])) { ?>						
				<a class="btn btn-default btn-xs" href="<?php echo $config->get('address'); ?>/tickets/view_email/<?php echo (int) $ticket['id']; ?>/"><span class="glyphicon glyphicon-inbox"></span></a>
			<?php } ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>