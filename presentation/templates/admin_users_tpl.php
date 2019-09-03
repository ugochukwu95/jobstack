<?php
	require_once PRESENTATION_DIR . 'admin_users.php';
	$admin_users = new AdminUsers();
	$admin_users->init();
	echo '
	<div class="row">
	  	<div class="col s12">
	  		<h5 class="center bebasFont teal-text">Users Admin</h5>
	  	</div>
    </div>
	';

	if (!is_null($admin_users->mErrorMessage)) {
		echo '
		<div class="center red"> 
			<h4 class="white-text">'.
				$admin_users->mErrorMessage
			.'</h4>
		</div>
		';
	}

	if ($admin_users->mSearchDescription != '') {
		echo '
		<h1 class="center">:-(</h1>
		<p class="center">'.$admin_users->mSearchDescription.'</p>';
	}
	elseif (count($admin_users->mUsers) == 0) {
		echo '<p class="center">There are no users in the database</p>';
	}
	else {
		echo '
			<div class="row">
				<div class="col s12 l8 offset-l2">
				<form class="center" method="POST" action="'.$admin_users->mLinkToUsersAdmin.'">
					<table class="grey-text text-darken-2">
						<thead>
							<tr>
								<th>Email</th>
								<th>Handle</th>
								<th></th>
							</tr>
						</thead>
						<tbody>';

						for ($i=0; $i<count($admin_users->mUsers); $i++) {
							echo'
								<tr class="user_row_'.$i.'">
									<td>'.$admin_users->mUsers[$i]['email'].'</td>
									<td>'.$admin_users->mUsers[$i]['handle'].'</td>
									<td>
										<a class="waves-effect waves-light teal btn white-text" href="'.$admin_users->mUsers[$i]['link_to_user_posts'].'">Posts</a> 								
										<a class="waves-effect waves-light red lighten-2 btn modal-trigger white-text" href="#modal'.$i.'"><i class="fas fa-trash"></i> Delete</a>
										<div id="modal'.$i.'" class="modal">
											<div class="modal-content">
												<h4 class="center">DELETE!</h4>
												<p class="center">Are you sure you want to delete user: #'.$admin_users->mUsers[$i]['customer_id'].'?</p>
											</div>
											<div class="modal-footer">
												<a href="#!" class="delete_user_'.$i.' center modal-close btn-flat waves-effect waves-light red white-text">
												Delete
												</a>
											</div>
										</div>
									</td>
								</tr>
								<script>
									$(document).ready(function() {
										$(".delete_user_'.$i.'").click(function(event) {
											event.preventDefault();
											$.post(
											"'.$admin_users->mLinkToUsersAdmin.'",
											{Delete_User: "", UserId: '.$admin_users->mUsers[$i]['customer_id'].'},
											function(data) {
												$(".user_row_'.$i.'").remove();
												M.toast({html: "Sucessfully deleted"});
											}
											);
										})
									});
								</script>
							';
						}

						echo '
						</tbody>
					</table>
				</form>
				</div>
			</div>
					';
			if ($admin_users->mrTotalPages > 1) {
				echo '
				<div class="row">
					<div class="col s12 m12 l6 offset-l3">
					<p class="center">Page '.$admin_users->mPagination.' of '.$admin_users->mrTotalPages.'</p>
					<ul class="pagination center">';
						if (isset($admin_users->mLinkToPreviousPage)) {
							echo '<li class="waves-effect"><a href="'.$admin_users->mLinkToPreviousPage.'"><i class="fas fa-arrow-left"></i></a></li>';
						}
						else {
							echo '<li class="disabled"><a href="#!"><i class="fas fa-arrow-left"></i></a></li>';
						}
						if (isset($admin_users->mLinkToNextPage)) {
							echo '<li class="waves-effect"><a href="'.$admin_users->mLinkToNextPage.'"><i class="fas fa-arrow-right"></i></a></li>';
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