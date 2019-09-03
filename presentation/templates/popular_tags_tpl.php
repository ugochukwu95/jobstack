<?php
	require_once PRESENTATION_DIR . 'popular_tags.php';
	$popular_tags = new PopularTags();
	$popular_tags->init();
	if (!is_null($popular_tags->mErrorMessage) || $popular_tags->mErrorMessage != '') {
		echo '
		<div class="row">
			<div class="col s12 m12">
				<div class="alertBox">
					<span class="alertBoxCloseBtn" onclick="this.parentElement.style.display=\'none\'">&times;</span>
					'.$popular_tags->mErrorMessage.'
				</div>
			</div>
		<div>
		';
	}
	if (!empty($popular_tags->mPosts)) {
		echo '
		<div class="row">
		<div class="col s12 l10 offset-l1">
			<br>
			<ul class="collection">';
				if (count($popular_tags->mPosts) < 2) {
					$items_count = 'post'; 
				}
				else {
					$items_count = 'posts';
				}
				echo ' 
				<li class="collection-item avatar">
					<i class="fas fa-hashtag circle teal white-text"></i>
					<span class="title">
						<a href="'.$popular_tags->mLinkToJob.'" class="grey-text text-darken-2">'.$popular_tags->mJobName.'</a>
					</span>
					<p class="grey-text text-darken-2"><small>#'.count($popular_tags->mPosts).' '.$items_count.'</small></p>
					<p><a href="'.$popular_tags->mLinkToJob.'" class="btn-small red lighten-2 white-text waves-light waves-effect">SEE JOB</a></p>
				</li>';
			echo '
			</ul>
		</div>
		</div>
		';
	}
	
	if (!empty($popular_tags->mPosts)) {
	    if ($popular_tags->mUserId == 0) {
	        echo '
	            <div class="row">
	                <div class="col s12 m10 offset-m1 l10 offset-l1">
	                    <div class="card white">
	                        <div class="card-image">
	                            <img src="'.$popular_tags->mLinkToCommunityImage.'" class="responsive-img" alt="join-our-community">
	                        </div>
	                        <div class="card-content">
	                            <p class="grey-text text-darken-2">Join our community to be able to create posts, like and comment on already created posts amongst other 
	                            wonderful features.</p>
	                            <br>
	                            <p class="grey-text text-darken-2">For example, the "<i class="fas fa-hashtag"></i>" you see on the job boards lets you
	                             say what you think of that particular job posting. Is the pay good? Are the staff helpful and kind?</p>
	                        </div>
	                        <div class="card-action">
	                            <a href="'.$popular_tags->mLinkToLoginPage.'" class="btn waves-effect waves-light red lighten-2 white-text">Login / Register</a>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        ';
	    }
	}
	
		echo '
		<div class=" if_no_posts hide">
			<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
			<h5 class="grey-text text-darken-2 center">There are no posts yet.</h5>
		</div>';
		if (empty($popular_tags->mPosts)) {
			if ($popular_tags->mUserId != 0) {
				$first = '<a class="red-text text-lighten-2 modal-trigger" href="#post_to_your_profile_modal">first</a>';
				$comment = '<a class="red-text text-lighten-2 modal-trigger" href="#post_to_your_profile_modal">comment</a>';
				$picture = '<a class="red-text text-lighten-2 modal-trigger" href="#post_to_your_profile_modal">picture</a>';
			}
			else {
				$first = '<a class="red-text text-lighten-2" href="'.$popular_tags->mLinkToLoginPage.'">first</a>';
				$comment = '<a class="red-text text-lighten-2 modal-trigger" href="'.$popular_tags->mLinkToLoginPage.'">comment</a>';
				$picture = '<a class="red-text text-lighten-2 modal-trigger" href="'.$popular_tags->mLinkToLoginPage.'">picture</a>';
			}
			echo '<h1 class="center grey-text text-darken-2">:-(</h1><br><br>';
			echo '<h5 class="grey-text text-darken-2 center">There are no posts yet.</h5>';
			echo '<h5 class="grey-text text-darken-2 center">Be the '.$first.' to make a '.$comment.' or post a '.$picture.'</h5>';
		}
		if ($popular_tags->mUserId != 0) {
			echo '
			<div class="fixed-action-btn">
				<a class="btn-floating btn-large teal white-text waves-effect waves-light modal-trigger" href="#post_to_your_profile_modal">
				<i class="far fa-edit"></i>
				</a>
			</div>
			<div id="post_to_your_profile_modal" class="modal">
				<div class="modal-content white">
					<a href="#!" class="modal-close btn-flat red-text text-lighten-2" id="close-modal"><i class="fas fa-arrow-left"></i></a>
					<br>';
					echo '
					<div class="row">
						<form class="col s12" method="post" enctype="multipart/form-data" action="'.$popular_tags->mLinkToPopularTags.'">
						<h6 class="center teal truncate white-text col s12 m12" style="padding:8px;"><small><i class="fas fa-hashtag"></i> &nbsp;'.$popular_tags->mJobName.'</small></h6>
						<div class="row">
							<div class="input-field col s12">
								<textarea id="post_to_your_profile" type="text" name="Post" placeholder="What is happening? What\'s new?" style="width:100%;height:150px;padding:12px 20px;box-sizing:border-box;border:2px solid lightgrey;border-radius:4px;background-color:white;resize:none;"></textarea>
							</div>
						</div>
						<div class="row center" id="comment_image_preview"></div>
						<div class="row" style="position:relative">
							<div class="col s12">
								<input type="file" name="PostImage[]" id ="comment_image" class="inputfile" multiple>
								<label for="comment_image" style="position:absolute;top:10px;"><i class="far fa-image fa-2x"></i></label>
								<button onclick="reset($(\'#comment_image\'));event.preventDefault();$(\'.container_thumbnail\').remove();" class="btn-small red lighten-2 white-text hide" id="resetFile" style="position:absolute;top:10px; left:40px;">Reset</button>
								<button class="btn-floating red lighten-2 white-text waves-effect waves-light right" type="submit" name="Button_Post_With_Tag" style="font-size:8px;"><i class="fas fa-plus fa-xs" style="font-size:12px;"></i></button>
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
				</script>
			</div>';
		}
		if ($popular_tags->mUserId != 0 && !empty($popular_tags->mPosts)) {
			echo '
			<div class="row">
				<div class="col s12 l10 offset-l1">
					<h6 class="grey-text text-darken-2">Posts <i class="fas fa-arrow-down"></i></h6>
				</div>
			</div>
			';
			for ($i=0; $i<count($popular_tags->mPosts); $i++) {
				echo '
				<div class="row card_my_stream'.$i.' post_customer_'.$popular_tags->mPosts[$i]['customer_id'].'">
					<div class="col s12 l10 offset-l1">
						<div class="card white grey-text text-darken-2 z-depth-0" style="border: 1px solid lightgrey;">
							<div class="card-content card_content_my_stream'.$i.'">
								<p style="position:relative;">
									<span>';
										if (empty($popular_tags->mPosts[$i]['avatar'])) {
											echo '
											<a href="'.$popular_tags->mPosts[$i]['link_to_user'].'" class="white-text">
												<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
													<span class="white-text" style="font-size:15px;"><b>'.substr($popular_tags->mPosts[$i]['handle'], 0, 1).'</b></span>
												</span>
											</a>';
										}
										else {
											echo '
											<a href="'.$popular_tags->mPosts[$i]['link_to_user'].'">
												<img src="'.$popular_tags->mSiteUrl.'images/profile_pictures/'.$popular_tags->mPosts[$i]['avatar'].'" alt="'.$popular_tags->mPosts[$i]['handle'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;" />
											</a>
											';
										} 
					 					echo '
									</span>
									<span class="grey-text text-darken-2" style="position:absolute;">
										<b>&nbsp;<a href="'.$popular_tags->mPosts[$i]['link_to_user'].'" class="grey-text text-darken-2">
												'.$popular_tags->mPosts[$i]['handle'].'
										</a></b>
									</span>
									<span class="grey-text text-darken-2" style="position:absolute;top:20px">
										&nbsp;&nbsp;posted <span data-livestamp="'.date('Y-m-d H:i:s', strtotime($popular_tags->mPosts[$i]['date_posted'])).'"></span>
									</span>';
									if ($popular_tags->mPosts[$i]['customer_id'] != $popular_tags->mUserId) {
										echo '
										<span class="grey-text text-darken-2" style="position:absolute;right:0;">
											<b><a class="dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="posts_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b> 
											<ul id="posts_dropdown_'.$i.'" class="dropdown-content" style="max-width:300px;">
												<li><a href="#!" id="hide_post_'.$i.'"><small><i class="fas fa-eye-slash"></i> Hide this post</small></a></li>
												<li><a href="#!" id="block_post_'.$i.'"><small><i class="fas fa-ban"></i> Block all posts from <b>'.$popular_tags->mPosts[$i]['handle'].'</b></small></a></li>
												<li class="report_'.$i.'"><a href="#!" id="report_post_'.$i.'"><small><i class="fas fa-flag"></i> Report this post</small></a></li>';
												if (!in_array($popular_tags->mPosts[$i]['customer_id'], $popular_tags->mPeopleYouFollow)) {
													echo '
													<li class="follow_'.$popular_tags->mPosts[$i]['customer_id'].'"><a href="#!" id="follow_user_'.$i.'"><small><i class="fas fa-user-plus"></i> Follow <b>'.$popular_tags->mPosts[$i]['handle'].'</b></small></a></li>';
												}
												else {
													echo '
													<li class="unfollow_'.$popular_tags->mPosts[$i]['customer_id'].'"><a href="#!" id="unfollow_user_'.$i.'"><small><i class="fas fa-user-plus"></i> Unfollow <b>'.$popular_tags->mPosts[$i]['handle'].'</b></small></a></li>';
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
													$.post(
														"'.$popular_tags->mLinkToPopularTags.'",
														{Hide_Post: "", PostId: '.$popular_tags->mPosts[$i]['post_id'].'},
														function(data) {
															$(".card_my_stream'.$i.'").fadeOut(500);
															M.toast({html: "Hidden successfully"});
														}
													);
												});

												// Block User functionality
												$(".card_content_my_stream'.$i.'").on("click", "#block_post_'.$i.'", function(event) {
													event.preventDefault();
													$.post(
														"'.$popular_tags->mLinkToPopularTags.'",
														{Block_Post: "", BlockCustomerId: '.$popular_tags->mPosts[$i]['customer_id'].'},
														function(data) {
															$(".post_customer_'.$popular_tags->mPosts[$i]['customer_id'].'").fadeOut(500);
															M.toast({html: "Blocked successfully"});
														}
													);
												});

												// Report User functionality
												$(".card_content_my_stream'.$i.'").on("click", "#report_post_'.$i.'", function(event) {
													event.preventDefault();
													$.post(
														"'.$popular_tags->mLinkToPopularTags.'",
														{Report_Post: "", CustomerId: '.$popular_tags->mPosts[$i]['customer_id'].', PostId: '.$popular_tags->mPosts[$i]['post_id'].'},
														function(data) {
															$(".report_'.$i.'").fadeOut(500);
															M.toast({html: "Reported successfully"});
														}
													);
												});

												// Follow User functionality
												$(".card_content_my_stream'.$i.'").on("click", "#follow_user_'.$i.'", function(event) {
													event.preventDefault();
													$.post(
														"'.$popular_tags->mLinkToPopularTags.'",
														{Follow_User: "", FollowCustomerId: '.$popular_tags->mPosts[$i]['customer_id'].'},
														function(data) {
															$(".follow_'.$popular_tags->mPosts[$i]['customer_id'].'").remove();
															M.toast({html: "Following '.$popular_tags->mPosts[$i]['handle'].'"});
														}
													);
												});
												// Unfollow User functionality
												$(".card_content_my_stream'.$i.'").on("click", "#unfollow_user_'.$i.'", function(event) {
													event.preventDefault();
													$.post(
														"'.$popular_tags->mLinkToPopularTags.'",
														{Unfollow_User: "", UnfollowCustomerId: '.$popular_tags->mPosts[$i]['customer_id'].'},
														function(data) {
															$(".unfollow_'.$popular_tags->mPosts[$i]['customer_id'].'").remove();
															M.toast({html: "You unfollowed '.$popular_tags->mPosts[$i]['handle'].'"});
														}
													);
												});
											});
										</script>';
									}
									else {
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
													$.post(
														"'.$popular_tags->mLinkToPopularTags.'",
														{Delete_Post: "", PostId: '.$popular_tags->mPosts[$i]['post_id'].'},
														function(data) {
															$(".card_my_stream'.$i.'").fadeOut(500);
															M.toast({html: "Deleted successfully"});
														}
													);
												});
											});
										</script>';
									}
									echo '
									</p>
									<br><br>
									<span style="white-space:pre-line;"><a id="postOnlineText'.$i.'" href="'.$popular_tags->mPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2">'.$popular_tags->mPosts[$i]['post'].'</a></span>
									<script>
										$(document).ready(function() {
											var fullReviewText'.$i.' = $("#postOnlineText'.$i.'").text();
											if ($("#postOnlineText'.$i.'").text().length > 350) {
												var extractText = $("#postOnlineText'.$i.'").text().substring(0, 350);
												$("#postOnlineText'.$i.'").text(extractText + "...").append("<a href=\"#!\" class=\"grey-text text-darken-2 moreButton'.$i.'\">Read more</a><br><br>");
											}
											$(".card_content_my_stream'.$i.'").on("click", ".moreButton'.$i.'", function(event) {
												event.preventDefault();
												$("#postOnlineText'.$i.'").text(fullReviewText'.$i.');
											});
										});
									</script>
									<br><br>';
									if (!empty($popular_tags->mPosts[$i]['post_images']) || !is_null($popular_tags->mPosts[$i]['post_images'])) {
										for ($m=0; $m<count($popular_tags->mPosts[$i]['post_images']); $m++) {
											if (count($popular_tags->mPosts[$i]['post_images']) == 1) {
												echo '
													<div class="row">
														<div class="col s12 center">
															<img src="'.$popular_tags->mSiteUrl.'/images/post_images/'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'  picture" class="center materialboxed responsive-img" style="border-radius:4px;margin:auto;display:block;" />
														</div>
													</div>
												';
											}
											if (count($popular_tags->mPosts[$i]['post_images']) == 2) {
												if ($m == 0) {
													echo '<div class="row">';
												}
												echo '
													<div class="col s6 m6 l6">
														<img src="'.$popular_tags->mSiteUrl.'/images/post_images/'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
													</div>
												';
												if ($m == 1) {
													echo '</div>';
												}
											}
											if (count($popular_tags->mPosts[$i]['post_images']) == 3) {
												if ($m == 0) {
													echo '<div class="row">';
												}
												if ($m == 0 || $m == 1)
												echo '
													<div class="col s6 m6 l6">
														<img src="'.$popular_tags->mSiteUrl.'/images/post_images/'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
													</div>
												';
												if ($m == 1) {
													echo '</div>';
												}
												if ($m == 2) {
													echo '
													<div class="row">
														<div class="col s12">
															<img src="'.$popular_tags->mSiteUrl.'/images/post_images/'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'  picture" class="responsive-img materialboxed" style="border-radius:4px;" />
														</div>
													</div>
													';
												}
											}
											if (count($popular_tags->mPosts[$i]['post_images']) == 4) {
												if ($m == 0 || $m == 2) {
													echo '<div class="row">';
												}
												echo '
													<div class="col s6 m6 l6">
														<img src="'.$popular_tags->mSiteUrl.'/images/post_images/'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
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
										<a href="'.$popular_tags->mPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2"><span class="fas fa-comment"></span> '.$popular_tags->mPosts[$i]['comments_count'].'</a>
										<span style="position:absolute;left:46%;" id="like_post_functionality_'.$i.'" class="scale-transition ';
										if ($popular_tags->mPosts[$i]['is_liked'] == 'yes') {
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
										if ($popular_tags->mPosts[$i]['is_liked'] == 'yes') {
											echo 'scale-in';
										}
										else {
											echo 'scale-out';
										}
										echo ' 
										">
											<i class="fas fa-thumbs-up red-text text-darken-2 like_post_red_'.$i.'"></i>
										</span>
										<span style="position:absolute;left:53%;" id="liked_text_'.$i.'"> &nbsp;'.$popular_tags->mPosts[$i]['total_likes'].'</span>';
										if ($popular_tags->mUserId != 0) {
											echo '
											<script>
												$(document).ready(function() {
													$("#like_functionality_'.$i.'").on("click", "#like_post_functionality_'.$i.'", function(){
														$("#like_post_functionality_'.$i.'").removeClass("scale-in").addClass("scale-out");
														var liked_text = $("#liked_text_'.$i.'").text();
															liked_text++;
															$("#liked_text_'.$i.'").html(" &nbsp;" + liked_text);
														$("#dislike_post_functionality_'.$i.'").removeClass("scale-out").addClass("scale-in");
														$.post("'.$popular_tags->mLinkToPopularTags.'",
														{Like: "Like", PostId: '.$popular_tags->mPosts[$i]['post_id'].'},
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
														$.post("'.$popular_tags->mLinkToPopularTags.'",
														{Dislike: "Dislike", PostId: '.$popular_tags->mPosts[$i]['post_id'].'},
														function(data) {
															// nothing
														}
														)
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
												var share_url = encodeURIComponent("'.$popular_tags->mPosts[$i]['link_to_post_details'].'");

												$(".facebook_link_'.$i.'").attr("href", "https://www.facebook.com/sharer.php?u=" + share_url);
												$(".twitter_link_'.$i.'").attr("href", "https://twitter.com/intent/tweet?url=" + share_url + "&hashtags=JobStack,jobs,Nigeria");
												$(".linkedin_link_'.$i.'").attr("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_url + "&title='.$popular_tags->mPosts[$i]['handle'].'" + "&source=JobStack");
												$(".whatsapp_link_'.$i.'").attr("href", "whatsapp://send?text=" + share_url);
												$(".telegram_link_'.$i.'").attr("href", "https://telegram.me/share/url?url=" + share_url);
											});
										</script>
									</div>
								</div>
							</div>
					</div>
				</div>';
			}
			if (count($popular_tags->mPostListPages ) > 1) {
				echo '
				<div class="row">
					<div class="col s12">
						<ul class="pagination center">';
							for ($m = 0; $m < count($popular_tags->mPostListPages); $m++) {
								if ($popular_tags->mPage == ($m+1)) {
									echo '<li class="waves-effect active red lighten-2"><a href="'.$popular_tags->mPostListPages[$m].'"><small>'.($m+1).'</small></a></li>';
								}
								else {
									echo '<li class="waves-effect"><a href="'.$popular_tags->mPostListPages[$m].'"><small>'.($m+1).'</small></a></li>';
								}
							}
						echo '
						</ul>
					</div>
				</div>';
			}
		}
		else {
			for ($i=0; $i<count($popular_tags->mPosts); $i++) {
				echo '
				<div class="row card_my_stream'.$i.' post_customer_'.$popular_tags->mPosts[$i]['customer_id'].'">
					<div class="col s12 l10 offset-l1">
						<div class="card white grey-text text-darken-2 z-depth-0" style="border: 1px solid lightgrey;">
							<div class="card-content card_content_my_stream'.$i.'">
								<p style="position:relative;">
									<span>';
										if (empty($popular_tags->mPosts[$i]['avatar'])) {
											echo '
											<a href="'.$popular_tags->mPosts[$i]['link_to_user'].'" class="white-text">
												<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
													<span class="white-text" style="font-size:15px;"><b>'.substr($popular_tags->mPosts[$i]['handle'], 0, 1).'</b></span>
												</span>
											</a>';
										}
										else {
											echo '
											<a href="'.$popular_tags->mPosts[$i]['link_to_user'].'">
												<img src="'.$popular_tags->mSiteUrl.'images/profile_pictures/'.$popular_tags->mPosts[$i]['avatar'].'" alt="'.$popular_tags->mPosts[$i]['handle'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;" />
											</a>
											';
										} 
					 					echo '
									</span>
									<span class="grey-text text-darken-2" style="position:absolute;">
										<b>&nbsp;<a href="'.$popular_tags->mPosts[$i]['link_to_user'].'" class="grey-text text-darken-2">
												'.$popular_tags->mPosts[$i]['handle'].'
										</a></b>
									</span>
									<span class="grey-text text-darken-2" style="position:absolute;top:20px">
										&nbsp;&nbsp;posted <time class="timeago" datetime="'.date('Y-m-d H:i:s', strtotime($popular_tags->mPosts[$i]['date_posted'])).'">'.date('m').' '.date('d').', '.date('Y').'</time>
									</span>';
									echo '
									</p>';
									echo '
									<br><br>
									<span style="white-space:pre-line;"><a id="postOfflineText'.$i.'" href="'.$popular_tags->mPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2">'.$popular_tags->mPosts[$i]['post'].'</a></span>
									<script>
										$(document).ready(function() {
											var fullReviewText'.$i.' = $("#postOfflineText'.$i.'").text();
											if ($("#postOfflineText'.$i.'").text().length > 350) {
												var extractText = $("#postOfflineText'.$i.'").text().substring(0, 350);
												$("#postOfflineText'.$i.'").text(extractText + "...").append("<a href=\"#!\" class=\"grey-text text-darken-2 moreButton'.$i.'\">Read more</a><br><br>");
											}
											$(".card_content_my_stream'.$i.'").on("click", ".moreButton'.$i.'", function(event) {
												event.preventDefault();
												$("#postOfflineText'.$i.'").text(fullReviewText'.$i.');
											});
										});
									</script>
									<br><br>';
									if (!empty($popular_tags->mPosts[$i]['post_images']) || !is_null($popular_tags->mPosts[$i]['post_images'])) {
										for ($m=0; $m<count($popular_tags->mPosts[$i]['post_images']); $m++) {
											if (count($popular_tags->mPosts[$i]['post_images']) == 1) {
												echo '
													<div class="row">
														<div class="col s12">
															<img src="'.$popular_tags->mSiteUrl.'/images/post_images/'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;margin:auto;display:block;" />
														</div>
													</div>
												';
											}
											if (count($popular_tags->mPosts[$i]['post_images']) == 2) {
												if ($m == 0) {
													echo '<div class="row">';
												}
												echo '
													<div class="col s6 m6 l6">
														<img src="'.$popular_tags->mSiteUrl.'/images/post_images/'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
													</div>
												';
												if ($m == 1) {
													echo '</div>';
												}
											}
											if (count($popular_tags->mPosts[$i]['post_images']) == 3) {
												if ($m == 0) {
													echo '<div class="row">';
												}
												if ($m == 0 || $m == 1)
												echo '
													<div class="col s6 m6 l6">
														<img src="'.$popular_tags->mSiteUrl.'/images/post_images/'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
													</div>
												';
												if ($m == 1) {
													echo '</div>';
												}
												if ($m == 2) {
													echo '
													<div class="row">
														<div class="col s12">
															<img src="'.$popular_tags->mSiteUrl.'/images/post_images/'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'  picture" class="responsive-img materialboxed" style="border-radius:4px;" />
														</div>
													</div>
													';
												}
											}
											if (count($popular_tags->mPosts[$i]['post_images']) == 4) {
												if ($m == 0 || $m == 2) {
													echo '<div class="row">';
												}
												echo '
													<div class="col s6 m6 l6">
														<img src="'.$popular_tags->mSiteUrl.'/images/post_images/'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$popular_tags->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
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
										<a href="'.$popular_tags->mPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2"><span class="fas fa-comment"></span> '.$popular_tags->mPosts[$i]['comments_count'].'</a>
										<span style="position:absolute;left:46%;">
											<i class="fas fa-thumbs-up like_post_grey_'.$i.'"></i>
										</span>
										<span style="position:absolute;left:53%;"> &nbsp;'.$popular_tags->mPosts[$i]['total_likes'].'</span>';
										echo '
										<script>
											$(document).ready(function() {
												$("#like_functionality_'.$i.'").on("click", ".like_post_grey_'.$i.'", function(){
													window.location.href = "'.$popular_tags->mLinkToLoginPage.'";
												});
											});
										</script>';
										echo '
										<span class="right share_dropdown-trigger_'.$i.'" data-target="share_dropdown_'.$i.'"><span class="fas fa-share"></span> Share</span>
										<ul id="share_dropdown_'.$i.'" class="dropdown-content">
											<li><a href="#!" class="facebook_link_'.$i.'" target="_blank"><b><small><i class="fab fa-facebook-square"></i> Facebook</small></b></a></li>
											<li><a href="#!" target="_blank" class="twitter_link_'.$i.'"><b><small><i class="fab fa-twitter"></i> Twitter</small></b></a></li>
											<li><a href="#!" target="_blank" class="linkedin_link_'.$i.'"><b><small><i class="fab fa-linkedin"></i> LinkedIn</small></b></a></li>
										</ul>
										<script>
											$(document).ready(function() {
												$(".share_dropdown-trigger_'.$i.'").dropdown();
												var share_url = encodeURIComponent("'.$popular_tags->mPosts[$i]['link_to_post_details'].'");

												$(".facebook_link_'.$i.'").attr("href", "https://www.facebook.com/sharer.php?u=" + share_url);
												$(".twitter_link_'.$i.'").attr("href", "https://twitter.com/intent/tweet?url=" + share_url + "&hashtags=JobStack,jobs,Nigeria");
												$(".linkedin_link_'.$i.'").attr("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_url + "&title='.$popular_tags->mPosts[$i]['handle'].'" + "&source=JobStack");
											});
										</script>
									</div>
								</div>
							</div>
					</div> 
				</div>';
			}
			if (count($popular_tags->mPostListPages ) > 1) {
				echo '
				<div class="row">
					<div class="col s12">
						<ul class="pagination center">';
							for ($m = 0; $m < count($popular_tags->mPostListPages); $m++) {
								if ($popular_tags->mPage == ($m+1)) {
									echo '<li class="waves-effect active red lighten-2"><a href="'.$popular_tags->mPostListPages[$m].'"><small>'.($m+1).'</small></a></li>';
								}
								else {
									echo '<li class="waves-effect"><a href="'.$popular_tags->mPostListPages[$m].'"><small>'.($m+1).'</small></a></li>';
								}
							}
						echo '
						</ul>
					</div>
				</div>';
			}
		}
?>