<?php
	require_once PRESENTATION_DIR . 'customer_logged.php';
	$customer_logged = new CustomerLogged;
	$customer_logged->init();
	echo '
	<li class="'.$customer_logged->mUserProfileActive.'"><a href="'.$customer_logged->mLinkToUserProfile.'" class="grey-text text-darken-2"><i class="material-icons">account_circle</i>My Profile</a></li>
	<li class="'.$customer_logged->mActiveLink.'"><a href="'.$customer_logged->mLinkToEditProfile.'" class="grey-text text-darken-2"><i class="material-icons">person_add</i>Edit Profile</a></li>
	<li><a href="'.$customer_logged->mLinkToLogout.'" class="grey-text text-darken-2"><i class="material-icons grey-text text-darken-2">exit_to_app</i>Logout</a></li>
	';
?>