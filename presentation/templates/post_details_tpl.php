<?php
	require_once PRESENTATION_DIR . 'post_details.php';
	$post_details = new PostDetails();
	$post_details->init();
	if (!is_null($post_details->mErrorMessage) || $post_details->mErrorMessage != '') {
		echo '
		<div class="row">
			<div class="col s12 m12">
				<div class="alertBox">
					<span class="alertBoxCloseBtn" onclick="this.parentElement.style.display=\'none\'">&times;</span>
					'.$post_details->mErrorMessage.'
				</div>
			</div>
		<div>
		';
	}
	echo '
	<div class="row hide if_post_is_zero">
		<div class="col s12 m8 offset-m2">
			<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
			<h5 class="center grey-text text-darken-2 hide deleted_post">This post has been deleted</h5>
			<h5 class="center grey-text text-darken-2 hide hidden_post">This post has been hidden</h5>
			<h5 class="center grey-text text-darken-2 hide blocked_post">This user has been blocked</h5>
		</div>
	</div>

	<div class="row card_my_stream">
		<div class="col s12 l10 offset-l1">
			<div class="card white grey-text text-darken-2 z-depth-0" style="border: 1px solid lightgrey;">
				<div class="card-content card_content_my_stream">
					<p style="position:relative;">
						<span>';
							if (empty($post_details->mPostDetails['avatar'])) {
								echo '
								<a href="'.$post_details->mPostDetails['link_to_user'].'" class="white-text">
									<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
										<span class="white-text" style="font-size:15px;"><b>'.substr($post_details->mPostDetails['handle'], 0, 1).'</b></span>
									</span>
								</a>';
							}
							else {
								echo '
								<a href="'.$post_details->mPostDetails['link_to_user'].'">
									<img src="'.$post_details->mSiteUrl.'images/profile_pictures/'.$post_details->mPostDetails['avatar'].'" alt="'.$post_details->mPostDetails['handle'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;" />
								</a>
								';
							} 
						echo '
						</span>
						<span class="grey-text text-darken-2" style="position:absolute;">
							<b>&nbsp;&nbsp;<a href="'.$post_details->mPostDetails['link_to_user'].'" class="grey-text text-darken-2">'.$post_details->mPostDetails['handle'].'</a></b>
						</span>
						<span class="grey-text text-darken-2" style="position:absolute;top:20px">
							&nbsp;&nbsp;posted <span data-livestamp="'.date('Y-m-d H:i:s', strtotime($post_details->mPostDetails['date_posted'])).'"></span>
						</span>';
						if (Customer::GetCurrentCustomerId() != 0) {
							if ($post_details->mPostDetails['customer_id'] != Customer::GetCurrentCustomerId()) {
								echo '
								<span class="grey-text text-darken-2" style="position:absolute;right:0;">
									<b><a class="dropdown_trigger'.$post_details->mPostDetails['post_id'].' grey-text text-darken-2" href="#!" data-target="posts_dropdown_'.$post_details->mPostDetails['post_id'].'"><i class="fas fa-ellipsis-h"></i></a></b>
									<ul id="posts_dropdown_'.$post_details->mPostDetails['post_id'].'" class="dropdown-content" style="max-width:300px;">
										<li><a href="#!" id="hide_post'.$post_details->mPostDetails['post_id'].'"><small><i class="fas fa-eye-slash"></i> Hide</small></a></li>
										<li><a href="#!" id="block_post_'.$post_details->mPostDetails['post_id'].'"><small><i class="fas fa-ban"></i> Block all posts from <b>'.$post_details->mPostDetails['handle'].'</b></small></a></li>
										<li class="report_'.$post_details->mPostDetails['post_id'].'"><a href="#!" id="report_post_'.$post_details->mPostDetails['post_id'].'"><small><i class="fas fa-flag"></i> Report this post</small></a></li>';
										if (!in_array($post_details->mPostDetails['customer_id'], $post_details->mPeopleYouFollow)) {
									    	echo '<li class="follow_post_details_'.$post_details->mPostDetails['post_id'].'"><a href="#!" id="follow_user_post_details_'.$post_details->mPostDetails['post_id'].'"><small><i class="fas fa-user-plus"></i> Follow <b>'.$post_details->mPostDetails['handle'].'</b></small></a></li>';
									    }
									    else {
									    	echo '<li class="unfollow_post_details_'.$post_details->mPostDetails['post_id'].'"><a href="#!" id="unfollow_user_post_details_'.$post_details->mPostDetails['post_id'].'"><small><i class="fas fa-user-plus"></i> Unfollow <b>'.$post_details->mPostDetails['handle'].'</b></small></a></li>';
									    }
									echo '
									</ul>
								<span>
								<script>
									$(document).ready(function() {
										$(".dropdown_trigger'.$post_details->mPostDetails['post_id'].'").dropdown();

										// Hide post functionality
										$(".card_content_my_stream").on("click", "#hide_post'.$post_details->mPostDetails['post_id'].'", function(event) {
											event.preventDefault();
											$(".card_my_stream").fadeOut(500);
											M.toast({html: "Hidden successfully"});
											$(".if_post_is_zero").removeClass("hide").addClass("show");
											$(".hidden_post").removeClass("hide").addClass("show");
											$.post(
											"'.$post_details->mLinkToPostDetails.'",
											{Hide_Post: "", PostId: '.$post_details->mPostDetails['post_id'].'},
											function(data) {
												// nothing
											}
											);
										});

										// Block User functionality
										$(".card_content_my_stream").on("click", "#block_post_'.$post_details->mPostDetails['post_id'].'", function(event) {
											event.preventDefault();
											$(".card_my_stream").fadeOut(500);
											M.toast({html: "Blocked successfully"});
											$(".if_post_is_zero").removeClass("hide").addClass("show");
											$(".blocked_post").removeClass("hide").addClass("show");
											$.post(
											"'.$post_details->mLinkToPostDetails.'",
											{Block_Post: "", BlockCustomerId: '.$post_details->mPostDetails['customer_id'].'},
											function(data) {
												// nothing
											}
											);
										});

										// Report User functionality
										$(".card_content_my_stream").on("click", "#report_post_'.$post_details->mPostDetails['post_id'].'", function(event) {
											event.preventDefault();
											$(".report_'.$post_details->mPostDetails['post_id'].'").fadeOut(500);
											M.toast({html: "Reported successfully"});
											$.post(
											"'.$post_details->mLinkToPostDetails.'",
											{Report_Post: "", CustomerId: '.$post_details->mPostDetails['customer_id'].', PostId: '.$post_details->mPostDetails['post_id'].'},
											function(data) {
												// nothing
											}
											);
										});

										// Follow User functionality
										$(".card_content_my_stream").on("click", "#follow_user_post_details_'.$post_details->mPostDetails['post_id'].'", function(event) {
											event.preventDefault();
											$(".follow_post_details_'.$post_details->mPostDetails['post_id'].'").fadeOut(500);
											M.toast({html: "Following '.$post_details->mPostDetails['handle'].'"});
											$.post(
											"'.$post_details->mLinkToPostDetails.'",
											{Follow_User: "", FollowCustomerId: '.$post_details->mPostDetails['customer_id'].'},
											function(data) {
												// nothing
											}
											);
										});

										// Unfollow User functionality
										$(".card_content_my_stream").on("click", "#unfollow_user_post_details_'.$post_details->mPostDetails['post_id'].'", function(event) {
											event.preventDefault();
											$(".unfollow_post_details_'.$post_details->mPostDetails['post_id'].'").fadeOut(500);
											M.toast({html: "You unfollowed '.$post_details->mPostDetails['handle'].'"});
											$.post(
											"'.$post_details->mLinkToPostDetails.'",
											{Unfollow_User: "", UnfollowCustomerId: '.$post_details->mPostDetails['customer_id'].'},
											function(data) {
												// nothing
											}
											);
										});
									});
								</script>';
							}
							else {
								echo '
								<span class="grey-text text-darken-2" style="position:absolute;right:0;">
									<b><a class="dropdown_trigger'.$post_details->mPostDetails['post_id'].' grey-text text-darken-2" href="#!" data-target="posts_dropdown'.$post_details->mPostDetails['post_id'].'"><i class="fas fa-ellipsis-h"></i></a></b>
										<ul id="posts_dropdown'.$post_details->mPostDetails['post_id'].'" class="dropdown-content" style="max-width:300px;">
											<li><a href="#!" id="delete_post'.$post_details->mPostDetails['post_id'].'"><small><i class="fas fa-trash"></i> Delete</small></a></li>
										</ul>
								</span>
								<script>
									$(document).ready(function() {
										$(".dropdown_trigger'.$post_details->mPostDetails['post_id'].'").dropdown();
										$(".card_content_my_stream").on("click", "#delete_post'.$post_details->mPostDetails['post_id'].'", function(event) {
											event.preventDefault();
											$(".card_my_stream").fadeOut(500);
											M.toast({html: "Deleted successfully"});
											$(".if_post_is_zero").removeClass("hide").addClass("show");
											$(".deleted_post").removeClass("hide").addClass("show");
											$.post(
											"'.$post_details->mLinkToPostDetails.'",
											{Delete_Post: "", PostId: '.$post_details->mPostDetails['post_id'].'},
											function(data) {
												// nothing
											}
											);
										});
									});
								</script>
								';
							}
						}
					echo '
					</p>';
					if (!is_null($post_details->mPostDetails['job_id'])) {
						echo '
						<br>
						<h6 class="truncate" title="tag '.$post_details->mPostDetails['position_name'].' at '.$post_details->mPostDetails['company_name'].'">
							<small>
								<a class="teal-text truncate" href="'.$post_details->mPostDetails['link_to_popular_tags_page'].'"><i class="fas fa-hashtag"></i> &nbsp;'.$post_details->mPostDetails['position_name'].' at '.$post_details->mPostDetails['company_name'].'
								</a>
							</small>
						</h6>
						';
					}
					else {
						echo '<br>';
					}
					echo '
					<br>
					<span style="white-space:pre-line;">'.$post_details->mPostDetails['post'].'</span>
					<br><br>';
					if (!empty($post_details->mPostDetails['post_images']) || !is_null($post_details->mPostDetails['post_images'])) {
						for ($m=0; $m<count($post_details->mPostDetails['post_images']); $m++) {
							if (count($post_details->mPostDetails['post_images']) == 1) {
								echo '
									<div class="row">
										<div class="col s12">
											<img src="'.$post_details->mSiteUrl.'/images/post_images/'.$post_details->mPostDetails['post_images'][$m]['image'].'" alt="'.$post_details->mPostDetails['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;margin:auto;display:block;" />
										</div>
									</div>
								';
							}
							if (count($post_details->mPostDetails['post_images']) == 2) {
								if ($m == 0) {
									echo '<div class="row">';
								}
								echo '
									<div class="col s6 m6 l6">
										<img src="'.$post_details->mSiteUrl.'/images/post_images/'.$post_details->mPostDetails['post_images'][$m]['image'].'" alt="'.$post_details->mPostDetails['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
									</div>
								';
								if ($m == 1) {
									echo '</div>';
								}
							}
							if (count($post_details->mPostDetails['post_images']) == 3) {
								if ($m == 0) {
									echo '<div class="row">';
								}
								if ($m == 0 || $m == 1)
								echo '
									<div class="col s6 m6 l6">
										<img src="'.$post_details->mSiteUrl.'/images/post_images/'.$post_details->mPostDetails['post_images'][$m]['image'].'" alt="'.$post_details->mPostDetails['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
									</div>
								';
								if ($m == 1) {
									echo '</div>';
								}
								if ($m == 2) {
									echo '
									<div class="row">
										<div class="col s12">
											<img src="'.$post_details->mSiteUrl.'/images/post_images/'.$post_details->mPostDetails['post_images'][$m]['image'].'" alt="'.$post_details->mPostDetails['post_images'][$m]['image'].'  picture" class="responsive-img materialboxed" style="border-radius:4px;" />
										</div>
									</div>
									';
								}
							}
							if (count($post_details->mPostDetails['post_images']) == 4) {
								if ($m == 0 || $m == 2) {
									echo '<div class="row">';
								}
								echo '
									<div class="col s6 m6 l6">
										<img src="'.$post_details->mSiteUrl.'/images/post_images/'.$post_details->mPostDetails['post_images'][$m]['image'].'" alt="'.$post_details->mPostDetails['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
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
					<div style="position:relative;" id="like_functionality_'.$post_details->mPostDetails['post_id'].'">';
						echo '
						<a href="#comment_modal" class="grey-text text-darken-2 modal-trigger comment_modal_'.$post_details->mPostDetails['post_id'].'"><span class="fas fa-comment"></span> comment</a>';
						if (Customer::GetCurrentCustomerId() == 0) {
    						echo '
    						<script>
    						    $(document).ready(function() {
    						        $("#like_functionality_'.$post_details->mPostDetails['post_id'].'").on("click", ".comment_modal_'.$post_details->mPostDetails['post_id'].'", function(event) {
    						            event.preventDefault();
    						            window.location.href = "'.$post_details->mLinkToLoginPage.'";
    						        });
    						    });
    						</script>';
						}
						echo '
						<span style="position:absolute;left:46%;" id="like_post_functionality_'.$post_details->mPostDetails['post_id'].'" class="scale-transition ';
						if ($post_details->mPostDetails['is_liked'] == 'yes') {
							echo 'scale-out';
						}
						else {
							echo 'scale-in';
						}
						echo '
						">
							<i class="fas fa-thumbs-up like_post_grey_'.$post_details->mPostDetails['post_id'].'"></i>
						</span>
						<span style="position:absolute;left:46%;" id="dislike_post_functionality_'.$post_details->mPostDetails['post_id'].'" class="scale-transition ';
							if ($post_details->mPostDetails['is_liked'] == 'yes') {
								echo 'scale-in';
							}
							else {
								echo 'scale-out';
							}
						echo '
						">
							<i class="fas fa-thumbs-up red-text text-darken-2 like_post_red_'.$post_details->mPostDetails['post_id'].'"></i>
						</span>
						<span style="position:absolute;left:53%;" id="liked_text_'.$post_details->mPostDetails['post_id'].'"> &nbsp;'.$post_details->mPostDetails['total_likes'].'</span>';
						if (Customer::GetCurrentCustomerId() !== 0) {
							echo '
							<script>
								$(document).ready(function() {
									$("#like_functionality_'.$post_details->mPostDetails['post_id'].'").on("click", "#like_post_functionality_'.$post_details->mPostDetails['post_id'].'", function(){
										$("#like_post_functionality_'.$post_details->mPostDetails['post_id'].'").removeClass("scale-in").addClass("scale-out");
										var liked_text = $("#liked_text_'.$post_details->mPostDetails['post_id'].'").text();
										liked_text++;
										$("#liked_text_'.$post_details->mPostDetails['post_id'].'").html(" &nbsp;" + liked_text);
										$("#dislike_post_functionality_'.$post_details->mPostDetails['post_id'].'").removeClass("scale-out").addClass("scale-in");
										$.post("'.$post_details->mLinkToPostDetails.'",
										{Like: "Like", PostId: '.$post_details->mPostDetails['post_id'].'},
										function(data) {
											// nothing
										})
									});
									$("#like_functionality_'.$post_details->mPostDetails['post_id'].'").on("click", "#dislike_post_functionality_'.$post_details->mPostDetails['post_id'].'", function(){
										$("#like_post_functionality_'.$post_details->mPostDetails['post_id'].'").removeClass("scale-out").addClass("scale-in");
										var disliked_text = $("#liked_text_'.$post_details->mPostDetails['post_id'].'").text();
										disliked_text--;
										$("#liked_text_'.$post_details->mPostDetails['post_id'].'").html(" &nbsp;" + disliked_text);
										$("#dislike_post_functionality_'.$post_details->mPostDetails['post_id'].'").removeClass("scale-in").addClass("scale-out");
										$.post("'.$post_details->mLinkToPostDetails.'",
										{Dislike: "Dislike", PostId: '.$post_details->mPostDetails['post_id'].'},
										function(data) {
											// nothing
										})
									});
								});
							</script>';
						}
						else {
							echo '
							<script>
								$(document).ready(function() {
									$("#like_functionality_'.$post_details->mPostDetails['post_id'].'").on("click", "#like_post_functionality_'.$post_details->mPostDetails['post_id'].'", function(){
										event.preventDefault();
										window.location.href = "'.$post_details->mLinkToLoginPage.'";
									});
									$("#like_functionality_'.$post_details->mPostDetails['post_id'].'").on("click", "#dislike_post_functionality_'.$post_details->mPostDetails['post_id'].'", function(){
										event.preventDefault();
										window.location.href = "'.$post_details->mLinkToLoginPage.'";
									});
								});
							</script>';
						}
						echo '
						<span class="right share_dropdown-trigger_'.$post_details->mPostDetails['post_id'].'" data-target="share_dropdown_'.$post_details->mPostDetails['post_id'].'"><span class="fas fa-share"></span> Share</span>
						<ul id="share_dropdown_'.$post_details->mPostDetails['post_id'].'" class="dropdown-content">
							<li><a href="#!" class="facebook_link_'.$post_details->mPostDetails['post_id'].'" target="_blank"><b><small><i class="fab fa-facebook-square"></i> Facebook</small></b></a></li>
							<li><a href="#!" target="_blank" class="twitter_link_'.$post_details->mPostDetails['post_id'].'"><b><small><i class="fab fa-twitter"></i> Twitter</small></b></a></li>
							<li><a href="#!" target="_blank" class="linkedin_link_'.$post_details->mPostDetails['post_id'].'"><b><small><i class="fab fa-linkedin"></i> LinkedIn</small></b></a></li>
							<li><a href="#!" target="_blank" class="whatsapp_link_'.$post_details->mPostDetails['post_id'].'" data-action="share/whatsapp/share"><b><small><i class="fab fa-whatsapp"></i> WhatsApp</small></b></a></li>
							<li><a href="#!" target="_blank" class="telegram_link_'.$post_details->mPostDetails['post_id'].'"><b><small><i class="fab fa-telegram"></i> Telegram</small></b></a></li>
						</ul>
						<script>
							$(document).ready(function() {
								$(".share_dropdown-trigger_'.$post_details->mPostDetails['post_id'].'").dropdown();
								var share_url = encodeURIComponent("'.$post_details->mLinkToPostDetails.'");

								$(".facebook_link_'.$post_details->mPostDetails['post_id'].'").attr("href", "https://www.facebook.com/sharer.php?u=" + share_url);
								$(".twitter_link_'.$post_details->mPostDetails['post_id'].'").attr("href", "https://twitter.com/intent/tweet?url=" + share_url + "&hashtags=JobStack,jobs,Nigeria");
								$(".linkedin_link_'.$post_details->mPostDetails['post_id'].'").attr("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_url + "&title='.$post_details->mPostDetails['handle'].'" + "&source=JobStack");
								$(".whatsapp_link_'.$post_details->mPostDetails['post_id'].'").attr("href", "whatsapp://send?text=" + share_url);
								$(".telegram_link_'.$post_details->mPostDetails['post_id'].'").attr("href", "https://telegram.me/share/url?url=" + share_url);
							});
						</script>
					</div> 
				</div>
			</div>
		</div>
	</div>
	<div class="card_my_stream">
			<div class="divider"></div>
			<br>';
			if ($post_details->mCommentsCount == '1') {
				echo '<h6 class="grey-text text-darken-2 center"><span class="comments_count">1</span> comment</h6>';
			}
			else {
				echo '<h6 class="grey-text text-darken-2 center"><span class="comments_count">'.$post_details->mCommentsCount.'</span> comments</h6>'; 
			}
			echo '
			<br>
			<div class="divider"></div>
			<br>
			<div class="after_this_element">';
			if (!empty($post_details->mComments)) {
				for ($m=0; $m<count($post_details->mComments); $m++) {
					echo '
					<div class="row comment_row_'.$m.' block_user_'.$post_details->mComments[$m]['customer_id'].'">
						<div class="col s12 l10 offset-l1">
							<div class="card white grey-text text-darken-2 z-depth-0" style="border: 1px solid lightgrey;">
								<div class="card-content">
									<p style="position:relative;">
									<span>';
										if (empty($post_details->mComments[$m]['avatar'])) {
											echo '
											<a href="'.$post_details->mComments[$m]['link_to_user'].'" class="white-text">
												<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
												<span class="white-text" style="font-size:15px;"><b>'.substr($post_details->mComments[$m]['handle'], 0, 1).'</b>
												</span>
												</span>
											</a>';
										}
										else {
											echo '
											<a href="'.$post_details->mComments[$m]['link_to_user'].'">
												<img src="'.$post_details->mSiteUrl.'images/profile_pictures/'.$post_details->mComments[$m]['avatar'].'" alt="'.$post_details->mComments[$m]['handle'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;" />
											</a>
											';
										} 
									echo '
									</span>
									<span class="grey-text text-darken-2" style="position:absolute;">
										<b>&nbsp;<a href="'.$post_details->mComments[$m]['link_to_user'].'" class="grey-text text-darken-2">
											'.$post_details->mComments[$m]['handle'].'
										</a></b>
									</span>
									<span class="grey-text text-darken-2" style="position:absolute;top:20px">
										&nbsp;&nbsp;commented <span data-livestamp="'.date('Y-m-d H:i:s', strtotime($post_details->mComments[$m]['created_on'])).'"></span>
									</span>';
									if (Customer::GetCurrentCustomerId() != 0) {
										if ($post_details->mComments[$m]['customer_id'] != Customer::GetCurrentCustomerId()) {
											echo '
											<span class="grey-text text-darken-2" style="position:absolute;right:0;">
												<b><a class="comments_dropdown_trigger'.$post_details->mComments[$m]['comment_id'].' grey-text text-darken-2" href="#!" data-target="comments_dropdown_'.$post_details->mComments[$m]['comment_id'].'"><i class="fas fa-ellipsis-h"></i></a></b> 
												<ul id="comments_dropdown_'.$post_details->mComments[$m]['comment_id'].'" class="dropdown-content" style="max-width:300px;">
													<li><a href="#!" id="hide_comment_'.$post_details->mComments[$m]['comment_id'].'"><small><i class="fas fa-eye-slash"></i> Hide</small></a></li>
													<li><a href="#!" id="block_comment_'.$post_details->mComments[$m]['comment_id'].'"><small><i class="fas fa-ban"></i> Block <b>'.$post_details->mComments[$m]['handle'].'</b></small></a></li>
													<li id="report_button_'.$m.'"><a href="#!" id="report_comment_'.$post_details->mComments[$m]['comment_id'].'"><small><i class="fas fa-flag"></i> Report this comment</small></a></li>';
													if (!in_array($post_details->mComments[$m]['customer_id'], $post_details->mPeopleYouFollow) && $post_details->mComments[$m]['customer_id'] != Customer::GetCurrentCustomerId()) {
														echo '<li class="follow_'.$post_details->mComments[$m]['comment_id'].'"><a href="#!" id="follow_user_comment_'.$post_details->mComments[$m]['comment_id'].'"><small><i class="fas fa-user-plus"></i> Follow <b>'.$post_details->mComments[$m]['handle'].'</b></small></a></li>';
													}
													else {
														echo '<li class="unfollow_'.$post_details->mComments[$m]['customer_id'].'"><a href="#!" id="unfollow_user_comment_'.$post_details->mComments[$m]['comment_id'].'"><small><i class="fas fa-user-plus"></i> Unfollow <b>'.$post_details->mComments[$m]['handle'].'</b></small></a></li>';
													}
												echo '
												</ul>
											</span>
											<script>
												$(document).ready(function() {
													$(".comments_dropdown_trigger'.$post_details->mComments[$m]['comment_id'].'").dropdown();
													// Hide comment functionality
													$(".card_my_stream").on("click", "#hide_comment_'.$post_details->mComments[$m]['comment_id'].'", function(event) {
														event.preventDefault();
														var comments_count = $(".comments_count").text();
														comments_count--;
														$(".comment_row_'.$m.'").fadeOut(500);
														M.toast({html: "Hidden successfully"});
														$(".comments_count").text(comments_count);
														$.post(
															"'.$post_details->mLinkToPostDetails.'",
															{Hide_Comment: "", CommentId: '.$post_details->mComments[$m]['comment_id'].'},
															function(data) {
																// nothing
															});
													});
													// Block User functionality
													$(".card_my_stream").on("click", "#block_comment_'.$post_details->mComments[$m]['comment_id'].'", function(event) {
														event.preventDefault();
														var blocked_users = $(".block_user_'.$post_details->mComments[$m]['customer_id'].'").length;
														var comments_count = $(".comments_count").text();
														comments_count = comments_count - blocked_users;
														$(".block_user_'.$post_details->mComments[$m]['customer_id'].'").fadeOut(500);
														M.toast({html: "Blocked successfully"});
														$(".comments_count").text(comments_count);
														$.post(
														"'.$post_details->mLinkToPostDetails.'",
														{Block_Post: "", BlockCustomerId: '.$post_details->mComments[$m]['customer_id'].'},
														function(data) {
															// nothing
														}
														);
													});
													// Report User functionality
													$(".card_my_stream").on("click", "#report_comment_'.$post_details->mComments[$m]['comment_id'].'", function(event) {
														event.preventDefault();
														$("#report_button_'.$m.'").fadeOut(500);
														M.toast({html: "Reported successfully"});
														$.post(
														"'.$post_details->mLinkToPostDetails.'",
														{Report_Comment: "", CustomerId: '.$post_details->mComments[$m]['customer_id'].', CommentId: '.$post_details->mComments[$m]['comment_id'].'},
														function(data) {
															// nothing
														}
														);
													});
													// Follow User functionality
													$(".card_my_stream").on("click", "#follow_user_comment_'.$post_details->mComments[$m]['comment_id'].'", function(event) {
														event.preventDefault();
														$(".follow_'.$post_details->mComments[$m]['customer_id'].'").fadeOut(500);
														M.toast({html: "Following '.$post_details->mComments[$m]['handle'].'"});
														$.post(
														"'.$post_details->mLinkToPostDetails.'",
														{Follow_User: "", FollowCustomerId: '.$post_details->mComments[$m]['customer_id'].'},
														function(data) {
															// nothing
														}
														);
													});
													// Unfollow User functionality
													$(".card_my_stream").on("click", "#unfollow_user_comment_'.$post_details->mComments[$m]['comment_id'].'", function(event) {
														event.preventDefault();
														$(".unfollow_'.$post_details->mComments[$m]['customer_id'].'").fadeOut(500);
														M.toast({html: "You unfollowed '.$post_details->mComments[$m]['handle'].'"});
														$.post(
														"'.$post_details->mLinkToPostDetails.'",
														{Unfollow_User: "", UnfollowCustomerId: '.$post_details->mComments[$m]['customer_id'].'},
														function(data) {
															// nothing
														}
														);
													});
												});
											</script>';
										}
										else {
											echo '
											<span class="grey-text text-darken-2" style="position:absolute;right:0;">
												<b><a class="comments_dropdown_trigger'.$post_details->mComments[$m]['comment_id'].' grey-text text-darken-2" href="#!" data-target="comments_dropdown'.$post_details->mComments[$m]['comment_id'].'"><i class="fas fa-ellipsis-h"></i></a></b>
													<ul id="comments_dropdown'.$post_details->mComments[$m]['comment_id'].'" class="dropdown-content" style="max-width:300px;">
														<li><a href="#!" id="delete_comment'.$post_details->mComments[$m]['comment_id'].'"><small><i class="fas fa-trash"></i> Delete</small></a></li>
													</ul>
											</span>
											<script>
												$(document).ready(function() {
													$(".comments_dropdown_trigger'.$post_details->mComments[$m]['comment_id'].'").dropdown();
													$(".card_my_stream").on("click", "#delete_comment'.$post_details->mComments[$m]['comment_id'].'", function(event) {
														event.preventDefault();
														var comments_count = $(".comments_count").text();
														comments_count--;
														$(".comment_row_'.$m.'").fadeOut(500);
														M.toast({html: "Deleted successfully"});
														$(".comments_count").text(comments_count);
														$.post(
														"'.$post_details->mLinkToPostDetails.'",
														{Delete_Comment: "", CommentId: '.$post_details->mComments[$m]['comment_id'].'},
														function(data) {
															// nothing
														});
													});
												});
											</script>';
										}
									}
									echo '
									</p>
									<br>
									<span id="postOnlineText'.$m.'" style="white-space:pre-line;">'.$post_details->mComments[$m]['comment'].'</span>
									<br><br>
									<script>
										$(document).ready(function() {
											var fullReviewText'.$m.' = $("#postOnlineText'.$m.'").text();
											if ($("#postOnlineText'.$m.'").text().length > 150) {
												var extractText = $("#postOnlineText'.$m.'").text().substring(0, 150);
												$("#postOnlineText'.$m.'").text(extractText + "...").append("<a href=\"#!\" class=\"grey-text text-darken-2 moreButton'.$m.'\">Read more</a><br><br>");
											}
											$(".comment_row_'.$m.'").on("click", ".moreButton'.$m.'", function(event) {
												event.preventDefault();
												$("#postOnlineText'.$m.'").text(fullReviewText'.$m.');
											});
										});
									</script>';
									if (!empty($post_details->mComments[$m]['comment_images']) || !is_null($post_details->mComments[$m]['comment_images'])) {
										for ($i=0; $i<count($post_details->mComments[$m]['comment_images']); $i++) {
											if (count($post_details->mComments[$m]['comment_images']) == 1) {
												echo '
													<div class="row">
														<div class="col s12">
															<img src="'.$post_details->mSiteUrl.'/images/comment_images/'.$post_details->mComments[$m]['comment_images'][$i]['image'].'" alt="'.$post_details->mComments[$m]['comment_images'][$i]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
														</div>
													</div>
												';
											}
											if (count($post_details->mComments[$m]['comment_images']) == 2) {
												if ($i == 0) {
													echo '<div class="row">';
												}
												echo '
													<div class="col s6 m6 l6">
														<img src="'.$post_details->mSiteUrl.'/images/comment_images/'.$post_details->mComments[$m]['comment_images'][$i]['image'].'" alt="'.$post_details->mComments[$m]['comment_images'][$i]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
													</div>
												';
												if ($i == 1) {
													echo '</div>';
												}
											}
											if (count($post_details->mComments[$m]['comment_images']) == 3) {
												if ($i == 0) {
													echo '<div class="row">';
												}
												if ($i == 0 || $i == 1)
												echo '
													<div class="col s6 m6 l6">
														<img src="'.$post_details->mSiteUrl.'/images/comment_images/'.$post_details->mComments[$m]['comment_images'][$i]['image'].'" alt="'.$post_details->mComments[$m]['comment_images'][$i]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
													</div>
												';
												if ($i == 1) {
													echo '</div>';
												}
												if ($i == 2) {
													echo '
													<div class="row">
														<div class="col s12">
															<img src="'.$post_details->mSiteUrl.'/images/comment_images/'.$post_details->mComments[$m]['comment_images'][$i]['image'].'" alt="'.$post_details->mComments[$m]['comment_images'][$i]['image'].'  picture" class="responsive-img materialboxed" style="border-radius:4px;" />
														</div>
													</div>
													';
												}
											}
											if (count($post_details->mComments[$m]['comment_images']) == 4) {
												if ($i == 0 || $i == 2) {
													echo '<div class="row">';
												}
												echo '
													<div class="col s6 m6 l6">
														<img src="'.$post_details->mSiteUrl.'/images/comment_images/'.$post_details->mComments[$m]['comment_images'][$i]['image'].'" alt="'.$post_details->mComments[$m]['comment_images'][$i]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
													</div>
												';
												if ($i == 1 || $i == 3) {
													echo '</div>';
												}
											}
										}
									}
									echo '
									<div style="position:relative;" id="like_dislike_functionality_'.$m.'">
										<span style="position:absolute;left:0%;" id="like_grey_thumbs_up_comment_functionality_'.$m.'" class="scale-transition ';
										if ($post_details->mComments[$m]['is_liked'] == 'yes') {
											echo 'scale-out';
										}
										else {
											echo 'scale-in';
										}
										echo '
										">
											<i class="fas fa-thumbs-up like_comment_grey_'.$m.'"></i>
										</span>
										<span style="position:absolute;left:0%;" id="like_red_thumbs_up_comment_functionality_'.$m.'" class="scale-transition ';
										if ($post_details->mComments[$m]['is_liked'] == 'yes') {
											echo 'scale-in';
										}
										else {
											echo 'scale-out';
										}
										echo '
										">
											<i class="fas fa-thumbs-up red-text text-darken-2 like_comment_red_'.$m.'"></i>
										</span>
										<span style="position:absolute;left:8%;" id="liked_text_'.$m.'"> &nbsp;'.$post_details->mComments[$m]['total_likes'].'</span>

										<span style="position:absolute;left:15%;" id="dislike_grey_thumbs_up_comment_functionality_'.$m.'" class="scale-transition ';
										if ($post_details->mComments[$m]['is_disliked'] == 'yes') {
											echo 'scale-out';
										}
										else {
											echo 'scale-in';
										}
										echo '
										">
											<i class="fas fa-thumbs-down dislike_comment_grey_'.$m.'"></i>
										</span>
										<span style="position:absolute;left:15%;" id="dislike_red_thumbs_up_comment_functionality_'.$m.'" class="scale-transition ';
										if ($post_details->mComments[$m]['is_disliked'] == 'yes') {
											echo 'scale-in';
										}
										else {
											echo 'scale-out';
										}
										echo '
										">
											<i class="fas fa-thumbs-down red-text text-darken-2 dislike_comment_red_'.$m.'"></i>
										</span>
										<span style="position:absolute;left:23%;" id="disliked_text_'.$m.'"> &nbsp;'.$post_details->mComments[$m]['total_dislikes'].'</span>';
										if (Customer::GetCurrentCustomerId() !== 0) {
											echo '
											<script>
												$(document).ready(function() {
													// Like functionality
													$("#like_dislike_functionality_'.$m.'").on("click", "#like_grey_thumbs_up_comment_functionality_'.$m.'", function(){
														$("#like_grey_thumbs_up_comment_functionality_'.$m.'").removeClass("scale-in").addClass("scale-out");
														var liked_text = $("#liked_text_'.$m.'").text();
														liked_text++;
														$("#liked_text_'.$m.'").html(" &nbsp;" + liked_text + " &nbsp;");
														$("#like_red_thumbs_up_comment_functionality_'.$m.'").removeClass("scale-out").addClass("scale-in");
														$.post("'.$post_details->mLinkToPostDetails.'",
														{Like_Comment: "", CommentId: '.$post_details->mComments[$m]['comment_id'].'},
														function(data) {
															// nothing
														}
														);
													});
													$("#like_dislike_functionality_'.$m.'").on("click", "#like_red_thumbs_up_comment_functionality_'.$m.'", function(){
														$("#like_grey_thumbs_up_comment_functionality_'.$m.'").removeClass("scale-out").addClass("scale-in");
														var liked_text = $("#liked_text_'.$m.'").text();
														liked_text--;
														$("#liked_text_'.$m.'").html(" &nbsp;" + liked_text + " &nbsp;");
														$("#like_red_thumbs_up_comment_functionality_'.$m.'").removeClass("scale-in").addClass("scale-out");
														$.post("'.$post_details->mLinkToPostDetails.'",
														{Delete_Like_Comment: "", CommentId: '.$post_details->mComments[$m]['comment_id'].'},
														function(data) {
															// nothing
														}
														);
													});

													// Dislike functionality
													$("#like_dislike_functionality_'.$m.'").on("click", "#dislike_grey_thumbs_up_comment_functionality_'.$m.'", function(){
														$("#dislike_grey_thumbs_up_comment_functionality_'.$m.'").removeClass("scale-in").addClass("scale-out");
														var disliked_text = $("#disliked_text_'.$m.'").text();
														disliked_text++;
														$("#disliked_text_'.$m.'").html(" &nbsp;" + disliked_text + " &nbsp;");
														$("#dislike_red_thumbs_up_comment_functionality_'.$m.'").removeClass("scale-out").addClass("scale-in");
														$.post("'.$post_details->mLinkToPostDetails.'",
														{Dislike_Comment: "", CommentId: '.$post_details->mComments[$m]['comment_id'].'},
														function(data) {
															// nothing
														}
														);
													});
													$("#like_dislike_functionality_'.$m.'").on("click", "#dislike_red_thumbs_up_comment_functionality_'.$m.'", function(){
														$("#dislike_grey_thumbs_up_comment_functionality_'.$m.'").removeClass("scale-out").addClass("scale-in");
														var disliked_text = $("#disliked_text_'.$m.'").text();
														disliked_text--;
														$("#disliked_text_'.$m.'").html(" &nbsp;" + disliked_text + " &nbsp;");
														$("#dislike_red_thumbs_up_comment_functionality_'.$m.'").removeClass("scale-in").addClass("scale-out");
														$.post("'.$post_details->mLinkToPostDetails.'",
														{Delete_Dislike_Comment: "", CommentId: '.$post_details->mComments[$m]['comment_id'].'},
														function(data) {
															// nothing
														}
														);
													});
												});
											</script>';
										}
										else {
											echo '
											<script>
												$(document).ready(function() {
													$("#like_dislike_functionality_'.$m.'").on("click", "#like_grey_thumbs_up_comment_functionality_'.$m.'", function(){
														event.preventDefault();
														window.location.href = "'.$post_details->mLinkToLoginPage.'";
													});
													$("#like_dislike_functionality_'.$m.'").on("click", "#dislike_grey_thumbs_up_comment_functionality_'.$m.'", function(){
														event.preventDefault();
														window.location.href = "'.$post_details->mLinkToLoginPage.'";
													});
												});
											</script>';
										}
									echo '
									<br>
									</div>
								</div>
							</div>
						</div>
					</div>
					';
				}
			}
		echo '
		</div>
		</div>';

		if (Customer::GetCurrentCustomerId() != 0) {
			echo '
			<div class="fixed-action-btn card_my_stream" id="comment_button_modal">
				<a class="btn-floating btn-large teal white-text waves-effect waves-light modal-trigger" href="#comment_modal">
					<i class="far fa-edit"></i>
				</a>
			</div>

			<div id="comment_modal" class="modal white">
				<div class="modal-content">
					<a href="#!" class="modal-close btn-flat red-text text-lighten-2" id="close-modal"><i class="fas fa-arrow-left"></i></a>
					<br>
					<div class="row">
						<form class="col s12" method="post" enctype="multipart/form-data" action="'.$post_details->mLinkToPostDetails.'">
							<div class="row">
								<div class="input-field col s12">
									<textarea id="post_comment" placeholder="Reply to @'.$post_details->mPostDetails['handle'].'" type="text" name="Comment" style="width:100%;height:150px;padding:12px 20px;box-sizing:border-box;border:2px solid #ccc;border-radius:4px;background-color:white;resize:none;"></textarea>
								</div>
							</div>
							<div class="row center" id="comment_image_preview"></div>
							<div class="row" style="position:relative">
								<div class="col s12">
									<input type="file" name="CommentImage[]" id ="comment_image" class="inputfile" multiple>
									<label for="comment_image" style="position:absolute;top:10px;"><i class="far fa-image fa-2x"></i></label>
									<button onclick="reset($(\'#comment_image\'));event.preventDefault();$(\'.container_thumbnail\').remove();" class="btn-small red lighten-2 white-text hide" id="resetFile" style="position:absolute;top:10px; left:40px;">Reset</button>
									<button class="btn-floating red lighten-2 white-text waves-effect waves-light right" type="submit" name="InsertComment" style="font-size:8px;"><i class="fas fa-plus fa-xs" style="font-size:12px;"></i></button>
								</div>
							</div>
						</form>
					</div>
					<div class="row">
						<div class="col s12">
						<p class="teal-text"><small>Four (4) images max</small></p>
						</div>
					</div>
				</div>
				<script>
					$(document).ready(function() {
						$("#comment_modal").on("change", "#comment_image", function() {
							$("#resetFile").removeClass("hide").addClass("show");
							var total_file = document.getElementById("comment_image").files.length;
							if (total_file > 4 || $(".thumbnail_comment").length >= 4) {
								return;
							}
							for (var i=0; i<total_file; i++) {
								$("#comment_image_preview").append("<div class=\"col s3 container_thumbnail\"><img src=\""+URL.createObjectURL(event.target.files[i])+"\" class=\"thumbnail_comment responsive-img\"></div>");
							}
						});
						window.reset = function(e) {
							e.wrap("<form>").closest("form").get(0).reset();
							e.unwrap();
						}
					});
				</script>
			</div>';
		}
?> 