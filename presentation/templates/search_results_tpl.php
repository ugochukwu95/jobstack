<?php
	echo '<h3 class="center bebasFont teal-text text-darken-2">Search Results</h3>';

	if (isset($_GET['CompanySearch']) && $_GET['CompanySearch'] == 'on') {
		require_once 'admin_company_tpl.php';
	}
	elseif (isset($_GET['UserSearch']) && $_GET['UserSearch'] == 'on') {
		require_once 'admin_users_tpl.php';
	}
	else {
		require_once 'admin_jobs_tpl.php';
	}
?>