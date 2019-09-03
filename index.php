<?php
	session_start();

	// Start output buffer
	ob_start();

	date_default_timezone_set('Africa/Lagos');
	// Inxlude utility files
	require_once 'include/config.php';

	// include Business tier files
	require_once BUSINESS_DIR . 'error_handler.php';

	// Load the database handler
	require_once BUSINESS_DIR . 'database_handler.php';

	// include link functionality
	require_once PRESENTATION_DIR . 'link.php';

	require_once BUSINESS_DIR . 'password_hasher.php';

	require_once BUSINESS_DIR . 'customer.php';

	// Load the database handler
	require_once BUSINESS_DIR . 'catalog.php';

	require_once BUSINESS_DIR . 'saved_jobs_cart.php';

	// Set the Error Handler
	ErrorHandler::SetHandler();

	// URL correction
	Link::CheckRequest();

	require_once TEMPLATE_DIR . 'site_front_tpl.php';

	// Close database connection
	DatabaseHandler::Close();

	// Output content from the buffer
	flush();
	ob_flush();
	ob_end_clean();
?>