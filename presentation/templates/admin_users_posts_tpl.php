<?php
	require_once PRESENTATION_DIR . 'admin_users_posts.php';
	$admin_users_posts = new AdminUsersPosts();
	$admin_users_posts->init();
	echo '
	<div class="row">
		<div class="col s12">
			<h5 class="center teal-text bebasFont">'.$admin_users_posts->mUserHandle.' Posts</h5>
		</div>
	</div>
	';
	if (count($admin_users_posts->mPosts) == 0) {
		echo '
		<div class="row">
			<div class="col s12">
				<h3 class="center grey-text text-darken-2">:-(</h3>
				<h6 class="center grey-text text-darken-2">User has not made any posts.</h6>
			</div>
		</div>
		';
	}
	else {
		echo '
		<div class="row">
			<div class="col s12 l8 offset-l2">
				<form>
					<table class="grey-text text-darken-2" id="userPostsTable">
						<thead>
							<tr>
								<th>Post</th>
								<th>Date Posted</th>
								<th>Display</th>
								<th></th>
							</tr>
						</thead>
						<tbody>';
						for($i=0; $i<count($admin_users_posts->mPosts); $i++) {
							echo '
							<tr>
								<td>'.$admin_users_posts->mPosts[$i]['post'].'</td>
								<td>'.$admin_users_posts->mPosts[$i]['date_posted'].'</td>
								<td>
									<div class="row">
										<div class="input-field col s12">
											<input id="displayVal'.$i.'" type="number" value="'.$admin_users_posts->mPosts[$i]['display'].'">
										</div>
									</div>
								</td>
								<td><a href="#!" class="btn red lighten-2 white-text" id="updateDisplay'.$i.'">Alter Display</a></td>
							</tr>
							<script>
								$(document).ready(function() {
									$("#userPostsTable").on("click", "#updateDisplay'.$i.'", function(event) {
										event.preventDefault();
										var displayValue'.$i.' = $("#displayVal'.$i.'").val();
										var type'.$i.' = typeof displayValue'.$i.';

										if ((displayValue'.$i.' > 1) || (displayValue'.$i.' < 0)) {
											return;
										}
										$.post(
											"'.$admin_users_posts->mLinkToUsersPostsAdmin.'",
											{AlterDisplay: displayValue'.$i.', PostId: '.$admin_users_posts->mPosts[$i]['post_id'].'},
											function(data) {
												M.toast({html: "Sucessfully updated"});
											}
										);
									});
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
	}
	if (count($admin_users_posts->mPostsListPages) > 1) {
		echo '
		<div class="row">
			<div class="col s12 m12 l6 offset-l3">
			<p class="center">Page '.$admin_users_posts->mPagination.' of '.$admin_users_posts->mrTotalPages.'</p>
			<ul class="pagination center">';
				if (isset($admin_users_posts->mLinkToPreviousPage)) {
					echo '<li class="waves-effect"><a href="'.$admin_users_posts->mLinkToPreviousPage.'"><i class="fas fa-arrow-left"></i></a></li>';
				}
				else {
					echo '<li class="disabled"><a href="#!"><i class="fas fa-arrow-left"></i></a></li>';
				}
				if (isset($admin_users_posts->mLinkToNextPage)) {
					echo '<li class="waves-effect"><a href="'.$admin_users_posts->mLinkToNextPage.'"><i class="fas fa-arrow-right"></i></a></li>';
				}
				else {
					echo '<li class="disabled"><a href="#!"><i class="fas fa-arrow-right"></i></a></li>';
				}
		echo '</ul>
			</div>
		</div>';
	}
?>