<?php
	// my stream functionality
	//
	//
	//
	//
	//

	if ((Customer::GetCurrentCustomerId()) == $user_profile->mCustomer['customer_id']) {
		echo '
		<div class="fixed-action-btn">
			<a class="btn-floating btn-large teal white-text waves-effect waves-light modal-trigger" href="#post_to_your_profile_modal">
				<i class="far fa-edit"></i>
			</a>
		</div>
		<div id="post_to_your_profile_modal" class="modal white">
			<div class="modal-content">
				<a href="#!" class="modal-close btn-flat red-text text-lighten-2" id="close-modal"><i class="fas fa-arrow-left"></i></a>
				<br>';
				echo '
				<div class="row">
					<form class="col s12" method="post" enctype="multipart/form-data" action="'.$user_profile->mLinkToUserProfile.'">
						<div class="row">
							<div class="input-field col s12">
								<textarea id="post_to_your_profile" placeholder="Post to your profile" type="text" name="post_to_your_profile" style="width:100%;height:150px;padding:12px 20px;box-sizing:border-box;border:2px solid #ccc;border-radius:4px;background-color:white;resize:none;"></textarea>
							</div>
						</div>
						<div class="row center" id="comment_image_preview"></div>
						<div class="row" style="position:relative">
							<div class="col s12">
								<input type="file" name="PostImage[]" id ="comment_image" class="inputfile" multiple>
								<label for="comment_image" style="position:absolute;top:10px;"><i class="far fa-image fa-2x"></i></label>
								<button onclick="reset($(\'#comment_image\'));event.preventDefault();$(\'.container_thumbnail\').remove();" class="btn-small red lighten-2 white-text hide" id="resetFile" style="position:absolute;top:10px; left:40px;">Reset</button>
								<button class="btn-floating red lighten-2 white-text waves-effect waves-light right" type="submit" name="Button_Post" style="font-size:8px;"><i class="fas fa-plus fa-xs" style="font-size:12px;"></i></button>
							</div>
						</div>
					</form> 
				</div>
				<div class="row">
					<div class="col s12">
					<p class="teal-text"><small>Four (4) images max</small></p>
					</div>
				</div>';
		echo '
			</div>
		</div>
		<script>
			$(document).ready(function() {
				$("#post_to_your_profile_modal").on("change", "#comment_image", function() {
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
		</script>';
	}
					if (empty($user_profile->mMyStream)) {
						echo '
						<div>
							<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
							<h5 class="grey-text text-darken-2 center">No posts yet.</h5>
						</div>';
					}
					else {
						echo '<div class="myStreamMyStream">';
						for ($i=0; $i<count($user_profile->mMyStream); $i++) {
							echo '
							<div class="row card_my_stream'.$i.' post_customer_'.$user_profile->mMyStream[$i]['customer_id'].'">
								<div class="col s12 l10 offset-l1">
								<div class="card white grey-text text-darken-2 z-depth-0" style="border: 1px solid lightgrey;">
									<div class="card-content card_content_my_stream'.$i.'">
										<p style="position:relative;">
											<span>';
												if (empty($user_profile->mMyStream[$i]['avatar'])) {
													echo '
													<a href="'.$user_profile->mMyStream[$i]['link_to_user'].'" class="white-text">
													<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
															<span class="white-text" style="font-size:15px;"><b>'.substr($user_profile->mMyStream[$i]['handle'], 0, 1).'</b></span>
													</span>
													</a>';
												}
												else {
													echo '
													<a href="'.$user_profile->mMyStream[$i]['link_to_user'].'">
													<img src="'.$user_profile->mSiteUrl.'images/profile_pictures/'.$user_profile->mMyStream[$i]['avatar'].'" alt="'.$user_profile->mMyStream[$i]['handle'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;" />
													</a>
													';
												} 
				 							echo '
											</span>
											<span class="grey-text text-darken-2" style="position:absolute;">
												<b>&nbsp;<a href="'.$user_profile->mMyStream[$i]['link_to_user'].'" class="grey-text text-darken-2">
												'.$user_profile->mMyStream[$i]['handle'].'
												</a></b>
											</span>
											<span class="grey-text text-darken-2" style="position:absolute;top:20px">
												&nbsp;&nbsp;posted <span data-livestamp="'.date('Y-m-d H:i:s', strtotime($user_profile->mMyStream[$i]['date_posted'])).'"></span>
											</span>';
											if ($user_profile->mMyStream[$i]['customer_id'] != Customer::GetCurrentCustomerId() && Customer::GetCurrentCustomerId() != 0) {
												echo '
												<span class="grey-text text-darken-2" style="position:absolute;right:0;">
													<b><a class="dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="posts_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b> 
													<ul id="posts_dropdown_'.$i.'" class="dropdown-content" style="max-width:300px;">
														<li><a href="#!" id="hide_post_'.$i.'"><small><i class="fas fa-eye-slash"></i> Hide this post</small></a></li>
														<li><a href="#!" id="block_post_'.$i.'"><small><i class="fas fa-ban"></i> Block all posts from <b>'.$user_profile->mMyStream[$i]['handle'].'</b></small></a></li>
														<li class="report_'.$i.'"><a href="#!" id="report_post_'.$i.'"><small><i class="fas fa-flag"></i> Report this post</small></a></li>';
														if (!in_array($user_profile->mMyStream[$i]['customer_id'], $user_profile->mPeopleYouFollow)) {
															echo '<li class="follow_'.$i.' follow_customer_'.$user_profile->mMyStream[$i]['customer_id'].'"><a href="#!" id="follow_user_'.$i.'"><small><i class="fas fa-user-plus"></i> Follow <b>'.$user_profile->mMyStream[$i]['handle'].'</b></small></a></li>';
														}
														else {
															echo '
															<li class="unfollow_'.$i.' unfollow_customer_'.$user_profile->mMyStream[$i]['customer_id'].'">
																<a href="#!" id="unfollow_user_'.$i.'">
																	<small><i class="fas fa-user-plus"></i> Unfollow <b>'.$user_profile->mMyStream[$i]['handle'].'</b></small>
																</a>
															</li>';
														}
													echo '
													</ul>
												</span>
												<script>
													$(document).ready(function() {
														$(".dropdown_trigger'.$i.'").dropdown();

														// Hide post functionality
														$(".card_content_my_stream'.$i.'").on("click", "#hide_post_'.$i.'", function(event) {
															event.preventDefault();
															$(".card_my_stream'.$i.'").fadeOut(500);
															M.toast({html: "Hidden successfully"});
															$.post(
															"'.$user_profile->mLinkToUserProfile.'",
															{Hide_Post: "", PostId: '.$user_profile->mMyStream[$i]['post_id'].'},
															function(data) {
																// nothing
															}
															);
														});

														// Block User functionality
														$(".card_content_my_stream'.$i.'").on("click", "#block_post_'.$i.'", function(event) {
															event.preventDefault();
															$(".post_customer_'.$user_profile->mMyStream[$i]['customer_id'].'").fadeOut(500);
															M.toast({html: "Blocked successfully"});
															$.post(
															"'.$user_profile->mLinkToUserProfile.'",
															{Block_Post: "", BlockCustomerId: '.$user_profile->mMyStream[$i]['customer_id'].'},
															function(data) {
																// nothing
															}
															);
														});

														// Report User functionality
														$(".card_content_my_stream'.$i.'").on("click", "#report_post_'.$i.'", function(event) {
															event.preventDefault();
															$(".report_'.$i.'").remove();
															M.toast({html: "Reported successfully"});
															$.post(
															"'.$user_profile->mLinkToUserProfile.'",
															{Report_Post: "", CustomerId: '.$user_profile->mMyStream[$i]['customer_id'].', PostId: '.$user_profile->mMyStream[$i]['post_id'].'},
															function(data) {
																// nothing
															}
															);
														});

														// Follow User functionality
														$(".card_content_my_stream'.$i.'").on("click", "#follow_user_'.$i.'", function(event) {
															event.preventDefault();
															$(".follow_customer_'.$user_profile->mMyStream[$i]['customer_id'].'").remove();
															M.toast({html: "Following '.$user_profile->mMyStream[$i]['handle'].'"});
															$.post(
															"'.$user_profile->mLinkToUserProfile.'",
															{Follow_User: "", FollowCustomerId: '.$user_profile->mMyStream[$i]['customer_id'].'},
															function(data) {
																// nothing
															}
															);
														});

														// Unfollow User functionality
														$(".card_content_my_stream'.$i.'").on("click", "#unfollow_user_'.$i.'", function(event) {
															event.preventDefault();
															$(".unfollow_customer_'.$user_profile->mMyStream[$i]['customer_id'].'").remove();
															M.toast({html: "You unfollowed '.$user_profile->mMyStream[$i]['handle'].'"});
															$.post(
															"'.$user_profile->mLinkToUserProfile.'",
															{Unfollow_User: "", UnfollowCustomerId: '.$user_profile->mMyStream[$i]['customer_id'].'},
															function(data) {
																// nothing
															}
															);
														});
													});
												</script>';
											}
											elseif ($user_profile->mMyStream[$i]['customer_id'] == Customer::GetCurrentCustomerId() && Customer::GetCurrentCustomerId() != 0) {
												echo '
												<span class="grey-text text-darken-2" style="position:absolute;right:0;">
													<b><a class="dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="posts_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b>
													<ul id="posts_dropdown_'.$i.'" class="dropdown-content" style="max-width:300px;">
														<li><a href="#!" id="delete_post_'.$i.'"><small><i class="fas fa-trash"></i> Delete this post</small></a></li>
													</ul>
												</span>
												<script>
													$(document).ready(function() {
														$(".dropdown_trigger'.$i.'").dropdown();
														$(".card_content_my_stream'.$i.'").on("click", "#delete_post_'.$i.'", function(event) {
															event.preventDefault();
															$(".card_my_stream'.$i.'").fadeOut(500);
															M.toast({html: "Deleted successfully"});
															$.post(
															"'.$user_profile->mLinkToUserProfile.'",
															{Delete_Post: "", PostId: '.$user_profile->mMyStream[$i]['post_id'].'},
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
										</p>

										';
										if (!is_null($user_profile->mMyStream[$i]['job_id'])) {
											echo '
											<br>
											<h6 class="truncate" title="tag '.$user_profile->mMyStream[$i]['position_name'].' at '.$user_profile->mMyStream[$i]['company_name'].'">
												<small>
													<a class="teal-text truncate" href="'.$user_profile->mMyStream[$i]['link_to_popular_tags_page'].'"><i class="fas fa-hashtag"></i> &nbsp;'.$user_profile->mMyStream[$i]['position_name'].' at '.$user_profile->mMyStream[$i]['company_name'].'
													</a>
												</small>
											</h6>
											';
										}
										else {
											echo '<br>';
										}
										echo'
										<br>
										<span style="white-space:pre-line;"><a id="postOfflineText'.$i.'" href="'.$user_profile->mMyStream[$i]['link_to_post_details'].'" class="grey-text text-darken-2">'.$user_profile->mMyStream[$i]['post'].'</a></span>
										<script>
											$(document).ready(function() {
												var fullReviewText'.$i.' = $("#postOfflineText'.$i.'").text();
												if ($("#postOfflineText'.$i.'").text().length > 150) {
													var extractText = $("#postOfflineText'.$i.'").text().substring(0, 150);
													$("#postOfflineText'.$i.'").text(extractText + "...").append("<a href=\"#!\" class=\"grey-text text-darken-2 moreButton'.$i.'\">Read more</a><br><br>");
												}
												$(".card_content_my_stream'.$i.'").on("click", ".moreButton'.$i.'", function(event) {
													event.preventDefault();
													$("#postOfflineText'.$i.'").text(fullReviewText'.$i.');
												});
											});
										</script>
										<br><br>';
										if (!empty($user_profile->mMyStream[$i]['post_images']) || !is_null($user_profile->mMyStream[$i]['post_images'])) {
											for ($m=0; $m<count($user_profile->mMyStream[$i]['post_images']); $m++) {
												if (count($user_profile->mMyStream[$i]['post_images']) == 1) {
													echo '
														<div class="row">
															<div class="col s12">
																<img src="'.$user_profile->mSiteUrl.'/images/post_images/'.$user_profile->mMyStream[$i]['post_images'][$m]['image'].'" alt="'.$user_profile->mMyStream[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;margin:auto;display:block;" />
															</div>
														</div>
													';
												}
												if (count($user_profile->mMyStream[$i]['post_images']) == 2) {
													if ($m == 0) {
														echo '<div class="row">';
													}
													echo '
														<div class="col s6 m6 l6">
															<img src="'.$user_profile->mSiteUrl.'/images/post_images/'.$user_profile->mMyStream[$i]['post_images'][$m]['image'].'" alt="'.$user_profile->mMyStream[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
														</div>
													';
													if ($m == 1) {
														echo '</div>';
													}
												}
												if (count($user_profile->mMyStream[$i]['post_images']) == 3) {
													if ($m == 0) {
														echo '<div class="row">';
													}
													if ($m == 0 || $m == 1)
													echo '
														<div class="col s6 m6 l6">
															<img src="'.$user_profile->mSiteUrl.'/images/post_images/'.$user_profile->mMyStream[$i]['post_images'][$m]['image'].'" alt="'.$user_profile->mMyStream[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
														</div>
													';
													if ($m == 1) {
														echo '</div>';
													}
													if ($m == 2) {
														echo '
														<div class="row">
															<div class="col s12">
																<img src="'.$user_profile->mSiteUrl.'/images/post_images/'.$user_profile->mMyStream[$i]['post_images'][$m]['image'].'" alt="'.$user_profile->mMyStream[$i]['post_images'][$m]['image'].'  picture" class="responsive-img materialboxed" style="border-radius:4px;" />
															</div>
														</div>
														';
													}
												}
												if (count($user_profile->mMyStream[$i]['post_images']) == 4) {
													if ($m == 0 || $m == 2) {
														echo '<div class="row">';
													}
													echo '
														<div class="col s6 m6 l6">
															<img src="'.$user_profile->mSiteUrl.'/images/post_images/'.$user_profile->mMyStream[$i]['post_images'][$m]['image'].'" alt="'.$user_profile->mMyStream[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
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
											echo '<a href="'.$user_profile->mMyStream[$i]['link_to_post_details'].'" class="grey-text text-darken-2"><span class="fas fa-comment"></span> '.$user_profile->mMyStream[$i]['comments_count'].'</a>
											<span style="position:absolute;left:46%;" id="like_post_functionality_'.$i.'" class="scale-transition ';
												if ($user_profile->mMyStream[$i]['is_liked'] == 'yes') {
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
												if ($user_profile->mMyStream[$i]['is_liked'] == 'yes') {
														echo 'scale-in';
													}
												else {
													echo 'scale-out';
												}
											echo ' 
											">
												<i class="fas fa-thumbs-up red-text text-darken-2 like_post_red_'.$i.'"></i>
											</span>
											<span style="position:absolute;left:53%;" id="liked_text_'.$i.'"> &nbsp;'.$user_profile->mMyStream[$i]['total_likes'].'</span>';
											if (Customer::GetCurrentCustomerId() !== 0) {
											echo '
											<script>
												$(document).ready(function() {
													$("#like_functionality_'.$i.'").on("click", "#like_post_functionality_'.$i.'", function(){
														$("#like_post_functionality_'.$i.'").removeClass("scale-in").addClass("scale-out");
														var liked_text = $("#liked_text_'.$i.'").text();
														liked_text++;
														$("#liked_text_'.$i.'").html(" &nbsp;" + liked_text);
														$("#dislike_post_functionality_'.$i.'").removeClass("scale-out").addClass("scale-in");
														$.post("'.$user_profile->mLinkToUserProfile.'",
														{Like: "Like", PostId: '.$user_profile->mMyStream[$i]['post_id'].'},
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
														$.post("'.$user_profile->mLinkToUserProfile.'",
														{Dislike: "Dislike", PostId: '.$user_profile->mMyStream[$i]['post_id'].'},
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
														$("#like_functionality_'.$i.'").on("click", "#like_post_functionality_'.$i.'", function(){
															window.location.href = "'.$user_profile->mLinkToLoginPage.'";
														});
														$("#like_functionality_'.$i.'").on("click", "#dislike_post_functionality_'.$i.'", function(){
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
													var share_url = encodeURIComponent("'.$user_profile->mMyStream[$i]['link_to_post_details'].'");

													$(".facebook_link_'.$i.'").attr("href", "https://www.facebook.com/sharer.php?u=" + share_url);
													$(".twitter_link_'.$i.'").attr("href", "https://twitter.com/intent/tweet?url=" + share_url + "&hashtags=JobStack,jobs,Nigeria");
													$(".linkedin_link_'.$i.'").attr("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_url + "&title='.$user_profile->mMyStream[$i]['handle'].'" + "&source=JobStack");
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
						echo '</div>';
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