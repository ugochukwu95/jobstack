<?php

				echo '
					<div class="hide if_liked_post_is_zero">
						<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
						<h5 class="grey-text text-darken-2 center">There are no liked posts.</h5>
					</div>';
				if (empty($user_profile->mLikedPosts)) {
					echo '
					<div class="row">
						<div class="col s12">
							<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
							<h5 class="grey-text text-darken-2 center">There are no liked posts.</h5>
						</div>
					</div>';
				}
				else {
					for ($i=0; $i<count($user_profile->mLikedPosts); $i++) {
						echo '
						<div class="row liked_posts like_card_'.$i.' post_like_customer_'.$user_profile->mLikedPosts[$i]['customer_id'].'">
							<div class="col s12 l10 offset-l1">
							<div class="card white grey-text text-darken-2 card'.$i.' z-depth-0" style="border: 1px solid lightgrey;">
								<div class="card-content like_card_content_'.$i.'">
									<p style="position:relative;">
										<span>';
											if (empty($user_profile->mLikedPosts[$i]['avatar'])) {
													echo '
													<a href="'.$user_profile->mLikedPosts[$i]['link_to_user'].'" class="white-text">
													<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
															<span class="white-text" style="font-size:15px;"><b>'.substr($user_profile->mLikedPosts[$i]['handle'], 0, 1).'</b></span>
													</span>
													</a>';
												}
												else {
													echo '
													<a href="'.$user_profile->mLikedPosts[$i]['link_to_user'].'">
													<img src="'.$user_profile->mSiteUrl.'images/profile_pictures/'.$user_profile->mLikedPosts[$i]['avatar'].'" alt="'.$user_profile->mLikedPosts[$i]['handle'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;" />
													</a>
													'; 
												}
				 							echo '
										</span>
										<span class="grey-text text-darken-2" style="position:absolute;">
											<b>&nbsp;<a href="'.$user_profile->mLikedPosts[$i]['link_to_user'].'" class="grey-text text-darken-2">
											'.$user_profile->mLikedPosts[$i]['handle'].'
											</a>
											</b>
										</span>
										<span class="grey-text text-darken-2" style="position:absolute;top:20px">
											&nbsp;&nbsp;posted <span data-livestamp="'.date('Y-m-d H:i:s', strtotime($user_profile->mLikedPosts[$i]['date_posted'])).'"></span>
										</span>';
										if ($user_profile->mLikedPosts[$i]['customer_id'] != Customer::GetCurrentCustomerId() && Customer::GetCurrentCustomerId() != 0) {
											echo '
											<span class="grey-text text-darken-2" style="position:absolute;right:0;">
												<b><a class="like_dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="liked_posts_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b>
												<ul id="liked_posts_dropdown_'.$i.'" class="dropdown-content">
													<li><a href="#!" id="hide_like_post_'.$i.'"><small><i class="fas fa-eye-slash"></i> Hide this post</small></a></li>
													<li><a href="#!" id="block_like_post_'.$i.'"><small><i class="fas fa-ban"></i> Block all posts from <b>'.$user_profile->mLikedPosts[$i]['handle'].'</b></small></a></li>
													<li class="report_like_'.$i.'"><a href="#!" id="report_like_post_'.$i.'"><small><i class="fas fa-flag"></i> Report this post</small></a></li>';
													if (!in_array($user_profile->mLikedPosts[$i]['customer_id'], $user_profile->mPeopleYouFollow)) {
														echo '<li class="follow_like_'.$i.' follow_customer_'.$user_profile->mLikedPosts[$i]['customer_id'].'"><a href="#!" id="follow_user_like_'.$i.'"><small><i class="fas fa-user-plus"></i> Follow <b>'.$user_profile->mLikedPosts[$i]['handle'].'</b></small></a></li>';
													}
													else {
														echo '
														<li class="unfollow_like_'.$i.' unfollow_customer_'.$user_profile->mLikedPosts[$i]['customer_id'].'">
																<a href="#!" id="unfollow_user_like_'.$i.'">
																	<small><i class="fas fa-user-plus"></i> Unfollow <b>'.$user_profile->mLikedPosts[$i]['handle'].'</b></small>
																</a>
															</li>';
														}
												echo '	
												</ul>
											</span>
											<script>
												$(document).ready(function() {
													$(".like_dropdown_trigger'.$i.'").dropdown();

													// Hide post functionality
													$(".like_card_content_'.$i.'").on("click", "#hide_like_post_'.$i.'", function(event) {
														event.preventDefault();
														$(".like_card_'.$i.'").fadeOut(500);
														M.toast({html: "Hidden successfully"});
														var liked_value = $(".liked_posts").length;
														liked_value--;
														if (liked_value == "0") {
															$(".if_liked_post_is_zero").removeClass("hide").addClass("show");
														}
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Hide_Post: "", PostId: '.$user_profile->mLikedPosts[$i]['post_id'].'},
														function(data) {
															// nothing
														}
														);
													});

													// Block User functionality
													$(".like_card_content_'.$i.'").on("click", "#block_like_post_'.$i.'", function(event) {
														event.preventDefault();
														$(".post_like_customer_'.$user_profile->mLikedPosts[$i]['customer_id'].'").fadeOut(500);
														M.toast({html: "Blocked successfully"});
														var liked_value = $(".liked_posts").length;
														liked_value--;
														if (liked_value == "0") {
															$(".if_liked_post_is_zero").removeClass("hide").addClass("show");
														}
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Block_Post: "", BlockCustomerId: '.$user_profile->mLikedPosts[$i]['customer_id'].'},
														function(data) {
															// nothing
														}
														);
													});

													// Report User functionality
													$(".like_card_content_'.$i.'").on("click", "#report_like_post_'.$i.'", function(event) {
														event.preventDefault();
														$(".report_like_'.$i.'").remove();
														M.toast({html: "Reported successfully"});
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Report_Post: "", CustomerId: '.$user_profile->mLikedPosts[$i]['customer_id'].', PostId: '.$user_profile->mLikedPosts[$i]['post_id'].'},
														function(data) {
															// nothing
														}
														);
													});

													// Follow User functionality
													$(".like_card_content_'.$i.'").on("click", "#follow_user_like_'.$i.'", function(event) {
														event.preventDefault();
														$(".follow_customer_'.$user_profile->mLikedPosts[$i]['customer_id'].'").remove();
														M.toast({html: "Following '.$user_profile->mLikedPosts[$i]['handle'].'"});
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Follow_User: "", FollowCustomerId: '.$user_profile->mLikedPosts[$i]['customer_id'].'},
														function(data) {
															// nothing
														}
														);
													});

													// Unfollow User functionality
													$(".like_card_content_'.$i.'").on("click", "#unfollow_user_like_'.$i.'", function(event) {
														event.preventDefault();
														$(".unfollow_customer_'.$user_profile->mLikedPosts[$i]['customer_id'].'").remove();
														M.toast({html: "You unfollowed '.$user_profile->mLikedPosts[$i]['handle'].'"});
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Unfollow_User: "", UnfollowCustomerId: '.$user_profile->mLikedPosts[$i]['customer_id'].'},
														function(data) {
															// nothing
														}
														);
													});
												});
											</script>';
										}
										elseif ($user_profile->mLikedPosts[$i]['customer_id'] == Customer::GetCurrentCustomerId() && Customer::GetCurrentCustomerId() != 0) {
											echo '
												<span class="grey-text text-darken-2" style="position:absolute;right:0;">
													<b><a class="like_dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="liked_posts_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b>
													<ul id="liked_posts_dropdown_'.$i.'" class="dropdown-content" style="max-width:300px;">
														<li><a href="#!" id="delete_like_post_'.$i.'"><small><i class="fas fa-trash"></i> Delete this post</small></a></li>
													</ul>
												</span>
												<script>
													$(document).ready(function() {
														$(".like_dropdown_trigger'.$i.'").dropdown();

														// Delete functionality
														$(".like_card_content_'.$i.'").on("click", "#delete_like_post_'.$i.'", function(event) {
															event.preventDefault();
															$(".like_card_'.$i.'").fadeOut(500);
															M.toast({html: "Deleted successfully"});
															var liked_value = $(".liked_posts").length;
															liked_value--;
															if (liked_value == "0") {
																$(".if_liked_post_is_zero").removeClass("hide").addClass("show");
															}
															$.post(
															"'.$user_profile->mLinkToUserProfile.'",
															{Delete_Post: "", PostId: '.$user_profile->mLikedPosts[$i]['post_id'].'},
															function(data) {
																// nothing
															}
															);
														});
													});
												</script>
											';
										}
									echo '
									</p>';
										if (!is_null($user_profile->mLikedPosts[$i]['job_id'])) {
											echo '
											<br>
											<h6 class="truncate" title="tag '.$user_profile->mLikedPosts[$i]['position_name'].' at '.$user_profile->mLikedPosts[$i]['company_name'].'">
												<small>
													<a class="teal-text truncate" href="'.$user_profile->mLikedPosts[$i]['link_to_popular_tags_page'].'"><i class="fas fa-hashtag"></i> &nbsp;'.$user_profile->mLikedPosts[$i]['position_name'].' at '.$user_profile->mLikedPosts[$i]['company_name'].'
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
									<span style="white-space:pre-line;"><a id="postOnlineText'.$i.'" href="'.$user_profile->mLikedPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2">'.$user_profile->mLikedPosts[$i]['post'].'</a></span>
									<br><br>
									<script>
										$(document).ready(function() {
											var fullReviewText'.$i.' = $("#postOnlineText'.$i.'").text();
											if ($("#postOnlineText'.$i.'").text().length > 150) {
												var extractText = $("#postOnlineText'.$i.'").text().substring(0, 150);
												$("#postOnlineText'.$i.'").text(extractText + "...").append("<a href=\"#!\" class=\"grey-text text-darken-2 moreButton'.$i.'\">Read more</a><br><br>");
											}
											$(".like_card_'.$i.'").on("click", ".moreButton'.$i.'", function(event) {
												event.preventDefault();
												$("#postOnlineText'.$i.'").text(fullReviewText'.$i.');
											});
										});
									</script>';
									if (!empty($user_profile->mLikedPosts[$i]['post_images']) || !is_null($user_profile->mLikedPosts[$i]['post_images'])) {
										for ($m=0; $m<count($user_profile->mLikedPosts[$i]['post_images']); $m++) {
											if (count($user_profile->mLikedPosts[$i]['post_images']) == 1) {
												echo '
													<div class="row">
														<div class="col s12">
															<img src="'.$user_profile->mSiteUrl.'/images/post_images/'.$user_profile->mLikedPosts[$i]['post_images'][$m]['image'].'" alt="'.$user_profile->mLikedPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;margin:auto;display:block;" />
														</div>
													</div>
												';
											}
											if (count($user_profile->mLikedPosts[$i]['post_images']) == 2) {
												if ($m == 0) {
													echo '<div class="row">';
												}
												echo '
													<div class="col s6">
														<img src="'.$user_profile->mSiteUrl.'/images/post_images/'.$user_profile->mLikedPosts[$i]['post_images'][$m]['image'].'" alt="'.$user_profile->mLikedPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
													</div>
												';
												if ($m == 1) {
													echo '</div>';
												}
											}
											if (count($user_profile->mLikedPosts[$i]['post_images']) == 3) {
												if ($m == 0) {
													echo '<div class="row">';
												}
												if ($m == 0 || $m == 1)
												echo '
													<div class="col s6">
														<img src="'.$user_profile->mSiteUrl.'/images/post_images/'.$user_profile->mLikedPosts[$i]['post_images'][$m]['image'].'" alt="'.$user_profile->mLikedPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
													</div>
												';
												if ($m == 1) {
													echo '</div>';
												}
												if ($m == 2) {
													echo '
													<div class="row">
														<div class="col s12">
															<img src="'.$user_profile->mSiteUrl.'/images/post_images/'.$user_profile->mLikedPosts[$i]['post_images'][$m]['image'].'" alt="'.$user_profile->mLikedPosts[$i]['post_images'][$m]['image'].'  picture" class="responsive-img materialboxed" style="border-radius:4px;" />
														</div>
													</div>
													';
												}
											}
											if (count($user_profile->mLikedPosts[$i]['post_images']) == 4) {
												if ($m == 0 || $m == 2) {
													echo '<div class="row">';
												}
												echo '
													<div class="col s6">
														<img src="'.$user_profile->mSiteUrl.'/images/post_images/'.$user_profile->mLikedPosts[$i]['post_images'][$m]['image'].'" alt="'.$user_profile->mLikedPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
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
									<div style="position:relative;" id="dislike_functionality_'.$i.'">
										<a href="'.$user_profile->mLikedPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2">
											<span class="fas fa-comment"></span> '.$user_profile->mLikedPosts[$i]['comments_count'].'
										</a>
										<span style="position:absolute;left:46%;" class="remove_liked_post_icon_'.$i.'"><span class="fas fa-thumbs-up ';
										if ($user_profile->mLikedPosts[$i]['is_liked'] == 'yes') {
											echo 'red-text text-darken-2';
										} 
										echo '
										"></span> '.$user_profile->mLikedPosts[$i]['total_likes'].'</span>';
										if ($user_profile->mLikedPosts[$i]['is_liked'] == 'yes') {
											echo '
											<script>
											$(document).ready(function() {
												var current_page = '.$user_profile->mPage.';
												
												$("#dislike_functionality_'.$i.'").on("click", ".remove_liked_post_icon_'.$i.'", function() {
													var liked_num = $(".liked_posts").length;
													liked_num--;
													$(".like_card_'.$i.'").remove();
													if (liked_num == 0 && current_page == 1) {
														$(".if_liked_post_is_zero").removeClass("hide", 2000);
													}
													$.post("'.$user_profile->mLinkToUserProfile.'",
														{Dislike: "Dislike", PostId: '.$user_profile->mLikedPosts[$i]['post_id'].'},
														function(data) {
															// nothing
														}
													)	
												});
											});
											</script>
											';
										}
										else {
											echo '
											<script>
												$(document).ready(function() {
													$("#dislike_functionality_'.$i.'").on("click", ".remove_liked_post_icon_'.$i.'", function(){
														window.location.href = "'.$user_profile->mLinkToLoginPage.'";
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
												var share_url = encodeURIComponent("'.$user_profile->mLikedPosts[$i]['link_to_post_details'].'");

												$(".facebook_link_'.$i.'").attr("href", "https://www.facebook.com/sharer.php?u=" + share_url);
												$(".twitter_link_'.$i.'").attr("href", "https://twitter.com/intent/tweet?url=" + share_url + "&hashtags=JobStack,jobs,Nigeria");
												$(".linkedin_link_'.$i.'").attr("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_url + "&title='.$user_profile->mLikedPosts[$i]['handle'].'" + "&source=JobStack");
												$(".whatsapp_link_'.$i.'").attr("href", "whatsapp://send?text=" + share_url);
												$(".telegram_link_'.$i.'").attr("href", "https://telegram.me/share/url?url=" + share_url);
											});
										</script>
									</div>
								</div>
							</div>
							</div>
						</div>
						';
					}
				}

			if (count($user_profile->mPostListPages ) > 1) {
						echo '
						<div class="row">
							<div class="col s12">
								<ul class="pagination center">';
									for ($m = 0; $m < count($user_profile->mPostListPages); $m++) {
										if ($user_profile->mPage == ($m+1)) {
											echo '<li class="waves-effect active red lighten-2"><a href="'.$user_profile->mPostListPages[$m].'">'.($m+1).'</a></li>';
										}
										else {
											echo '<li class="waves-effect"><a href="'.$user_profile->mPostListPages[$m].'">'.($m+1).'</a></li>';
										}
									}
								echo '
								</ul>
							</div>
						</div>';
					}
?>