<?php
	require_once PRESENTATION_DIR . 'cart_details.php';
	$cart_details = new CartDetails();
	$cart_details->init();

	if ($cart_details->mIsCartNowEmpty == 1) {
		echo '
			<div class="row empty-saved-jobs">
				<div class="col s12">
					<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
					<h5 class="center"><span class="grey-text text-darken-2">You have no saved jobs.</h5>
					<p class="center red-text text-lighten-2"><a href="'.$cart_details->mLinkToContinueBrowsing.'" class="center red-text text-lighten-2"><i class="fas fa-arrow-left"></i> continue browsing</a>
					</p>
				</div>
			</div>
		';
	}
	else {
		echo '
				<div class="row saved-jobs-heading">
				</div>
				';
		if ($cart_details->mJobs) {
			if ($cart_details->mrTotalPages > 1) {
				echo '
				<div class="row">
					<div class="col s12">
						<p class="">viewing Page <span class="teal-text"><b>'.$cart_details->mPage.'</b></span> of '.$cart_details->mrTotalPages.'</p>
					</div>
				</div>
				';
			}

			echo '<div class="flex-container">';
			for ($i=0; $i<count($cart_details->mJobs); $i++) {
				echo '
				<div class="flex-items div'.$i.'">
						<div class="card white hoverable small">
							<div class="card-content grey-text text-darken-2" style="cursor:pointer;" onclick="location.href=\''.$cart_details->mJobs[$i]['link_to_job'].'\'">
								<h5 class=""><a class="grey-text text-darken-2" href="'.$cart_details->mJobs[$i]['link_to_job'].'">'.$cart_details->mJobs[$i]['position_name'].' at<br>'.$cart_details->mJobs[$i]['company_name'].'</a></h5>
								<br>
								<p class="" style="position:relative;">- '.$cart_details->mJobs[$i]['location'].'</p>
								<p class="grey-text text-darken-2">
									- Date Posted: ';
									$d = strtotime($cart_details->mJobs[$i]['date_posted']);
									echo date('d', $d) . 'th ' . date('M', $d) . ', ' . date('Y', $d);
									$today = date('Y-m-d');
									if ($cart_details->mJobs[$i]['date_of_expiration'] < $today) {
										echo '<span class="white-text">&nbsp; - Expired</span>';
									}
									echo '
								</p>
							</div>
							<div class="card-action" id="save_job_functionality'.$i.'">
								<h5>';
									echo '
									<a class="waves-effect waves-red grey-text text-darken-2 modal-trigger" href="#modal_'.$i.'" style="position:absolute;top:10px;left:10%">
										<i class="fas fa-hashtag"></i>
									</a>';
								echo '
								</h5>
								<h5 class="right" style="cursor:pointer;">';
								echo '<i class="material-icons save_job_minus_icon_'.$i.' red-text text-lighten-2 scale-transition scale-in" style="position:absolute;top:10px;right:10%">favorite</i>';
								echo '
								</h5>
							</div>
						</div>
					<script>
						$("#save_job_functionality'.$i.'").on("click", ".save_job_minus_icon_'.$i.'", function(){
							$(".div'.$i.'").remove(); // Remove deleted card
							$(".badge").text((($(".badge").text())-1)); // Alter number of saved jobs
							M.toast({html: "Sucessfully removed"});
							if ($(".badge").text() == 0) {
								$(".saved-jobs-heading").replaceWith(function(n) {
								return "<div class=\"row empty-saved-jobs grey-text text-darken-2\"><div class=\"col s12\"><h1 class=\"center\">:-(</h1><h5 class=\"center\"><span>You have no saved jobs.</h5><br><br><p class=\"center\"><a href=\"'.$cart_details->mLinkToContinueBrowsing.'\" class=\"center red-text text-lighten-2\"><i class=\"fas fa-arrow-left\"></i> continue browsing</a></p></div></div>";})
							}
							$.post("'.VIRTUAL_LOCATION.'cart-details",
							{CartAction: '.REMOVE_JOB.', JobId: '.$cart_details->mJobs[$i]['job_id'].'},
							function(data) {
								// nothing
							});
						});
					</script>
					<div id="modal_'.$i.'" class="modal"> 
						<div class="row">
							<form class="col s12 l8 offset-l2">
								<div class="modal-content">
									<h6 class="grey-text text-darken-2 center"><span class="modal-close modal_close_'.$i.' red-text text-lighten-2"><i class="fas fa-chevron-left"></i></span> &nbsp;Post to your profile</h6>
										<br>
									<h6 class="teal truncate white-text" style="padding:8px;" title="tag '.$cart_details->mJobs[$i]['position_name'].' at '.$cart_details->mJobs[$i]['company_name'].'">
										<small>
											<a class="white-text" href="'.$cart_details->mJobs[$i]['link_to_popular_tags_page'].'"><i class="fas fa-tag"></i> &nbsp;'.$cart_details->mJobs[$i]['position_name'].' at '.$cart_details->mJobs[$i]['company_name'].'
											</a>
										</small>
									</h6>
									<div class="row">
										<div class="input-field col s12">
											<textarea id="post_to_your_profile_'.$i.'" type="text" class="materialize-textarea post_with_tag_'.$i.'"></textarea>
												<label for="post_to_your_profile_'.$i.'">Compose post</label>
												<a href="#!" id="button_submit_post_'.$i.'" class="left btn-small btn-flat white-text red lighten-2">POST</a>
										</div>
									</div>
								</div>
								<div class="s12">
									
								</div>
							</form>
						</div>
					</div>
					<script>
						$("#modal_'.$i.'").on("click", "#button_submit_post_'.$i.'", function(event){
							event.preventDefault();
							var post_with_tag = $(".post_with_tag_'.$i.'").val();
							if (post_with_tag.length == 0) {
								return;
							}
							$(".modal_close_'.$i.'").click();
							$(".post_with_tag_'.$i.'").val("");
							M.toast({html: "Posted successfully &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$cart_details->mLinkToUserProfile.'\">view post</a>"});
							$.post("'.$cart_details->mLinkToCartDetails.'",
							{Button_Post_With_Tag: "", Post: post_with_tag, JobId: '.$cart_details->mJobs[$i]['job_id'].'},
							function(data) {
								// nothing
							})
						});
					</script>
				</div>
				';
			}
			echo '</div>';


		if (count($cart_details->mJobListPages) > 1) {
			echo '<ul class="pagination black-text center">';
				for ($m = 0; $m < count($cart_details->mJobListPages); $m++) {
					if ($cart_details->mPage == ($m+1)) {
						echo '<li class="waves-effect active teal"><a href="'.$cart_details->mJobListPages[$m].'"><small>'.($m+1).'</small></a></li>';
					}
					else {
						echo '<li class="waves-effect"><a href="'.$cart_details->mJobListPages[$m].'"><small>'.($m+1).'</small></a></li>';
					}
				}
				echo '</ul>';
			}
	}	
	}
	
?>