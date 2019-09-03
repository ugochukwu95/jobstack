<?php
	require_once PRESENTATION_DIR . 'trending_chatter.php';
	$trending_chatter = new TrendingChatter();
	$trending_chatter->init();
	if (!is_null($trending_chatter->mErrorMessage) || $trending_chatter->mErrorMessage != '') {
		echo '
		<div class="row">
			<div class="col s12 m12 l8 offset-l2">
				<div class="alertBox">
					<span class="alertBoxCloseBtn" onclick="this.parentElement.style.display=\'none\'">&times;</span>
					'.$trending_chatter->mErrorMessage.'
				</div>
			</div>
		<div>
		';
	}
	echo '
	<style>
	.collection-item:hover {
		background-color: ghostwhite;
	}
	</style>
	
	<div class="row">
		<div class="col s12">
		    <br>
			<ul class="tabs">
				<li class="tab col l6"><a href="#trending"><i class="fas fa-chart-line"></i> Trending Chatter</a></li>
				<li class="tab col l6"><a href="#popular"><i class="fas fa-hashtag"></i> Popular Tags</a></li>
			</ul>
		</div>
		<div id="trending" class="col s12">
    		<br>';
    		if ((Customer::GetCurrentCustomerId()) == 0) {
        		echo '
        		<div class="row">
        			<div class="col s12 l8 offset-l2">
                        <div class="card white">
                            <div class="card-content">
                                <p class="grey-text text-darken-2">Join our community to be able to create posts, like and comment on already created posts amongst other 
                                wonderful features.</p>
                                <br>
                                <p class="grey-text text-darken-2">For example, the "<i class="fas fa-hashtag"></i>" you see on the job boards lets you
                                 say what you think of that particular job posting. Is the pay good? Are the staff helpful and kind?</p>
                            </div>
                            <div class="card-action">
                                <a href="'.$trending_chatter->mLinkToLoginPage.'" class="btn waves-effect waves-light red lighten-2 white-text">Login / Register</a>
                            </div>
                        </div>
                    </div>
        		</div>';
    		}
    		if ((Customer::GetCurrentCustomerId()) != 0) {
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
    						<form class="col s12" enctype="multipart/form-data" method="post" action="'.$trending_chatter->mLinkToTrendingChatter.'">
    						<div class="row">
    							<div class="input-field col s12">
    								<textarea id="post_to_your_profile" type="text" placeholder="What is happening? What\'s new?" name="post_to_your_profile" style="width:100%;height:150px;padding:12px 20px;box-sizing:border-box;border:2px solid lightgrey;border-radius:4px;background-color:white;resize:none;"></textarea>
    							</div>
    						</div>
    						<div class="row center" id="comment_image_preview"></div>
    						<div class="row" style="position:relative">
    							<div class="col s12 input_file_div">
    								<input type="file" name="PostImage[]" id ="comment_image" class="inputfile" multiple="multiple">
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
		    echo '<div class="row">';
    		if (Customer::GetCurrentCustomerId() != 0) {
    			for ($i=0; $i<count($trending_chatter->mPosts); $i++) {
    				echo '
    					<div class="col s12 l8 offset-l2 card_my_stream'.$i.' post_customer_'.$trending_chatter->mPosts[$i]['customer_id'].'">
    						<div class="card white grey-text text-darken-2 z-depth-0" style="border: 1px solid lightgrey;">
    							<div class="card-content card_content_my_stream'.$i.'">
    								<p style="position:relative;">
    									<span>';
    										if (empty($trending_chatter->mPosts[$i]['avatar'])) {
    											echo '
    											<a href="'.$trending_chatter->mPosts[$i]['link_to_user'].'" class="white-text">
    												<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
    													<span class="white-text" style="font-size:15px;"><b>'.substr($trending_chatter->mPosts[$i]['handle'], 0, 1).'</b></span>
    												</span>
    											</a>';
    										}
    										else {
    											echo '
    											<a href="'.$trending_chatter->mPosts[$i]['link_to_user'].'">
    												<img src="'.$trending_chatter->mSiteUrl.'images/profile_pictures/'.$trending_chatter->mPosts[$i]['avatar'].'" alt="'.$trending_chatter->mPosts[$i]['handle'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;" />
    											</a>
    											';
    										} 
    					 					echo '
    									</span>
    									<span class="grey-text text-darken-2" style="position:absolute;top:0;">
    										<b>&nbsp;<a href="'.$trending_chatter->mPosts[$i]['link_to_user'].'" class="grey-text text-darken-2">
    												'.$trending_chatter->mPosts[$i]['handle'].'
    										</a></b>
    									</span>
    									<span class="grey-text text-darken-2" style="position:absolute;top:20px;">
    										&nbsp;&nbsp;posted <span data-livestamp="'.date('Y-m-d H:i:s', strtotime($trending_chatter->mPosts[$i]['date_posted'])).'"></span>
    									</span>';
    									if ($trending_chatter->mPosts[$i]['customer_id'] != Customer::GetCurrentCustomerId()) {
    										echo '
    										<span class="grey-text text-darken-2" style="position:absolute;right:0;">
    											<b><a class="dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="posts_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b> 
    											<ul id="posts_dropdown_'.$i.'" class="dropdown-content" style="max-width:300px;">
    												<li><a href="#!" id="hide_post_'.$i.'"><small><i class="fas fa-eye-slash"></i> Hide this post</small></a></li>
    												<li><a href="#!" id="block_post_'.$i.'"><small><i class="fas fa-ban"></i> Block all posts from <b>'.$trending_chatter->mPosts[$i]['handle'].'</b></small></a></li>
    												<li class="report_'.$i.'"><a href="#!" id="report_post_'.$i.'"><small><i class="fas fa-flag"></i> Report this post</small></a></li>';
    												if (!in_array($trending_chatter->mPosts[$i]['customer_id'], $trending_chatter->mPeopleYouFollow)) {
    													echo '
    													<li class="follow_user_'.$trending_chatter->mPosts[$i]['customer_id'].'"><a href="#!" id="follow_user_'.$i.'"><small><i class="fas fa-user-plus"></i> Follow <b>'.$trending_chatter->mPosts[$i]['handle'].'</b></small></a></li>';
    												}
    												else {
    													echo '
    													<li class="unfollow_user_'.$trending_chatter->mPosts[$i]['customer_id'].'"><a href="#!" id="unfollow_user_'.$i.'"><small><i class="fas fa-user-plus"></i> Unfollow <b>'.$trending_chatter->mPosts[$i]['handle'].'</b></small></a></li>';
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
    														"'.$trending_chatter->mLinkToTrendingChatter.'",
    														{Hide_Post: "", PostId: '.$trending_chatter->mPosts[$i]['post_id'].'},
    														function(data) {
    															// nothing
    														}
    													);
    												});
    
    												// Block User functionality
    												$(".card_content_my_stream'.$i.'").on("click", "#block_post_'.$i.'", function(event) {
    													event.preventDefault();
    													$(".post_customer_'.$trending_chatter->mPosts[$i]['customer_id'].'").fadeOut(500);
    													M.toast({html: "Blocked successfully"});
    													$.post(
    														"'.$trending_chatter->mLinkToTrendingChatter.'",
    														{Block_Post: "", BlockCustomerId: '.$trending_chatter->mPosts[$i]['customer_id'].'},
    														function(data) {
    															// nothing
    														}
    													);
    												});
    
    												// Report User functionality
    												$(".card_content_my_stream'.$i.'").on("click", "#report_post_'.$i.'", function(event) {
    													event.preventDefault();
    													$(".report_'.$i.'").fadeOut(500);
    													M.toast({html: "Reported successfully"});
    													$.post(
    														"'.$trending_chatter->mLinkToTrendingChatter.'",
    														{Report_Post: "", CustomerId: '.$trending_chatter->mPosts[$i]['customer_id'].', PostId: '.$trending_chatter->mPosts[$i]['post_id'].'},
    														function(data) {
    															// nothing
    														}
    													);
    												});
    
    												// Follow User functionality
    												$(".card_content_my_stream'.$i.'").on("click", "#follow_user_'.$i.'", function(event) {
    													event.preventDefault();
    													$(".follow_user_'.$trending_chatter->mPosts[$i]['customer_id'].'").remove();
    													M.toast({html: "Following '.$trending_chatter->mPosts[$i]['handle'].'"});
    													$.post(
    														"'.$trending_chatter->mLinkToTrendingChatter.'",
    														{Follow_User: "", FollowCustomerId: '.$trending_chatter->mPosts[$i]['customer_id'].'},
    														function(data) {
    															// nothing
    														}
    													);
    												});
    												// Unfollow User functionality
    												$(".card_content_my_stream'.$i.'").on("click", "#unfollow_user_'.$i.'", function(event) {
    													event.preventDefault();
    													$(".unfollow_user_'.$trending_chatter->mPosts[$i]['customer_id'].'").remove();
    													M.toast({html: "You unfollowed '.$trending_chatter->mPosts[$i]['handle'].'"});
    													$.post(
    														"'.$trending_chatter->mLinkToTrendingChatter.'",
    														{Unfollow_User: "", UnfollowCustomerId: '.$trending_chatter->mPosts[$i]['customer_id'].'},
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
    														"'.$trending_chatter->mLinkToTrendingChatter.'",
    														{Delete_Post: "", PostId: '.$trending_chatter->mPosts[$i]['post_id'].'},
    														function(data) {
    															// nothing
    														}
    													);
    												});
    											});
    										</script>';
    									}
    									echo '
    									</p>';
    									if (!is_null($trending_chatter->mPosts[$i]['job_id'])) {
    										echo '
    										<br>
    										<h6 class="truncate" title="tag '.$trending_chatter->mPosts[$i]['position_name'].' at '.$trending_chatter->mPosts[$i]['company_name'].'">
    											<small>
    												<a class="teal-text truncate" href="'.$trending_chatter->mPosts[$i]['link_to_popular_tags_page'].'"><i class="fas fa-hashtag"></i> &nbsp;'.$trending_chatter->mPosts[$i]['position_name'].' at '.$trending_chatter->mPosts[$i]['company_name'].'
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
    									<span style="white-space:pre-line;"><a id="postOnlineText'.$i.'" href="'.$trending_chatter->mPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2">'.$trending_chatter->mPosts[$i]['post'].'</a></span>
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
    									if (!empty($trending_chatter->mPosts[$i]['post_images']) || !is_null($trending_chatter->mPosts[$i]['post_images'])) {
    										for ($m=0; $m<count($trending_chatter->mPosts[$i]['post_images']); $m++) {
    											if (count($trending_chatter->mPosts[$i]['post_images']) == 1) {
    												echo '
    													<div class="row">
    														<div class="col s12 center">
    															<img src="'.$trending_chatter->mSiteUrl.'/images/post_images/'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'  picture" class="center materialboxed responsive-img" style="border-radius:4px;margin:auto;display:block;" />
    														</div>
    													</div>
    												';
    											}
    											if (count($trending_chatter->mPosts[$i]['post_images']) == 2) {
    												if ($m == 0) {
    													echo '<div class="row">';
    												}
    												echo '
    													<div class="col s6 m6 l6">
    														<img src="'.$trending_chatter->mSiteUrl.'/images/post_images/'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
    													</div>
    												';
    												if ($m == 1) {
    													echo '</div>';
    												}
    											}
    											if (count($trending_chatter->mPosts[$i]['post_images']) == 3) {
    												if ($m == 0) {
    													echo '<div class="row">';
    												}
    												if ($m == 0 || $m == 1)
    												echo '
    													<div class="col s6 m6 l6">
    														<img src="'.$trending_chatter->mSiteUrl.'/images/post_images/'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
    													</div>
    												';
    												if ($m == 1) {
    													echo '</div>';
    												}
    												if ($m == 2) {
    													echo '
    													<div class="row">
    														<div class="col s12">
    															<img src="'.$trending_chatter->mSiteUrl.'/images/post_images/'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'  picture" class="responsive-img materialboxed" style="border-radius:4px;" />
    														</div>
    													</div>
    													';
    												}
    											}
    											if (count($trending_chatter->mPosts[$i]['post_images']) == 4) {
    												if ($m == 0 || $m == 2) {
    													echo '<div class="row">';
    												}
    												echo '
    													<div class="col s6 m6 l6">
    														<img src="'.$trending_chatter->mSiteUrl.'/images/post_images/'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
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
    										<a href="'.$trending_chatter->mPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2"><span class="fas fa-comment"></span> '.$trending_chatter->mPosts[$i]['comments_count'].'</a>
    										<span style="position:absolute;left:46%;" id="like_post_functionality_'.$i.'" class="scale-transition ';
    										if ($trending_chatter->mPosts[$i]['is_liked'] == 'yes') {
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
    										if ($trending_chatter->mPosts[$i]['is_liked'] == 'yes') {
    											echo 'scale-in';
    										}
    										else {
    											echo 'scale-out';
    										}
    										echo ' 
    										">
    											<i class="fas fa-thumbs-up red-text text-darken-2 like_post_red_'.$i.'"></i>
    										</span>
    										<span style="position:absolute;left:53%;" id="liked_text_'.$i.'">&nbsp;'.$trending_chatter->mPosts[$i]['total_likes'].'</span>';
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
    														$.post("'.$trending_chatter->mLinkToTrendingChatter.'",
    														{Like: "Like", PostId: '.$trending_chatter->mPosts[$i]['post_id'].'},
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
    														$.post("'.$trending_chatter->mLinkToTrendingChatter.'",
    														{Dislike: "Dislike", PostId: '.$trending_chatter->mPosts[$i]['post_id'].'},
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
    												var share_url = encodeURIComponent("'.$trending_chatter->mPosts[$i]['link_to_post_details'].'");
    
    												$(".facebook_link_'.$i.'").attr("href", "https://www.facebook.com/sharer.php?u=" + share_url);
    												$(".twitter_link_'.$i.'").attr("href", "https://twitter.com/intent/tweet?url=" + share_url + "&hashtags=JobStack,jobs,Nigeria");
    												$(".linkedin_link_'.$i.'").attr("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_url + "&title='.$trending_chatter->mPosts[$i]['handle'].'" + "&source=JobStack");
    												$(".whatsapp_link_'.$i.'").attr("href", "whatsapp://send?text=" + share_url);
    												$(".telegram_link_'.$i.'").attr("href", "https://telegram.me/share/url?url=" + share_url);
    											});
    										</script>
    									</div>
    								</div>
    							</div>
    					</div>';
    			}
    			if (count($trending_chatter->mPostListPages ) > 1) {
    				echo '
    				<div class="row">
    					<div class="col s12">
    						<ul class="pagination center">';
    							for ($m = 0; $m < count($trending_chatter->mPostListPages); $m++) {
    								if ($trending_chatter->mPage == ($m+1)) {
    									echo '<li class="waves-effect active red lighten-2"><a href="'.$trending_chatter->mPostListPages[$m].'"><small>'.($m+1).'</small></a></li>';
    								}
    								else {
    									echo '<li class="waves-effect"><a href="'.$trending_chatter->mPostListPages[$m].'"><small>'.($m+1).'</small></a></li>';
    								}
    							}
    						echo '
    						</ul>
    					</div>
    				</div>';
    			}
    		}
    		else {
    			for ($i=0; $i<count($trending_chatter->mPosts); $i++) {
    				echo '
    				<div class="row card_my_stream'.$i.' post_customer_'.$trending_chatter->mPosts[$i]['customer_id'].'">
    					<div class="col s12 l8 offset-l2">
    						<div class="card white grey-text text-darken-2 z-depth-0" style="border: 1px solid lightgrey;">
    							<div class="card-content card_content_my_stream'.$i.'">
    								<p style="position:relative;">
    									<span>';
    										if (empty($trending_chatter->mPosts[$i]['avatar'])) {
    											echo '
    											<a href="'.$trending_chatter->mPosts[$i]['link_to_user'].'" class="white-text">
    												<span class="teal" style="display:inline-block;width:30px;line-height:37px;text-align:center;border-radius:4px;">
    													<span class="white-text" style="font-size:15px;"><b>'.substr($trending_chatter->mPosts[$i]['handle'], 0, 1).'</b></span>
    												</span>
    											</a>';
    										}
    										else {
    											echo '
    											<a href="'.$trending_chatter->mPosts[$i]['link_to_user'].'">
    												<img src="'.$trending_chatter->mSiteUrl.'images/profile_pictures/'.$trending_chatter->mPosts[$i]['avatar'].'" alt="'.$trending_chatter->mPosts[$i]['handle'].' profile picture" style="width:30px;line-height:30px;border-radius:4px;" />
    											</a>
    											';
    										} 
    					 					echo '
    									</span>
    									<span class="grey-text text-darken-2" style="position:absolute;">
    										<b>&nbsp;<a href="'.$trending_chatter->mPosts[$i]['link_to_user'].'" class="grey-text text-darken-2">
    												'.$trending_chatter->mPosts[$i]['handle'].'
    										</a></b>
    									</span>
    									<span class="grey-text text-darken-2" style="position:absolute;top:20px">
    										&nbsp;&nbsp;posted <time class="timeago" datetime="'.date('Y-m-d H:i:s', strtotime($trending_chatter->mPosts[$i]['date_posted'])).'">'.date('m').' '.date('d').', '.date('Y').'</time>
    									</span>';
    									echo '
    									</p>';
    									if (!is_null($trending_chatter->mPosts[$i]['job_id'])) {
    										echo '
    										<br>
    										<h6 class="truncate" title="tag '.$trending_chatter->mPosts[$i]['position_name'].' at '.$trending_chatter->mPosts[$i]['company_name'].'">
    											<small>
    												<a class="teal-text truncate" href="'.$trending_chatter->mPosts[$i]['link_to_popular_tags_page'].'"><i class="fas fa-hashtag"></i> &nbsp;'.$trending_chatter->mPosts[$i]['position_name'].' at '.$trending_chatter->mPosts[$i]['company_name'].'
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
    									<span style="white-space:pre-line;"><a id="postOfflineText'.$i.'" href="'.$trending_chatter->mPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2">'.$trending_chatter->mPosts[$i]['post'].'</a></span>
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
    									if (!empty($trending_chatter->mPosts[$i]['post_images']) || !is_null($trending_chatter->mPosts[$i]['post_images'])) {
    										for ($m=0; $m<count($trending_chatter->mPosts[$i]['post_images']); $m++) {
    											if (count($trending_chatter->mPosts[$i]['post_images']) == 1) {
    												echo '
    													<div class="row">
    														<div class="col s12">
    															<img src="'.$trending_chatter->mSiteUrl.'/images/post_images/'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;margin:auto;display:block;" />
    														</div>
    													</div>
    												';
    											}
    											if (count($trending_chatter->mPosts[$i]['post_images']) == 2) {
    												if ($m == 0) {
    													echo '<div class="row">';
    												}
    												echo '
    													<div class="col s6 m6 l6">
    														<img src="'.$trending_chatter->mSiteUrl.'/images/post_images/'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
    													</div>
    												';
    												if ($m == 1) {
    													echo '</div>';
    												}
    											}
    											if (count($trending_chatter->mPosts[$i]['post_images']) == 3) {
    												if ($m == 0) {
    													echo '<div class="row">';
    												}
    												if ($m == 0 || $m == 1)
    												echo '
    													<div class="col s6 m6 l6">
    														<img src="'.$trending_chatter->mSiteUrl.'/images/post_images/'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
    													</div>
    												';
    												if ($m == 1) {
    													echo '</div>';
    												}
    												if ($m == 2) {
    													echo '
    													<div class="row">
    														<div class="col s12">
    															<img src="'.$trending_chatter->mSiteUrl.'/images/post_images/'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'  picture" class="responsive-img materialboxed" style="border-radius:4px;" />
    														</div>
    													</div>
    													';
    												}
    											}
    											if (count($trending_chatter->mPosts[$i]['post_images']) == 4) {
    												if ($m == 0 || $m == 2) {
    													echo '<div class="row">';
    												}
    												echo '
    													<div class="col s6 m6 l6">
    														<img src="'.$trending_chatter->mSiteUrl.'/images/post_images/'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'" alt="'.$trending_chatter->mPosts[$i]['post_images'][$m]['image'].'  picture" class="materialboxed responsive-img" style="border-radius:4px;" />
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
    										<a href="'.$trending_chatter->mPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2"><span class="fas fa-comment"></span> '.$trending_chatter->mPosts[$i]['comments_count'].'</a>
    										<span style="position:absolute;left:46%;">
    											<i class="fas fa-thumbs-up like_post_grey_'.$i.'"></i>
    										</span>
    										<span style="position:absolute;left:53%;"> &nbsp;'.$trending_chatter->mPosts[$i]['total_likes'].'</span>';
    										echo '
    										<script>
    											$(document).ready(function() {
    												$("#like_functionality_'.$i.'").on("click", ".like_post_grey_'.$i.'", function(event){
    													event.preventDefault();
    													window.location.href = "'.$trending_chatter->mLinkToLoginPage.'";
    												});
    											});
    										</script>';
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
    												var share_url = encodeURIComponent("'.$trending_chatter->mPosts[$i]['link_to_post_details'].'");
    
    												$(".facebook_link_'.$i.'").attr("href", "https://www.facebook.com/sharer.php?u=" + share_url);
    												$(".twitter_link_'.$i.'").attr("href", "https://twitter.com/intent/tweet?url=" + share_url + "&hashtags=JobStack,jobs,Nigeria");
    												$(".linkedin_link_'.$i.'").attr("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_url + "&title='.$trending_chatter->mPosts[$i]['handle'].'" + "&source=JobStack");
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
    			if (count($trending_chatter->mPostListPages ) > 1) {
    				echo '
    				<div class="row">
    					<div class="col s12">
    						<ul class="pagination center">';
    							for ($m = 0; $m < count($trending_chatter->mPostListPages); $m++) {
    								if ($trending_chatter->mPage == ($m+1)) {
    									echo '<li class="waves-effect active red lighten-2"><a href="'.$trending_chatter->mPostListPages[$m].'"><small>'.($m+1).'</small></a></li>';
    								}
    								else {
    									echo '<li class="waves-effect"><a href="'.$trending_chatter->mPostListPages[$m].'"><small>'.($m+1).'</small></a></li>';
    								}
    							}
    						echo '
    						</ul>
    					</div>
    				</div>';
    			}
    		}
    		echo '
    	</div>
    	</div>
		<div id="popular" class="col s12 l8 offset-l2">
			<br>
			<ul class="collection">';
				for ($i=0; $i<count($trending_chatter->mHighestTrendingTags); $i++) {
					if ($trending_chatter->mHighestTrendingTags[$i]['items_count'] < 2) {
						$items_count = 'post';
					}
					else {
						$items_count = 'posts';
					}
					echo ' 
					<li class="collection-item avatar post_tag_'.$i.'">
						<i class="fas fa-hashtag circle teal white-text"></i>
						<span class="title">
							<a class="teal-text" href="'.$trending_chatter->mHighestTrendingTags[$i]['link_to_popular_tags_page'].'">'.$trending_chatter->mHighestTrendingTags[$i]['position_name'].' at '.$trending_chatter->mHighestTrendingTags[$i]['company_name'].'</a>
						</span>
					</li>
					<script>
				    	$(document).ready(function() {
				    		$("#popular").on("click", ".post_tag_'.$i.'", function(event) {
				    			window.location.href="'.$trending_chatter->mHighestTrendingTags[$i]['link_to_popular_tags_page'].'";
				    		});
				    	});
				    </script>
					';
				}
			echo '
			</ul>
		</div>
	</div>
	';
?>