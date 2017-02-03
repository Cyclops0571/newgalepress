<?php
namespace sts;
use sts as core;

if (!defined(__NAMESPACE__ . '\ROOT')) exit;

$site->set_title($language->get('New Ticket'));
$site->set_config('container-type', 'container');

if (!$auth->can('manage_tickets') && !$auth->can('tickets')) {
	header('Location: ' . $config->get('address') . '/');
	exit;
}

if (isset($_POST['add'])) {
	if (!empty($_POST['subject'])) {		
		
		$upload_file 	= false;
		$files_upload 	= array();
		
		if ($config->get('storage_enabled')) {
			if (isset($_FILES['file']) && is_array($_FILES['file'])) {
				$files_array = rearrange($_FILES['file']);	
				foreach($files_array as $file) {
					if ($file['size'] > 0) {
						$upload_file = true;
						$file_array['file']			= $file;
						$file_array['name']			= $file['name'];		
						$file_array['user_id']		= $auth->get('id');		
						$files_upload[] 			= $storage->upload($file_array);
					}
				}
			}
		}
				
		if ($upload_file && empty($files_upload)) {
			$message = $language->get('File Upload Failed. Ticket Not Submitted.');
		}
		else {
			$add_array = 
				array(
					'subject'			=> $_POST['subject'],
					'description'		=> $_POST['description'],
					'priority_id'		=> (int) $_POST['priority_id'],
					'html'				=> 0
				);
			if ($config->get('html_enabled')) {
				$add_array['html'] = 1;
			}
			$add_array['user_id'] 		= $auth->get('id');
			$add_array['company_id'] 	= $auth->get('company_id');
			
			$add_array['department_id'] = 1;
			if (isset($_POST['department_id']) && ($_POST['department_id'] != '')) {
				$add_array['department_id']	= (int) $_POST['department_id'];
			}

			if ($auth->can('manage_tickets') || $auth->can('tickets_view_assigned_department')) {
				if (isset($_POST['user_id']) && ($_POST['user_id'] != '')) {
					$add_array['user_id']	= (int) $_POST['user_id'];
				}
				if (isset($_POST['assigned_user_id']) && ($_POST['assigned_user_id'] != '')) {
					$add_array['assigned_user_id']	= (int) $_POST['assigned_user_id'];
				}
				if (isset($_POST['cc']) && (!empty($_POST['cc']))) {
					$add_array['cc']	= $_POST['cc'];
				}
				if (isset($_POST['company_id']) && ($_POST['company_id'] != '')) {
					$add_array['company_id']	= (int) $_POST['company_id'];
				}
				if (isset($_POST['project_id']) && ($_POST['project_id'] != '')) {
					$add_array['project_id']	= (int) $_POST['project_id'];
				}
			}
			
			if (!empty($files_upload)) {
				$add_array['attach_file_ids']	= $files_upload;
			}
			
			$id = $tickets->add($add_array);
					
			foreach($_POST as $index => $value){
				if(strncasecmp($index, 'field-', 6) === 0) {
					$group_index = explode('-', $index);
					$group_id = (int) $group_index[1];
					if ($group_id !== 0) {
					
						$edit_array['ticket_field_group_id']	= $group_id;
						$edit_array['ticket_id']				= $id;
						$edit_array['value']					= $value;
					
						$ticket_custom_fields->add_value($edit_array);
						unset($edit_array);
					}
				}			
			}
							
			header('Location: ' . $config->get('address') . '/tickets/view/' . $id . '/');
			exit;
		}
	}
	else {
		$message = $language->get('Subject Empty');
	}
}

$priorities 	= $ticket_priorities->get(array('enabled' => 1));

if ($auth->can('manage_tickets')) {
	$departments	= $ticket_departments->get(array('enabled' => 1));
} else {
	$departments 	= $ticket_departments->get(array('enabled' => 1, 'get_other_data' => true, 'user_id' => $auth->get('id')));
}


