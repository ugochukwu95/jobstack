<?php
	require_once PRESENTATION_DIR . 'admin_user_job_details.php';
	$admin_developer_message_details = new AdminUserJobDetails();
	$admin_developer_message_details->init();
	echo '
	<div class="container">
		<div class="row">
			<div class="col s12 grey-text text-darken-2">
				<div class="card white">
				    <div class="card-content grey-text text-darken-2">
				    <p>Date posted: '.$admin_developer_message_details->mMessage['date_posted'].'</p><br>
				    <ul class="collection flow-text">
                      <li class="collection-item">Company Name: '.$admin_developer_message_details->mMessage['company_name'].'</li>
                      <li class="collection-item">Company Website: '.$admin_developer_message_details->mMessage['company_website'].'</li>
                      <li class="collection-item">CAC Reg. No.: '.$admin_developer_message_details->mMessage['cac_reg_no'].'</li>
                      <li class="collection-item">Email: '.$admin_developer_message_details->mMessage['email'].'</li>
                      <li class="collection-item">Phone Number: '.$admin_developer_message_details->mMessage['phone_number'].'</li>
                      <li class="collection-item">Position Name: '.$admin_developer_message_details->mMessage['position_name'].'</li>
                      <li class="collection-item">Job Category: '.$admin_developer_message_details->mMessage['job_category'].'</li>
                      <li class="collection-item">Job Location: '.$admin_developer_message_details->mMessage['job_location'].'</li>
                      <li class="collection-item">Application Deadline: '.$admin_developer_message_details->mMessage['application_deadline'].'</li>
                      <li class="collection-item">Job Description: '.$admin_developer_message_details->mMessage['job_description'].'</li>
                    </ul>
    				<p><a href="#!" class="btn red lighten-2 white-text delete_message">Delete</a></p>
    				</div>
    			</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$(".delete_message").click(function(event) {
				event.preventDefault();
				$.post(
					"'.$admin_developer_message_details->mLinkToAdminUserJobDetails.'",
					{Delete_Job: "", ID: '.$admin_developer_message_details->mMessage['id'].'},
					function(data) {
						$(".row").remove();
						M.toast({html: "Deleted successfully"});
						window.location = "'.$admin_developer_message_details->mLinkToAdminUsersJobs.'";
					}
				);
			});
		});
	</script>
	';
?>