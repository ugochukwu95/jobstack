<?php
	require_once PRESENTATION_DIR . 'admin_report_comments.php';
	$admin_report_comments = new AdminReportComments();
	$admin_report_comments->init();
	echo '
	<div class="row">
	  	<div class="col s12">
	  		<h5 class="center bebasFont teal-text">Report Comment Admin</h5>
	  	</div>
    </div>
	';

	if (count($admin_report_comments->mComments) == 0) {
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
						for ($i=0; $i<count($admin_report_comments->mComments); $i++) {
							echo'
							<tr class="user_row_'.$i.'">
								<td>'.$admin_report_comments->mComments[$i]['email'].'</td>
								<td>'.$admin_report_comments->mComments[$i]['handle'].'</td>
								<td>'.$admin_report_comments->mComments[$i]['reported_on'].'</td>
								<td>'.$admin_report_comments->mComments[$i]['access_denied'].'</td>
								<td>								
									<a class="waves-effect waves-light red lighten-2 btn modal-trigger white-text" href="'.$admin_report_comments->mComments[$i]['report_comment_details'].'">VISIT</a>
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
			if ($admin_report_comments->mrTotalPages > 1) {
				echo '
				<div class="row">
					<div class="col s12 m12 l6 offset-l3">
					<p class="center">Page '.$admin_report_comments->mPagination.' of '.$admin_report_comments->mrTotalPages.'</p>
					<ul class="pagination center">';
						if (isset($admin_report_comments->mLinkToPreviousPage)) {
							echo '<li class="waves-effect"><a href="'.$admin_report_comments->mLinkToPreviousPage.'"><i class="fas fa-arrow-left"></i></a></li>';
						}
						else {
							echo '<li class="disabled"><a href="#!"><i class="fas fa-arrow-left"></i></a></li>';
						}
						if (isset($admin_report_comments->mLinkToNextPage)) {
							echo '<li class="waves-effect"><a href="'.$admin_report_comments->mLinkToNextPage.'"><i class="fas fa-arrow-right"></i></a></li>';
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