<?php
namespace sts;
use sts as core;

if (!defined(__NAMESPACE__ . '\ROOT')) exit;

$site->set_title($language->get('Edit Canned Response'));
$site->set_config('container-type', 'container');

if (!$auth->can('manage_system_settings')) {
	header('Location: ' . $config->get('address') . '/');
	exit;
}

$id = (int) $url->get_item();

$response		= $canned_responses->get(array('id' => $id));
	
if (empty($response)) {
	header('Location: ' . $config->get('address') . '/settings/tickets/#canned_responses');
	exit;
}

$item = $response[0];

if (isset($_POST['delete'])) {
	$canned_responses->delete(array('id' => $item['id']));
	header('Location: ' . $config->get('address') . '/settings/tickets/#canned_responses');
	exit;
}

if (isset($_POST['save'])) {
	if (!empty($_POST['name'])) {
		$add_array['name']				= $_POST['name'];
		$add_array['description']		= $_POST['description'];

		$canned_responses->edit(array('columns' => $add_array, 'id' => $id));
		
		header('Location: ' . $config->get('address') . '/settings/tickets/#canned_responses');
		exit;
		//$message = $language->get('Saved');
		
	}
	else {
		$message = $language->get('Name empty');
	}
	$response		= $canned_responses->get(array('id' => $id));
	$item = $response[0];
}



include(core\ROOT . '/user/themes/'. CURRENT_THEME .'/includes/html_header.php');
?>
<script type="text/javascript">
	$(document).ready(function () {
		$('#delete').click(function () {
			if (confirm("<?php echo safe_output($language->get('Are you sure you wish to delete this response?')); ?>")){
				return true;
			}
			else{
				return false;
			}
		});
	});
</script>

<div class="row">
	<form method="post" action="<?php echo safe_output($_SERVER['REQUEST_URI']); ?>">

		<div class="col-md-3">
			<div class="well well-sm">
				<div class="pull-left">
					<h4><?php echo safe_output($language->get('Canned Response')); ?></h4>
				</div>
			
				
				<div class="pull-right">
					<p>
						<button type="submit" name="save" class="btn btn-primary"><?php echo safe_output($language->get('Save')); ?></button>
						<a href="<?php echo $config->get('address'); ?>/settings/tickets/#canned_responses" class="btn btn-default"><?php echo safe_output($language->get('Cancel')); ?></a>
					</p>
				</div>
					
				<div class="clearfix"></div>	
				
					<br />
					<div class="pull-right"><button type="submit" id="delete" name="delete" class="btn btn-danger"><?php echo safe_output($language->get('Delete')); ?></button></div>
					<div class="clearfix"></div>

			</div>
		</div>

		<div class="col-md-9">

			<?php if (isset($message)) { ?>
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<?php echo html_output($message); ?>
				</div>
			<?php } ?>

			<div class="well well-sm">
				
				<p><?php echo $language->get('Name'); ?><br /><input type="text" name="name" value="<?php echo safe_output($item['name']); ?>" size="30" /></p>

				<p><?php echo $language->get('Response'); ?><br /><textarea class="wysiwyg_enabled" name="description" cols="70" rows="12"><?php echo safe_output($item['description']); ?></textarea></p>



			</div>
				
			<div class="clearfix"></div>

		</div>

	</form>
</div>
<?php include(core\ROOT . '/user/themes/'. CURRENT_THEME .'/includes/html_footer.php'); ?>