<?php
	require_once PRESENTATION_DIR . 'admin_users_jobs.php';
	$admin_users = new AdminUsersJobs();
	$admin_users->init();
	echo '
	<div class="row">
	  	<div class="col s12">
	  		<h5 class="center bebasFont teal-text">Users Jobs Admin</h5>
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

	if (count($admin_users->mUsers) == 0) {
		echo '<p class="center">There are no users jobs in the database</p>';
	}
	else {
		echo '
			<div class="row">
				<div class="col s12 l8 offset-l2">
				<form class="center" method="POST" action="'.$admin_users->mLinkToUsersJobsAdmin.'">
					<table class="grey-text text-darken-2">
						<thead>
							<tr>
								<th>Company Name</th>
								<th>Position Name</th>
								<th>Date Posted</th>
								<th></th>
							</tr>
						</thead>
						<tbody>';

						for ($i=0; $i<count($admin_users->mUsers); $i++) {
							echo'
								<tr class="user_row_'.$i.'">
									<td>'.$admin_users->mUsers[$i]['company_name'].'</td>
									<td>'.$admin_users->mUsers[$i]['position_name'].'</td>
									<td>'.$admin_users->mUsers[$i]['date_posted'].'</td>
									<td>
										<a class="waves-effect waves-light teal btn white-text" href="'.$admin_users->mUsers[$i]['link_to_user_job_details'].'">Job Post</a> 								
									</td>
								</tr>';
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