include(core\ROOT . '/user/themes/'. CURRENT_THEME .'/includes/html_header.php');
?>
<div class="row">
	<form method="post" enctype="multipart/form-data" action="<?php echo safe_output($_SERVER['REQUEST_URI']); ?>">
	
		<div class="col-md-3">
			<div class="well well-sm">
				<div class="pull-right">
					<p><button type="submit" name="add" class="btn btn-primary"><?php echo safe_output($language->get('Add Ticket')); ?></button></p>
				</div>
				<div class="pull-left">
					<h4><?php echo safe_output($language->get('New Ticket')); ?></h4>
				</div>

				<div class="clearfix"></div>
				<?php if ($auth->can('manage_tickets') || $auth->can('tickets_view_assigned_department') || $auth->can('tickets_view_assigned_department')) { ?>
					<br />
					<div class="pull-right">
						<p><a href="#" id="show_extra_settings" class="btn btn-info"><?php echo safe_output($language->get('Show Extra Options')); ?></a></p>
					</div>
					<div class="clearfix"></div>
				<?php } ?>
			</div>
		</div>

		<div class="col-md-9">
			<?php if (isset($message)) { ?>
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<?php echo html_output($message); ?>
				</div>
			<?php } ?>
			

			<div class="col-md-6">
			
				<div class="well well-sm">		
				
					<div class="form-group">		
						<div class="col-lg-12">	
				
							<p><?php echo safe_output($language->get('Subject')); ?><br /><input required type="text" name="subject" class="form-control" value="<?php if (isset($_POST['subject'])) echo safe_output($_POST['subject']); ?>" size="50" /></p>		
							
							<?php if (count($departments) > 1) { ?>
								<p><?php echo safe_output($language->get('Department')); ?><br />
								<?php if ($auth->can('manage_tickets') || $auth->can('tickets_view_assigned_department')) { ?>
									<select name="department_id" id="update_department_id">
										<?php foreach ($departments as $department) { ?>
										<option value="<?php echo (int) $department['id']; ?>"<?php if (isset($_POST['department_id']) && ($_POST['department_id'] == $department['id'])) { echo ' selected="selected"'; } ?>><?php echo safe_output($department['name']); ?></option>
										<?php } ?>
									</select>
								<?php } else { ?>
									<select name="department_id" id="update_department_id">
										<?php foreach ($departments as $department) { ?>
											<?php if ($department['is_user_member'] || $department['public_view']) { ?>
												<option value="<?php echo (int) $department['id']; ?>"<?php if (isset($_POST['department_id']) && ($_POST['department_id'] == $department['id'])) { echo ' selected="selected"'; } ?>><?php echo safe_output($department['name']); ?></option>
											<?php } ?>
										<?php } ?>
									</select>						
								<?php } ?>
								</p>
							<?php } ?>
							
							<?php $plugins->run('add_ticket_form_after_department'); ?>

							<p><?php echo safe_output($language->get('Priority')); ?><br />
							<select name="priority_id">
								<?php foreach ($priorities as $priority) { ?>
								<option value="<?php echo (int) $priority['id']; ?>"<?php if (isset($_POST['priority_id']) && ($_POST['priority_id'] == $priority['id'])) { echo ' selected="selected"'; } ?>><?php echo safe_output($priority['name']); ?></option>
								<?php } ?>
							</select></p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			
			<div class="extra_settings">

				<div class="col-md-5">
				
					<div class="well well-sm">	
					
						<div class="form-group">		
							<div class="col-lg-12">	
							
								<?php if ($auth->can('manage_tickets') || $auth->can('tickets_view_assigned_department')) { ?>
																			
										<p><?php echo safe_output($language->get('On Behalf Of')); ?><br />
										<select name="user_id" id="user_id">
											<option value=""></option>
											<?php if (isset($_POST['user_id'])) { ?>
												<option value="<?php echo (int) $_POST['user_id']; ?>" selected="selected"></option>
											<?php } ?>
										</select></p>
										
										<p><?php echo safe_output($language->get('Assigned To')); ?><br />
										<select name="assigned_user_id" id="assigned_user_id">
											<option value=""></option>
											<?php if (isset($_POST['assigned_user_id'])) { ?>
												<option value="<?php echo (int) $_POST['assigned_user_id']; ?>" selected="selected"></option>
											<?php } ?>
										</select></p>
										
										<p><?php echo safe_output($language->get('Carbon Copy')); ?>
											<i data-toggle="tooltip" data-placement="right" data-original-title="<?php echo safe_output($language->get('Allows you to Carbon Copy this ticket to other users e.g. user@example.com,user2@example.net. Note: CCed users will be able to view the entire ticket thread via the guest portal.')); ?>" class="glyphicon glyphicon-question-sign"></i>
											<br />
											<input type="text" name="cc" class="form-control" placeholder="user@example.com" value="<?php if (isset($_POST['cc'])) echo safe_output($_POST['cc']); ?>" size="50" />
										</p>
									
								<?php } ?>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

				
			<div class="clearfix"></div>

			<div class="col-md-12">
			
				<div class="well well-sm">	
					<div class="form-group">		
						<div class="col-lg-12">	
				
							<p><?php echo safe_output($language->get('Description')); ?><br />
								<textarea class="wysiwyg_enabled" name="description" cols="80" rows="12"><?php if (isset($_POST['description'])) echo safe_output($_POST['description']); ?></textarea>
							</p>
							
							<?php $site->display_custom_field_forms(); ?>
							
							<?php if ($config->get('storage_enabled')) { ?>
								<p><?php echo safe_output($language->get('Attach File')); ?></p>
								
								<div class="form-group">		
									<div class="col-lg-4">								
										<div class="pull-left"><input name="file[]" type="file" /></div>
										<div class="pull-right"><a href="#" id="add_extra_file"><span class="glyphicon glyphicon-plus"></span></a></div>
										<div id="attach_file_area"></div>					
									</div>
								</div>
								
								<div class="clearfix"></div>
							<?php } ?>
							
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="clearfix"></div>

			<div class="col-md-12">

				<div class="pull-right">
					<p><button type="submit" name="add" class="btn btn-primary"><?php echo safe_output($language->get('Add Ticket')); ?></button></p>
				</div>
			</div>
				
		</div>
	</form>
</div>
<?php include(core\ROOT . '/user/themes/'. CURRENT_THEME .'/includes/html_footer.php'); ?>