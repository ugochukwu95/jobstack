<?php
	require_once PRESENTATION_DIR . 'company_details.php';
	$company_details = new CompanyDetails();
	$company_details->init();
	echo '
	<div class="row">
		<div class="col s12 l12">
			<div class="card" style="">
				<div class="card-image waves-effect waves-block waves-light">
					<div class="container">
					<br><br>
    					<div class="col s6 offset-s3">
    					    <img class="responsive-img" src="'.$company_details->mCompany['image'].'" alt="'.$company_details->mCompany['name'].' logo">
    					</div>
					</div>
				</div>
				<div class="card-content" style="margin-top:20px;">
					<span class="card-title grey-text text-darken-2 center">'.$company_details->mCompany['name'].'</span>
				</div>
			</div>
		</div>
		<div class="col s12 l12">
			<div class="card white" style="overflow-y:auto;">
				<div class="card-content grey-text text-darken-2 flow-text" style="overflow-y:auto;">
					<h5 class="grey-text text-darken-2">About Company</h5>
					<div class="divider"></div>
					<br>';
					if (!empty($company_details->mCompany['company_description'])) {
						echo '<p class="">'.$company_details->mCompany['company_description'].'</p>';
					}
					else {
						echo '<p class="">Nothing to show.</p>';
					}
				echo '
				</div>';
				if (!empty($company_details->mCompany['link'])) { 
					echo '
					<div class="card-action">
						<a href="'.$company_details->mCompany['link'].'" class="btn-flat red lighten-2 white-text" title="company website" target="_blank">FIND OUT MORE</a>
					</div>';
				}
			echo '
			</div>
		</div>
	</div>
	';
	if (!empty($company_details->mJobs)) {
		if (count($company_details->mJobs) == 1) {
			$word = 'job';
		}
		else {
			$word = 'jobs';
		}
		echo '
		<div class="row">
			<div class="col s12">					
			    <h5 class="grey-text text-darken-2 center">'.count($company_details->mJobs).' '.$word.' at '.$company_details->mCompany['name'].'</h5>
						<br>
						<div class="flex-container card_item">';
							for ($i=0; $i<count($company_details->mJobs); $i++) {
								echo '
								<div class="flex-item">
									<div class="card white z-depth-1 hoverable small">
										<div class="card-content white-text job_card_'.$i.'" style="cursor:pointer;">
											<h5 class=""><a class="grey-text text-darken-2" href="'.$company_details->mJobs[$i]['link_to_job'].'">'.$company_details->mJobs[$i]['position_name'].' at<br>'.$company_details->mJobs[$i]['company_name'].'</a></h5>
											<br>
											<p style="position:relative;" class="grey-text text-darken-2">- '.$company_details->mJobs[$i]['location'].'</p>
											<p class="grey-text text-darken-2">
												- Date Posted: ';
												$d = strtotime($company_details->mJobs[$i]['date_posted']);
												echo date('d', $d) . 'th ' . date('M', $d) . ', ' . date('Y', $d);
												echo '</span>';
												$today = date('Y-m-d');
												if ($company_details->mJobs[$i]['date_of_expiration'] < $today) {
													echo ' - Expired';
												}
												echo '
											</p>
										</div>
										<div class="card-action" id="save_job_functionality'.$i.'" style="cursor:pointer;">
											<h5>';
												echo '
												<a class="waves-effect waves-red grey-text text-darken-2 modal-trigger" href="#front_modal_'.$i.'" style="position:absolute;top:0px;left:10%">
													<i class="fas fa-hashtag"></i>
												</a>';
											echo '
											</h5>
											<h5>';
												echo '<i class="material-icons save_job_plus_icon_'.$i.' grey-text text-darken-2 scale-transition ';
												if ($company_details->mJobs[$i]['card_color'] == 'red') {
													echo 'scale-out';
												}
												else {
													echo 'scale-in';
												}

												echo '" style="position:absolute;top:0px;right:25px">favorite_border</i>';
												echo '<i class="material-icons save_job_minus_icon_'.$i.' red-text text-darken-2 scale-transition ';
												if ($company_details->mJobs[$i]['card_color']  !== 'red') {
													echo 'scale-out';
												}
												else {
													echo 'scale-in';
												}
												
												echo '" style="position:absolute;top:0px;right:25px">favorite</i>';
											echo '
											</h5>
										</div>
									</div>
									<script>
										$("#save_job_functionality'.$i.'").on("click", ".save_job_plus_icon_'.$i.'", function(){
										    $(".save_job_plus_icon_'.$i.'").removeClass("scale-in").addClass("scale-out");
												var badgeText = $(".badge").text();
												badgeText++;
												$(".badge").text(badgeText);
												// $("#save_job_functionality'.$i.'").prepend("<i class=\"material-icons save_job_minus_icon_'.$i.' teal-text text-darken-2 scale-transition scale-in right\">favorite</i>");
												$(".save_job_minus_icon_'.$i.'").removeClass("scale-out").addClass("scale-in");
												M.toast({html: "Sucessfully saved  &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$company_details->mLinkToCartPage.'\">view saved job</a>"});
											$.post("'.VIRTUAL_LOCATION.'cart-details",
											{CartAction: '.ADD_JOB.', JobId: '.$company_details->mJobs[$i]['job_id'].'},
											function(data) {
												// nothing
											})
										});
										$("#save_job_functionality'.$i.'").on("click", ".save_job_minus_icon_'.$i.'", function(){
										    $(".save_job_minus_icon_'.$i.'").removeClass("scale-in").addClass("scale-out");
												$(".badge").text((($(".badge").text()) - 1));
												// $("#save_job_functionality'.$i.'").prepend("<i class=\"material-icons save_job_plus_icon_'.$i.' teal-text text-darken-2 scale-transition scale-in right\">favorite_border</i>");
												$(".save_job_plus_icon_'.$i.'").removeClass("scale-out").addClass("scale-in");
												M.toast({html: "Sucessfully removed"});
											$.post("'.VIRTUAL_LOCATION.'cart-details",
											{CartAction: '.REMOVE_JOB.', JobId: '.$company_details->mJobs[$i]['job_id'].'},
											function(data) {
												// nothing
											})
										});
									</script>
									<script>
									    $(".card_item").on("click", ".job_card_'.$i.'", function() {
									        window.location.href = "'.$company_details->mJobs[$i]['link_to_job'].'";
									    });
									</script>
								</div>';
							}
					echo '</div>';
					for ($i=0; $i<count($company_details->mJobs); $i++) {
						echo '
							<div id="front_modal_'.$i.'" class="modal">
								<div class="row">
									<form class="col s12 l8 offset-l2">
										<div class="modal-content">
											<h6 class="grey-text text-darken-2 center"><span class="modal-close front_modal_close_'.$i.' red-text text-lighten-2"><i class="fas fa-arrow-left"></i></span> &nbsp;Compose post: tag job</h6>
												<br>
											<h6 class="teal truncate white-text" style="padding:8px;" title="tag '.$company_details->mJobs[$i]['position_name'].' at '.$company_details->mJobs[$i]['company_name'].'">
												<small>
													<a class="white-text" href="'.$company_details->mJobs[$i]['link_to_popular_tags_page'].'"><i class="fas fa-tag"></i> &nbsp;'.$company_details->mJobs[$i]['position_name'].' at '.$company_details->mJobs[$i]['company_name'].'
													</a>
												</small>
											</h6>
											<br>
											<div class="row">
												<div class="input-field col s12">
													<textarea id="post_to_your_profile_'.$i.'" type="text" class="materialize-textarea front_post_with_tag_'.$i.'"></textarea>
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
								$("#front_modal_'.$i.'").on("click", "#front_button_submit_post_'.$i.'", function(event){
									event.preventDefault();
									var post_with_tag = $(".front_post_with_tag_'.$i.'").val();
									if (post_with_tag.length == 0) {
										return;
									}
									$.post("'.$company_details->mLinkToCompany.'",
									{Button_Post_With_Tag: "", Post: post_with_tag, JobId: '.$company_details->mJobs[$i]['job_id'].'},
									function(data) {
										$(".front_modal_close_'.$i.'").click();
										$(".front_post_with_tag_'.$i.'").val("");
										M.toast({html: "Posted successfully &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$company_details->mLinkToUserProfile.'\">view post</a>"});
									})
								});
							</script>';
					}
					if (count($company_details->mJobListPages) > 1) {
						echo '
						<div class="row">
							<div class="col s12">
								<ul class="pagination center">';
									for ($m = 0; $m < count($company_details->mJobListPages); $m++) {
										if ($company_details->mPage == ($m+1)) {
											echo '<li class="waves-effect active red lighten-2"><a href="'.$company_details->mJobListPages[$m].'"><small>'.($m+1).'</small></a></li>';
										}
										else {
											echo '<li class="waves-effect"><a href="'.$company_details->mJobListPages[$m].'"><small>'.($m+1).'</small></a></li>';
										}
									}
								echo '
								</ul>
							</div>
						</div>';
					}
					echo '
			</div>
		</div>
		';
	}
	else {
		echo '
		<div class="row">
			<div class="col s12">
				<div class="card white z-depth-0" style="border: 1px solid lightgrey">
					<div class="card-content grey-text text-darken-2">
						<span class="card-title grey-text text-darken-2 center"><b>Jobs at '.$company_details->mCompany['name'].'</b></span>
						<br>
						<p class="flow-text center">Nothing to show.</p>
						<br><br>
					</div>
				</div>
			</div>
		</div>
		';
	}
	include 'company_review_tpl.php'; 
?>