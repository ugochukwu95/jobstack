<?php
	require_once PRESENTATION_DIR . 'admin_menu.php';
	$admin_menu = new AdminMenu();

	echo '
		<div class="navbar-fixed">
			<nav class="teal white-text">
				<div class="nav-wrapper">
					<a href="'.$admin_menu->mLinkToStoreAdmin.'" class="brand-logo white-text text-darken-2 center">Job<span>Stack</span></a>
					<a href="#!" data-target="slide-out" class="sidenav-trigger show-on-large"><i class="fas fa-bars white-text text-darken-2"></i></a>
					<ul class="right show-on-large" id="nav-mobile">
						<li><a href="#!" class="white-text text-darken-2 openSearchNav"><i class="fas fa-search"></i></a></li>
					</ul> 
				</div>
			</nav>
		</div>
		<ul id="slide-out" class="sidenav white grey-text text-darken-2">
			<li><a href="'.$admin_menu->mLinkToStoreAdmin.'" class="grey-text text-darken-2 bebasFont center"><h4>Job<span class="teal-text text-darken-2">Stack</span></h4></a><div class="divider"></div></li>
			<li><a href="'.$admin_menu->mLinkToStoreAdmin.'"><i class="fas fa-chart-line"></i>Dashboard</a></li>
			<li><a href="'.$admin_menu->mLinkToStoreFront.'" class="grey-text text-darken-2"><i class="fas fa-home"></i>JobStack Homepage</a></li>
			<li><a href="'.$admin_menu->mLinkToCompanyPage.'" class="grey-text text-darken-2"><i class="fas fa-building"></i>Company</a></li>
			<li><a href="'.$admin_menu->mLinkToUsersAdmin.'" class="grey-text text-darken-2"><i class="fas fa-user-plus"></i>Users</a></li>
			<li><a href="'.$admin_menu->mLinkToUsersJobsAdmin.'" class="grey-text text-darken-2"><i class="fas fa-user-plus"></i>Users Jobs</a></li>
			<li><a href="'.$admin_menu->mLinkToReportPostsAdmin.'" class="grey-text text-darken-2"><i class="fas fa-edit"></i>Reported Posts</a></li>
			<li><a href="'.$admin_menu->mLinkToReportCommentsAdmin.'" class="grey-text text-darken-2"><i class="fas fa-edit"></i>Reported Comments</a></li>
			<li><a href="'.$admin_menu->mLinkToDeveloperMessages.'" class="grey-text text-darken-2"><i class="fas fa-envelope"></i>Developer Messages</a></li>
			<li><a href="'.$admin_menu->mLinkToLogout.'" class="grey-text text-darken-2"><i class="fas fa-user-times"></i>Logout</a></li>
		</ul>
		
		<!-- Search Box Functionality -->
		<div id="mySidenav" class="search_sidenav scale-transition scale-out">
			<p class="center">
				<a href="javascript:void(0)" class="closebtn red-text text-lighten-2 center closeNav">&times;</a>
			</p>
			<br><br><br>
			';
			require_once $site_admin->mSearchBoxCell;
		echo '
		</div>';
?>