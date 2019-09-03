<?php
	require_once PRESENTATION_DIR . 'company_review.php';
	$company_review = new CompanyReview();
	$company_review->init();
	if ($company_review->mTotalReviews != 0) {
		echo '
		<div class="row">
			<div class="col s12">
				<h5 class="grey-text text-darken-2 center">User Reviews</h5>
			</div>
		</div>';
		for ($i=0; $i<count($company_review->mReviews); $i++) {
		echo '
		<div class="row review_card_'.$i.'">
			<div class="col s12">
				<div class="card white grey-text text-darken-2 hoverable" style="border: 1px solid lightgrey;">
					<div class="card-content company_review_content_'.$i.'">
						<p style="position:relative;">
							<span>';
								if (!empty($company_review->mReviews[$i]['avatar'])) {
									echo '
									<a href="'.$company_review->mReviews[$i]['link_to_user_profile'].'">
										<img src="'.$company_review->mSiteUrl.'images/profile_pictures/'.$company_review->mReviews[$i]['avatar'].'" alt="'.$company_review->mReviews[$i]['reviewer'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;">
									</a>';
								} 
								else {
									echo '
									<a href="'.$company_review->mReviews[$i]['link_to_user_profile'].'" class="white-text">
										<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
											<span class="white-text" style="font-size:15px;"><b>'.substr($company_review->mReviews[$i]['reviewer'], 0, 1).'</b>
											</span>
										</span>
									</a>'; 
								}
				 			echo '
							</span>
							<span class="grey-text text-darken-2" style="position:absolute;">
								<b>&nbsp;<a href="'.$company_review->mReviews[$i]['link_to_user_profile'].'" class="grey-text text-darken-2">'.$company_review->mReviews[$i]['reviewer'].'</a></b>
							</span>
							<span class="grey-text text-darken-2" style="position:absolute;top:20px">
								&nbsp;posted <time class="timeago" datetime="'.date('Y-m-d H:i:s', strtotime($company_review->mReviews[$i]['created_on'])).'">'.date('m').' '.date('d').', '.date('Y').'</time>
							</span>';
							if ($company_review->mCustomerId != 0 && $company_review->mCustomerId == $company_review->mReviews[$i]['customer_id']) {
								echo '
								<span class="grey-text text-darken-2" style="position:absolute;right:0;">
									<b><a class="company_review_dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="company_review_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b>
									<ul id="company_review_dropdown_'.$i.'" class="dropdown-content">
										<li><a href="#!" id="submit_DeleteReview_'.$company_review->mReviews[$i]['review_id'].'"><small><i class="fas fa-trash"></i> Delete</small></a></li>
									</ul>
								</span>
								<script>
									$(document).ready(function() {
										$(".company_review_dropdown_trigger'.$i.'").dropdown();

										// Delete review functionality
										$(".company_review_content_'.$i.'").on("click", "#submit_DeleteReview_'.$company_review->mReviews[$i]['review_id'].'", function(event) {
											event.preventDefault();
											$.post(
											"'.$company_review->mLinkToCompany.'",
											{Delete_Review: "", ReviewId: '.$company_review->mReviews[$i]['review_id'].'},
											function(data) {
												$(".review_card_'.$i.'").fadeOut(500);
												M.toast({html: "Deleted successfully"});
											}
											);
										});
									});
								</script>';
							}
							echo '
							</p>
							<br>
							<span style="white-space:pre-line;" id="reviewText'.$i.'">'.$company_review->mReviews[$i]['review'].'</span>
							<br><br>
							<script>
								$(document).ready(function() {
									var fullReviewText'.$i.' = $("#reviewText'.$i.'").text();
									if ($("#reviewText'.$i.'").text().length > 150) {
										var extractText = $("#reviewText'.$i.'").text().substring(0, 150);
										$("#reviewText'.$i.'").text(extractText + "...").append("<br><br><a href=\"#!\" class=\"red-text text-lighten-2 moreButton'.$i.'\">Read more</a>");
									}
									$(".review_card_'.$i.'").on("click", ".moreButton'.$i.'", function(event) {
										event.preventDefault();
										$("#reviewText'.$i.'").text(fullReviewText'.$i.');
									});
								});
							</script>
							<div class="divider"></div>
							<p>';
								if (!empty($company_review->mReviews[$i]['rating'])) {
									switch($company_review->mReviews[$i]['rating']) {
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
								}
							echo '
							</p>
						</div>
					</div>
				</div>
			</div>';
		}
		if ($company_review->mTotalReviews > 3) {
			echo '
			<p class="center">
				<a href="'.$company_review->mLinkToMoreCompanyReviews.'" class="btn waves-effect waves-light red lighten-2 white-text">MORE REVIEWS</a>
			</p>';
		}
	}
	else {
		echo '
		<div class="row">
			<div class="col s12">
				<br>
				<h5 class="center grey-text text-darken-2">Be the first person to voice your opinion</h5>
		';
		if ($company_review->mEnableAddJobReviewForm) { 
    		echo '
    					<br>
    					<form class="col s12" method="post" action="'.$company_review->mLinkToCompany.'">
    						<div class="row">
    							<div class="input-field col s12">
    								<h6>&nbsp;&nbsp;Compose review:</h6>
    								<textarea id="reviewJob" name="review" placeholder="What do you think about '.$company_review->mCompanyName.', '.$company_review->mReviewerName.'?" class="" value="'.$company_review->mEditReview.'" style="width:100%;height:150px;padding:12px 20px;box-sizing:border-box;border:2px solid #ccc;border-radius:4px;background-color:white;resize:none;">'.$company_review->mEditReview.'</textarea>
    								<br>
    							<div>
    						</div>
    						<div class="row">
    							<div class="input-field col s12">
    								<select name="group1">
    									<option value="" disabled>Rate '.$company_review->mCompanyName.'</option>
    									<option value="1" selected>1 star</option>
    									<option value="2">2 stars</option>
    									<option value="3">3 stars</option>
    									<option value="4">4 stars</option>
    									<option value="5">5 stars</option>
    								</select>
    								<label>Rate '.$company_review->mCompanyName.'</label>
    							</div>
    						</div>
    						<p class="center">
    							<button type="submit" class="btn red lighten-2 white-text waves-light waves-effect" name="AddCompanyReview">Add Review</button>
    						</p>
    					</form>
    					</div>
    				</div>
    			</div>
    		</div>
    		';
    	}
    	else {
    		echo '
    				<h6 class="center">You must <a href="'.$company_review->mLinkToLoginPage.'" class="red-text text-lighten-2">login</a> to add a review.</h6>
    				</div>
    				</div>
    		';
    	}
	} 
	
?>