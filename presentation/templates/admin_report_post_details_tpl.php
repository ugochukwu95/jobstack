<?php
	require_once PRESENTATION_DIR . 'admin_report_post_details.php';
	$admin_report_post_details = new AdminReportPostDetails();
	$admin_report_post_details->init();
	echo '
	<div class="container">
		<h5 class="center bebasFont teal-text text-darken-2">ReportID #'.$admin_report_post_details->mReportId.' details </h5>
		<p class="center">
			<small>
			<a href="'.$admin_report_post_details->mLinkToAdminReportPost.'" class="waves-effect waves-light btn white-text red lighten-2 back_link"><i class="fas fa-arrow-left"></i> Back to report posts page</a>
			</small>
		</p>
	</div>';
	if (!is_null($admin_report_post_details->mErrorMessage)) {
		echo '<p class="red-text">'.$admin_report_post_details->mErrorMessage.'</p>';
	}
	echo '
	<div class="row container row_post">
		<div class="col s12 l8 offset-l2">
			<div class="card white grey-text text-darken-2">
				<div class="card-content">
					<span class="card-title">'.$admin_report_post_details->mPost['handle'].', '.$admin_report_post_details->mPost['email'].', Access Status: <span class="accessVal">'.$admin_report_post_details->mPost['access_denied'].'</span></span>
					<div class="divider"></div>
					<small>Posted on: '.$admin_report_post_details->mPost['date_posted'].'</small>
					<small>Reported on: '.$admin_report_post_details->mPost['reported_on'].'</small>
					<br><br>
					<p>Post: '.$admin_report_post_details->mPost['post'].'</p>
				</div>
				<div class="card-action">';
					echo '
					<ul>';
						if ($admin_report_post_details->mPost['access_denied'] < 3) {
							echo '<li class="waves-effect"><a href="#!" class="btn red lighten-2 white-text waves-light waves-effect warn">WARN</a></li>';
						}
						echo '
						<li class="waves-effect"><a href="#!" class="btn red lighten-2 white-text waves-light waves-effect delete_post">Delete Post</a></li>
						<li class="waves-effect"><a href="#!" class="btn red lighten-2 white-text waves-light waves-effect delete_report">Delete Report</a></li>
					</ul>

					<script>
						$(document).ready(function() {
							$(".warn"). click(function(event) {
								event.preventDefault();
								var ad = $(".accessVal").text();
								$.post(
								"'.$admin_report_post_details->mLinkToAdminReportPostDetails.'",
								{Warn: '.$admin_report_post_details->mPost['customer_id'].', AccessDenied: "'.$admin_report_post_details->mPost['access_denied'].'"},
								function(data) {
									ad++;
									$(".accessVal").text(ad);
									M.toast({html: "Sucessfully warned"});
									if (ad == 3) {
										$(".warn").remove();
										window.location.href = "'.$admin_report_post_details->mLinkToAdminReportPost.'";
									}									
								}
								);
							});

							$(".delete_post"). click(function(event) {
								event.preventDefault();
								$.post(
								"'.$admin_report_post_details->mLinkToAdminReportPostDetails.'",
								{Delete_Post: '.$admin_report_post_details->mPost['post_id'].', UserId: '.$admin_report_post_details->mPost['customer_id'].'},
								function(data) {
									M.toast({html: "Sucessfully deleted"});
									$(".row_post").remove();
									window.location.href = "'.$admin_report_post_details->mLinkToAdminReportPost.'";
								}
								);
							});

							$(".delete_report"). click(function(event) {
								event.preventDefault();
								$.post(
								"'.$admin_report_post_details->mLinkToAdminReportPostDetails.'",
								{Delete_Report: '.$admin_report_post_details->mReportId.'},
								function(data) {
									M.toast({html: "Sucessfully deleted"});
									$(".row_post").remove();
									window.location.href = "'.$admin_report_post_details->mLinkToAdminReportPost.'";
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