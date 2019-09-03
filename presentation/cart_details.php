<?php
	class CartDetails {
		public $mJobs;
		public $mPage = 1;
		public $mrTotalPages;
		public $mTotalAmount;
		public $mIsCartNowEmpty = 0;
		public $mJobListPages = [];
		public $mLinkToContinueBrowsing;
		public $mLinkToCartDetails;
		public $mLinkToUserProfile;

		private $_mItemId;
		private $_mJobId;
		private $_mCartAction;

		public function __construct() {
			if (isset($_GET['CartAction'])) {
				if (isset($_POST['CartAction'])) {
					$this->_mCartAction = (int)$_POST['CartAction'];
				}

				if (isset($_GET['Page'])) {
					if ($this->mPage > 0) {
						$this->mPage = (int)$_GET['Page'];
					}
					else {
						trigger_error('Page must be greater than 0', E_USER_ERROR);
					}
				}

				if ($this->_mCartAction == REMOVE_JOB) {
					if (isset($_POST['JobId'])) {
						$this->_mJobId = (int)$_POST['JobId'];
					}
					else {
						trigger_error('JobId must be set for this type of request', E_USER_ERROR);
					}
				}

				if ($this->_mCartAction == ADD_JOB) {
					if (isset($_POST['JobId'])) {
						$this->_mJobId = (int)$_POST['JobId'];
					}
					else {
						trigger_error('JobId must be set for this type of request', E_USER_ERROR);
					}
				}
			}
			$this->mLinkToCartDetails = Link::ToCartPage();
			$this->mLinkToUserProfile = Link::ToUserProfile((int)Customer::GetCurrentCustomerId());
		}

		public function init() {

			if (isset($_SESSION['link_to_continue_browsing'])) {
				$continue_browsing = Link::QueryStringToArray($_SESSION['link_to_continue_browsing']);

				$page = 1;


				if (isset($continue_browsing['Page'])) {
					$page = $continue_browsing['Page'];
				}

				if (isset($continue_browsing['JobId'])) {
					$this->mLinkToContinueBrowsing = Link::ToJob($continue_browsing['JobId']);
				}
				elseif (isset($continue_browsing['Jobs'])) {
					$this->mLinkToContinueBrowsing = Link::ToJobsPage($page);
				}
				elseif (isset($continue_browsing['Companies'])) {
					$this->mLinkToContinueBrowsing = Link::ToCompanies($page);
				}
				elseif (isset($continue_browsing['CompanyId'])) {
					$this->mLinkToContinueBrowsing = Link::ToCompany($continue_browsing['CompanyId']);
				}
				elseif (isset($continue_browsing['UserProfile'])) {
					$this->mLinkToContinueBrowsing = Link::ToUserProfile($continue_browsing['UserProfile']);
				}
				elseif (isset($continue_browsing['PostId']) && isset($continue_browsing['UserId'])) {
					$this->mLinkToContinueBrowsing = Link::ToPostDetails($continue_browsing['UserId'], $continue_browsing['PostId']);
				}
				elseif (isset($continue_browsing['TrendingChatter'])) {
					$this->mLinkToContinueBrowsing = Link::ToTrendingChatter($page);
				}
				elseif (isset($continue_browsing['PopularTags'])) {
					$this->mLinkToContinueBrowsing = Link::ToPopularTags($continue_browsing['PopularTags'], $page);
				}
				else {
					$this->mLinkToContinueBrowsing = Link::ToIndex($page);
				}
			}

			switch($this->_mCartAction) {
				case REMOVE_JOB:
					SavedJobsCart::RemoveJob($this->_mJobId);
					header('Location: ' . Link::ToCart());
				break;
				case ADD_JOB:
					SavedJobsCart::AddJob($this->_mJobId);
					header('Location: ' . $this->mLinkToContinueBrowsing);
					break;
				default:
				// Do Nothing
				break;
			}

			$this->mTotalAmount = SavedJobsCart::GetTotalAmount();

			$this->mJobs = SavedJobsCart::GetCartJobs($this->mPage, $this->mrTotalPages);

			if ($this->mrTotalPages > 1) {
				if ($this->mPage < $this->mrTotalPages) {
					if (isset($_GET['CartAction'])) {
						$this->mLinkToNextPage = Link::ToCartPage($this->mPage + 1, $this->mrTotalPages);
					}
				}
			}

			if ($this->mPage > 1) {
				if (isset($_GET['CartAction'])) {
					$this->mLinkToPreviousPage = Link::ToCartPage($this->mPage - 1, $this->mrTotalPages);
				}
			}
			// Build the pages links
			for ($i = 1; $i <= $this->mrTotalPages; $i++) {
				if (isset($_GET['CartAction'])) {
					$this->mJobListPages[] = Link::ToCartPage($i);
				}				
			}

			/* 404 redirect if the page number is larger than the total number of pages */
			if ($this->mPage > $this->mrTotalPages && !empty($this->mrTotalPages)) {
				// Clean output buffer
				ob_clean();
				// Load the 404 page
				include '404.php';
				// Clear the output buffer and stop execution
				flush();
				ob_flush();
				ob_end_clean();
				exit();
			}

			for ($i = 0; $i < count($this->mJobs); $i++) {
 
				// Creates link to job details page
				$this->mJobs[$i]['link_to_job'] = Link::ToJob($this->mJobs[$i]['job_id']);
				$this->mJobs[$i]['link_to_popular_tags_page'] = Link::ToPopularTags($this->mJobs[$i]['job_id']);
			}

			if (count($this->mJobs) == 0) {
				$this->mIsCartNowEmpty = 1;
			}

			for ($i = 0; $i < count($this->mJobs); $i++) {
				$this->mJobs[$i]['remove'] = Link::ToCart(REMOVE_JOB, $this->mJobs[$i]['job_id']);
			}
		}
	}
?>