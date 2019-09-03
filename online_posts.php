<?php
	// my stream functionality
			//
			//
			//
			//
			//


			echo '
			<div id="test-swipe-1" class="col s12">';
				if ((Customer::GetCurrentCustomerId()) == $user_profile->mCustomer['customer_id']) {
					echo '
						<div class="fixed-action-btn">
							<a class="btn-floating btn-large teal white-text waves-effect waves-light modal-trigger" href="#post_to_your_profile_modal">
								<i class="far fa-edit"></i>
							</a>
						</div>
						<div id="post_to_your_profile_modal" class="modal">
							<div class="modal-content">
								<h6 class="grey-text text-darken-2 center">Post to your profile</h6>
								<br>';
								echo '
								<div class="row">
									<form class="col s12" method="post" action="'.$user_profile->mLinkToUserProfile.'">
									<div class="row">
										<div class="input-field col s10 l7 offset-l2">
											<span class="fas fa-sticky-note prefix"></span>
											<textarea id="post_to_your_profile" type="text" name="post_to_your_profile" class="materialize-textarea"></textarea>
											<label for="post_to_your_profile">Post To Your Profile</label>
										</div>
										<div class="input-field col s2 l1">
											<button type="submit" name="Button_Post" class="btn-small red lighten-2">POST</button>
										</div>
									</div>
									</form> 
								</div>';
						echo '
							</div>
						</div>';
				}
					if (empty($user_profile->mMyStream)) {
						echo '<h5 class="grey-text text-darken-2 center">No Posts Yet ...</h5>';
					}
					else {
						echo '<div class="myStreamPosts">';
						for ($i=0; $i<count($user_profile->mMyStream); $i++) {
							echo '
							<div class="row card_my_stream'.$i.' post_customer_'.$user_profile->mMyStream[$i]['customer_id'].'">
								<div class="col s12 m8 offset-m2 l8 offset-l2">
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
												&nbsp;&nbsp;posted <time class="timeago" datetime="'.date('Y-m-d H:i:s', strtotime($user_profile->mMyStream[$i]['date_posted'])).'">'.date('m').' '.date('d').', '.date('Y').'</time>
											</span>';
											if ($user_profile->mMyStream[$i]['customer_id'] != Customer::GetCurrentCustomerId()) {
												echo '
												<span class="grey-text text-darken-2" style="position:absolute;right:0;">
													<b><a class="dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="posts_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b> 
													<ul id="posts_dropdown_'.$i.'" class="dropdown-content" style="max-width:300px;">
														<li><a href="#!" id="hide_post_'.$i.'"><small><i class="fas fa-eye-slash"></i> Hide this post</small></a></li>
														<li><a href="#!" id="block_post_'.$i.'"><small><i class="fas fa-ban"></i> Block all posts from <b>'.$user_profile->mMyStream[$i]['handle'].'</b></small></a></li>
														<li class="report_'.$i.'"><a href="#!" id="report_post_'.$i.'"><small><i class="fas fa-flag"></i> Report this post</small></a></li>';
														if (!in_array($user_profile->mMyStream[$i]['customer_id'], $user_profile->mPeopleYouFollow)) {
															echo '<li class="follow_'.$i.'"><a href="#!" id="follow_user_'.$i.'"><small><i class="fas fa-user-plus"></i> Follow <b>'.$user_profile->mMyStream[$i]['handle'].'</b></small></a></li>';
														}
													echo '
													</ul>
												</span>
												<script>
													$(".dropdown_trigger'.$i.'").dropdown();

													// Hide post functionality
													$(".card_content_my_stream'.$i.'").on("click", "#hide_post_'.$i.'", function(event) {
														event.preventDefault();
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Hide_Post: "", PostId: '.$user_profile->mMyStream[$i]['post_id'].'},
														function(data) {
															$(".card_my_stream'.$i.'").remove();
															M.toast({html: "Hidden successfully"});
														}
														);
													});

													// Block User functionality
													$(".card_content_my_stream'.$i.'").on("click", "#block_post_'.$i.'", function(event) {
														event.preventDefault();
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Block_Post: "", BlockCustomerId: '.$user_profile->mMyStream[$i]['customer_id'].'},
														function(data) {
															$(".post_customer_'.$user_profile->mMyStream[$i]['customer_id'].'").remove();
															M.toast({html: "Blocked successfully"});
														}
														);
													});

													// Report User functionality
													$(".card_content_my_stream'.$i.'").on("click", "#report_post_'.$i.'", function(event) {
														event.preventDefault();
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Report_Post: "", CustomerId: '.$user_profile->mMyStream[$i]['customer_id'].', PostId: '.$user_profile->mMyStream[$i]['post_id'].'},
														function(data) {
															$(".report_'.$i.'").remove();
															M.toast({html: "Reported successfully"});
														}
														);
													});

													// Follow User functionality
													$(".card_content_my_stream'.$i.'").on("click", "#follow_user_'.$i.'", function(event) {
														event.preventDefault();
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Follow_User: "", FollowCustomerId: '.$user_profile->mMyStream[$i]['customer_id'].'},
														function(data) {
															$(".follow_'.$i.'").remove();
															M.toast({html: "Following '.$user_profile->mMyStream[$i]['handle'].'"});
														}
														);
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
													$(".dropdown_trigger'.$i.'").dropdown();
													$(".card_content_my_stream'.$i.'").on("click", "#delete_post_'.$i.'", function(event) {
														event.preventDefault();
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Delete_Post: "", PostId: '.$user_profile->mMyStream[$i]['post_id'].'},
														function(data) {
															$(".card_my_stream'.$i.'").remove();
															M.toast({html: "Deleted successfully"});
														}
														);
													});
												</script>
												';
											}
										echo '
										</p>

										<br>
										<span style="white-space:pre-line;"><a href="'.$user_profile->mMyStream[$i]['link_to_post_details'].'" class="grey-text text-darken-2">'.$user_profile->mMyStream[$i]['post'].'</a></span>
										<br><br>
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
											<span style="position:absolute;left:51%;" id="liked_text_'.$i.'"> '.$user_profile->mMyStream[$i]['total_likes'].'</span>';
											if (Customer::GetCurrentCustomerId() !== 0) {
											echo '
											<script>
												$("#like_functionality_'.$i.'").on("click", "#like_post_functionality_'.$i.'", function(){
													$.post("'.$user_profile->mLinkToUserProfile.'",
													{Like: "Like", PostId: '.$user_profile->mMyStream[$i]['post_id'].'},
													function(data) {
														$("#like_post_functionality_'.$i.'").removeClass("scale-in").addClass("scale-out");
														var liked_text = $("#liked_text_'.$i.'").text();
														liked_text++;
														$("#liked_text_'.$i.'").text(liked_text);
														$("#dislike_post_functionality_'.$i.'").removeClass("scale-out").addClass("scale-in");
													}
													)
												});
												$("#like_functionality_'.$i.'").on("click", "#dislike_post_functionality_'.$i.'", function(){
													$.post("'.$user_profile->mLinkToUserProfile.'",
													{Dislike: "Dislike", PostId: '.$user_profile->mMyStream[$i]['post_id'].'},
													function(data) {
														$("#like_post_functionality_'.$i.'").removeClass("scale-out").addClass("scale-in");
														var disliked_text = $("#liked_text_'.$i.'").text();
														disliked_text--;
														$("#liked_text_'.$i.'").text(disliked_text);
														$("#dislike_post_functionality_'.$i.'").removeClass("scale-in").addClass("scale-out");
													}
													)
												});
											</script>';
											}
											echo '
											<span class="right"><span class="fas fa-share"></span> Share</span>
										</div>
									</div>
								</div>
								<br>
								<div class="divider"></div>
								</div>
							</div>
							';
						}
						echo '</div>';
					}
			echo '
			</div>';

			//Liked post functionality
			//
			//
			//
			//
			//


			echo '
			<div class="col s12">
				<br>';
				echo '<h5 class="grey-text text-darken-2 center hide if_liked_post_is_zero">There are no posts you like yet ...</h5>';
				if (empty($user_profile->mLikedPosts)) {
					echo '<h5 class="grey-text text-darken-2 center">There are no posts you like yet ...</h5>';
				}
				else {
					for ($i=0; $i<count($user_profile->mLikedPosts); $i++) {
						echo '
						<div class="row like_card_'.$i.' post_like_customer_'.$user_profile->mLikedPosts[$i]['customer_id'].'">
							<div class="col s12 m8 offset-m2 l8 offset-l2">
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
											&nbsp;&nbsp;posted <time class="timeago" datetime="'.date('Y-m-d H:i:s', strtotime($user_profile->mLikedPosts[$i]['date_posted'])).'">'.date('m').' '.date('d').', '.date('Y').'</time>
										</span>';
										if ($user_profile->mLikedPosts[$i]['customer_id'] != Customer::GetCurrentCustomerId()) {
											echo '
											<span class="grey-text text-darken-2" style="position:absolute;right:0;">
												<b><a class="like_dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="liked_posts_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b>
												<ul id="liked_posts_dropdown_'.$i.'" class="dropdown-content">
													<li><a href="#!" id="hide_like_post_'.$i.'"><small><i class="fas fa-eye-slash"></i> Hide this post</small></a></li>
													<li><a href="#!" id="block_like_post_'.$i.'"><small><i class="fas fa-ban"></i> Block all posts from <b>'.$user_profile->mLikedPosts[$i]['handle'].'</b></small></a></li>
													<li class="report_like_'.$i.'"><a href="#!" id="report_like_post_'.$i.'"><small><i class="fas fa-flag"></i> Report this post</small></a></li>';
													if (!in_array($user_profile->mLikedPosts[$i]['customer_id'], $user_profile->mPeopleYouFollow)) {
														echo '<li class="follow_like_'.$i.'"><a href="#!" id="follow_user_like_'.$i.'"><small><i class="fas fa-user-plus"></i> Follow <b>'.$user_profile->mLikedPosts[$i]['handle'].'</b></small></a></li>';
													}
												echo '	
												</ul>
											</span>
											<script>
													$(".like_dropdown_trigger'.$i.'").dropdown();

													// Hide post functionality
													$(".like_card_content_'.$i.'").on("click", "#hide_like_post_'.$i.'", function(event) {
														event.preventDefault();
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Hide_Post: "", PostId: '.$user_profile->mLikedPosts[$i]['post_id'].'},
														function(data) {
															$(".like_card_'.$i.'").remove();
															M.toast({html: "Hidden successfully"});
															var liked_value = '.count($user_profile->mLikedPosts).';
															liked_value--;
															if (liked_value == "0") {
																$(".if_liked_post_is_zero").removeClass("hide").addClass("show");
															}
														}
														);
													});

													// Block User functionality
													$(".like_card_content_'.$i.'").on("click", "#block_like_post_'.$i.'", function(event) {
														event.preventDefault();
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Block_Post: "", BlockCustomerId: '.$user_profile->mLikedPosts[$i]['customer_id'].'},
														function(data) {
															$(".post_like_customer_'.$user_profile->mLikedPosts[$i]['customer_id'].'").remove();
															M.toast({html: "Blocked successfully"});
															var liked_value = '.count($user_profile->mLikedPosts).';
															liked_value--;
															if (liked_value == "0") {
																$(".if_liked_post_is_zero").removeClass("hide").addClass("show");
															}
														}
														);
													});

													// Report User functionality
													$(".like_card_content_'.$i.'").on("click", "#report_like_post_'.$i.'", function(event) {
														event.preventDefault();
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Report_Post: "", CustomerId: '.$user_profile->mLikedPosts[$i]['customer_id'].', PostId: '.$user_profile->mLikedPosts[$i]['post_id'].'},
														function(data) {
															$(".report_like_'.$i.'").remove();
															M.toast({html: "Reported successfully"});
														}
														);
													});

													// Follow User functionality
													$(".like_card_content_'.$i.'").on("click", "#follow_user_like_'.$i.'", function(event) {
														event.preventDefault();
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Follow_User: "", FollowCustomerId: '.$user_profile->mLikedPosts[$i]['customer_id'].'},
														function(data) {
															$(".follow_like_'.$i.'").remove();
															M.toast({html: "Following '.$user_profile->mLikedPosts[$i]['handle'].'"});
														}
														);
													});
											</script>';
										}
										else {
											echo '
												<span class="grey-text text-darken-2" style="position:absolute;right:0;">
													<b><a class="like_dropdown_trigger'.$i.' grey-text text-darken-2" href="#!" data-target="liked_posts_dropdown_'.$i.'"><i class="fas fa-ellipsis-h"></i></a></b>
													<ul id="liked_posts_dropdown_'.$i.'" class="dropdown-content" style="max-width:300px;">
														<li><a href="#!" id="delete_like_post_'.$i.'"><small><i class="fas fa-trash"></i> Delete this post</small></a></li>
													</ul>
												</span>
												<script>
													$(".like_dropdown_trigger'.$i.'").dropdown();

													// Delete functionality
													$(".like_card_content_'.$i.'").on("click", "#delete_like_post_'.$i.'", function(event) {
														event.preventDefault();
														$.post(
														"'.$user_profile->mLinkToUserProfile.'",
														{Delete_Post: "", PostId: '.$user_profile->mLikedPosts[$i]['post_id'].'},
														function(data) {
															$(".like_card_'.$i.'").remove();
															M.toast({html: "Deleted successfully"});
															var liked_value = '.count($user_profile->mLikedPosts).';
															liked_value--;
															if (liked_value == "0") {
																$(".if_liked_post_is_zero").removeClass("hide").addClass("show");
															}
														}
														);
													});
												</script>
											';
										}
									echo '
									</p>
									
									<br>
									<span style="white-space:pre-line;"><a href="'.$user_profile->mLikedPosts[$i]['link_to_post_details'].'" class="grey-text text-darken-2">'.$user_profile->mLikedPosts[$i]['post'].'</a></span>
									<br><br>
									<div class="divider"></div>
									<div style="position:relative;" id="dislike_functionality_'.$i.'">
										<span class="fas fa-comment"></span> comment
										<span style="position:absolute;left:46%;" class="remove_liked_post_icon_'.$i.'"><span class="fas fa-thumbs-up ';
										if (Customer::GetCurrentCustomerId() !== 0) {
											echo 'red-text text-darken-2';
										}
										echo '
										"></span> '.$user_profile->mLikedPosts[$i]['total_likes'].'</span>';
										if (Customer::GetCurrentCustomerId() !== 0) {
											echo '
											<script>
											$("#dislike_functionality_'.$i.'").on("click", ".remove_liked_post_icon_'.$i.'", function() {
												$.post("'.$user_profile->mLinkToUserProfile.'",
													{Dislike: "Dislike", PostId: '.$user_profile->mLikedPosts[$i]['post_id'].'},
													function(data) {
														var liked_value = '.count($user_profile->mLikedPosts).';
														liked_value--;
														$(".card'.$i.'").remove();
														if (liked_value == "0") {
															$(".if_liked_post_is_zero").removeClass("hide").addClass("show");
														}
													}
												)	
											});
											</script>
											';
										}
										echo '
										<span class="right"><span class="fas fa-share"></span> Share</span>
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
			<div class="col s12 l8 offset-l2">
				<br>
				<div class="row">
					<div class="col s12">
						<h5 class="grey-text text-darken-2"><span class="teal-text">About</span> '.$user_profile->mCustomer['handle'].'</h5>
						<div class="divider"></div>';
						if (empty($user_profile->mCustomer['about_you'])) {
							echo '
							<p class="grey-text text-darken-2">'.$user_profile->mCustomer['handle'].' has not added any additional information to their account.</p>
							';
						}
						else {
							echo '
							<p class="grey-text text-darken-2" style="white-space:pre-line;">'.$user_profile->mCustomer['about_you'].'</p>
							';
						}
					echo '
					</div>
				</div>
				<div class="divider"></div>
				<ul class="collection">
					<li class="collection-item avatar">
						<i class="fas fa-home circle teal tooltipped" data-position="right" data-tooltip="Hometown"></i>';
						if (empty($user_profile->mCustomer['hometown'])) {
							echo '<h6 class="grey-text text-darken-2">Nothing to show ...</h6>';
						}
						else {
							echo '<h6 class="grey-text text-darken-2">'.$user_profile->mCustomer['hometown'].'</h6>';
						}
					echo '
					</li>
					<li class="collection-item avatar">
						<i class="fas fa-cogs circle teal tooltipped" data-position="right" data-tooltip="Occupation"></i>';
						if (empty($user_profile->mCustomer['occupation'])) {
							echo '<h6 class="grey-text text-darken-2">Nothing to show ...</h6>';
						}
						else {
							echo '<h6 class="grey-text text-darken-2">'.$user_profile->mCustomer['occupation'].'</h6>';
						}
					echo '
					</li>
					<li class="collection-item avatar">
						<i class="fas fa-university circle teal tooltipped" data-position="right" data-tooltip="Highest Institution Attended"></i>';
						if (empty($user_profile->mCustomer['university'])) {
							echo '<h6 class="grey-text text-darken-2">Nothing to show ...</h6>';
						}
						else {
							echo '<h6 class="grey-text text-darken-2">'.$user_profile->mCustomer['university'].'</h6>';
						}
					echo '
					</li>
					<li class="collection-item avatar">
						<i class="fas fa-paint-brush circle teal tooltipped" data-position="right" data-tooltip="Skills"></i>';
						if (!empty($user_profile->mCustomerSkills)) {
							for ($i=0; $i<count($user_profile->mCustomerSkills); $i++) {
								echo '
								<div class="chip" id="skillChip">
									<span>'.$user_profile->mCustomerSkills[$i]['skill'].'</span>
								</div>
							';
							}
							echo '
							<br>
							<a href="#!" class="blue-text hide moreChips">more...</a>
							<script>
								var maxChips = 5;
								if (document.querySelectorAll("#skillChip").length > 5) {
									$(".moreChips").removeClass("hide").addClass("show");
									var hiddenChips = (document.querySelectorAll("#skillChip").length - 5);
									var i;
									for (i=0; i<hiddenChips; i++) {
										document.querySelectorAll("#skillChip")[i+5].classList.add("hide");
									}
								}
								$(".moreChips").click(function(event) {
									event.preventDefault();
									var hiddenChips = (document.querySelectorAll("#skillChip").length - 5);
									$(".chip").removeClass("hide").addClass("show");
									$(".moreChips").removeClass("show").addClass("hide");
								})
							</script>';
						}
						else { 
							echo 'Nothing to show ...';
						}
					echo '
					</li>
				</ul>
			</div>
		</div>
	</div>
	';
?>