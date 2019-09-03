<?php
	if (isset($_GET['CompanySearch']) && $_GET['CompanySearch'] == 'on') {
		require_once 'company_list_tpl.php';
	}
	else {
	    require_once 'jobs_list_tpl.php';
	}
	
?>