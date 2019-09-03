<?php
	require_once PRESENTATION_DIR . 'admin_developer_messages.php';
	$admin_developer_messages = new AdminDeveloperMessages();
	$admin_developer_messages->init();
	echo '
	<div class="row">
	  	<div class="col s12">
	  		<h5 class="center bebasFont teal-text">Developer Messages</h5>
	  	</div>
	 </div>	
	';

	if (count($admin_developer_messages->mMessages) == 0) {
		echo '<p class="center">There are no messages</p>';
	}
	else {
		echo '
		<div class="row">
			<div class="col s12 l8 offset-l2">
			<form class="center">
				<table class="grey-text text-darken-2">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Phone Number</th>
							<th>Date Posted</th>
							<th></th>
						</tr>
					</thead>
					<tbody>';
					for ($i=0; $i<count($admin_developer_messages->mMessages); $i++) {
						echo'
							<tr id="message_row_'.$i.'">
								<td>'.$admin_developer_messages->mMessages[$i]['first_name'].'</td>
								<td>'.$admin_developer_messages->mMessages[$i]['last_name'].'</td>
								<td>'.$admin_developer_messages->mMessages[$i]['email'].'</td>
								<td>'.$admin_developer_messages->mMessages[$i]['phone_number'].'</td>
								<td>'.$admin_developer_messages->mMessages[$i]['date_posted'].'</td>
								<td>
									<a href="'.$admin_developer_messages->mMessages[$i]['link_to_message'].'" class="btn red lighten-2 white-text">Read</a>
									<a class="waves-effect waves-light red lighten-2 btn modal-trigger white-text" href="#modal'.$i.'"><i class="fas fa-trash"></i> Delete</a>
									<div id="modal'.$i.'" class="modal">
										<div class="modal-content">
											<br><br>
											<h4 class="center">DELETE!</h4>
											<p class="center">Are you sure you want to delete this message?</p>
										</div>
										<div class="modal-footer">
											<a class="btn red lighten-2 white-text" id="delete_message_'.$i.'" href="#!">Delete</a>
										</div>
										<script>
											$(document).ready(function() {
												$("form").on("click", "#delete_message_'.$i.'", function(event) {
													event.preventDefault();
													$.post(
														"'.$admin_developer_messages->mLinkToAdminDeveloperMessages.'",
														{Delete_Message: "", MessageId: '.$admin_developer_messages->mMessages[$i]['id'].'},
														function(data) {
															$("#modal'.$i.'").fadeOut(500);
															$("#message_row_'.$i.'").fadeOut(500);
															M.toast({html: "Deleted successfully"});
														}
													);
												});
											});
										</script>
									</div>
								</td>
							</tr>
						';
					}

					echo '
					</tbody>
				</table>
			</form>
			</div>
		</div>';

		if (count($admin_developer_messages->mMessagesListPages) > 1) {
			echo '
			<div class="row">
				<div class="col s12 m12 l6 offset-l3">
					<p class="center">Page '.$admin_developer_messages->mPagination.' of '.$admin_developer_messages->mrTotalPages.'</p>
					<ul class="pagination center">';
						if (isset($admin_developer_messages->mLinkToPreviousPage)) {
							echo '<li class="waves-effect"><a href="'.$admin_developer_messages->mLinkToPreviousPage.'"><i class="fas fa-arrow-left"></i></a></li>';
						}
						else {
							echo '<li class="disabled"><a href="#!"><i class="fas fa-arrow-left"></i></a></li>';
						}
						if (isset($admin_developer_messages->mLinkToNextPage)) {
							echo '<li class="waves-effect"><a href="'.$admin_developer_messages->mLinkToNextPage.'"><i class="fas fa-arrow-right"></i></a></li>';
						}
						else {
							echo '<li class="disabled"><a href="#!"><i class="fas fa-arrow-right"></i></a></li>';
						}
				echo '</ul>
				</div>
			</div>';
		}
	}
?>