<?php
	require_once PRESENTATION_DIR . 'jobs_list.php';
	$jobs_list = new JobsList();
	$jobs_list->init();
    
    echo '
    <style>
	    .search_btn {
	        padding: 20px;
	        border-radius: 8px;
	        cursor: pointer;
	        white-space: nowrap;
	    }
	</style>
    ';
	if ($jobs_list->mSearchDescription != '') {
		echo '
		<div class="row">
			<div class="col s12">
				<h1 class="center">:-(</h1>
				<p class="center grey-text text-darken-2">'.$jobs_list->mSearchDescription.'</p>
				<p class="grey-text text-darken-2 center">Oops! Change the wording of your search query or try browsing our <a href="'.$jobs_list->mLinkToAllJobs.'" class="red-text">Catalog.</a></p>
			</div>
		</div>
		';
	}

	if (!is_null($jobs_list->mErrorMessage)) {
		echo $jobs_list->mErrorMessage;
	}

	if ($jobs_list->mJobs && $jobs_list->mIsFrontPage == 'no') {
	    
		if ($jobs_list->mrTotalPages > 1) {
			echo '
			<div class="row">
				<div class="col s12">
					<p class=" grey-text text-darken-2 center">viewing <span class="teal-text"><b>'.$jobs_list->mPage.'</b></span> of '.$jobs_list->mrTotalPages.' pages.</p>';
				echo '
				</div>
			</div>
			';
		}
		$jobs_list_count = count($jobs_list->mJobs);
		
		if ($jobs_list->mJobsPageName == 'All Jobs' && $jobs_list->mSearchString == '') {
			echo '<br>
			<p class="center">
				<span><a href="'.$jobs_list->mLinkToTodayJobs.'" class="btn teal grey-text text-darken-2 lighten-5">today</a></span>&nbsp;
				<span><a href="'.$jobs_list->mLinkToYesterdayJobs.'" class="btn teal grey-text text-darken-2 lighten-5">yesterday</a></span>&nbsp;<br><br><br>
				<span><a href="'.$jobs_list->mLinkToThisWeekJobs.'" class="btn teal grey-text text-darken-2 lighten-5">this week</a></span>&nbsp;
				<span><a href="'.$jobs_list->mLinkToLastThirtyDaysJobs.'" class="btn teal grey-text text-darken-2 lighten-5">Last 30 days</a></span>
			</p>';
		}
		
		echo '<div class="flex-container">';
		for ($i=0; $i<count($jobs_list->mJobs); $i++) {
			echo '
				<div class="flex-item">
					<div class="card white hoverable">
					<div class="card-content grey-text text-darken-2 card_content_'.$i.'" style="cursor:pointer;">';
					/*if (!empty($jobs_list->mJobs[$i]['image'])) {
					    echo '
					    <div class="row">
					        <div class="col s6 offset-s3">
					        <p><img src="'.Link::Build('images/company_logo/'.$jobs_list->mJobs[$i]['image']).'" alt="'.$jobs_list->mJobs[$i]['company_name'].' logo" class="responsive-img"></p>
					        </div>
					    </div>';
					}*/
					echo '
					<h5 class=""><a class="grey-text text-darken-2" href="'.$jobs_list->mJobs[$i]['link_to_job'].'">'.$jobs_list->mJobs[$i]['position_name'].' at<br>'.$jobs_list->mJobs[$i]['company_name'].'</a></h5>
					<br>
					<p id="" class="" style="position:relative;">- '.$jobs_list->mJobs[$i]['location'].'</p>
					<p class="grey-text text-darken-2">
						- Date Posted: ';
						$d = strtotime($jobs_list->mJobs[$i]['date_posted']);
						echo date('d', $d) . ' ' . date('M', $d) . ', ' . date('Y', $d);
						$today = date('Y-m-d');
						if ($jobs_list->mJobs[$i]['date_of_expiration'] < $today) {
							echo '<span class="grey-text text-darken-2">&nbsp; - Expired</span>';
						}
						echo '
					</p>
					</div>
					<div class="card-action" id="save_job_functionality'.$i.'">';
						if (Customer::GetCurrentCustomerId() != 0) {
							echo '
							<h5>
							<a class="waves-effect waves-red grey-text text-darken-2 modal-trigger" href="#modal_'.$i.'" style="position:absolute;top:0px;left:10%">
								<i class="fas fa-hashtag"></i>
							</a>
							</h5>';
						}
						else {
							echo '
							<h5>
							<a class="waves-effect waves-red grey-text text-darken-2" href="#!" style="position:absolute;top:0px;left:10%">
								<i class="fas fa-hashtag tag_'.$i.'"></i>
							</a>
							</h5>
							<script>
								$(document).ready(function() {
									$("#save_job_functionality'.$i.'").on("click", ".tag_'.$i.'", function(event){
										event.preventDefault();
										window.location.href = "'.$jobs_list->mLinkToLoginPage.'";
									});
								});
							</script>';
						}
						echo '
						<h5 style="cursor:pointer;">';
							echo '<i class="material-icons save_job_plus_icon_'.$i.' grey-text text-darken-2 scale-transition ';
							if ($jobs_list->mJobs[$i]['card_color'] == 'red') {
								echo 'scale-out';
							}
							else {
								echo 'scale-in';
							}

							echo '" style="position:absolute;top:0px;right:10%">favorite_border</i>';
							echo '<i class="material-icons save_job_minus_icon_'.$i.' red-text text-lighten-2 scale-transition ';
							if ($jobs_list->mJobs[$i]['card_color']  !== 'red') {
								echo 'scale-out';
							}
							else {
								echo 'scale-in';
							}
							
							echo '" style="position:absolute;top:0px;right:10%">favorite</i>';
						echo '
						</h5>
					</div>
					</div>
					<script>
						$(document).ready(function() {
							$(".card_content_'.$i.'").click(function(event) {
								window.location.href = "'.$jobs_list->mJobs[$i]['link_to_job'].'";
							});
							$("#save_job_functionality'.$i.'").on("click", ".save_job_plus_icon_'.$i.'", function(){
								$(".save_job_plus_icon_'.$i.'").removeClass("scale-in").addClass("scale-out");
								var badgeText = $(".badge").text();
								badgeText++;
								$(".badge").text(badgeText);
								$(".save_job_minus_icon_'.$i.'").removeClass("scale-out").addClass("scale-in");
								M.toast({html: "Sucessfully saved &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$jobs_list->mLinkToCartPage.'\">view saved job</a>"});
								$.post("'.$jobs_list->mSiteUrl.'cart-details",
								{CartAction: '.ADD_JOB.', JobId: '.$jobs_list->mJobs[$i]['job_id'].'},
								function(data) {
									// nothing
								})
							});
							$("#save_job_functionality'.$i.'").on("click", ".save_job_minus_icon_'.$i.'", function(){
								$(".save_job_minus_icon_'.$i.'").removeClass("scale-in").addClass("scale-out");
								$(".badge").text((($(".badge").text()) - 1));
								$(".save_job_plus_icon_'.$i.'").removeClass("scale-out").addClass("scale-in");
								M.toast({html: "Sucessfully removed"});
								$.post("'.$jobs_list->mSiteUrl.'cart-details",
								{CartAction: '.REMOVE_JOB.', JobId: '.$jobs_list->mJobs[$i]['job_id'].'},
								function(data) {
									// nothing
								})
							});
						});
					</script>
				</div>
				<div id="modal_'.$i.'" class="modal">
					<div class="row">
						<form class="col s12 l8 offset-l2" enctype="multipart/form-data">
							<div class="modal-content">
								<h6 class="grey-text text-darken-2 left"><span class="modal-close modal_close_'.$i.' red-text text-lighten-2"><i class="fas fa-arrow-left"></i></span></h6>
									<br><br>
								<h6 class="teal truncate white-text" style="padding:8px;" title="tag '.$jobs_list->mJobs[$i]['position_name'].' at '.$jobs_list->mJobs[$i]['company_name'].'">
									<small>
										<a class="white-text" href="'.$jobs_list->mJobs[$i]['link_to_popular_tags_page'].'"><i class="fas fa-hashtag"></i> &nbsp;'.$jobs_list->mJobs[$i]['position_name'].' at '.$jobs_list->mJobs[$i]['company_name'].'
										</a>
									</small>
								</h6>
								<br>
								<div class="row">
									<div class="input-field col s12">
										<textarea placeholder="Have you head any news about this job?" id="post_to_your_profile_'.$i.'" type="text" class="post_with_tag_'.$i.'" style="width:100%;height:150px;padding:12px 20px;box-sizing:border-box;border:2px solid lightgrey;border-radius:4px;background-color:white;resize:none;"></textarea>
									</div>
								</div>
							</div>
							<div class="center">
								<a href="#!" id="button_submit_post_'.$i.'" class="center btn-small btn-flat white-text red lighten-2">POST</a>
							</div> 
						</form>
					</div>
				</div>
				<script>
					$(document).ready(function() {
						$("#modal_'.$i.'").on("click", "#button_submit_post_'.$i.'", function(event){
							event.preventDefault();
							var post_with_tag = $(".post_with_tag_'.$i.'").val();
							if (post_with_tag.length == 0) {
								return;
							}
							$(".modal_close_'.$i.'").click();
							$(".post_with_tag_'.$i.'").val("");
							M.textareaAutoResize($(".post_with_tag_'.$i.'"));
							M.toast({html: "Posted successfully &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$jobs_list->mLinkToUserProfile.'\">view post</a>"});
							$.post("'.$jobs_list->mLinkToAllJobs.'",
							{Button_Post_With_Tag: "", Post: post_with_tag, JobId: '.$jobs_list->mJobs[$i]['job_id'].'},
							function(data) {
								// nothing
							})
						});
					});
				</script>
			';
		}
		echo '</div>';


		if (count($jobs_list->mJobListPages) > 1) {
			echo '
			<div class="row">
				<div class="col s12">
					<ul class="pagination black-text center">';
					    if ($jobs_list->mPage == 1) {
					        echo '<li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>';
					    }
					    else {
					        echo '<li class="waves-effect waves-red"><a href="'.$jobs_list->mLinkToPreviousPage.'"><i class="material-icons">chevron_left</i></a></li>';
					    }
					    if ($jobs_list->mPage == $jobs_list->mrTotalPages) {
					        echo '<li class="disabled"><a href="#!"><i class="material-icons">chevron_right</i></a></li>';
					    }
					    else {
					        echo '<li class="waves-effect waves-red"><a href="'.$jobs_list->mLinkToNextPage.'"><i class="material-icons">chevron_right</i></a></li>';
					    }
						echo '
					</ul>
				</div>
			</div>';
		}
	}
	elseif ($jobs_list->mJobs && $jobs_list->mIsFrontPage == 'yes') {
		if ($jobs_list->mrTotalPages > 1 && $jobs_list->mIsFrontPage == 'no') {
			echo '
			<div class="row">
				<div class="col s12">
					<h5 class="bebasFont center teal-text">All Jobs</h5>
					<p class="center">viewing <span class="teal-text"><b>'.$jobs_list->mPage.'</b></span> of '.$jobs_list->mrTotalPages.' pages.</p>
				</div>
			</div>
			';
		}
		$jobs_list_count = count($jobs_list->mJobs);
		echo '
		<div class="row">
			<div class="col s12">
				<div class="flex-container">';
					for ($i=0; $i<count($jobs_list->mJobs); $i++) {
						echo '
						<div class="flex-item">
							<div class="card white hoverable">
							<div class="card-content card_content_'.$i.' grey-text text-darken-2" style="cursor:pointer;">
							';
							/*if (!empty($jobs_list->mJobs[$i]['image'])) {
        					    echo '
        					    <div class="row">
        					        <div class="col s6 offset-s3">
        					        <p><img src="'.Link::Build('images/company_logo/'.$jobs_list->mJobs[$i]['image']).'" alt="'.$jobs_list->mJobs[$i]['company_name'].' logo" class="responsive-img"></p>
        					        </div>
        					    </div>';
        					}*/
							echo '
							<h5 class=""><a class="grey-text text-darken-2" href="'.$jobs_list->mJobs[$i]['link_to_job'].'">'.$jobs_list->mJobs[$i]['position_name'].' at<br>'.$jobs_list->mJobs[$i]['company_name'].'</a></h5>
							<br>
							<p class="" style="position:relative;">- '.$jobs_list->mJobs[$i]['location'].'
							</p>
							<p class="">
								- Date Posted: ';
								$d = strtotime($jobs_list->mJobs[$i]['date_posted']);
								echo date('d', $d) . ' ' . date('M', $d) . ', ' . date('Y', $d);
								$today = date('Y-m-d');
								if ($jobs_list->mJobs[$i]['date_of_expiration'] < $today) {
									echo '<span class="grey-text text-darken-2">&nbsp; - Expired</span>';
								}
								echo '
							</p>';
							if ($jobs_list->mJobs[$i]['jobs_count'] > 1) {
						        echo '
							    <p class="">- '.$jobs_list->mJobs[$i]['company_name'].' has '.($jobs_list->mJobs[$i]['jobs_count']-1).' more job(s)</p>';
						    }
							echo '
							</div>
							<div class="card-action" id="save_job_functionality'.$i.'">';
							if (Customer::GetCurrentCustomerId() != 0) {
								echo '
								<h5>
								<a class="waves-effect waves-red grey-text text-darken-2 modal-trigger" href="#front_modal_'.$i.'" style="position:absolute;top:0px;left:10%">
									<i class="fas fa-hashtag"></i>
								</a>
								</h5>';
							}
							else {
								echo '
								<h5>
								<a class="waves-effect waves-red grey-text text-darken-2 modal-trigger" href="#!" style="position:absolute;top:0px;left:10%">
									<i class="fas fa-hashtag tag_'.$i.'"></i>
								</a>
								</h5>
								<script>
									$(document).ready(function() {
										$("#save_job_functionality'.$i.'").on("click", ".tag_'.$i.'", function(event){
											event.preventDefault();
											window.location.href = "'.$jobs_list->mLinkToLoginPage.'";
										});
									});
								</script>';
							}
							echo '
							<h5 style="cursor:pointer;">';
								echo '<i class="material-icons save_job_plus_icon_'.$i.' grey-text text-darken-2 scale-transition ';
								if ($jobs_list->mJobs[$i]['card_color'] == 'red') {
									echo 'scale-out';
								}
								else {
									echo 'scale-in';
								}

								echo '" style="position:absolute;top:0px;right:10%">favorite_border</i>';
								echo '<i class="material-icons save_job_minus_icon_'.$i.' red-text text-lighten-2 scale-transition ';
								if ($jobs_list->mJobs[$i]['card_color']  !== 'red') {
									echo 'scale-out';
								}
								else {
									echo 'scale-in';
								}
								
								echo '" style="position:absolute;top:0px;right:10%">favorite</i>';
							echo '
							</h5>
							</div>
							</div>
							<script>
								$(document).ready(function() {
									$(".card_content_'.$i.'").click(function(event) {
										window.location.href = "'.$jobs_list->mJobs[$i]['link_to_job'].'";
									});
									$("#save_job_functionality'.$i.'").on("click", ".save_job_plus_icon_'.$i.'", function(){
										$(".save_job_plus_icon_'.$i.'").removeClass("scale-in").addClass("scale-out");
										var badgeText = $(".badge").text(); 
										badgeText++;
										$(".badge").text(badgeText);
										// $("#save_job_functionality'.$i.'").prepend("<i class=\"fas fa-minus-circle save_job_minus_icon_'.$i.' teal-text text-darken-2 scale-transition scale-in right\"></i>");
										$(".save_job_minus_icon_'.$i.'").removeClass("scale-out").addClass("scale-in");
										M.toast({html: "Sucessfully saved &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$jobs_list->mLinkToCartPage.'\">view saved job</a>"});
										$.post("'.VIRTUAL_LOCATION.'cart-details",
										{CartAction: '.ADD_JOB.', JobId: '.$jobs_list->mJobs[$i]['job_id'].'},
										function(data) {
											// nothing
										})
									});
									$("#save_job_functionality'.$i.'").on("click", ".save_job_minus_icon_'.$i.'", function(){
										$(".save_job_minus_icon_'.$i.'").removeClass("scale-in").addClass("scale-out");
										$(".badge").text((($(".badge").text()) - 1));
										// $("#save_job_functionality'.$i.'").prepend("<i class=\"fas fa-plus-circle save_job_plus_icon_'.$i.' teal-text text-darken-2 scale-transition scale-in right\"></i>");
										$(".save_job_plus_icon_'.$i.'").removeClass("scale-out").addClass("scale-in");
										M.toast({html: "Sucessfully removed"});
										$.post("'.VIRTUAL_LOCATION.'cart-details",
										{CartAction: '.REMOVE_JOB.', JobId: '.$jobs_list->mJobs[$i]['job_id'].'},
										function(data) {
											
										})
									}); 
								});	
							</script>
						</div>
						';
					}
		echo '</div>';
			for ($i=0; $i<count($jobs_list->mJobs); $i++) {
				echo '
					<div id="front_modal_'.$i.'" class="modal">
						<div class="row">
							<form class="col s12 l8 offset-l2">
								<div class="modal-content">
									<h6 class="grey-text text-darken-2 left"><span class="modal-close front_modal_close_'.$i.' red-text text-lighten-2"><i class="fas fa-arrow-left"></i></span></h6>
										<br><br>
									<h6 class="teal truncate white-text" style="padding:8px;" title="tag '.$jobs_list->mJobs[$i]['position_name'].' at '.$jobs_list->mJobs[$i]['company_name'].'">
										<small>
											<a class="white-text" href="'.$jobs_list->mJobs[$i]['link_to_popular_tags_page'].'"><i class="fas fa-hashtag"></i> &nbsp;'.$jobs_list->mJobs[$i]['position_name'].' at '.$jobs_list->mJobs[$i]['company_name'].'
											</a>
										</small>
									</h6>
									<br>
									<div class="row">
										<div class="input-field col s12">
											<textarea placeholder="Have you head any news about this job?" id="post_to_your_profile_'.$i.'" type="text" class="materialize-textarea front_post_with_tag_'.$i.'"></textarea>
												<label for="post_to_your_profile_'.$i.'">Compose post</label>
										</div>
									</div>
								</div>
								<div class="center">
									<a href="#!" id="front_button_submit_post_'.$i.'" class="center btn-small btn-flat white-text red lighten-2">POST</a>
								</div> 
							</form>
						</div>
					</div>
					<script>
						$(document).ready(function() {
							$("#front_modal_'.$i.'").on("click", "#front_button_submit_post_'.$i.'", function(event){
								event.preventDefault();
								var post_with_tag = $(".front_post_with_tag_'.$i.'").val();
								if (post_with_tag.length == 0) {
									return;
								}
								$.post("'.$jobs_list->mLinkToAllJobs.'",
								{Button_Post_With_Tag: "", Post: post_with_tag, JobId: '.$jobs_list->mJobs[$i]['job_id'].'},
								function(data) {
									$(".front_modal_close_'.$i.'").click();
									$(".front_post_with_tag_'.$i.'").val("");
									M.textareaAutoResize($(".front_post_with_tag_'.$i.'"));
									M.toast({html: "Posted successfully &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$jobs_list->mLinkToUserProfile.'\">view post</a>"});
								})
							});
						});
					</script>';
			}
			echo '
			</div>
		</div>';
					        //echo '<div class=\'onesignal-customlink-container\'></div>
					        //<br>';
	}
?>