<?php
// SITE_ROOT contains the full path to the jobstack folder
define('SITE_ROOT', dirname(dirname(__FILE__)));

// Application directories
define('PRESENTATION_DIR', SITE_ROOT . '/presentation/');
define('BUSINESS_DIR', SITE_ROOT . '/business/');
define('TEMPLATE_DIR', SITE_ROOT . '/presentation/templates/');

// Server HTTP port (can omit if the default 80 is used)
define('HTTP_SERVER_PORT', '80');
/* Name of the virtual directory the site runs in, for example: '/jobstack/' if the site runs at http://www.example.com/jobstack/
'/' if the site runs at http://www.example.com/ */
define('VIRTUAL_LOCATION', '/');

// These should be true while developing the web site
define('IS_WARNING_FATAL', false);
define('DEBUGGING', false);

// The error types to be reported
define('ERROR_TYPES', E_ALL);

// Settings about mailing the error messages to admin
define('SEND_ERROR_MAIL', true);
define('ADMIN_ERROR_MAIL', 'xxxxx');
define('SENDMAIL_FROM', 'Errors@jobstack.com.ng');
ini_set('sendmail_from', SENDMAIL_FROM);

// By default we don't log errors to a file
define('LOG_ERRORS', false);
define('LOG_ERRORS_FILE', SITE_ROOT . '/errors_log.txt'); // Windows
/* Generic error message to be displayed instead of debug info (when DEBUGGING is false) */
define('SITE_GENERIC_ERROR_MESSAGE', '<h1>Jobstack Error!</h1>');

// Database connectivity setup
define('DB_PERSISTENCY', 'true');
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'xxxx');
define('DB_PASSWORD', 'xxxx');
define('DB_DATABASE', 'xxxxx');
define('PDO_DSN', 'mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE);


define('SHORT_JOB_DESCRIPTION_LENGTH', 250);
define('SHORT_ADMIN_POSTS_DESCRIPTION_LENGTH', 30);
define('JOBS_PER_PAGE', 30);
define('ADMIN_JOBS_PER_PAGE', 20);
define('FRONT_PAGE_JOBS', 30);
define('POSTS_PER_PAGE', 100);
define('FRONT_PAGE_POSTS', 4);
define('SIMILAR_JOBS_AMOUNT', 6);
define('REVIEWS_PER_PAGE', 3);
define('RECOMMENDED_JOBS_PER_PAGE', 10);
define('HIGHEST_RECRUITING_LOCATIONS_COUNT', 50);
define('HIGHEST_RECRUITING_COMPANIES_COUNT', 50);

define('FT_MIN_WORD_LEN', 3);

// Cart actions
define('ADD_JOB', 1);
define('REMOVE_JOB', 2);

// Random value used for hashing
define('HASH_PREFIX', 'K1-');
?>
