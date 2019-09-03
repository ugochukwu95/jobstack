<?php
	require_once PRESENTATION_DIR . 'admin_report_comment_details.php';
	$admin_report_comment_details = new AdminReportCommentDetails();
	$admin_report_comment_details->init();
	echo '
	<div class="container">
		<h5 class="center bebasFont teal-text text-darken-2">Report ID #'.$admin_report_comment_details->mReportId.' details </h5>
		<p class="center">
			<small>
			<a href="'.$admin_report_comment_details->mLinkToAdminReportComment.'" class="waves-effect waves-light btn white-text red lighten-2 back_link"><i class="fas fa-arrow-left"></i> Back to report comments page</a>
			</small>
		</p>
	</div>';
	if (!is_null($admin_report_comment_details->mErrorMessage)) {
		echo '<p class="red-text">'.$admin_report_comment_details->mErrorMessage.'</p>';
	}
	echo '
	<div class="row container row_post">
		<div class="col s12 l8 offset-l2">
			<div class="card white grey-text text-darken-2">
				<div class="card-content">
					<span class="card-title">'.$admin_report_comment_details->mPost['handle'].', '.$admin_report_comment_details->mPost['email'].', Access Status: <span class="accessVal">'.$admin_report_comment_details->mPost['access_denied'].'</span></span>
					<div class="divider"></div>
					<small>Posted on: '.$admin_report_comment_details->mPost['created_on'].'</small>
					<small>Reported on: '.$admin_report_comment_details->mPost['reported_on'].'</small>
					<br><br>
					<p>Comment: '.$admin_report_comment_details->mPost['comment'].'</p>
				</div>
				<div class="card-action">';
					echo '
					<ul>';
						if ($admin_report_comment_details->mPost['access_denied'] < 3) {
							echo '<li class="waves-effect"><a href="#!" class="btn red lighten-2 white-text waves-light waves-effect warn">WARN</a></li>';
						}
						echo '
						<li class="waves-effect"><a href="#!" class="btn red lighten-2 white-text waves-light waves-effect delete_post">Delete Comment</a></li>
						<li class="waves-effect"><a href="#!" class="btn red lighten-2 white-text waves-light waves-effect delete_report">Delete Report</a></li>
					</ul>

					<script>
						$(document).ready(function() {
							$(".warn"). click(function(event) {
								event.preventDefault();
								var ad = $(".accessVal").text();
								$.post(
								"'.$admin_report_comment_details->mLinkToAdminReportCommentDetails.'",
								{Warn: '.$admin_report_comment_details->mPost['customer_id'].', AccessDenied: "'.$admin_report_comment_details->mPost['access_denied'].'"},
								function(data) {
									ad++;
									$(".accessVal").text(ad);
									M.toast({html: "Sucessfully warned"});
									if (ad == 3) {
										$(".warn").remove();
									}									
								}
								);
							});

							$(".delete_post"). click(function(event) {
								event.preventDefault();
								$.post(
								"'.$admin_report_comment_details->mLinkToAdminReportCommentDetails.'",
								{Delete_Comment: '.$admin_report_comment_details->mPost['comment_id'].', UserId: '.$admin_report_comment_details->mPost['customer_id'].'},
								function(data) {
									M.toast({html: "Sucessfully deleted"});
									$(".row_post").remove();
									window.location.href = "'.$admin_report_comment_details->mLinkToAdminReportComment.'";
								}
								);
							});

							$(".delete_report"). click(function(event) {
								event.preventDefault();
								$.post(
								"'.$admin_report_comment_details->mLinkToAdminReportCommentDetails.'",
								{Delete_Report: '.$admin_report_comment_details->mReportId.'},
								function(data) {
									M.toast({html: "Sucessfully deleted"});
									$(".row_post").remove();
									window.location.href = "'.$admin_report_comment_details->mLinkToAdminReportComment.'";
								}
								);
							});
						});
					</script>
				</div>
			</div>
		</div>
	</div>
	';
?>