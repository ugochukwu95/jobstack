<?php
	require_once PRESENTATION_DIR . 'admin_report_posts.php';
	$admin_report_posts = new AdminReportPosts();
	$admin_report_posts->init();
	echo '
	<div class="row">
	  	<div class="col s12">
	  		<h5 class="center bebasFont teal-text">Report Post Admin</h5>
	  	</div>
    </div>
	';

	if (count($admin_report_posts->mPosts) == 0) {
		echo '<p class="center">There are no reports at this time</p>';
	}
	else {
		echo '
			<div class="row">
				<div class="col s12 l8 offset-l2">
					<table class="grey-text text-darken-2 responsive-table">
						<thead>
							<tr>
								<th>Email</th>
								<th>Handle</th>
								<th>Reported On</th>
								<th>Access Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>';

						for ($i=0; $i<count($admin_report_posts->mPosts); $i++) {
							echo'
							<tr class="user_row_'.$i.'">
								<td>'.$admin_report_posts->mPosts[$i]['email'].'</td>
								<td>'.$admin_report_posts->mPosts[$i]['handle'].'</td>
								<td>'.$admin_report_posts->mPosts[$i]['reported_on'].'</td>
								<td>'.$admin_report_posts->mPosts[$i]['access_denied'].'</td>
								<td>								
									<a class="waves-effect waves-light red lighten-2 btn modal-trigger white-text" href="'.$admin_report_posts->mPosts[$i]['report_post_details'].'">VISIT</a>
								</td>
							</tr>
							';
						}
						echo '
						</tbody>
					</table>
				</div>
			</div>
					';
			if ($admin_report_posts->mrTotalPages > 1) {
				echo '
				<div class="row">
					<div class="col s12 m12 l6 offset-l3">
					<p class="center">Page '.$admin_report_posts->mPagination.' of '.$admin_report_posts->mrTotalPages.'</p>
					<ul class="pagination center">';
						if (isset($admin_report_posts->mLinkToPreviousPage)) {
							echo '<li class="waves-effect"><a href="'.$admin_report_posts->mLinkToPreviousPage.'"><i class="fas fa-arrow-left"></i></a></li>';
						}
						else {
							echo '<li class="disabled"><a href="#!"><i class="fas fa-arrow-left"></i></a></li>';
						}
						if (isset($admin_report_posts->mLinkToNextPage)) {
							echo '<li class="waves-effect"><a href="'.$admin_report_posts->mLinkToNextPage.'"><i class="fas fa-arrow-right"></i></a></li>';
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