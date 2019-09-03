<?php
	require_once PRESENTATION_DIR . 'more_job_reviews.php';
	$review = new MoreJobReviews();
	$review->init();

	if ($review->mTotalReviews !== 0) {
		echo '
		<br>
		<div class="row rowCardReview">
			<div class="col s12">
				<h5 class="center grey-text text-darken-2 bebasFont">More user reviews: '.$review->mJobName.'</h5>
				<br>';
				for ($i=0; $i<count($review->mReviews); $i++) {
					echo '
					<div class="row review_card_'.$i.'">
						<div class="col s12 l8 offset-l2">
							<div class="card white grey-text text-darken-2 hoverable" style="border: 1px solid lightgrey;">
								<div class="card-content review_content_'.$i.'">
									<p style="position:relative;">
										<span>';
										if (!empty($review->mReviews[$i]['avatar'])) {
											echo '
											<a href="'.$review->mReviews[$i]['link_to_user'].'">
												<img src="'.$review->mSiteUrl.'images/profile_pictures/'.$review->mReviews[$i]['avatar'].'" alt="'.$review->mReviews[$i]['reviewer'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;">
											</a>';
										} 
										else {
											echo '
											<a href="'.$review->mReviews[$i]['link_to_user'].'" class="white-text">
												<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
													<span class="white-text" style="font-size:15px;"><b>'.substr($review->mReviews[$i]['reviewer'], 0, 1).'</b>
													</span>
												</span>
											</a>'; 
										}
				 						echo '
										</span>
										<span class="grey-text text-darken-2" style="position:absolute;">
											<b>&nbsp;<a href="'.$review->mReviews[$i]['link_to_user'].'" class="grey-text text-darken-2">'.$review->mReviews[$i]['reviewer'].'</a></b>
										</span>
										<span class="grey-text text-darken-2" style="position:absolute;top:20px">
											&nbsp;posted <time class="timeago" datetime="'.date('Y-m-d H:i:s', strtotime($review->mReviews[$i]['created_on'])).'">'.date('m').' '.date('d').', '.date('Y').'</time>
										</span>';
										if ($review->mCustomerId != 0 && $review->mCustomerId == $review->mReviews[$i]['customer_id']) {
											echo '
											<span class="grey-text text-darken-2" style="position:absolute;right:0;">
												<b><a class="review_dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="review_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b>
												<ul id="review_dropdown_'.$i.'" class="dropdown-content">
													<li><a href="#!" id="submit_EditReview_'.$review->mReviews[$i]['review_id'].'"><small><i class="far fa-edit"></i> Edit</small></a></li>
													<li><a href="#!" id="submit_DeleteReview_'.$review->mReviews[$i]['review_id'].'"><small><i class="fas fa-trash"></i> Delete</small></a></li>
												</ul>
											</span>
											<script>
											$(document).ready(function() {
													$(".review_dropdown_trigger'.$i.'").dropdown();
															
													// Edit review functionality
													$(".review_content_'.$i.'").on("click", "#submit_EditReview_'.$review->mReviews[$i]['review_id'].'", function(event) {
														event.preventDefault();
														var review = "'.trim(preg_replace('/\s\s+/', ' ', $review->mReviews[$i]['review'])).'";
														$.post(
															"'.$review->mLinkToMoreJobReviews.'",
															{Edit_Review: "", ReviewId: '.$review->mReviews[$i]['review_id'].'},
															function(data) {
																$(".review_card_'.$i.'").fadeOut(500);
																$("#reviewJob").val(review);
																$([document.documentElement, document.body]).animate({
																	scrollTop: $("#reviewJob").offset().top
																}, 500);
															}
														);
													});

													// Delete review functionality
													$(".review_content_'.$i.'").on("click", "#submit_DeleteReview_'.$review->mReviews[$i]['review_id'].'", function(event) {
														event.preventDefault();
														$.post(
															"'.$review->mLinkToMoreJobReviews.'",
															{Delete_Review: "", ReviewId: '.$review->mReviews[$i]['review_id'].'},
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
									<span style="white-space:pre-line;" id="reviewText'.$i.'">'.$review->mReviews[$i]['review'].'</span>
									<br><br>
									<script>
										$(document).ready(function() {
											var fullReviewText'.$i.' = $("#reviewText'.$i.'").text();
											if ($("#reviewText'.$i.'").text().length > 150) {
												var extractText = $("#reviewText'.$i.'").text().substring(0, 150);
												$("#reviewText'.$i.'").text(extractText + "...").append("<a href=\"#!\" class=\"red-text text-lighten-2 moreButton'.$i.'\">more</a>");
											}
											$(".rowCardReview").on("click", ".moreButton'.$i.'", function(event) {
												event.preventDefault();
												$("#reviewText'.$i.'").text(fullReviewText'.$i.');
											});
										});
									</script>
									<div class="divider"></div>
									<p>';
									if ($review->mCustomerId != 0) {
										echo '
										<span id="secondary-contents'.$i.'">';
										if (empty(Catalog::CustomerGetLikedReview((int)$review->mReviews[$i]['review_id'], Customer::GetCurrentCustomerId()))) {
											echo '
											<span class="thumbs-up-link'.$i.'"><i class="far fa-thumbs-up farthumb"></i>';
											if (is_null(Catalog::GetLikedReviews((int)$review->mReviews[$i]['review_id']))) {
												echo '0';
											}
											else {
												echo Catalog::GetLikedReviews((int)$review->mReviews[$i]['review_id']);
											}
											echo '
											</span>&nbsp;';
										}
										else {
											echo '
											<span class="thumbs-up-fas-link'.$i.'"><i class="fas fa-thumbs-up fasthumb"></i>';
											if (is_null(Catalog::GetLikedReviews((int)$review->mReviews[$i]['review_id']))) {
												echo '0';
											}
											else {
												echo Catalog::GetLikedReviews((int)$review->mReviews[$i]['review_id']);
											}
											echo '
											</span>&nbsp;';
										}


										if (empty(Catalog::CustomerGetDislikedReview((int)$review->mReviews[$i]['review_id'], (int)Customer::GetCurrentCustomerId()))) {
											echo '
											<span class="thumbs-down-link'.$i.'"><i class="far fa-thumbs-down fardown"></i>';
											if (is_null(Catalog::GetDislikedReviews((int)$review->mReviews[$i]['review_id']))) {
												echo '0';
											}
											else {
												echo Catalog::GetDislikedReviews((int)$review->mReviews[$i]['review_id']);
											}
											echo '
											</span>';
										}
										else {
											echo '
											<span class="thumbs-down-fas-link'.$i.'"><i class="fas fa-thumbs-down fasdown"></i>';
											if (is_null(Catalog::GetDislikedReviews((int)$review->mReviews[$i]['review_id']))) {
												echo '0';
											}
											else {
												echo Catalog::GetDislikedReviews((int)$review->mReviews[$i]['review_id']);
											}
											echo '
											</span>';
										}
										echo '	
										</span>';
									}
									echo '
									<script>
										$(document).ready(function() {
											$("#secondary-contents'.$i.'").on("click", ".farthumb", function(){
												var thumbs = $(".thumbs-up-link'.$i.'").text();
												thumbs++;
												$.post("'.$review->mLinkToMoreJobReviews.'",
												{InLikes: thumbs, ReviewId: '.(int)$review->mReviews[$i]['review_id'].'},
												function(data) {
													$(".thumbs-up-link'.$i.'").replaceWith(function(n) {
														return "<span class=\"thumbs-up-fas-link'.$i.'\"><i class=\"fas fa-thumbs-up fasthumb\"></i>" + thumbs + "</span>";
													}); 
												})
											});
											$("#secondary-contents'.$i.'").on("click", ".fasthumb", function(){
												var thumbs = $(".thumbs-up-fas-link'.$i.'").text();
												thumbs--;
												$.post("'.$review->mLinkToMoreJobReviews.'",
												{DeleteLikedReview: thumbs, ReviewId: '.(int)$review->mReviews[$i]['review_id'].'},
												function(data) {
													$(".thumbs-up-fas-link'.$i.'").replaceWith(function(n) {
														return "<span class=\"thumbs-up-link'.$i.'\"><i class=\"far fa-thumbs-up farthumb\"></i>" + thumbs + "</span>";
													}); 
												})
											}); 
											$("#secondary-contents'.$i.'").on("click", ".fardown", function(){
												var thumbs = $(".thumbs-down-link'.$i.'").text();
												thumbs++;
												$.post("'.$review->mLinkToJob.'",
												{InDislikes: thumbs, ReviewId: '.(int)$review->mReviews[$i]['review_id'].'},
												function(data) {
													$(".thumbs-down-link'.$i.'").replaceWith(function(n) {
														return "<span class=\"thumbs-down-fas-link'.$i.'\"><i class=\"fas fa-thumbs-down fasdown\"></i>" + thumbs + "</span>";
													}); 
												})
											});
											$("#secondary-contents'.$i.'").on("click", ".fasdown", function(){
												var thumbs = $(".thumbs-down-fas-link'.$i.'").text();
												thumbs--;
												$.post("'.$review->mLinkToJob.'",
												{DeleteDislikedReview: thumbs, ReviewId: '.(int)$review->mReviews[$i]['review_id'].'},
												function(data) {
													$(".thumbs-down-fas-link'.$i.'").replaceWith(function(n) {
														return "<span class=\"thumbs-down-link'.$i.'\"><i class=\"far fa-thumbs-down fardown\"></i>" + thumbs + "</span>";
													}); 
												})
											});
										});
									</script>
								</p>
							</div>
						</div>
					</div>
				</div>';
				}
			echo '
			</div>
		</div>';
		if (count($review->mPostListPages ) > 1) {
			echo '
			<div class="row">
				<div class="col s12">
					<ul class="pagination center">';
						for ($m = 0; $m < count($review->mPostListPages); $m++) {
							if ($review->mPage == ($m+1)) {
								echo '<li class="waves-effect active red lighten-2"><a href="'.$review->mPostListPages[$m].'">'.($m+1).'</a></li>';
							}
							else {
								echo '<li class="waves-effect"><a href="'.$review->mPostListPages[$m].'">'.($m+1).'</a></li>';
							}
						}
					echo '
					</ul>
				</div>
			</div>';
		}
	}
	else {
		echo '
		<div class="row">
			<div class="col s12">
				<h5>Be the first person to voice your opinion!</h5>
			</div>
		</div>
		';
	}
	if ($review->mEnableAddJobReviewForm) {
		echo '
		<div class="row">
			<div class="col s12 l8 offset-l2">
				<h6>&nbsp;&nbsp;Compose review:</h6>
				<form class="col s12" method="post" action="'.$review->mLinkToMoreJobReviews.'">
					<div class="row">
						<div class="input-field col s12">
							<textarea id="reviewJob" name="review" placeholder="What do you think about this job posting '.$review->mReviewerName.'?" style="width:100%;height:150px;padding:12px 20px;box-sizing:border-box;border:2px solid lightgrey;border-radius:4px;background-color:white;resize:none;"></textarea>
							<p class="center">
								<button type="submit" class="btn red lighten-2 white-text waves-light waves-effect" name="AddJobReview">Add Review</button>
							</p>
						</div>
					</div>
				</form>
			</div>
		</div>
		';
	}
	else {
		echo '
		<div class="row">
			<div class="col s12">
				<h6 class="">You must <a href="'.$review->mLinkToLoginPage.'" class="red-text text-lighten-2">login</a> to add a review.</h6>
			</div>
		</div>
		';
	}
?>