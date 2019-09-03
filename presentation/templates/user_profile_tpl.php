<?php
	require_once PRESENTATION_DIR . 'user_profile.php';
	$user_profile = new UserProfile();
	$user_profile->init();
	if (!is_null($user_profile->mErrorMessage) || $user_profile->mErrorMessage != '') {
		echo '
		<div class="row">
			<div class="col s12 m12">
				<div class="alertBox">
					<span class="alertBoxCloseBtn" onclick="this.parentElement.style.display=\'none\'">&times;</span>
					'.$user_profile->mErrorMessage.'
				</div>
			</div>
		<div>
		';
	}
	echo '
	<br>
	<div class="row">
		<div class="col s12 l10 offset-l1 user_profile_functionality" style="position:relative;">
			<span>';
				if (!empty($user_profile->mCustomer['avatar'])) {
					echo '<img class="materialboxed" src="'.$user_profile->mCustomer['avatar'].'" alt="'.$user_profile->mCustomer['handle'].' profile picture" style="width:60px;height:60px;border-radius:4px;">';
				}
				else {
					echo '<span class="teal" style="display:inline-block;width:60px;line-height:60px;text-align:center;border-radius:50%;">
							<span class="white-text" style="font-size:30px;">'.substr($user_profile->mCustomer['handle'], 0, 1).'</span>
						  </span>';
				}
			echo '
			</span>
			<span>
				<span style="font-size:22px;position:absolute; left:80px;top:0px;" class="grey-text text-darken-2">&nbsp;@'.$user_profile->mCustomer['handle'].'  &nbsp;';
				if (Customer::GetCurrentCustomerId() != 0 && $user_profile->mCustomer['customer_id'] != Customer::GetCurrentCustomerId()) {
					echo '
					<span class="">
						<a class="dropdown_trigger_follow_ish_'.$user_profile->mCustomer['customer_id'].' red-text text-lighten-2" href="#!" data-target="user_dropdown">
							<i class="fas fa-cog red-text text-lighten-2"></i>
						</a>
					</span>
					<ul id="user_dropdown" class="dropdown-content" style="max-width:300px;">';
						if (!in_array($user_profile->mCustomer['customer_id'], $user_profile->mPeopleYouFollow)) {
							echo '
							<li class="follow_'.$user_profile->mCustomer['customer_id'].'">
								<a href="#!" id="follow_user_'.$user_profile->mCustomer['customer_id'].'">
									<small><i class="fas fa-user-plus"></i> Follow <b>'.$user_profile->mCustomer['handle'].'</b></small>
								</a>
							</li>';
						}
						else {
							echo '
							<li class="unfollow_'.$user_profile->mCustomer['customer_id'].'">
								<a href="#!" id="unfollow_user_'.$user_profile->mCustomer['customer_id'].'">
									<small><i class="fas fa-user-plus"></i> Unfollow <b>'.$user_profile->mCustomer['handle'].'</b></small>
								</a>
							</li>';
						}

						if (!in_array($user_profile->mCustomer['customer_id'], $user_profile->mPeopleYouBlocked)) {
							echo '
							<li class="block_'.$user_profile->mCustomer['customer_id'].'">
								<a href="#!" id="block_user_'.$user_profile->mCustomer['customer_id'].'">
									<small><i class="fas fa-user-plus"></i> Block <b>'.$user_profile->mCustomer['handle'].'</b></small>
								</a>
							</li>';
						}
						else {
							echo '
							<li class="unblock_'.$user_profile->mCustomer['customer_id'].'">
								<a href="#!" id="unblock_user_'.$user_profile->mCustomer['customer_id'].'">
									<small><i class="fas fa-user-plus"></i> Unblock <b>'.$user_profile->mCustomer['handle'].'</b></small>
								</a>
							</li>';
						}
					echo '
					</ul>
					<script>
						$(".dropdown_trigger_follow_ish_'.$user_profile->mCustomer['customer_id'].'").dropdown();

						// Block user functionality
						$(".user_profile_functionality").on("click", "#block_user_'.$user_profile->mCustomer['customer_id'].'", function(event) {
							event.preventDefault();
							$.post(
								"'.$user_profile->mLinkToUserProfile.'",
								{Block_Post: "", BlockCustomerId: '.$user_profile->mCustomer['customer_id'].'},
								function(data) {
									$(".block_'.$user_profile->mCustomer['customer_id'].'").replaceWith("<li class=\"unblock_'.$user_profile->mCustomer['customer_id'].'\"><a href=\"#!\" id=\"unblock_user_'.$user_profile->mCustomer['customer_id'].'\"><small><i class=\"fas fa-user-plus\"></i> Unblock <b>'.$user_profile->mCustomer['handle'].'</b></small></a></li>");
									M.toast({html: "Blocked successfully"});
									window.location.href = "'.$user_profile->mLinkToUserProfile.'";
								}
							);
						});

						// Unblock user
						$(".user_profile_functionality").on("click", "#unblock_user_'.$user_profile->mCustomer['customer_id'].'", function(event) {
							event.preventDefault();
							$.post(
								"'.$user_profile->mLinkToUserProfile.'",
								{Unblock_Post: "", UnblockCustomerId: '.$user_profile->mCustomer['customer_id'].'},
								function(data) {
									$(".unblock_'.$user_profile->mCustomer['customer_id'].'").replaceWith("<li class=\"block_'.$user_profile->mCustomer['customer_id'].'\"><a href=\"#!\" id=\"block_user_'.$user_profile->mCustomer['customer_id'].'\"><small><i class=\"fas fa-user-plus\"></i> Block <b>'.$user_profile->mCustomer['handle'].'</b></small></a></li>");
									M.toast({html: "Unblocked successfully"});
									window.location.href = "'.$user_profile->mLinkToUserProfile.'";
								}
							);
						});

						// Follow User functionality
						$(".user_profile_functionality").on("click", "#follow_user_'.$user_profile->mCustomer['customer_id'].'", function(event) {
							event.preventDefault();
							$.post(
								"'.$user_profile->mLinkToUserProfile.'",
								{Follow_User: "", FollowCustomerId: '.$user_profile->mCustomer['customer_id'].'},
								function(data) {
								$(".follow_'.$user_profile->mCustomer['customer_id'].'").replaceWith("<li class=\"unfollow_'.$user_profile->mCustomer['customer_id'].'\"><a href=\"#!\" id=\"unfollow_user_'.$user_profile->mCustomer['customer_id'].'\"><small><i class=\"fas fa-user-plus\"></i> Unfollow <b>'.$user_profile->mCustomer['handle'].'</b></small></a></li>");
								M.toast({html: "Following '.$user_profile->mCustomer['handle'].'"});
								}
							);
						});

						// Follow User functionality
						$(".user_profile_functionality").on("click", "#unfollow_user_'.$user_profile->mCustomer['customer_id'].'", function(event) {
							event.preventDefault();
							$.post(
								"'.$user_profile->mLinkToUserProfile.'",
								{Unfollow_User: "", UnfollowCustomerId: '.$user_profile->mCustomer['customer_id'].'},
								function(data) {
								$(".unfollow_'.$user_profile->mCustomer['customer_id'].'").replaceWith("<li class=\"follow_'.$user_profile->mCustomer['customer_id'].'\"><a href=\"#!\" id=\"follow_user_'.$user_profile->mCustomer['customer_id'].'\"><small><i class=\"fas fa-user-plus\"></i> Follow <b>'.$user_profile->mCustomer['handle'].'</b></small></a></li>");
								M.toast({html: "You unfollowed '.$user_profile->mCustomer['handle'].'"});
								}
							);
						});
					</script>';
				}
				if (Customer::GetCurrentCustomerId() != 0 && $user_profile->mCustomer['customer_id'] == (int)Customer::GetCurrentCustomerId()) {
					echo '
					<a href="'.$user_profile->mLinkToEditProfile.'" class="red-text text-lighten-2">
						<span class="fa-stack red-text text-lighten-2">
							<i class="far fa-circle fa-stack-2x"></i>
							<i class="fas fa-pencil-alt fa-stack-1x"></i>
						</span>
					</a> 
					</span>';
				}
			echo '
			</span>
		</div>';

		echo '
	</div>';
	echo '
	<br>
	<div class="row">
		<div class="col s12">
			<div class="row"> 
				<div class="col s12 l10 offset-l1 center">
					<ul id="tabs-swipe-demo" class="tabs center">
						<li class="tab col l3"><a class="'.$user_profile->mActiveMyPostsLink.'" target="_self" href="'.$user_profile->mLinkToMyPosts.'">Posts</a></li>
						<li class="tab col l3"><a class="'.$user_profile->mActiveLikedPostsLink.'" target="_self" href="'.$user_profile->mLinkToLikedPosts.'">Liked Posts</a></li>
						<li class="tab col l3"><a class="'.$user_profile->mActiveAboutLink.'" target="_self" href="'.$user_profile->mLinkToAbout.'">About</a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col s12">';
					if (in_array($user_profile->mCustomer['customer_id'], $user_profile->mPeopleYouBlocked)) {
						echo '
						<div>
							<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
							<h5 class="grey-text text-darken-2 center">You have blocked this user.</h5>
						</div>';
					}
					elseif (in_array(Customer::GetCurrentCustomerId(), $user_profile->mPeopleThatBlockedYou)) {
						echo '
						<div>
							<h1 class="center grey-text text-darken-2">:-(</h1><br><br>
							<h5 class="grey-text text-darken-2 center">This user has blocked you.</h5>
						</div>';
					}
					else {
						require_once $user_profile->mContentsCell;
					}
				echo '
				</div>
			</div>
		</div>
	</div>';
?>