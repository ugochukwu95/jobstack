
<?php
	require_once PRESENTATION_DIR . 'job_details.php';
	$job_details = new JobDetails();
	$job_details->init();

	echo '
	<br>
	<div itemscope itemtype="http://schema.org/JobPosting">
	<meta itemprop="specialCommitments" content="VeteranCommit" />
	<div class="row">
		<div class="col s12 parentDiv">
			<br>
			<h5 class=" grey-text text-darken-2 center"><span itemprop="title">'.$job_details->mJob['position_name'].'</span> at <span itemprop="hiringOrganization" itemscope itemtype="http://schema.org/Organization"><span itemprop="name">'.$job_details->mJob['company_name'].'</span></span></h5>
			<br>
		</div>
	</div>
	
	<div class="row">
		<div class="col s12 m12 l12">
			<br>
			<div class="divider"></div>
			<br>';
				echo '
					<div class="row">
						<div class="col s12">
							<div class="card">';
							if (!empty($job_details->mJob['company_image'])) {
								echo '
								<div class="card-image waves-effect waves-block waves-light" onclick="location.href=\''.$job_details->mJob['link_to_company'].'\'">
									<div class="card-image">
										<div class="container">
											<br><br>
											<div class="row">
    											<div class="col s6 offset-s3">
    											<img itemprop="image" src="'.$job_details->mJob['company_image'].'" alt="'.$job_details->mJob['company_name'].' logo" class="responsive-img">
    										    <br><br>
    										    </div>
										    </div>
										</div>
									</div>
								</div>';
							}
							echo '
							    <div class="card-content flow-text" style="margin-top:20px;" class="grey-text text-darken-2">';
									    if ($job_details->mCountJobs > 1) {
									        echo '
									        <br>
									        <p class="grey-text text-darken-2">- '.$job_details->mJob['company_name'].' has '.($job_details->mCountJobs - 1).' more job(s). <a href="'.$job_details->mJob['link_to_company'].'" class="red-text text-lighten-2">Find out more.</a></p>
									        <br>
									        ';
									    }
										if (!empty($job_details->mJob['rating'])) {
											switch($job_details->mJob['rating']) {
												case 0:
												echo '<i class="far fa-star grey-text"></i><i class="far fa-star grey-text"></i><i class="far fa-star grey-text"></i><i class="far fa-star grey-text"></i><i class="far fa-star grey-text"></i>';
												break;
												case 1:
												echo '<i class="fas fa-star yellow-text text-lighten-1"></i><i class="far fa-star grey-text"></i><i class="far fa-star grey-text"></i><i class="far fa-star grey-text"></i><i class="far fa-star grey-text"></i>';
												break;
												case 2:
												echo '<i class="fas fa-star yellow-text text-lighten-1"></i><i class="fas fa-star yellow-text text-lighten-1"></i><i class="far fa-star grey-text"></i><i class="far fa-star grey-text"></i><i class="far fa-star grey-text"></i>';
												break;
												case 3:
												echo '<i class="fas fa-star yellow-text text-lighten-1"></i><i class="fas fa-star yellow-text text-lighten-1"></i><i class="fas fa-star yellow-text text-lighten-1"></i><i class="far fa-star grey-text"></i><i class="far fa-star grey-text"></i>';
												break;
												case 4:
												echo '<i class="fas fa-star yellow-text text-lighten-1"></i><i class="fas fa-star yellow-text text-lighten-1"></i><i class="fas fa-star yellow-text text-lighten-1"></i><i class="fas fa-star yellow-text text-lighten-1"></i><i class="far fa-star grey-text"></i>';
												break;
												case 5:
												echo '<i class="fas fa-star yellow-text text-lighten-1"></i><i class="fas fa-star yellow-text text-lighten-1"></i><i class="fas fa-star yellow-text text-lighten-1"></i><i class="fas fa-star yellow-text text-lighten-1"></i><i class="fas fa-star yellow-text text-lighten-1"></i>';
											}
											echo '
											<p>&nbsp;- average user rating</p>
											<br>
											<p class="red-text text-darken-2">- <a class="red-text text-lighten-2" href="'.$job_details->mLinkToMoreCompanyReviews.'">User Reviews</a></p><br>';
										}
										else {
											echo '<p class="grey-text text-darken-2">- Be the first to review: <a class="red-text text-lighten-2" href="'.$job_details->mJob['link_to_company'].'">'.$job_details->mJob['company_name'].'</a></p><br>';
										}
									echo '
									    <p class="grey-text text-darken-2">- Location: <span itemprop="jobLocation" itemscope itemtype="http://schema.org/Place"><span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="addressLocality">'.$job_details->mJob['location_name'].'</span></span></span></p>
                            			<br>
                            			<p class="grey-text text-darken-2">- Date Posted: 
                            			<span>';
                            			$d = strtotime($job_details->mJob['date_posted']);
                            			echo date('d', $d) . ' ' . date('M', $d) . ', ' . date('Y', $d);
                            			echo '</span>';
                            			$today = date('Y-m-d');
                            			if ($job_details->mJob['date_of_expiration'] < $today) {
                            				echo ' - Expired';
                            			}
                            			echo '<span itemprop="datePosted" style="visibility: hidden;">';
                            			echo date(DATE_ISO8601, strtotime($job_details->mJob['date_posted']));
                            			echo '</span>';
                            			echo
                            			'</p><br>
                            			<p class="grey-text text-darken-2">- Share on:
                            			<span><a href="#!" class="facebook_link_static" target="_blank"><i class="fab fa-facebook-square" style="padding:10px;background:#3B5998;color:white;font-size:20px;text-align:center;text-decoration:none;"></i></a></span>
                            			<span><a href="#!" class="twitter_link_static" target="_blank"><i class="fab fa-twitter" style="padding:10px;background:#55ACEE;color:white;font-size:20px;text-align:center;text-decoration:none;"></i></a></span>
                            			<span><a href="#!" class="linkedin_link_static" target="_blank"><i class="fab fa-linkedin" style="padding:10px;background:#007bb5;color:white;font-size:20px;text-align:center;text-decoration:none;"></i></a></span>
                            			<span><a href="#!" class="whatsapp_link_static" target="_blank"><i class="fab fa-whatsapp" style="padding:10px;background:lightgreen;color:white;font-size:20px;text-align:center;text-decoration:none;"></i></a></span>
                            			</p>
                            			<br>
                            			<script>
                            				$(document).ready(function() {
                            					var share_static_url = encodeURIComponent("'.$job_details->mLinkToJobDetails.'");
                            
                            					$(".facebook_link_static").attr("href", "https://www.facebook.com/sharer.php?u=" + share_static_url);
                            					$(".twitter_link_static").attr("href", "https://twitter.com/intent/tweet?url=" + share_static_url + "&hashtags=JobStack,jobs,Nigeria");
                            					$(".linkedin_link_static").attr("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_static_url + "&title='.$job_details->mLinkToJobDetails.'" + "&source=JobStack");
                            					$(".whatsapp_link_static").attr("href", "whatsapp://send?text=" + share_static_url);
                            					$(".telegram_link_static").attr("href", "https://telegram.me/share/url?url=" + share_static_url);
                            				});
                            			</script>
									</div>
									<div class="card-action">
									    ';
			
                            			if (!empty($job_details->mJob['job_link'])) {
                            				echo '
                            				<span><a itemprop="url" href="'.$job_details->mJob['job_link'].'" target="_blank" class="btn red lighten-2 white-text waves-light waves-effect">Apply</a></span>
                            				';
                            			}
                            			if ($job_details->mJob['card_color'] == 'teal') {
                            				echo '
                            				<span><button class="btn waves-light waves-effect red lighten-2 white-text save_job'.$job_details->mJob['job_id'].'">Save Job</button></span>';
                            				echo '
                            					<script>
                            						$(document).ready(function() {
                            							$(".save_job'.$job_details->mJob['job_id'].'").on("click", function() {
                            							
                            							
                            				$(".save_job'.$job_details->mJob['job_id'].'").remove();
                            									var textBadge = $(".badge").text();
                            									textBadge++;
                            									$(".badge").text(textBadge); // Alter number of saved jobs
                            									M.toast({html: "Sucessfully saved &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$job_details->mLinkToCartPage.'\">view saved job</a>"});			
                            								$.post("'.VIRTUAL_LOCATION.'cart-details", 
                            								{
                            									CartAction: '.ADD_JOB.',
                            									JobId: '.$job_details->mJob['job_id'].'
                            									}, 
                            								function(data) {
                            									// Nothing
                            								})
                            							});
                            						});
                            					</script>
                            				';
                            			}
                            		echo '
									</div>
								</div>
							</div>
						</div>
				';
		echo '
		</div>
		<div class="col s12 m12 l12">
		    <br>
			<div class="divider"></div>
			<br>
		    <div class="card white job_description_text">
		        <div class="card-content grey-text text-darken-2">
        			<div class="grey-text text-darken-2">
            			<span itemprop="description" class="flow-text">'.$job_details->mJob['job_description'].'</span>' ;
            			if (!empty($job_details->mJob['job_link'])) {
            				echo '
            				<h5>Apply</h5>
            				<br>
            				<p><a href="'.$job_details->mJob['job_link'].'" class="btn red lighten-2 white-text waves-light waves-effect" target="_blank">Apply on company site</a></p> 
            				<br><br>
            				<div class="divider"></div>
            				<br>
            				';
            			}
            			else {
            				echo '<br><div class="divider"></div>';
            			}
        		    echo '
            		    <div class="row">
            		        <div class="col s12">
            		            <small>Remember: You should never send cash or cheques to a prospective employer, or provide your bank details or any other financial information. We pay great attention to vetting all jobs that appear on our site, but 
            		            please <a href="'.$job_details->mLinkToContactDeveloper.'" class="red-text text-lighten-2">get in touch</a> if you see any roles asking for such payments or financial details from you.</small>
            		        </div>
            		    </div>
        		    </div>
    			</div>
    		</div>
		</div>
	</div>
	</div>
	<br>';
	
    if (!empty($job_details->mSimilarJobs)) {
		$jobs_list_count = count($job_details->mSimilarJobs);
		echo '
		<h5 class="center grey-text text-darken-2">Similar Jobs</h5>
		<br>';
		echo '<div class="flex-container">';
		for ($i=0; $i<count($job_details->mSimilarJobs); $i++) {
			echo '
			<div class="flex-item">
				<div class="card white hoverable small">
					<div class="card-content grey-text text-darken-2 card_content_'.$i.'" style="cursor:pointer;">';
					    /*if (!empty($job_details->mSimilarJobs[$i]['image'])) {
						    echo '
						    <div class="row">
						        <div class="col s6 offset-s3">
						        <p><img src="'.Link::Build('images/company_logo/'.$job_details->mSimilarJobs[$i]['image']).'" alt="'.$job_details->mSimilarJobs[$i]['company_name'].' logo" class="responsive-img"></p>
						        </div>
						    </div>';
						}*/
						echo '
						<h5 class=""><a class="grey-text text-darken-2" href="'.$job_details->mSimilarJobs[$i]['link_to_job'].'">'.$job_details->mSimilarJobs[$i]['position_name'].' at<br>'.$job_details->mSimilarJobs[$i]['company_name'].'</a></h5>
						<br>
						<p style="position:relative;">- '.$job_details->mSimilarJobs[$i]['location'].'</p>
						<p class="grey-text text-darken-2">
							- Date Posted: ';
							$d = strtotime($job_details->mSimilarJobs[$i]['date_posted']);
							echo date('d', $d) . ' ' . date('M', $d) . ', ' . date('Y', $d);
						
							if (date($job_details->mSimilarJobs[$i]['date_of_expiration']) < date('Y-m-d')) {
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
								<a class="waves-effect waves-red grey-text text-darken-2 modal-trigger" href="#!" style="position:absolute;top:0px;left:10%">
									<i class="fas fa-hashtag tag_'.$i.'"></i>
								</a>
								</h5>
								<script>
									$(document).ready(function() {
										$("#save_job_functionality'.$i.'").on("click", ".tag_'.$i.'", function(event){
											event.preventDefault();
											window.location.href = "'.$job_details->mLinkToLoginPage.'";
										});
									});
								</script>';
							}
							echo '
							<h5 style="cursor:pointer;">';
								echo '<i class="material-icons save_job_plus_icon_'.$i.' grey-text text-darken-2 scale-transition ';
								if ($job_details->mSimilarJobs[$i]['card_color'] == 'red') {
									echo 'scale-out';
								}
								else {
									echo 'scale-in';
								}

								echo '" style="position:absolute;top:0px;right:10%">favorite_border</i>';
								echo '<i class="material-icons save_job_minus_icon_'.$i.' red-text text-darken-2 scale-transition ';
								if ($job_details->mSimilarJobs[$i]['card_color']  !== 'red') {
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
									window.location.href = "'.$job_details->mSimilarJobs[$i]['link_to_job'].'";
								});
								$("#save_job_functionality'.$i.'").on("click", ".save_job_plus_icon_'.$i.'", function(){
									$(".save_job_plus_icon_'.$i.'").removeClass("scale-in").addClass("scale-out");
									var badgeText = $(".badge").text();
									badgeText++;
									$(".badge").text(badgeText);
									// $("#save_job_functionality'.$i.'").prepend("<i class=\"material-icons save_job_minus_icon_'.$i.' teal-text text-darken-2 scale-transition scale-in right\">favorite</i>");
									$(".save_job_minus_icon_'.$i.'").removeClass("scale-out").addClass("scale-in");
									M.toast({html: "Sucessfully saved &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$job_details->mLinkToCartPage.'\">view saved job</a>"});
									$.post("'.$job_details->mSiteUrl.'cart-details",
									{CartAction: '.ADD_JOB.', JobId: '.$job_details->mSimilarJobs[$i]['job_id'].'},
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
									$.post("'.$job_details->mSiteUrl.'cart-details",
									{CartAction: '.REMOVE_JOB.', JobId: '.$job_details->mSimilarJobs[$i]['job_id'].'},
									function(data) {
										// nothing
									})
								});
							});
						</script>
					</div>
					<div id="modal_'.$i.'" class="modal">
						<div class="row">
							<form class="col s12 l8 offset-l2">
								<div class="modal-content">
									<h6 class="grey-text text-darken-2 center"><span class="modal-close modal_close_'.$i.' red-text text-lighten-2"><i class="fas fa-arrow-left"></i></span> &nbsp;Compose post: tag job</h6>
										<br>
									<h6 class="teal truncate white-text" style="padding:8px;" title="tag '.$job_details->mSimilarJobs[$i]['position_name'].' at '.$job_details->mSimilarJobs[$i]['company_name'].'">
										<small>
											<a class="white-text" href="'.$job_details->mSimilarJobs[$i]['link_to_job'].'"><i class="fas fa-hashtag"></i> &nbsp;'.$job_details->mSimilarJobs[$i]['position_name'].' at '.$job_details->mSimilarJobs[$i]['company_name'].'
											</a>
										</small>
									</h6>
									<br>
									<div class="row">
										<div class="input-field col s12">
											<textarea id="post_to_your_profile_'.$i.'" type="text" class="materialize-textarea post_with_tag_'.$i.'"></textarea>
												<label for="post_to_your_profile_'.$i.'">Compose post</label>
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
								M.toast({html: "Posted successfully &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$job_details->mLinkToUserProfile.'\">view post</a>"});
								$.post("'.$job_details->mLinkToJobDetails.'",
								{Button_Post_With_Tag: "", Post: post_with_tag, JobId: '.$job_details->mSimilarJobs[$i]['job_id'].'},
								function(data) {
									// nothing
								})
							});
						});
					</script>
				';
			}
		echo '</div>';
	}
	if (!is_null($job_details->mLinkToSearchResults)) {
	    echo '<br><p class="center"><a href="'.$job_details->mLinkToSearchResults.'" class="btn red lighten-2 white-text waves-light eaves-effect">More Similar Jobs</a></p><br>';
	}
	echo '
	<div class="row hide-on-large-only">
	    <div class="col s12">
	    <!-- Trending locations functionality -->
		<div class="trending_stuff">
    		<ul class="collection with-header white lighten-5 z-depth-1" style="border-top:none;border-radius:8px;">
    		    <li class="collection-header white lighten-5"><h5 class="center grey-text text-darken-2"><strong>Highest Hiring Locations</strong></h5></li>';
        		for ($i=0; $i<count($job_details->mTrendingLocations); $i++) {
        		    echo '
                    <li class="collection-item white lighten-5 link_to_job_'.$i.'">
                    <small class="grey-text text-darken-1">'.($i+1).' Trending</small><br>
                    <a href="'.$job_details->mTrendingLocations[$i]['link_to_location'].'" class="grey-text text-darken-4">
                    <strong>Jobs in '.$job_details->mTrendingLocations[$i]['location_name'].'</strong></a><br>
                    <span class="grey-text text-darken-2">'.$job_details->mTrendingLocations[$i]['jobs_count'].' jobs</span></li>
        		    ';
        		}
    		echo '
    		</ul>
    		<br><br>
    		<ul class="collection with-header white lighten-5 z-depth-1" style="border-top:none;border-radius:8px;">
    		    <li class="collection-header white lighten-5"><h5 class="center grey-text text-darken-2"><strong>Highest Hiring Companies</h5></strong></li>';
    		    for ($i=0; $i<count($job_details->mTrendingCompanies); $i++) {
    		        echo '
    		        <li class="collection-item avatar white lighten-5 link_to_company_'.$i.'">
    		        <img src="'.$job_details->mTrendingCompanies[$i]['image'].'" alt="'.$job_details->mTrendingCompanies[$i]['company_name'].'. logo" class="circle">
    		        <span class="title grey-text text-darken-2"><a href="'.$job_details->mTrendingCompanies[$i]['link_to_company'].'" class="grey-text text-darken-4">
    		            <strong>Jobs at '.$job_details->mTrendingCompanies[$i]['company_name'].'</a></strong></span>
    		        <p class="grey-text text-darken-1">'.$job_details->mTrendingCompanies[$i]['jobs_count'].' jobs</p></li>';
    		    }
    		echo '
    		</ul>
    	</div>';
    		for ($i=0; $i<count($job_details->mTrendingLocations); $i++) {
    		   echo '
    		   <script>
    		        $(document).ready(function() {
    		            $(".trending_stuff").on("click", ".link_to_job_'.$i.'", function(){
    		                window.location.href = "'.$job_details->mTrendingLocations[$i]['link_to_location'].'";
    		            });
    		        });
    		   </script>
    		   '; 
    		}
    		for ($i=0; $i<count($job_details->mTrendingCompanies); $i++) {
    		   echo '
    		   <script>
    		        $(document).ready(function() {
    		            $(".trending_stuff").on("click", ".link_to_company_'.$i.'", function(){
    		                window.location.href = "'.$job_details->mTrendingCompanies[$i]['link_to_company'].'";
    		            });
    		        });
    		   </script>
    		   '; 
    		}
	echo '
	    </div>
	</div>
	<br>
		<div class="row">
			<div class="col s12 l12">
			    <h5 class=" center grey-text text-darken-2">Trending Chatter</h5>
		        <br>
				<div class="card">
					<div class="card-content teal lighten-1 white-text content_chatter" style="cursor:pointer;">
						<p class="center">
    						<a href="'.$job_details->mLinkToPopularTags.'" class="white teal-text btn-large btn-floating center pulse">
    							<i class="fas fa-hashtag teal-text"></i>
    						</a>
						</p>
						<br>
						<p class="center flow-text">Do you want to say anything about this job posting? Join the <a href="'.$job_details->mLinkToPopularTags.'" class="white-text text-darken-2"><u>conversation</u></a> to find out <a href="'.$job_details->mLinkToPopularTags.'" class="white-text"><u>more</u></a> about this job, what other users are saying, and what '.$job_details->mJob['company_name'].' has been up to.</p>
						<br>
					</div>';
				if (empty($job_details->mRelatedPosts)) {
					echo '
					</div></div>
					';
				}
				elseif (!empty($job_details->mRelatedPosts)) {
					echo '
					<div class="card-tabs teal lighten-1 white-text">
						<ul class="tabs tabs-fixed-width teal lighten-1 white-text">';
						for($i=0; $i<count($job_details->mRelatedPosts); $i++) {
							echo '
							<li class="tab"><a href="#test'.$i.'" class="white-text">Post '.($i+1).'</a></li>
							';
						}
					echo 
						'</ul>
					</div>
					<div class="card-content white grey-text text-darken-2">';
						for($i=0; $i<count($job_details->mRelatedPosts); $i++) {
							echo '
							<div id="test'.$i.'">
								<p style="position:relative;">
									<span>';
										if (empty($job_details->mRelatedPosts[$i]['avatar'])) {
											echo '
											<a href="'.$job_details->mRelatedPosts[$i]['link_to_user'].'" class="white-text">
												<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
													<span class="white-text" style="font-size:15px;"><b>'.substr($job_details->mRelatedPosts[$i]['handle'], 0, 1).'</b></span>
												</span>
											</a>';
										}
										else {
											echo '
											<a href="'.$job_details->mRelatedPosts[$i]['link_to_user'].'">
												<img src="'.$job_details->mSiteUrl.'images/profile_pictures/'.$job_details->mRelatedPosts[$i]['avatar'].'" alt="'.$job_details->mRelatedPosts[$i]['handle'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;" />
											</a>
											';
										} 
			 						echo '
									</span>
									<span class="grey-text text-darken-2" style="position:absolute;left:27px;top:0;">
										<b>&nbsp;<a href="'.$job_details->mRelatedPosts[$i]['link_to_user'].'" class="grey-text text-darken-2">
												'.$job_details->mRelatedPosts[$i]['handle'].'
										</a></b>
									</span>
									<span class="grey-text text-darken-2" style="position:absolute;top:20px;left:27px;">
										&nbsp;&nbsp;posted <span data-livestamp="'.date('Y-m-d H:i:s', strtotime($job_details->mRelatedPosts[$i]['date_posted'])).'"></span>
									</span>';
									echo '
								</p>';
								echo '
								<br><br>
								<span style="white-space:pre-line;"><a id="postOnlineText'.$i.'" href="'.$job_details->mRelatedPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2">'.$job_details->mRelatedPosts[$i]['post'].'</a></span>
								<script>
									$(document).ready(function() {
										var fullReviewText'.$i.' = $("#postOnlineText'.$i.'").text();
										if ($("#postOnlineText'.$i.'").html().length > 350) {
											var extractText = $("#postOnlineText'.$i.'").html().substring(0, 350);
											$("#postOnlineText'.$i.'").text(extractText + "...").append("<a href=\"#!\" class=\"grey-text text-darken-2 moreButton'.$i.'\">Read more</a><br><br>");
										}
										$("#test'.$i.'").on("click", ".moreButton'.$i.'", function(event) {
											event.preventDefault();
											$("#postOnlineText'.$i.'").text(fullReviewText'.$i.');
										});
									});
								</script>
								<br><br>';
								if (!empty($job_details->mRelatedPosts[$i]['post_images']) || !is_null($job_details->mRelatedPosts[$i]['post_images'])) {
									for ($m=0; $m<count($job_details->mRelatedPosts[$i]['post_images']); $m++) {
										if (count($job_details->mRelatedPosts[$i]['post_images']) == 1) {
											echo '
												<div class="row">
													<div class="col s12">
														<img src="'.$job_details->mSiteUrl.'/images/post_images/'.$job_details->mRelatedPosts[$i]['post_images'][$m]['image'].'" alt="'.$job_details->mRelatedPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;margin:auto;display:block;" />
													</div>
												</div>
											';
										}
										if (count($job_details->mRelatedPosts[$i]['post_images']) == 2) {
											if ($m == 0) {
												echo '<div class="row">';
											}
											echo '
												<div class="col s6 m6 l6">
													<img src="'.$job_details->mSiteUrl.'/images/post_images/'.$job_details->mRelatedPosts[$i]['post_images'][$m]['image'].'" alt="'.$job_details->mRelatedPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
												</div>
											';
											if ($m == 1) {
												echo '</div>';
											}
										}
										if (count($job_details->mRelatedPosts[$i]['post_images']) == 3) {
											if ($m == 0) {
												echo '<div class="row">';
											}
											if ($m == 0 || $m == 1)
											echo '
												<div class="col s6 m6 l6">
													<img src="'.$job_details->mSiteUrl.'/images/post_images/'.$job_details->mRelatedPosts[$i]['post_images'][$m]['image'].'" alt="'.$job_details->mRelatedPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
												</div>
											';
											if ($m == 1) {
												echo '</div>';
											}
											if ($m == 2) {
												echo '
												<div class="row">
													<div class="col s12">
														<img src="'.$job_details->mSiteUrl.'/images/post_images/'.$job_details->mRelatedPosts[$i]['post_images'][$m]['image'].'" alt="'.$job_details->mRelatedPosts[$i]['post_images'][$m]['image'].'  picture" class="responsive-img materialboxed" style="border-radius:4px;" />
													</div>
												</div>
												';
											}
										}
										if (count($job_details->mRelatedPosts[$i]['post_images']) == 4) {
											if ($m == 0 || $m == 2) {
												echo '<div class="row">';
											}
											echo '
												<div class="col s6 m6 l6">
													<img src="'.$job_details->mSiteUrl.'/images/post_images/'.$job_details->mRelatedPosts[$i]['post_images'][$m]['image'].'" alt="'.$job_details->mRelatedPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
												</div>
											';
											if ($m == 1 || $m == 3) {
												echo '</div>';
											}
										}
									}
								}
								echo '
								<div class="divider"></div>
								<div style="position:relative;" id="like_functionality_'.$i.'">';
									echo '
									<a href="'.$job_details->mRelatedPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2"><span class="fas fa-comment"></span> '.$job_details->mRelatedPosts[$i]['comments_count'].'</a>';
									if (!is_null($job_details->mCustomerId)) {
										echo '
										<span style="position:absolute;left:46%;" id="like_post_functionality_'.$i.'" class="scale-transition ';
											if ($job_details->mRelatedPosts[$i]['is_liked'] == 'yes') {
												echo 'scale-out';
											}
											else {
												echo 'scale-in';
											}
											echo '
											">
												<i class="fas fa-thumbs-up like_post_grey_'.$i.'"></i>
										</span>
										<span style="position:absolute;left:46%;" id="dislike_post_functionality_'.$i.'" class="scale-transition ';
											if ($job_details->mRelatedPosts[$i]['is_liked'] == 'yes') {
												echo 'scale-in';
											}
											else {
												echo 'scale-out';
											}
											echo ' 
											">
											<i class="fas fa-thumbs-up red-text text-darken-2 like_post_red_'.$i.'"></i>
										</span>';
									}
									else {
										echo '
										<span style="position:absolute;left:46%;">
											<i class="fas fa-thumbs-up like_post_grey_'.$i.'"></i>
										</span>';
									}
									echo '
									<span style="position:absolute;left:51%;" id="liked_text_'.$i.'"> &nbsp;'.$job_details->mRelatedPosts[$i]['total_likes'].'</span>';
									if (!is_null($job_details->mCustomerId)) {
										echo '
										<script>
											$(document).ready(function() {
												$("#like_functionality_'.$i.'").on("click", "#like_post_functionality_'.$i.'", function(){
													$("#like_post_functionality_'.$i.'").removeClass("scale-in").addClass("scale-out");
													var liked_text = $("#liked_text_'.$i.'").text();
													liked_text++;
													$("#liked_text_'.$i.'").html(" &nbsp;" + liked_text);
													$("#dislike_post_functionality_'.$i.'").removeClass("scale-out").addClass("scale-in");
													$.post("'.$job_details->mLinkToJobDetails.'",
													{Like: "Like", PostId: '.$job_details->mRelatedPosts[$i]['post_id'].'},
													function(data) {
														// nothing
													}
													)
												});
												$("#like_functionality_'.$i.'").on("click", "#dislike_post_functionality_'.$i.'", function(){
													$("#like_post_functionality_'.$i.'").removeClass("scale-out").addClass("scale-in");
													var disliked_text = $("#liked_text_'.$i.'").text();
													disliked_text--;
													$("#liked_text_'.$i.'").html(" &nbsp;" + disliked_text);
													$("#dislike_post_functionality_'.$i.'").removeClass("scale-in").addClass("scale-out");
													$.post("'.$job_details->mLinkToJobDetails.'",
													{Dislike: "Dislike", PostId: '.$job_details->mRelatedPosts[$i]['post_id'].'},
													function(data) {
														// nothing
													}
													)
												});
											});
										</script>';
									}
									else {
										echo '
										<script>
											$(document).ready(function() {
												$("#like_functionality_'.$i.'").on("click", ".like_post_grey_'.$i.'", function(event){
													event.preventDefault();
													window.location.href = "'.$job_details->mLinkToLoginPage.'";
												});
											});
										</script>';
									}
									echo '
									<span class="right share_dropdown-trigger_'.$i.'" data-target="share_dropdown_'.$i.'"><span class="fas fa-share"></span> Share</span>
									<ul id="share_dropdown_'.$i.'" class="dropdown-content">
										<li><a href="#!" class="facebook_link_'.$i.'" target="_blank"><b><small><i class="fab fa-facebook-square"></i> Facebook</small></b></a></li>
										<li><a href="#!" target="_blank" class="twitter_link_'.$i.'"><b><small><i class="fab fa-twitter"></i> Twitter</small></b></a></li>
										<li><a href="#!" target="_blank" class="linkedin_link_'.$i.'"><b><small><i class="fab fa-linkedin"></i> LinkedIn</small></b></a></li>
										<li><a href="#!" target="_blank" class="whatsapp_link_'.$i.'" data-action="share/whatsapp/share"><b><small><i class="fab fa-whatsapp"></i> WhatsApp</small></b></a></li>
										<li><a href="#!" target="_blank" class="telegram_link_'.$i.'"><b><small><i class="fab fa-telegram"></i> Telegram</small></b></a></li>
									</ul>
									<script>
										$(document).ready(function() {
											$(".share_dropdown-trigger_'.$i.'").dropdown();
											var share_url = encodeURIComponent("'.$job_details->mRelatedPosts[$i]['link_to_post_details'].'");

											$(".facebook_link_'.$i.'").attr("href", "https://www.facebook.com/sharer.php?u=" + share_url);
											$(".twitter_link_'.$i.'").attr("href", "https://twitter.com/intent/tweet?url=" + share_url + "&hashtags=JobStack,jobs,Nigeria");
											$(".linkedin_link_'.$i.'").attr("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_url + "&title='.$job_details->mRelatedPosts[$i]['handle'].'" + "&source=JobStack");
											$(".whatsapp_link_'.$i.'").attr("href", "whatsapp://send?text=" + share_url);
											$(".telegram_link_'.$i.'").attr("href", "https://telegram.me/share/url?url=" + share_url);
										});
									</script>
								</div>';
							echo '
							</div>
							';
						}
					echo '
					</div>
				</div>
			</div>
		';
	}

	echo '
	<script>
		$(document).ready(function(){
		    $(".content_chatter").click(function() {
		        window.location.href = "'.$job_details->mLinkToPopularTags.'";
		    });
		});
    </script>
		<div class="col s12 l12">
		    <h5 class=" center grey-text text-darken-2">CVs, Cover Letters, Applications</h5>
		    <br>
			<div class="card">
		        <div class="card-image">
		          <img src="'.$job_details->mLinkToWebsiteImage.'" id="cv_image" class="responsive-img" style="cursor:pointer;">
		        </div>
		        <script>
		            $(document).ready(function() {
		                $("#cv_image").click(function() {
		                    window.location.href = "'.$job_details->mLinkToCareerService.'"; 
		                });
		            });
		        </script>
		        <div class="card-content">
		          <p class="flow-text">Grab the recruiter\'s attention using your CV, application or LinkedIn profile.</p>
		          <small>Sponsored content by our friends at <a href="https://www.ncl.ac.uk/careers/applications/cv/" class="red-text text-lighten-2" target="_blank">Newcastle University</a>.</small>
		        </div>
		        <div class="card-action">
		          <a href="'.$job_details->mLinkToCareerService.'" class="btn red lighten-2 white-text waves-light waves-effect">Find out more</a>
		        </div>
		    </div>
		</div>
	</div>
	<br>
	';

	if (!empty($job_details->mRecommendedJobs)) {
		$jobs_list_count = count($job_details->mRecommendedJobs);
		echo '
		<h5 class="center grey-text text-darken-2">Recommended Jobs</h5>
		<br>';
		echo '<div class="flex-container">';
		for ($i=0; $i<count($job_details->mRecommendedJobs); $i++) {
			echo '
			<div class="flex-item">
				<div class="card white hoverable small">
					<div class="card-content grey-text text-darken-2 card_content_'.$i.'" style="cursor:pointer;">';
					    /*if (!empty($job_details->mRecommendedJobs[$i]['image'])) {
						    echo '
						    <div class="row">
						        <div class="col s6 offset-s3">
						        <p><img src="'.Link::Build('images/company_logo/'.$job_details->mRecommendedJobs[$i]['image']).'" alt="'.$job_details->mRecommendedJobs[$i]['company_name'].' logo" class="responsive-img"></p>
						        </div>
						    </div>';
						}*/
						echo '
						<h5 class=""><a class="grey-text text-darken-2" href="'.$job_details->mRecommendedJobs[$i]['link_to_job'].'">'.$job_details->mRecommendedJobs[$i]['position_name'].' at<br>'.$job_details->mRecommendedJobs[$i]['company_name'].'</a></h5>
						<br>
						<p style="position:relative;">- '.$job_details->mRecommendedJobs[$i]['location'].'</p>
						<p class="grey-text text-darken-2">
							- Date Posted: ';
							$d = strtotime($job_details->mRecommendedJobs[$i]['date_posted']);
							echo date('d', $d) . ' ' . date('M', $d) . ', ' . date('Y', $d);
						
							if (date($job_details->mRecommendedJobs[$i]['date_of_expiration']) < date('Y-m-d')) {
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
								<a class="waves-effect waves-red grey-text text-darken-2 modal-trigger" href="#!" style="position:absolute;top:0px;left:10%">
									<i class="fas fa-hashtag tag_'.$i.'"></i>
								</a>
								</h5>
								<script>
									$(document).ready(function() {
										$("#save_job_functionality'.$i.'").on("click", ".tag_'.$i.'", function(event){
											event.preventDefault();
											window.location.href = "'.$job_details->mLinkToLoginPage.'";
										});
									});
								</script>';
							}
							echo '
							<h5 style="cursor:pointer;">';
								echo '<i class="material-icons save_job_plus_icon_'.$i.' grey-text text-darken-2 scale-transition ';
								if ($job_details->mRecommendedJobs[$i]['card_color'] == 'red') {
									echo 'scale-out';
								}
								else {
									echo 'scale-in';
								}

								echo '" style="position:absolute;top:0px;right:10%">favorite_border</i>';
								echo '<i class="material-icons save_job_minus_icon_'.$i.' red-text text-darken-2 scale-transition ';
								if ($job_details->mRecommendedJobs[$i]['card_color']  !== 'red') {
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
									window.location.href = "'.$job_details->mRecommendedJobs[$i]['link_to_job'].'";
								});
								$("#save_job_functionality'.$i.'").on("click", ".save_job_plus_icon_'.$i.'", function(){
									$(".save_job_plus_icon_'.$i.'").removeClass("scale-in").addClass("scale-out");
									var badgeText = $(".badge").text();
									badgeText++;
									$(".badge").text(badgeText);
									// $("#save_job_functionality'.$i.'").prepend("<i class=\"material-icons save_job_minus_icon_'.$i.' teal-text text-darken-2 scale-transition scale-in right\">favorite</i>");
									$(".save_job_minus_icon_'.$i.'").removeClass("scale-out").addClass("scale-in");
									M.toast({html: "Sucessfully saved &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$job_details->mLinkToCartPage.'\">view saved job</a>"});
									$.post("'.$job_details->mSiteUrl.'cart-details",
									{CartAction: '.ADD_JOB.', JobId: '.$job_details->mRecommendedJobs[$i]['job_id'].'},
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
									$.post("'.$job_details->mSiteUrl.'cart-details",
									{CartAction: '.REMOVE_JOB.', JobId: '.$job_details->mRecommendedJobs[$i]['job_id'].'},
									function(data) {
										// nothing
									})
								});
							});
						</script>
					</div>
					<div id="modal_'.$i.'" class="modal">
						<div class="row">
							<form class="col s12 l8 offset-l2">
								<div class="modal-content">
									<h6 class="grey-text text-darken-2 center"><span class="modal-close modal_close_'.$i.' red-text text-lighten-2"><i class="fas fa-arrow-left"></i></span> &nbsp;Compose post: tag job</h6>
										<br>
									<h6 class="teal truncate white-text" style="padding:8px;" title="tag '.$job_details->mRecommendedJobs[$i]['position_name'].' at '.$job_details->mRecommendedJobs[$i]['company_name'].'">
										<small>
											<a class="white-text" href="'.$job_details->mRecommendedJobs[$i]['link_to_job'].'"><i class="fas fa-hashtag"></i> &nbsp;'.$job_details->mRecommendedJobs[$i]['position_name'].' at '.$job_details->mRecommendedJobs[$i]['company_name'].'
											</a>
										</small>
									</h6>
									<br>
									<div class="row">
										<div class="input-field col s12">
											<textarea id="post_to_your_profile_'.$i.'" type="text" class="materialize-textarea post_with_tag_'.$i.'"></textarea>
												<label for="post_to_your_profile_'.$i.'">Compose post</label>
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
								M.toast({html: "Posted successfully &nbsp;<a class=\"white-text red-text text-lighten-2\" href=\"'.$job_details->mLinkToUserProfile.'\">view post</a>"});
								$.post("'.$job_details->mLinkToJobDetails.'",
								{Button_Post_With_Tag: "", Post: post_with_tag, JobId: '.$job_details->mRecommendedJobs[$i]['job_id'].'},
								function(data) {
									// nothing
								})
							});
						});
					</script>
				';
			}
		echo '</div>';
	}
?>