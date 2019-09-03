<?php
	require_once PRESENTATION_DIR . 'admin_developer_message_details.php';
	$admin_developer_message_details = new AdminDeveloperMessageDetails();
	$admin_developer_message_details->init();
	echo '
	<div class="container">
		<div class="row">
			<div class="col s12 grey-text text-darken-2">
				<br>
				<div class="divider"></div>
				<br>
				<h5 class="center"><i class="fas fa-user"></i> '.$admin_developer_message_details->mMessage['first_name'].' '.$admin_developer_message_details->mMessage['last_name'].'</h5>
				<p class="center"><small>'.$admin_developer_message_details->mMessage['date_posted'].'</small></p>
				<br>
				<div class="divider"></div>
				<br>
				<p class="flow-text">'.$admin_developer_message_details->mMessage['message'].'</p>
				<p><a href="#!" class="btn red lighten-2 white-text delete_message">Delete</a></p>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$(".delete_message").click(function(event) {
				event.preventDefault();
				$.post(
					"'.$admin_developer_message_details->mLinkToDeveloperMessageDetails.'",
					{Delete_Message: "", MessageId: '.$admin_developer_message_details->mMessage['id'].'},
					function(data) {
						$(".row").remove();
						M.toast({html: "Deleted successfully"});
						window.location = "'.$admin_developer_message_details->mLinkToDeveloperMessages.'";
					}
				);
			});
		});
	</script>
	';
?>