<?php
namespace sts;
use sts as core;

$site->set_title($language->get('View Message'));
$site->set_config('container-type', 'container');

$id = (int) $url->get_item();

$items = $messages->get(array('id' => $id, 'to_from_user_id' => $auth->get('id')));

if (count($items) == 1) { 
	$item = $items[0];
}
else {
	header('Location: ' . $config->get('address') . '/profile/');
	exit;
}

$notes_array = $message_notes->get(array('message_id' => (int)$item['id'], 'get_other_data' => true));

include(core\ROOT . '/user/themes/'. CURRENT_THEME .'/includes/html_header.php');
?>

<script type="text/javascript">
	$(document).ready(function () {
		$('#delete').click(function () {
			if (confirm("<?php echo safe_output($language->get('Are you sure you wish to delete this message?')); ?>")){
				return true;
			}
			else{
				return false;
			}
		});
	});
</script>
	
<div class="row">
	<div class="col-md-3">
		<div class="well well-sm">
			<div class="pull-left">
				<h4><?php echo safe_output($language->get('Private Message')); ?></h4>
			</div>
			
			<div class="pull-right">
				<p><a href="<?php echo $config->get('address'); ?>/profile/" class="btn btn-default"><?php echo safe_output($language->get('Cancel')); ?></a></p>
			</div>

			<div class="clearfix"></div>
			
			<label class="left-result"><?php echo safe_output($language->get('From')); ?></label>
			<p class="right-result">
				<?php echo core\safe_output(ucfirst($item['from_name'])); ?>
			</p>
			<div class="clearfix"></div>

			<label class="left-result"><?php echo safe_output($language->get('To')); ?></label>
			<p class="right-result">
				<?php echo core\safe_output(ucfirst($item['to_name'])); ?>
			</p>
			
			<div class="clearfix"></div>
			
			<label class="left-result"><?php echo safe_output($language->get('Sent')); ?></label>
			<p class="right-result">
				<?php echo safe_output(date('D, d M Y g:i A', strtotime($item['date_added']))); ?>
			</p>
			<div class="clearfix"></div>
			
			<?php if ($item['user_id'] == $auth->get('id')) { ?>
				<br />
				<div class="pull-right">
					<form method="post" action="<?php echo core\safe_output($config->get('address')); ?>/messages/delete/<?php echo (int) $item['id']; ?>/">
						<p><button type="submit" name="delete" id="delete" class="btn btn-danger"><?php echo safe_output($language->get('Delete')); ?></button></p>
					</form>
				</div>
					
				<div class="clearfix"></div>
			<?php } ?>

			
		</div>
	</div>

	<div class="col-md-9">
		<div class="well well-sm">
			<h3><?php echo safe_output($item['subject']); ?></h3>

			<?php echo nl2br(safe_output($item['message'])); ?>
			<div class="clearfix"></div>

		</div>
		
		<?php if (!empty($notes_array)) { ?>
			<div class="well well-sm">
				<h3><?php echo safe_output($language->get('Notes')); ?></h3>
				<?php $i = 0; foreach($notes_array as $note) { ?>
					<div class="well well-sm<?php if ($i % 2 == 0 ) { echo ' ticket-note-1'; } else { echo ' ticket-note-2'; } ?>">	
						<?php if ($config->get('gravatar_enabled')) { ?>
							<?php $gravatar->setEmail($note['email']); ?>
							<div class="pull-right">
								<p><img src="<?php echo $gravatar->getUrl(); ?>" alt="Gravatar" /></p>
							</div>
						<?php } ?>
						

						<p><?php echo nl2br(safe_output($note['message'])); ?></p>
						
						<div class="clearfix"></div>
						<p class="pull-right"><?php echo safe_output(ucwords($note['name'])); ?> - <?php echo safe_output(time_ago_in_words($note['date_added'])); ?> <?php echo safe_output($language->get('ago')); ?></p>
						<div class="clearfix"></div>
					</div>
				<?php $i++; } ?>
				
				<div class="clearfix"></div>

			</div>
		<?php } ?>
		
		<?php $messages->read(array('message_id' => $item['id'], 'user_id' => $auth->get('id'))); ?>

		<div class="well well-sm">
			<h3><a name="addnote"></a><?php echo safe_output($language->get('Add Note')); ?></h3>
			
			<form method="post" action="<?php echo $config->get('address'); ?>/messages/addnote/<?php echo (int) $item['id']; ?>/">
											
				<div id="no_underline">
					<p><textarea name="message" cols="70" rows="12"></textarea></p>
				</div>

				<br />
				<p><input type="hidden" name="id" value="<?php echo (int) $item['id']; ?>" /><button name="add" type="submit" class="btn btn-primary"><?php echo safe_output($language->get('Add')); ?></button></p>
			</form>
			
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<?php include(core\ROOT . '/user/themes/'. CURRENT_THEME .'/includes/html_footer.php'); ?>