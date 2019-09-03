<?php
	class SiteAdmin {
		public $mSiteUrl;
		public $mMenuCell = 'blank_tpl.php';
		public $mContentCell = 'blank_tpl.php';
		public $mSearchBoxCell = 'blank_tpl.php';

		public function __construct() {
			$this->mSiteUrl = Link::Build('');
			//header ('Location: http://' . getenv('SERVER_NAME') . getenv('REQUEST_URI'));
			//exit();
		}

		public function init() {
			if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] != true) {
				$this->mContentCell = 'admin_login_tpl.php';
			}
			if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
				$this->mMenuCell = 'admin_menu_tpl.php';
				$this->mContentCell = 'blank_tpl.php';
				$this->mSearchBoxCell = 'search_box_tpl.php';
			}
			
			if (isset($_GET['Page']) && ($_GET['Page'] == 'Logout')) {
					unset($_SESSION['admin_logged']);
					header('Location: '.Link::ToAdmin());
					exit();
			}

			if ((isset($_GET['SearchResults']) || (isset($_GET['Search']))) && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
				$this->mContentCell = 'search_results_tpl.php';
				$this->mSearchBoxCell = 'search_box_tpl.php';
			}
			else {
			// if page not explicitly set assume the jobs page
				$admin_page = isset($_GET['Page']) ? $_GET['Page'] : 'Jobs';

				if ($admin_page == 'Jobs' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_jobs_tpl.php';
				}
				elseif ($admin_page == 'JobDetails' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_jobs_details_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}

				elseif ($admin_page == 'Companies' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_company_tpl.php';
				}

				elseif ($admin_page == 'CompanyDetails' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_company_details_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}

				elseif ($admin_page == 'Users' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_users_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}
				elseif ($admin_page == 'ReportPosts' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_report_posts_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}
				elseif ($admin_page == 'ReportPostDetails' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_report_post_details_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}
				elseif ($admin_page == 'ReportComments' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_report_comments_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}
				elseif ($admin_page == 'ReportCommentDetails' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_report_comment_details_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}
				elseif ($admin_page == 'UserPosts' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_users_posts_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}
				elseif ($admin_page == 'DeveloperMessages' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_developer_messages_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}
				elseif ($admin_page == 'ADeveloperMessage' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_developer_message_details_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}
				elseif ($admin_page == 'UsersJobs' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_users_jobs_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}
				elseif ($admin_page == 'UserJobDetails' && isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
					$this->mContentCell = 'admin_user_job_details_tpl.php';
					$this->mSearchBoxCell = 'search_box_tpl.php';
				}
			}
		}
	}
?>