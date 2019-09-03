<?php
	session_start();
	ob_start();

	require_once 'include/config.php';

	require_once BUSINESS_DIR . 'error_handler.php';
	
	ErrorHandler::SetHandler();

	require_once PRESENTATION_DIR . 'link.php';

	require_once BUSINESS_DIR . 'database_handler.php';

	require_once BUSINESS_DIR . 'catalog.php';

	require_once BUSINESS_DIR . 'customer.php';

	require_once TEMPLATE_DIR . 'site_admin_tpl.php';

	DatabaseHandler::Close();

	flush();
	ob_flush();
	ob_end_clean();
?>